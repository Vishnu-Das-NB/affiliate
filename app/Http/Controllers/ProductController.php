<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display the product listing page
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Start with a base query
        $query = Product::query();
        // Apply search if provided
        if ($request->has('search') && $request->search && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Apply Deal of Day filter if selected
        if ($request->has('filter_dod') && $request->filter_dod && $request->filter_dod !== '') {
            $query->where('is_dod', $request->filter_dod);
        }
        $query->orderBy('show_at_pos')->orderByDesc('id');
        // Paginate the results (adjust per page as needed)
        $products = $query->paginate(10);


        return view('admin.products.index', compact('products'));
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

        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->latest()
            ->paginate(12);

        return view('welcome', compact('products', 'query'));
    }

    /**
     * Display the price tracker page
     *
     * @return \Illuminate\View\View
     */
    public function priceTracker()
    {
        $dealOfDay = Product::dealOfDay()->latest()->first();
        return view('price-tracker', compact('dealOfDay'));
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

        $products = Product::paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'products' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage()
        ]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('products', $filename, 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['is_dod'] = $request->has('is_dod');

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->all();
        if ($request->hasFile('image')) {
            // Delete the old image
            if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('products', $filename, 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $validated['is_dod'] = $request->has('is_dod');

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Delete the product image
        if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle the Deal of the Day status for a product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleDealOfDay(Product $product)
    {
        // If making this product the Deal of the Day, remove the status from other products
        if (!$product->is_dod) {
            Product::where('is_dod', true)->update(['is_dod' => false]);
        }

        $product->update(['is_dod' => !$product->is_dod]);

        return redirect()->back()
            ->with('success', 'Deal of the Day status updated successfully.');
    }
    /**
     * Display the product listing page
     *
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    { // Start with a base query
        $query = Product::query();
        // Apply search if provided
        if ($request->has('search') && $request->search && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Apply Deal of Day filter if selected
        if ($request->has('filter_dod') && $request->filter_dod && $request->filter_dod !== '') {
            $query->where('is_dod', $request->filter_dod);
        }
        $query->orderBy('show_at_pos')->orderByDesc('id');

        // Paginate the results (adjust per page as needed)
        $products = $query->paginate(12);


        if ($request->has('ajax') && $request->ajax == '1') {
            return view('product_list', compact('products'))->render();
        }

        return view('welcome', compact('products'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return back()->with('success', 'Products imported successfully!');
    }
}
