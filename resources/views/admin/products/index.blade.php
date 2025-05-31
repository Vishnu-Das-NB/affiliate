@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Manage Products</h4>
                        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data"
                            class="d-flex align-items-center">
                            @csrf
                            <input type="file" name="file" class="form-control me-2" accept=".xlsx,.xls" required
                                style="max-width: 300px;">
                            <button type="submit" class="btn btn-primary">Import</button>
                        </form>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New Product</a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Search Form -->
                        <form action="{{ route('admin.products.index') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Search by name..." value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select name="filter_dod" class="form-select">
                                        <option value="">All Products</option>
                                        <option value="1" {{ request('filter_dod') == '1' ? 'selected' : '' }}>Deal of
                                            Day Only</option>
                                        <option value="0" {{ request('filter_dod') == '0' ? 'selected' : '' }}>Regular
                                            Products</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Deal of Day</th>
                                        <th>Product Position</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                <a href="{{ $product->affiliate_link }}" target="_blank">
                                                    @if ($product->image)
                                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                            style="height: 50px; width: 50px;">
                                                    @else
                                                        <span class="text-muted">No image</span>
                                                    @endif
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ $product->affiliate_link }}" target="_blank"
                                                    class="text-decoration-none text-dark">
                                                    {{ $product->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.products.toggle-dod', $product->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $product->is_dod ? 'btn-success' : 'btn-outline-secondary' }}">
                                                        {{ $product->is_dod ? 'Yes' : 'No' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $product->show_at_pos }}</td>
                                            <td>{{ $product->created_at }}</td>
                                            <td>
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="btn btn-sm btn-primary me-1">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No products found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of
                                {{ $products->total() }} products
                            </div>
                            <div>
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
