<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get();

        $view->with('categories', $categories);
    }
}
