@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add New Menu</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="route" class="form-label">Route</label>
                    <input type="text" class="form-control" id="route" name="route">
                    <small class="text-muted">Enter the route name (e.g., admin.dashboard) or leave empty for parent menus.</small>
                </div>
                <div class="mb-3">
                    <label for="icon" class="form-label">Icon (Bootstrap Icons class)</label>
                    <input type="text" class="form-control" id="icon" name="icon">
                    <small class="text-muted">e.g., bi bi-speedometer2</small>
                </div>
                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Menu</label>
                    <select class="form-control" id="parent_id" name="parent_id">
                        <option value="">None</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" class="form-control" id="order" name="order" value="0">
                </div>
                <button type="submit" class="btn btn-primary">Create Menu</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
