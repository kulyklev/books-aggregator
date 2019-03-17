<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryLink;
use App\Http\Requests\UpdateCategoryLink;
use App\Models\Category;
use App\Models\CategoryLink;
use App\Services\ControllerService\CategoryLinkService;
use Illuminate\Http\Request;

class CategoryLinkController extends Controller
{
    protected $categoryLinkService;

    public function __construct(CategoryLinkService $categoryLinkService)
    {
        $this->categoryLinkService = $categoryLinkService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryLink $request
     * @param  \App\Models\Category Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryLink $request, Category $category)
    {
        $isSaved = $this->categoryLinkService->save($category, $request->input('url'), $request->input('dealer_id'));
        if ($isSaved) {
            return response('New category link is added', 201);
        } else {
            return response('Some error occurred', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryLink  $categoryLink
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryLink $categoryLink)
    {
        // TODO Is this method necessary???
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryLink $request
     * @param  \App\Models\Category $category
     * @param  \App\Models\CategoryLink $categoryLink
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryLink $request, Category $category, CategoryLink $categoryLink)
    {
        $isUpdated = $this->categoryLinkService->update($categoryLink, $request->input('url'));
        if ($isUpdated) {
            return response('Category link is updated', 200);
        } else {
            return response('Some error occurred', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryLink $categoryLink
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category,CategoryLink $categoryLink)
    {
        $isDeleted = $this->categoryLinkService->delete($categoryLink);
        if ($isDeleted) {
            return response('Category link is deleted', 200);
        } else {
            return response('Some error occurred', 400);
        }
    }
}
