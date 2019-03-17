<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 16.03.19
 * Time: 13:45
 */

namespace App\Services\ControllerService;


use App\Http\Resources\CategoryCollection;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;

class CategoryService
{
    /**
     * @return mixed
     */
    public function getAll()
    {
        return new CategoryCollection(Category::paginate(24));
    }

    public function save(string $name): bool
    {
        $newCategory = new Category();
        $newCategory->name = $name;
        return $newCategory->save();
    }

    /**
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Category $category, string $name)
    {
        $category->name = $name;
        return $category->save();
    }

    /**
     * @param Category $category
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Category $category): ?bool
    {
        return $category->delete();
    }
}