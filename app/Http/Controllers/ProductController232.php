<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController232 extends Controller
{
    /**
     * Display the product listing page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // For a real app, you'd fetch products from the database
        // $products = Product::orderBy('id', 'desc')->paginate(12);

        // For demo purposes, let's create sample products
        $products = $this->getSampleProducts(1, 12);

        return view('welcome', compact('products'));
    }

    /**
     * Search products
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Add your search logic here
        // Example:
        // $products = Product::where('name', 'like', "%{$query}%")->paginate(12);

        // For now, redirect back to home
        return redirect()->route('home')->with('message', 'Search functionality coming soon!');
    }

    /**
     * Display the price tracker page
     *
     * @return \Illuminate\View\View
     */
    public function priceTracker()
    {
        return view('price-tracker');
    }

    /**
     * Load more products for infinite scrolling
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadMore(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 9; // Number of products per page

        // Get products with pagination
        // Example query with actual database:
        // $products = Product::orderBy('id', 'desc')->paginate($perPage);

        // For demo purposes, let's create some sample products
        $products = $this->getSampleProducts($page, $perPage);
        $lastPage = 5; // Total number of pages (for demo)

        if ($page > $lastPage) {
            return response()->json([
                'products' => [],
                'last_page' => $lastPage
            ]);
        }

        return response()->json([
            'products' => $products,
            'current_page' => $page,
            'last_page' => $lastPage
        ]);
    }

    /**
     * Get sample products for demo purposes
     *
     * @param int $page
     * @param int $perPage
     * @return array
     */
    private function getSampleProducts($page, $perPage)
    {
        $productTypes = [
            'Fan Cleaner Duster',
            'Tank Cover',
            'Upliance AI',
            '50,000 MAH Powerbank',
            'Realme Buds Wireless',
            'Plant Stand',
            'Hikvision AI CCTV Camera',
            'Delavala Mortar And Pestle',
            'Samsung S25',
            'Heart TWS Earbuds',
            'Smart Glasses',
            '4-in-1 Earbuds',
            'Pressure Cooker',
            'Wireless Charger',
            'Smart Watch',
            'Bluetooth Speaker',
            'Air Fryer',
            'Wireless Mouse',
            'Gaming Headset',
            'Desktop Monitor'
        ];

        $products = [];
        $startId = 532 - (($page - 1) * $perPage);

        for ($i = 0; $i < $perPage; $i++) {
            $productId = $startId - $i;

            if ($productId < 0) {
                break;
            }

            $productIndex = $productId % count($productTypes);
            $productName = $productTypes[$productIndex];

            $products[] = [
                'id' => $productId,
                'name' => $productName,
                'image' => 'images/products/placeholder-' . (($productId % 5) + 1) . '.jpg'
            ];
        }

        return $products;
    }
}
