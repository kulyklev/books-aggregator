<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCategory;
use App\Http\Requests\StoreCategory;
use App\Models\Category;
use App\Services\ControllerService\CategoryService;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->categoryService->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategory $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $isSaved = $this->categoryService->save($request->input('name'));
        if ($isSaved) {
            return response('New category saved', 201);
        } else {
            return response('Some error occurred', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \App\Http\Resources\Category
     */
    public function show(Category $category)
    {
        return $this->categoryService->show($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategory $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request, Category $category)
    {
        $isUpdated = $this->categoryService->update($category, $request->input('name'));
        if ($isUpdated) {
            return response('Category \'' . $category->name . '\' is updated', 200);
        } else {
            return response('Some error occurred', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $isDeleted = $this->categoryService->delete($category);
        if ($isDeleted) {
            return response('Category \'' . $category->name . '\' is deleted', 200);
        } else {
            return response('Some error occurred', 400);
        }
    }

    public function getCategory(GetCategory $request, Category $category)
    {
        $books = $this->categoryService->getCategory($category);
        return $books;
    }
}
