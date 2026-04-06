<x-product::layouts.master>
    @php
        $categoryMap = $categoryOptions->keyBy('id');
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-700">Product Module</p>
                <h1 class="mt-2 text-3xl font-semibold text-stone-900">Product Management</h1>
            </div>
            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('product.index') }}#product-form"
                    class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-amber-500"
                >
                    Create
                </a>
                <a
                    href="{{ route('product.index') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-stone-900 px-4 py-3 text-sm font-medium text-white transition hover:bg-stone-700"
                >
                    Reset View
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[420px_minmax(0,1fr)]">
            <section id="product-form" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <div class="mb-5">
                    <h2 class="text-xl font-semibold text-stone-900">
                        {{ $mode === 'show' ? 'Product Detail' : ($mode === 'edit' ? 'Edit Product' : 'Create Product') }}
                    </h2>
                    <p class="mt-1 text-sm text-stone-500">
                        {{ $mode === 'show' ? 'Review the selected product information.' : ($mode === 'edit' ? 'Update the selected product.' : 'Add a new product to MySQL.') }}
                    </p>
                </div>

                @if ($mode === 'show' && $selectedProduct)
                    <div class="mt-6 rounded-2xl border border-sky-200 bg-sky-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">Product Detail</p>
                        <dl class="mt-3 space-y-3 text-sm text-stone-700">
                            <div>
                                <dt class="font-medium text-stone-900">Name</dt>
                                <dd>{{ $selectedProduct->name }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-stone-900">Category</dt>
                                <dd>{{ $categoryMap[$selectedProduct->category_id]->name ?? 'Unknown' }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-stone-900">Price</dt>
                                <dd>${{ number_format((float) $selectedProduct->price, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-stone-900">Description</dt>
                                <dd class="whitespace-pre-line">{{ $selectedProduct->description }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-6 rounded-2xl border border-stone-200 bg-stone-50 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-stone-500">Reviews</p>
                                <h3 class="mt-1 text-base font-semibold text-stone-900">
                                    {{ $reviews->count() }} review{{ $reviews->count() === 1 ? '' : 's' }}
                                </h3>
                            </div>
                        </div>

                        <div id="reviews" class="mt-4 space-y-3">
                            @forelse ($reviews as $review)
                                <article class="rounded-2xl border border-stone-200 bg-white p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-stone-900">{{ $review->author_name }}</p>
                                            <p class="mt-1 text-xs text-stone-500">
                                                {{ $review->created_at ? $review->created_at->format('d/m/Y H:i') : 'No timestamp' }}
                                            </p>
                                        </div>
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                                            {{ $review->rating }}/5
                                        </span>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-stone-700">{{ $review->comment }}</p>
                                </article>
                            @empty
                                <div class="rounded-2xl border border-dashed border-stone-300 bg-white px-4 py-6 text-sm text-stone-500">
                                    {{ __('No reviews for this product yet.') }}
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            <a
                                href="{{ route('product.index', ['show' => $selectedProduct->id, 'review' => 'create']) }}#review-form"
                                class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-amber-500"
                            >
                                Create Review
                            </a>
                        </div>

                        @if (($reviewMode ?? null) === 'create')
                            @php
                                $reviewErrors = $errors->getBag('review');
                            @endphp

                            <div id="review-form" class="mt-6 rounded-2xl border border-amber-200 bg-white p-4">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-700">Add Review</p>
                                        <h4 class="mt-1 text-base font-semibold text-stone-900">New review for this product</h4>
                                    </div>
                                    <a
                                        href="{{ route('product.index', ['show' => $selectedProduct->id]) }}#reviews"
                                        class="inline-flex items-center justify-center rounded-xl bg-stone-900 px-4 py-3 text-sm font-medium text-white transition hover:bg-stone-700"
                                    >
                                        Close
                                    </a>
                                </div>

                                @if ($reviewErrors->any())
                                    <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                                        <ul class="space-y-1">
                                            @foreach ($reviewErrors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('review.store', ['product' => $selectedProduct->id]) }}" class="mt-4 space-y-4">
                                    @csrf

                                    <div>
                                        <label for="author_name" class="mb-2 block text-sm font-medium text-stone-700">Author Name</label>
                                        <input
                                            id="author_name"
                                            name="author_name"
                                            type="text"
                                            value="{{ old('author_name') }}"
                                            class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                            placeholder="Example: Nguyen Van A"
                                            required
                                        >
                                    </div>

                                    <div>
                                        <label for="rating" class="mb-2 block text-sm font-medium text-stone-700">Rating</label>
                                        <select
                                            id="rating"
                                            name="rating"
                                            class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                            required
                                        >
                                            <option value="">Select rating</option>
                                            @for ($rating = 5; $rating >= 1; $rating--)
                                                <option value="{{ $rating }}" @selected((string) old('rating') === (string) $rating)>
                                                    {{ $rating }}/5
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div>
                                        <label for="comment" class="mb-2 block text-sm font-medium text-stone-700">Comment</label>
                                        <textarea
                                            id="comment"
                                            name="comment"
                                            rows="6"
                                            class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                            placeholder="Write your review"
                                            required
                                        >{{ old('comment') }}</textarea>
                                    </div>

                                    <div class="flex flex-wrap gap-3 pt-2">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-amber-500"
                                        >
                                            Save Review
                                        </button>
                                        <a
                                            href="{{ route('product.index', ['show' => $selectedProduct->id]) }}#reviews"
                                            class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-4 py-3 text-sm font-medium text-stone-700 transition hover:bg-stone-50"
                                        >
                                            Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                @else
                    <form
                        method="POST"
                        action="{{ $mode === 'edit' && $selectedProduct ? route('product.update', $selectedProduct->id) : route('product.store') }}"
                        class="space-y-4"
                    >
                        @csrf
                        @if ($mode === 'edit' && $selectedProduct)
                            @method('PUT')
                        @endif

                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-stone-700">Name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $selectedProduct->name ?? '') }}"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                placeholder="Example: Wireless Mouse"
                                required
                            >
                        </div>

                        <div>
                            <label for="category_id" class="mb-2 block text-sm font-medium text-stone-700">Category</label>
                            <select
                                id="category_id"
                                name="category_id"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                required
                            >
                                <option value="">Select category</option>
                                @foreach ($categoryOptions as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected((string) old('category_id', $selectedProduct->category_id ?? '') === (string) $category->id)
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="price" class="mb-2 block text-sm font-medium text-stone-700">Price</label>
                            <input
                                id="price"
                                name="price"
                                type="number"
                                step="0.01"
                                min="0"
                                value="{{ old('price', $selectedProduct->price ?? '') }}"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                placeholder="Example: 199.99"
                                required
                            >
                        </div>

                        <div>
                            <label for="description" class="mb-2 block text-sm font-medium text-stone-700">Description</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                placeholder="Write a short product description"
                                required
                            >{{ old('description', $selectedProduct->description ?? '') }}</textarea>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button
                                type="submit"
                                class="inline-flex flex-1 items-center justify-center rounded-xl bg-amber-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-amber-500"
                            >
                                {{ $mode === 'edit' ? 'Update Product' : 'Create Product' }}
                            </button>

                            @if ($mode === 'edit')
                                <a
                                    href="{{ route('product.index') }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-4 py-3 text-sm font-medium text-stone-700 transition hover:bg-stone-50"
                                >
                                    Cancel
                                </a>
                            @endif
                        </div>
                    </form>
                @endif
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-stone-900">Product List</h2>
                        <p class="mt-1 text-sm text-stone-500">{{ $products->total() }} products found. Showing 10 records per page.</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-stone-200">
                    <table class="min-w-full divide-y divide-stone-200">
                        <thead class="bg-stone-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Price</th>
                                <th class="whitespace-nowrap px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-stone-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200 bg-white">
                            @forelse ($products as $product)
                                <tr class="hover:bg-stone-50">
                                    <td class="px-4 py-4 text-sm text-stone-600">{{ $product->id }}</td>
                                    <td class="px-4 py-4 text-sm font-medium text-stone-900">
                                        <div>{{ $product->name }}</div>
                                        <div class="mt-1 line-clamp-2 text-xs text-stone-500">{{ \Illuminate\Support\Str::limit($product->description, 90) }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-stone-600">{{ $categoryMap[$product->category_id]->name ?? 'Unknown' }}</td>
                                    <td class="px-4 py-4 text-sm text-stone-600">${{ number_format((float) $product->price, 2) }}</td>
                                    <td class="whitespace-nowrap px-4 py-4">
                                        <div class="flex flex-nowrap justify-end gap-2">
                                            <a
                                                href="{{ route('product.show', $product->id) }}"
                                                class="rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-xs font-medium text-sky-700 transition hover:bg-sky-100"
                                            >
                                                Detail
                                            </a>
                                            <a
                                                href="{{ route('product.edit', $product->id) }}#product-form"
                                                class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-medium text-amber-700 transition hover:bg-amber-100"
                                            >
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('product.destroy', $product->id) }}" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-medium text-rose-700 transition hover:bg-rose-100"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-sm text-stone-500">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $products->withQueryString()->links() }}
                </div>
            </section>
        </div>
    </div>
</x-product::layouts.master>
