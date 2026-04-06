<x-category::layouts.master>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-emerald-700">Category Module</p>
                <h1 class="mt-2 text-3xl font-semibold text-stone-900">Category Management</h1>
            </div>
            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('category.index', ['create' => 1]) }}#category-form"
                    class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-emerald-500"
                >
                    Create
                </a>
                <a
                    href="{{ route('category.index') }}"
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

        <div class="grid gap-6 {{ $mode ? 'lg:grid-cols-[380px_minmax(0,1fr)]' : 'lg:grid-cols-1' }}">
            @if ($mode)
                <section id="category-form" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <div class="mb-5">
                    <h2 class="text-xl font-semibold text-stone-900">
                        {{ $mode === 'show' ? 'Category Detail' : ($mode === 'edit' ? 'Edit Category' : 'Create Category') }}
                    </h2>
                    <p class="mt-1 text-sm text-stone-500">
                        {{ $mode === 'show' ? 'Review the selected category information.' : ($mode === 'edit' ? 'Update the selected category.' : 'Add a new category to PostgreSQL.') }}
                    </p>
                </div>

                @if ($mode === 'show' && $selectedCategory)
                    <div class="mt-6 rounded-2xl border border-sky-200 bg-sky-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">Category Detail</p>
                        <dl class="mt-3 space-y-3 text-sm text-stone-700">
                            <div>
                                <dt class="font-medium text-stone-900">ID</dt>
                                <dd>{{ $selectedCategory->id }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-stone-900">Name</dt>
                                <dd>{{ $selectedCategory->name }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-stone-900">Slug</dt>
                                <dd>{{ $selectedCategory->slug }}</dd>
                            </div>
                        </dl>
                    </div>
                @else
                    <form
                        method="POST"
                        action="{{ $mode === 'edit' && $selectedCategory ? route('category.update', $selectedCategory->id) : route('category.store') }}"
                        class="space-y-4"
                    >
                        @csrf
                        @if ($mode === 'edit' && $selectedCategory)
                            @method('PUT')
                        @endif

                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-stone-700">Name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $selectedCategory->name ?? '') }}"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                placeholder="Example: Electronics"
                                required
                            >
                        </div>

                        <div>
                            <label for="slug" class="mb-2 block text-sm font-medium text-stone-700">Slug</label>
                            <input
                                id="slug"
                                name="slug"
                                type="text"
                                value="{{ old('slug', $selectedCategory->slug ?? '') }}"
                                class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                placeholder="example: electronics"
                            >
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button
                                type="submit"
                                class="inline-flex flex-1 items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-emerald-500"
                            >
                                {{ $mode === 'edit' ? 'Update Category' : 'Create Category' }}
                            </button>

                            @if ($mode === 'edit')
                                <a
                                    href="{{ route('category.index') }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-4 py-3 text-sm font-medium text-stone-700 transition hover:bg-stone-50"
                                >
                                    Cancel
                                </a>
                            @endif
                        </div>
                    </form>
                @endif
                </section>
            @endif

            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-stone-900">Category List</h2>
                        <p class="mt-1 text-sm text-stone-500">{{ $categories->total() }} categories found. Showing 10 records per page.</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-stone-200">
                    <table class="min-w-full divide-y divide-stone-200">
                        <thead class="bg-stone-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Slug</th>
                                <th class="whitespace-nowrap px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-stone-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200 bg-white">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-stone-50">
                                    <td class="px-4 py-4 text-sm text-stone-600">{{ $category->id }}</td>
                                    <td class="px-4 py-4 text-sm font-medium text-stone-900">{{ $category->name }}</td>
                                    <td class="px-4 py-4 text-sm text-stone-600">{{ $category->slug }}</td>
                                    <td class="whitespace-nowrap px-4 py-4">
                                        <div class="flex flex-nowrap justify-end gap-2">
                                            <a
                                                href="{{ route('category.show', $category->id) }}"
                                                class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-medium text-blue-700 transition hover:bg-blue-100"
                                            >
                                                Detail
                                            </a>
                                            <a
                                                href="{{ route('category.edit', $category->id) }}#category-form"
                                                class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-medium text-amber-700 transition hover:bg-amber-100"
                                            >
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('category.destroy', $category->id) }}" onsubmit="return confirm('Delete this category?');">
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
                                    <td colspan="4" class="px-4 py-8 text-center text-sm text-stone-500">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $categories->withQueryString()->links() }}
                </div>
            </section>
        </div>
    </div>
</x-category::layouts.master>
