<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 16.03.19
 * Time: 13:45
 */

namespace App\Services\ControllerService;


use App\Http\Resources\CategoryCollection;
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
}