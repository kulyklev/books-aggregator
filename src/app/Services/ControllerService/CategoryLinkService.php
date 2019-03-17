<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 17.03.19
 * Time: 15:07
 */

namespace App\Services\ControllerService;


use App\Models\Category;
use App\Models\CategoryLink;

class CategoryLinkService
{
    /**
     * @param \App\Models\Category Category $category
     * @param string $url
     * @param int $dealerId
     * @return bool
     */
    public function save(Category $category, string $url, int $dealerId): bool
    {
        $newCategoryLink = new CategoryLink();
        $newCategoryLink->category_id = $category->id;
        $newCategoryLink->dealer_id = $dealerId;
        $newCategoryLink->url = $url;
        return $newCategoryLink->save();
    }

    /**
     * @param \App\Models\CategoryLink $categoryLink
     * @param string $url
     * @return bool
     */
    public function update(CategoryLink $categoryLink, string $url): bool
    {
        $categoryLink->url = $url;
        return $categoryLink->save();
    }

    /**
     * @param \App\Models\CategoryLink $categoryLink
     * @return bool|null
     * @throws \Exception
     */
    public function delete(CategoryLink $categoryLink): ?bool
    {
        return $categoryLink->delete();
    }
}