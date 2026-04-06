<?php

namespace Modules\Review\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Models\Product;

class StoreReviewRequest extends FormRequest
{
    /**
     * Keep review validation errors separate from product form errors.
     */
    protected $errorBag = 'review';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'author_name' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:2000'],
        ];
    }

    protected function getRedirectUrl()
    {
        if ($this->expectsJson() || $this->is('api/*')) {
            return parent::getRedirectUrl();
        }

        $product = $this->route('product');
        $productId = $product instanceof Product ? (int) $product->getKey() : (int) $product;

        if ($productId > 0) {
            return route('product.index', [
                'show' => $productId,
                'review' => 'create',
            ]) . '#review-form';
        }

        return route('product.index');
    }
}
