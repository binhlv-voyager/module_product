<x-review::layouts.master>
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-700">Review Module</p>
                <h1 class="mt-2 text-3xl font-semibold text-stone-900">Create Review</h1>
                <p class="mt-2 text-sm text-stone-500">Add a new review for the selected product.</p>
            </div>
            <a
                href="{{ route('product.show', $product->id) }}"
                class="inline-flex items-center justify-center rounded-xl bg-stone-900 px-4 py-3 text-sm font-medium text-white transition hover:bg-stone-700"
            >
                Back To Product
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[320px_minmax(0,1fr)]">
            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">Product</p>
                <dl class="mt-3 space-y-3 text-sm text-stone-700">
                    <div>
                        <dt class="font-medium text-stone-900">ID</dt>
                        <dd>{{ $product->id }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-stone-900">Name</dt>
                        <dd>{{ $product->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-stone-900">Price</dt>
                        <dd>${{ number_format((float) $product->price, 2) }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <form method="POST" action="{{ route('review.store', $product->id) }}" class="space-y-4">
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

                    <div class="flex gap-3 pt-2">
                        <button
                            type="submit"
                            class="inline-flex flex-1 items-center justify-center rounded-xl bg-amber-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-amber-500"
                        >
                            Save Review
                        </button>
                        <a
                            href="{{ route('product.show', $product->id) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-4 py-3 text-sm font-medium text-stone-700 transition hover:bg-stone-50"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-review::layouts.master>
