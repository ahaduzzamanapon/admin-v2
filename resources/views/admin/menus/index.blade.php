@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-fixed shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-gray-800 fw-bold">Menu Builder</h5>
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Add New Menu
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Route</th>
                            <th>Icon</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->title }}</td>
                                <td>{{ $menu->route }}</td>
                                <td><i class="{{ $menu->icon }}"></i> {{ $menu->icon }}</td>
                                <td>{{ $menu->order }}</td>
                                <td>
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @foreach($menu->children as $child)
                                <tr>
                                    <td>— {{ $child->title }}</td>
                                    <td>{{ $child->route }}</td>
                                    <td><i class="{{ $child->icon }}"></i> {{ $child->icon }}</td>
                                    <td>{{ $child->order }}</td>
                                    <td>
                                        <a href="{{ route('admin.menus.edit', $child->id) }}" class="btn btn-sm btn-info">Edit</a>
                                        <form action="{{ route('admin.menus.destroy', $child->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
