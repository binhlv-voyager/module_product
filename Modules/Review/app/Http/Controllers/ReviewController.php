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
     * Create a newly created review.
     */
    public function create(StoreReviewRequest $request, Product $product)
    {
        $this->reviews->createReview([
            ...$request->validated(),
            'product_id' => (int) $product->id,
        ]);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Review created successfully.',
            ], 201);
        }

        return redirect()->to(route('product.index', [
            'show' => (int) $product->id,
        ]) . '#reviews')->with('status', 'Review created successfully.');
    }

    /**
     * Store route is intentionally unsupported.
     */
    public function store()
    {
        abort(404);
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
