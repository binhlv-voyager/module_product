<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Http\Requests\StoreProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Product\Services\ProductServiceInterface;
use Modules\Review\Services\ReviewServiceInterface;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductServiceInterface $products,
        private readonly ReviewServiceInterface $reviews,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'data' => $this->products->getAllProducts(),
            ]);
        }

        $products = $this->products->paginateProducts(10);
        $categoryOptions = $this->products->getCategoryOptions();
        $selectedProduct = null;
        $reviews = collect();
        $mode = null;
        $reviewMode = null;

        if ($request->filled('show')) {
            $selectedProduct = $this->products->getProductById($request->integer('show'));
            if (! $selectedProduct) {
                abort(404);
            }

            $reviews = $this->reviews->getReviewsByProductId((int) $selectedProduct->id);
            $mode = 'show';
            $reviewMode = $request->input('review');
        } elseif ($request->filled('edit')) {
            $selectedProduct = $this->products->getProductById($request->integer('edit'));
            if (! $selectedProduct) {
                abort(404);
            }
            $mode = 'edit';
        }

        return view('product::index', [
            'products' => $products,
            'categoryOptions' => $categoryOptions,
            'selectedProduct' => $selectedProduct,
            'reviews' => $reviews,
            'mode' => $mode,
            'reviewMode' => $reviewMode,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('product.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->products->createProduct($request->validated());

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Product created successfully.',
                'data' => $product,
            ], 201);
        }

        return redirect()
            ->route('product.index')
            ->with('status', 'Product created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request, $id)
    {
        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()->route('product.index', ['show' => $id]);
        }

        $product = $this->products->getProductById((int) $id);

        return response()->json([
            'data' => $product,
            'reviews' => $this->reviews->getReviewsByProductId((int) $product->id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return redirect()->route('product.index', ['edit' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $this->products->updateProduct((int) $id, $request->validated());

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Product updated successfully.',
                'data' => $this->products->getProductById((int) $id),
            ]);
        }

        return redirect()
            ->route('product.index')
            ->with('status', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($this->reviews->hasReviewsForProductId((int) $id)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Cannot delete product because it has reviews.',
                ], 409);
            }

            return redirect()
                ->route('product.index', ['show' => (int) $id])
                ->withErrors(['product' => __('Cannot delete product because it has reviews. Please delete its reviews first.')]);
        }

        $this->products->deleteProduct((int) $id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Product deleted successfully.',
            ]);
        }

        return redirect()
            ->route('product.index')
            ->with('status', 'Product deleted successfully.');
    }
}
