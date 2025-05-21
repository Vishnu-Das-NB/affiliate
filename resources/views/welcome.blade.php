<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SimpleGhar') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-footer {
            border-top: none;
        }

        .btn-primary {
            background-color: #6366F1;
            border-color: #6366F1;
        }

        .btn-primary:hover {
            background-color: #4F46E5;
            border-color: #4F46E5;
        }

        .badge {
            font-weight: 500;
        }

        /* Placeholder for images while loading */
        .img-placeholder {
            background-color: #e9ecef;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-grid {
            margin-bottom: 30px;
        }

        .product-card {
            margin-bottom: 25px;
            border: none;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image-container {
            position: relative;
            width: 100%;
            padding-top: 100%;
            /* Creates a square aspect ratio */
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* Maintains aspect ratio within square */
            padding: 10px;
        }

        .product-id {
            position: absolute;
            top: 3px;
            left: 0px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 14px;
            z-index: 2;
        }

        .product-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 25, 0.8);
            color: white;
            text-align: center;
            padding: 12px 5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 18px;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .product-title {
                font-size: 14px;
                padding: 8px 5px;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Main Content -->
        <div class="container py-4">
            <!-- Header with Logo -->
            <div class="text-center mb-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="SimpleGhar Logo" width="60" height="60">
                </a>
                <h4 class="mt-2">SimpleGhar Malayalam</h4>
                <p class="text-muted">@simplegharMalayalam</p>
            </div>

            <!-- Price Tracking Tool Banner -->
            <div class="bg-info bg-opacity-25 text-center p-3 mb-4 rounded">
                <p class="mb-1">Try Our New Price Tracking Tool & Save On Your Amazon Purchase.</p>
                <a href="{{ route('price-tracker') }}" class="btn btn-sm btn-primary">Try Now ></a>
            </div>

            <!-- Search Box -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search products..." id="search-box"
                                @if (request('search')) value="{{ request('search') }}" @endif name="search">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Product Grid -->

            <div class="container product-grid py-4">
                <div class="row" id="product-grid-row">
                    @include('product_list', ['products' => $products])
                </div>

                <div class="text-center mt-4" id="loading-spinner" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="load-more-sentinel" class="py-5"></div>

            </div>
        </div>
        <!-- Footer -->
        <footer class="text-center py-4 mt-4 text-muted">
            <p class="mb-0">&copy; {{ date('Y') }} SimpleGhar Malayalam. All rights reserved.</p>
        </footer>
    </div>

    <script>
        let page = 2;
        let loading = false;
        let observer;

        function getSearchParam() {
            const urlParams = new URLSearchParams(window.location.search);
            const search = urlParams.get('search') || urlParams.get('query');
            return search ? `&search=${encodeURIComponent(search)}` : '';
        }

        function loadMoreProducts() {
            if (loading) return;

            loading = true;
            document.getElementById('loading-spinner').style.display = 'block';

            const searchParam = getSearchParam();
            const url = `?page=${page}&ajax=1${searchParam}`;
            if (page > 1) {
                document.getElementById('loading-spinner').style.display = 'block';
            } else {
                document.getElementById('loading-spinner').style.display = 'none';
            }
            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const container = document.getElementById('product-grid-row');
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newProducts = doc.body.childNodes;
                    console.log(newProducts);
                    newProducts.forEach(node => {
                        container.appendChild(node);
                    });

                    document.getElementById('loading-spinner').style.display = 'none';
                    loading = false;

                    if (html.trim().length === 0) {
                        observer.disconnect(); // stop observing if no more data
                    } else {
                        page++;
                    }
                })
                .catch(() => {
                    document.getElementById('loading-spinner').style.display = 'none';
                    loading = false;
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const sentinel = document.querySelector("#load-more-sentinel");

            observer = new IntersectionObserver(entries => {
                if (entries[0].isIntersecting) {
                    loadMoreProducts();
                }
            }, {
                threshold: 1.0
            });

            observer.observe(sentinel);
        });
    </script>

</body>

</html>
