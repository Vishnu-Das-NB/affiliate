@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Add New Product</h4>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                    required>
                                <small class="text-muted">Recommended size: 800x800px. Max size: 2MB</small>
                            </div>

                            <div class="mb-4">
                                <label for="affiliate_link" class="form-label">Affiliate Link</label>
                                <input type="url" class="form-control" id="affiliate_link" name="affiliate_link"
                                    value="{{ old('affiliate_link') }}">
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="is_dod" name="is_dod"
                                    {{ old('is_dod') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_dod">Featured as Deal of the Day</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Create Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
