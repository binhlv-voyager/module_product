<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Http\Requests\StoreCategoryRequest;
use Modules\Category\Http\Requests\UpdateCategoryRequest;
use Modules\Category\Services\CategoryServiceInterface;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryServiceInterface $categories,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'data' => $this->categories->getAllCategories(),
            ]);
        }

        $categories = $this->categories->paginateCategories(10);
        $selectedCategory = null;
        $mode = null;

        if ($request->filled('show')) {
            $selectedCategory = $this->categories->getCategoryById($request->integer('show'));
            $mode = 'show';
        } elseif ($request->filled('edit')) {
            $selectedCategory = $this->categories->getCategoryById($request->integer('edit'));
            $mode = 'edit';
        }

        return view('category::index', [
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'mode' => $mode,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('category.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categories->createCategory($request->validated());

        return redirect()
            ->route('category.index')
            ->with('status', 'Category created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request, $id)
    {
        if (! ($request->expectsJson() || $request->is('api/*'))) {
            return redirect()->route('category.index', ['show' => $id]);
        }

        return response()->json([
            'data' => $this->categories->getCategoryById((int) $id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return redirect()->route('category.index', ['edit' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $this->categories->updateCategory((int) $id, $request->validated());

        return redirect()
            ->route('category.index')
            ->with('status', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->categories->deleteCategory((int) $id);

        return redirect()
            ->route('category.index')
            ->with('status', 'Category deleted successfully.');
    }
}
