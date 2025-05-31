<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Buylok') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    




    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" type="image/x-icon">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            overflow: hidden;
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
            border: none;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
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
        }

        .product-id {
            position: absolute;
            top: 9px;
            left: 9px;
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

        .follow {
      font-family: 'Poppins', sans-serif;
      font-weight: 400; /* Regular */
      font-size: 16px;
            line-height: 100%;
            letter-spacing: 0%;
            color: #000000;
        }
        .social-icon {
            width: 35px;
            height: 35px;
        }
        
        .typewriter-search {
            background: #f5f5f5;
            border: 1px solid #9d9d9d;
        }
        
        .typewriter-search::placeholder {
          color: #9d9d9d; /* or any light color like #e0e0e0, #fafafa */
          opacity: 1;   /* Ensures consistency across browsers */
          font-family: 'Poppins', sans-serif;
          text-transform: capitalize;
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
        <div class="container-fluid pb-2">
            <div class="row align-items-center mb-4">
                <!-- Logo Placeholder -->
                <div class="col-lg-8 p-3 my-3 px-xl-5">
                    <div class="w-50 m-auto text-center text-xl-start">
                        <a href="{{route('home')}}">
                            <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="img-fluid" height="97px" width="270px">
                        </a>
                    </div>
                </div>
                <!-- Social Icons -->
                <div class="col-lg-2 text-center">
                    <h4 class="follow">Follow Us & Subscribe</h4>
                    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                        <a href="#" class="social-icon bg-dark text-white rounded-circle d-flex align-items-center justify-content-center text-decoration-none fs-4">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon bg-dark text-white rounded-circle d-flex align-items-center justify-content-center text-decoration-none fs-4">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-icon bg-dark text-white rounded-circle d-flex align-items-center justify-content-center text-decoration-none fs-4">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon bg-dark text-white rounded-circle d-flex align-items-center justify-content-center text-decoration-none fs-4">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 text-center">
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <!-- Search Box -->
            <div id="search-bar-wrapper" class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control typewriter-search rounded-start-1"
                                placeholder="Search products..." id="search-box"
                                @if (request('search')) value="{{ request('search') }}" @endif name="search">
                            <button class="btn btn-dark rounded-end-1" type="submit">
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
        <div id="fixed-search-bar"
            style="display:none; position: fixed; bottom: 0; left: 0; width: 100%; background: #fff; padding: 10px 0; box-shadow: 0 -2px 8px rgba(0,0,0,0.15); z-index: 1050;">
            <div class="container">
                <form action="{{ route('home') }}" method="GET" id="fixed-search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control typewriter-search rounded-start-1" placeholder="Search products..."
                            id="fixed-search-box"
                            @if (request('search')) value="{{ request('search') }}" @endif name="search">
                        <button class="btn btn-dark rounded-end-1" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Footer -->
        <footer class="text-center py-4 mt-4 text-muted">
            <p>The products listed on this page contain affiliate links. When you purchase any product, Buylok may earn
                a commission.
                If any query contact to <a href="mailto:contact@buylok.com">contact@buylok.com</a> </p>
            <p class="mb-0">&copy; {{ date('Y') }} Buylok. All rights reserved.</p>
        </footer>
        <section>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12 text-center">
                    </div>
                </div>
            </div>
        </section>
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

            const searchBarWrapper = document.getElementById('search-bar-wrapper');
            const fixedSearchBar = document.getElementById('fixed-search-bar');
            const mainSearchBox = document.getElementById('search-box');
            const fixedSearchBox = document.getElementById('fixed-search-box');
            const mainSearchForm = document.getElementById('search-form');
            const fixedSearchForm = document.getElementById('fixed-search-form');

            // Copy initial value
            fixedSearchBox.value = mainSearchBox.value;

            // Sync inputs on typing
            mainSearchBox.addEventListener('input', () => {
                fixedSearchBox.value = mainSearchBox.value;
            });
            fixedSearchBox.addEventListener('input', () => {
                mainSearchBox.value = fixedSearchBox.value;
            });

            // Function to check if original search bar is visible
            function toggleFixedSearchBar() {
                const rect = searchBarWrapper.getBoundingClientRect();
                if (rect.bottom < 0) {
                    fixedSearchBar.style.display = 'block';
                } else {
                    fixedSearchBar.style.display = 'none';
                }
            }

            // Initial check
            toggleFixedSearchBar();

            // Listen for scroll events
            window.addEventListener('scroll', toggleFixedSearchBar);
            window.addEventListener('resize', toggleFixedSearchBar);
            const inputs = document.querySelectorAll(".typewriter-search");

            const words = ["headphones", "smartphones", "laptops", "gaming mouse", "keyboards", "wireless earbuds",
                "smartwatches"
            ];
            const typingSpeed = 100; // milliseconds per character
            const pauseBetweenWords = 2000; // pause before deleting

            inputs.forEach((input) => {
                if (input.value) return; // skip if already has user input

                let wordIndex = Math.floor(Math.random() * words.length);
                let charIndex = 0;
                let isDeleting = false;

                function typeEffect() {
                    const currentWord = words[wordIndex];
                    if (isDeleting) {
                        input.setAttribute("placeholder", currentWord.substring(0, charIndex--));
                        if (charIndex < 0) {
                            isDeleting = false;
                            wordIndex = Math.floor(Math.random() * words.length);
                        }
                    } else {
                        input.setAttribute("placeholder", currentWord.substring(0, charIndex++));
                        if (charIndex > currentWord.length) {
                            isDeleting = true;
                            setTimeout(typeEffect, pauseBetweenWords);
                            return;
                        }
                    }
                    setTimeout(typeEffect, typingSpeed);
                }

                typeEffect();
            });
        });
    </script>

</body>

</html>
