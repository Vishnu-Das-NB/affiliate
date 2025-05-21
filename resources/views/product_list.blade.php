@foreach ($products as $product)
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card product-card">
            <a href="{{ $product->affiliate_link }}" class="text-decoration-none" target="_blank">
                <div class="product-image-container">
                    @if ($product->is_dod)
                        <span class="product-id bg-success text-white">Deal Of The Day</span>
                    @endif
                    @if ($product->image)
                        @if (filter_var($product->image, FILTER_VALIDATE_URL))
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image" />
                        @else
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                        @endif
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="product-image">
                    @endif
                    <div class="product-title">{{ $product->name }}</div>
                </div>
            </a>
        </div>
    </div>
@endforeach
