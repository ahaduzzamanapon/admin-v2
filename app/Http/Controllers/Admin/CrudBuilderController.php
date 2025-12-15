<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;

class CrudBuilderController extends Controller
{
    public function index()
    {
        return view('admin.crud-builder.index');
    }

    public function getModels()
    {
        $models = [];
        $modelPath = app_path('Models');
        $files = File::allFiles($modelPath);

        foreach ($files as $file) {
            $models[] = $file->getFilenameWithoutExtension();
        }

        return response()->json($models);
    }

    public function getModelColumns(Request $request)
    {
        $modelName = $request->input('model');
        $modelClass = 'App\\Models\\' . $modelName;

        if (class_exists($modelClass)) {
            $model = new $modelClass();
            $table = $model->getTable();
            $columns = Schema::getColumnListing($table);
            return response()->json($columns);
        }

        return response()->json([], 404);
    }

    public function generate(Request $request)
    {
        $modelName = Str::studly($request->input('model_name'));
        $tableName = $request->input('table_name', Str::snake(Str::plural($modelName)));
        $fields = $request->input('fields');
        $softDelete = $request->has('soft_delete');
        $datatables = $request->has('datatables');
        $migration = $request->has('migration');
        $migrate = $request->has('migrate');
        $paginate = $request->input('paginate');

        // Prepare placeholders for stubs
        $modelVariable = Str::camel($modelName);
        $modelVariablePlural = Str::plural($modelVariable);
        $className = $modelName . 'Controller';
        $namespace = 'App\\Http\\Controllers\\Admin';
        $modelNamespace = 'App\\Models';

        $replacements = [
            '{{ modelName }}' => $modelName,
            '{{ tableName }}' => $tableName,
            '{{ modelVariable }}' => $modelVariable,
            '{{ modelVariablePlural }}' => $modelVariablePlural,
            '{{ className }}' => $className,
            '{{ namespace }}' => $namespace,
            '{{ modelNamespace }}' => $modelNamespace,
        ];

        // Generate Model
        $this->generateModel($modelName, $fields, $softDelete, $replacements);

        // Generate Migration
        if ($migration) {
            $this->generateMigration($modelName, $tableName, $fields, $softDelete, $replacements);
        }

        // Generate Controller
        $this->generateController($className, $modelName, $fields, $replacements);

        // Generate Views
        $this->generateViews($modelName, $fields, $replacements);

        // Run Migrations
        if ($migrate) {
            Artisan::call('migrate');
        }

        // Add routes
        $this->addRoutes($modelName, $className);

        // Add to menu
        $this->addToMenu($modelName);

        return redirect()->back()->with('success', 'CRUD generated successfully!');
    }

    protected function addRoutes($modelName, $className)
    {
        $modelVariablePlural = Str::plural(Str::camel($modelName));
        $route = "Route::resource('{$modelVariablePlural}', App\\Http\\Controllers\\Admin\\{$className}::class)->names('admin.{$modelVariablePlural}');";

        $crudRoutesPath = base_path('routes/crud.php');
        
        if (!File::exists($crudRoutesPath)) {
            File::put($crudRoutesPath, "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n");
        }

        File::append($crudRoutesPath, "\n" . $route);
    }

    protected function addToMenu($modelName)
    {
        $modelVariablePlural = Str::plural(Str::camel($modelName));
        $menuIcon = request()->input('menu_icon', 'bi bi-circle'); // Default to Bootstrap Icon

        // Check if menu already exists
        $exists = Menu::where('route', 'admin.' . $modelVariablePlural . '.index')->exists();
        
        if (!$exists) {
            Menu::create([
                'title' => Str::plural($modelName),
                'route' => 'admin.' . $modelVariablePlural . '.index',
                'icon' => $menuIcon,
                'order' => Menu::max('order') + 1,
            ]);
        }
    }

    protected function generateModel($modelName, $fields, $softDelete, $replacements)
    {
        $modelStub = File::get(resource_path('stubs/model.stub'));
        $fillable = [];
        foreach ($fields as $field) {
            $fillable[] = "'" . $field['name'] . "'";
        }
        $replacements['{{ fillable }}'] = implode(', ', $fillable);

        // Soft Deletes
        if ($softDelete) {
            $replacements['{{ softDeleteImport }}'] = "use Illuminate\\Database\\Eloquent\\SoftDeletes;";
            $replacements['{{ softDeleteTrait }}'] = "use SoftDeletes;";
        } else {
            $replacements['{{ softDeleteImport }}'] = "";
            $replacements['{{ softDeleteTrait }}'] = "";
        }

        // Generate Relationships
        $relationships = [];
        foreach ($fields as $field) {
            if ($field['db_type'] === 'foreignId') {
                $relationName = Str::camel(str_replace('_id', '', $field['name']));
                $relatedModel = Str::studly($relationName);
                if (!empty($field['options'])) {
                    $parts = explode(':', $field['options']);
                    if (count($parts) >= 1) {
                        $relatedModel = $parts[0];
                    }
                }
                
                $relationships[] = "    public function {$relationName}()";
                $relationships[] = "    {";
                $relationships[] = "        return \$this->belongsTo(\\App\\Models\\{$relatedModel}::class, '{$field['name']}');";
                $relationships[] = "    }";
            }
        }
        $replacements['{{ relationships }}'] = implode("\n\n", $relationships);

        $modelContent = str_replace(array_keys($replacements), array_values($replacements), $modelStub);

        $modelPath = app_path('Models/' . $modelName . '.php');
        File::put($modelPath, $modelContent);
    }

    protected function generateMigration($modelName, $tableName, $fields, $softDelete, $replacements)
    {
        $migrationStub = File::get(resource_path('stubs/migration.stub'));
        $schemaFields = [];

        foreach ($fields as $field) {
            $dbType = $field['db_type'];
            $fieldName = $field['name'];
            
            if ($dbType === 'foreignId') {
                $schemaLine = '$table->foreignId(\'' . $fieldName . '\')';
            } else {
                $schemaLine = '$table->' . $dbType . "('" . $fieldName . "')";
            }

            if (isset($field['nullable']) && $field['nullable']) {
                $schemaLine .= '->nullable()';
            }

            $schemaLine .= ';';
            $schemaFields[] = '            ' . $schemaLine;
        }

        if ($softDelete) {
            $schemaFields[] = '            $table->softDeletes();';
        }

        $replacements['{{ fields }}'] = implode("\n", $schemaFields);

        $migrationContent = str_replace(array_keys($replacements), array_values($replacements), $migrationStub);

        $timestamp = date('Y_m_d_His');
        $migrationFileName = $timestamp . '_create_' . $tableName . '_table.php';
        $migrationPath = database_path('migrations/' . $migrationFileName);

        File::put($migrationPath, $migrationContent);
    }

    protected function generateController($className, $modelName, $fields, $replacements)
    {
        $controllerStub = File::get(resource_path('stubs/controller.stub'));

        $imageFields = [];
        foreach ($fields as $field) {
            if ($field['html_type'] === 'image') {
                $imageFields[] = $field['name'];
            }
        }

        $except = "['_token', '_method']"; 
        if (count($imageFields) > 0) {
            $except = "['_token', '_method', '" . implode("', '", $imageFields) . "']";
        }

        $storeImage = '';
        foreach ($imageFields as $field) {
            $storeImage .= "        if (\$request->hasFile('{$field}')) {\n";
            $storeImage .= "            \$data['{$field}'] = \$request->file('{$field}')->store('{$replacements['{{ modelVariablePlural }}']}', 'public');\n";
            $storeImage .= "        }\n";
        }

        $updateImage = '';
        foreach ($imageFields as $field) {
            $updateImage .= "        if (\$request->hasFile('{$field}')) {\n";
            $updateImage .= "            if (\$item->{$field}) {\n";
            $updateImage .= "                Storage::disk('public')->delete(\$item->{$field});\n";
            $updateImage .= "            }\n";
            $updateImage .= "            \$data['{$field}'] = \$request->file('{$field}')->store('{$replacements['{{ modelVariablePlural }}']}', 'public');\n";
            $updateImage .= "        }\n";
        }

        $deleteImage = '';
        foreach ($imageFields as $field) {
            $deleteImage .= "        if (\$item->{$field}) {\n";
            $deleteImage .= "            Storage::disk('public')->delete(\$item->{$field});\n";
            $deleteImage .= "        }\n";
        }

        $replacements['{{ except }}'] = $except;
        $replacements['{{ storeImage }}'] = $storeImage;
        $replacements['{{ updateImage }}'] = $updateImage;
        $replacements['{{ deleteImage }}'] = $deleteImage;

        // Validation Rules
        $rules = [];
        foreach ($fields as $field) {
            $fieldRules = [];
            if (isset($field['validation']) && !empty($field['validation'])) {
                $fieldRules[] = $field['validation'];
            }
            if (isset($field['nullable']) && $field['nullable']) {
                $fieldRules[] = 'nullable';
            } else {
                $fieldRules[] = 'required';
            }
            
            if (!empty($fieldRules)) {
                $rules[] = "            '{$field['name']}' => '" . implode('|', $fieldRules) . "',";
            }
        }
        $replacements['{{ rules }}'] = implode("\n", $rules);

        // Relations Data for View
        $relations = [];
        $compact = [];
        foreach ($fields as $field) {
            if ($field['db_type'] === 'foreignId') {
                $relationName = Str::camel(str_replace('_id', '', $field['name']));
                $relatedModel = Str::studly($relationName);
                if (!empty($field['options'])) {
                    $parts = explode(':', $field['options']);
                    if (count($parts) >= 1) {
                        $relatedModel = $parts[0];
                    }
                }
                $pluralRelation = Str::plural($relationName);
                $relations[] = "        \${$pluralRelation} = \\App\\Models\\{$relatedModel}::all();";
                $compact[] = "'{$pluralRelation}'";
            }
        }
        
        $replacements['{{ relations }}'] = implode("\n", $relations);
        if (!empty($compact)) {
             $replacements['{{ compact }}'] = ', compact(' . implode(', ', $compact) . ')';
        } else {
             $replacements['{{ compact }}'] = '';
        }

        $controllerContent = str_replace(array_keys($replacements), array_values($replacements), $controllerStub);

        $controllerPath = app_path('Http/Controllers/Admin/' . $className . '.php');
        File::put($controllerPath, $controllerContent);
    }

    protected function generateViews($modelName, $fields, $replacements)
    {
        $modelVariablePlural = Str::plural(Str::camel($modelName));
        $viewDirectory = resource_path('views/admin/' . $modelVariablePlural);
        if (!File::isDirectory($viewDirectory)) {
            File::makeDirectory($viewDirectory, 0755, true);
        }

        // Generate index view
        $indexStub = File::get(resource_path('stubs/index.stub'));
        $tableHeaders = [];
        $tableColumns = [];
        foreach ($fields as $field) {
            $headerName = Str::title($field['name']);
            if ($field['db_type'] === 'foreignId' && Str::endsWith($field['name'], '_id')) {
                $headerName = Str::title(Str::replaceLast('_id', '', $field['name']));
            }
            $tableHeaders[] = '                    <th>' . $headerName . '</th>';
            
            if ($field['html_type'] === 'image') {
                $tableColumns[] = '                    <td><img src="{{ asset(\'storage/\' . $item->' . $field['name'] . ') }}" width="50" /></td>';
            } elseif ($field['db_type'] === 'foreignId') {
                 $relationName = Str::camel(Str::replaceLast('_id', '', $field['name']));
                 $displayColumn = 'id'; // Default
                 if (isset($field['options']) && strpos($field['options'], ':') !== false) {
                     $parts = explode(':', $field['options']);
                     if (count($parts) >= 2) {
                         $displayColumn = $parts[1];
                     }
                 }
                 $tableColumns[] = '                    <td>{{ $item->' . $relationName . '->' . $displayColumn . ' ?? \'\' }}</td>';
            } else {
                $tableColumns[] = '                    <td>{{ $item->' . $field['name'] . ' }}</td>';
            }
        }
        $replacements['{{ tableHeaders }}'] = implode("\n", $tableHeaders);
        $replacements['{{ tableColumns }}'] = implode("\n", $tableColumns);
        $indexContent = str_replace(array_keys($replacements), array_values($replacements), $indexStub);
        File::put($viewDirectory . '/index.blade.php', $indexContent);

        // Generate create view
        $createStub = File::get(resource_path('stubs/create.stub'));
        $formFields = [];
        $hasFile = false;
        $hasTextarea = false;
        foreach ($fields as $field) {
            $colClass = ($field['html_type'] === 'textarea' || $field['html_type'] === 'editor') ? 'col-12' : 'col-md-4';
            $formFields[] = '            <div class="' . $colClass . ' mb-3">';
            $formFields[] = '                <label for="' . $field['name'] . '" class="form-label">' . Str::title(str_replace('_', ' ', $field['name'])) . '</label>';
            
            if ($field['html_type'] === 'textarea') {
                $hasTextarea = true;
                $formFields[] = '                <textarea class="form-control editor" id="' . $field['name'] . '" name="' . $field['name'] . '" rows="3"></textarea>';
            } else if ($field['html_type'] === 'image') {
                $formFields[] = '                <input type="file" class="form-control" id="' . $field['name'] . '" name="' . $field['name'] . '">';
                $hasFile = true;
            } else if ($field['db_type'] === 'foreignId') {
                $relationName = Str::camel(str_replace('_id', '', $field['name']));
                $pluralRelation = Str::plural($relationName);
                $displayCol = 'name';
                if (!empty($field['options'])) {
                    $parts = explode(':', $field['options']);
                    if (count($parts) >= 2) {
                        $displayCol = $parts[1];
                    }
                }
                $formFields[] = '                <select class="form-select" id="' . $field['name'] . '" name="' . $field['name'] . '">';
                $formFields[] = '                    <option value="">Select ' . Str::title($relationName) . '</option>';
                $formFields[] = '                    @foreach($' . $pluralRelation . ' as $item)';
                $formFields[] = '                        <option value="{{ $item->id }}">{{ $item->' . $displayCol . ' }}</option>';
                $formFields[] = '                    @endforeach';
                $formFields[] = '                </select>';
            } else if ($field['html_type'] === 'select') {
                $formFields[] = '                <select class="form-select" id="' . $field['name'] . '" name="' . $field['name'] . '">';
                $formFields[] = '                    <option value="">Select ' . Str::title($field['name']) . '</option>';
                if (!empty($field['options'])) {
                    $options = explode(',', $field['options']);
                    foreach ($options as $option) {
                        $parts = explode(':', $option);
                        $val = $parts[0];
                        $label = isset($parts[1]) ? $parts[1] : $val;
                        $formFields[] = '                    <option value="' . $val . '">' . $label . '</option>';
                    }
                }
                $formFields[] = '                </select>';
            } else if ($field['html_type'] === 'radio') {
                 if (!empty($field['options'])) {
                    $options = explode(',', $field['options']);
                    foreach ($options as $option) {
                        $parts = explode(':', $option);
                        $val = $parts[0];
                        $label = isset($parts[1]) ? $parts[1] : $val;
                        $formFields[] = '                <div class="form-check form-check-inline">';
                        $formFields[] = '                    <input class="form-check-input" type="radio" name="' . $field['name'] . '" id="' . $field['name'] . '_' . $val . '" value="' . $val . '">';
                        $formFields[] = '                    <label class="form-check-label" for="' . $field['name'] . '_' . $val . '">' . $label . '</label>';
                        $formFields[] = '                </div>';
                    }
                }
            } else if ($field['html_type'] === 'checkbox') {
                $formFields[] = '                <div class="form-check form-switch">';
                $formFields[] = '                    <input type="hidden" name="' . $field['name'] . '" value="0">';
                $formFields[] = '                    <input class="form-check-input" type="checkbox" id="' . $field['name'] . '" name="' . $field['name'] . '" value="1">';
                $formFields[] = '                    <label class="form-check-label" for="' . $field['name'] . '">' . Str::title($field['name']) . '</label>';
                $formFields[] = '                </div>';
            } else {
                $formFields[] = '                <input type="' . $field['html_type'] . '" class="form-control" id="' . $field['name'] . '" name="' . $field['name'] . '">';
            }
            $formFields[] = '            </div>';
        }
        $replacements['{{ formFields }}'] = implode("\n", $formFields);
        if ($hasFile) {
            $replacements['{{ enctype }}'] = 'enctype="multipart/form-data"';
        } else {
            $replacements['{{ enctype }}'] = '';
        }
        
        $createContent = str_replace(array_keys($replacements), array_values($replacements), $createStub);
        File::put($viewDirectory . '/create.blade.php', $createContent);

        // Generate edit view
        $editStub = File::get(resource_path('stubs/edit.stub'));
        $formFields = [];
        $hasFile = false;
        $hasTextarea = false;
        foreach ($fields as $field) {
            $colClass = ($field['html_type'] === 'textarea' || $field['html_type'] === 'editor') ? 'col-12' : 'col-md-6';
            $formFields[] = '            <div class="' . $colClass . ' mb-3">';
            $formFields[] = '                <label for="' . $field['name'] . '" class="form-label">' . Str::title(str_replace('_', ' ', $field['name'])) . '</label>';
            if ($field['html_type'] === 'textarea') {
                $hasTextarea = true;
                $formFields[] = '                <textarea class="form-control editor" id="' . $field['name'] . '" name="' . $field['name'] . '" rows="3">{{ $item->' . $field['name'] . ' }}</textarea>';
            } else if ($field['html_type'] === 'image') {
                $formFields[] = '                <input type="file" class="form-control" id="' . $field['name'] . '" name="' . $field['name'] . '">';
                $formFields[] = '                <img src="{{ asset(\'storage/\' . $item->' . $field['name'] . ') }}" width="100" class="mt-2 rounded" />';
                $hasFile = true;
            } else if ($field['db_type'] === 'foreignId') {
                $relationName = Str::camel(str_replace('_id', '', $field['name']));
                $pluralRelation = Str::plural($relationName);
                $displayCol = 'name';
                if (!empty($field['options'])) {
                    $parts = explode(':', $field['options']);
                    if (count($parts) >= 2) {
                        $displayCol = $parts[1];
                    }
                }
                $formFields[] = '                <select class="form-select" id="' . $field['name'] . '" name="' . $field['name'] . '">';
                $formFields[] = '                    <option value="">Select ' . Str::title($relationName) . '</option>';
                $formFields[] = '                    @foreach($' . $pluralRelation . ' as $relItem)';
                $formFields[] = '                        <option value="{{ $relItem->id }}" {{ $item->' . $field['name'] . ' == $relItem->id ? \'selected\' : \'\' }}>{{ $relItem->' . $displayCol . ' }}</option>';
                $formFields[] = '                    @endforeach';
                $formFields[] = '                </select>';
            } else if ($field['html_type'] === 'select') {
                $formFields[] = '                <select class="form-select" id="' . $field['name'] . '" name="' . $field['name'] . '">';
                $formFields[] = '                    <option value="">Select ' . Str::title($field['name']) . '</option>';
                if (!empty($field['options'])) {
                    $options = explode(',', $field['options']);
                    foreach ($options as $option) {
                        $parts = explode(':', $option);
                        $val = $parts[0];
                        $label = isset($parts[1]) ? $parts[1] : $val;
                        $formFields[] = '                    <option value="' . $val . '" {{ $item->' . $field['name'] . ' == \'' . $val . '\' ? \'selected\' : \'\' }}>' . $label . '</option>';
                    }
                }
                $formFields[] = '                </select>';
            } else if ($field['html_type'] === 'radio') {
                 if (!empty($field['options'])) {
                    $options = explode(',', $field['options']);
                    foreach ($options as $option) {
                        $parts = explode(':', $option);
                        $val = $parts[0];
                        $label = isset($parts[1]) ? $parts[1] : $val;
                        $formFields[] = '                <div class="form-check form-check-inline">';
                        $formFields[] = '                    <input class="form-check-input" type="radio" name="' . $field['name'] . '" id="' . $field['name'] . '_' . $val . '" value="' . $val . '" {{ $item->' . $field['name'] . ' == \'' . $val . '\' ? \'checked\' : \'\' }}>';
                        $formFields[] = '                    <label class="form-check-label" for="' . $field['name'] . '_' . $val . '">' . $label . '</label>';
                        $formFields[] = '                </div>';
                    }
                }
            } else if ($field['html_type'] === 'checkbox') {
                $formFields[] = '                <div class="form-check form-switch">';
                $formFields[] = '                    <input type="hidden" name="' . $field['name'] . '" value="0">';
                $formFields[] = '                    <input class="form-check-input" type="checkbox" id="' . $field['name'] . '" name="' . $field['name'] . '" value="1" {{ $item->' . $field['name'] . ' ? \'checked\' : \'\' }}>';
                $formFields[] = '                    <label class="form-check-label" for="' . $field['name'] . '">' . Str::title($field['name']) . '</label>';
                $formFields[] = '                </div>';
            } else {
                $formFields[] = '                <input type="' . $field['html_type'] . '" class="form-control" id="' . $field['name'] . '" name="' . $field['name'] . '" value="{{ $item->' . $field['name'] . ' }}">';
            }
            $formFields[] = '            </div>';
        }
        $replacements['{{ formFields }}'] = implode("\n", $formFields);
        if ($hasFile) {
            $replacements['{{ enctype }}'] = 'enctype="multipart/form-data"';
        } else {
            $replacements['{{ enctype }}'] = '';
        }

        $editContent = str_replace(array_keys($replacements), array_values($replacements), $editStub);
        File::put($viewDirectory . '/edit.blade.php', $editContent);
    }
}
