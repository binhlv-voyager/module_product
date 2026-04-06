<?php

namespace Modules\Review\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Product\Models\Product;
use Modules\Review\Http\Requests\StoreReviewRequest;
use Modules\Review\Services\ReviewServiceInterface;

class ReviewController extends Controller
{
    public function __construct(
        private readonly ReviewServiceInterface $reviews,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => $this->reviews->getAllReviews(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        // Keep review creation inside the product detail page (products?show=ID&review=create).
        return redirect()->to(route('product.index', [
            'show' => (int) $product->id,
            'review' => 'create',
        ]) . '#review-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request, Product $product)
    {
        $this->reviews->createReview([
            ...$request->validated(),
            'product_id' => (int) $product->id,
        ]);

        return redirect()->to(route('product.index', [
            'show' => (int) $product->id,
        ]) . '#reviews')->with('status', 'Review created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        abort(404);
    }
}
