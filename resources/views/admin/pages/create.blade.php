@extends('layouts.admin')

@section('title', 'Create Page')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Create Page</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}"
                        placeholder="Leave empty to auto-generate">
                </div>

                <div class="mb-3">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="15" required>{{ old('content') }}</textarea>
                    <div class="form-text">HTML is allowed.</div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" checked>
                    <label class="form-check-label" for="isActive">Active</label>
                </div>

                <button type="submit" class="btn btn-primary">Create Page</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection