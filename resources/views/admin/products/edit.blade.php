@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Edit Product: {{ $product->name }}</h4>
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

                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $product->name) }}" required>
                            </div>


                            <div class="mb-4">
                                <label for="name" class="form-label">Product Shown At</label>
                                <input type="number" class="form-control" id="show_at_pos" name="show_at_pos"
                                    value="{{ old('show_at_pos', $product->show_at_pos) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label">Product Image</label>
                                @if ($product->image)
                                    <div class="mb-3">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <small class="text-muted">Leave empty to keep the current image. Recommended size:
                                    800x800px. Max size: 2MB</small>
                            </div>

                            <div class="mb-4">
                                <label for="affiliate_link" class="form-label">Affiliate Link</label>
                                <input type="url" class="form-control" id="affiliate_link" name="affiliate_link"
                                    value="{{ old('affiliate_link', $product->affiliate_link) }}">
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="is_dod" name="is_dod"
                                    {{ old('is_dod', $product->is_dod) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_dod">Featured as Deal of the Day</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
