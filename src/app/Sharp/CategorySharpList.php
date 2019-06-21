<?php

namespace App\Sharp;

use App\Models\Category;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListFilter;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Support\Facades\Log;

class CategorySharpList extends SharpEntityList implements EntityListFilter
{
    /**
    * @return array
    */
    public function values()
    {
        //
    }

    /**
     * Retrieve all rows data as array.
     *
     * @param EntityListQueryParams $params
     * @return array
     */
    function getListData(EntityListQueryParams $params)
    {
        //I added this variables to fix shark problem with default values in EntityListQueryParams
        //I have no idea why it worked one day and stopped another
        //The problem occurs when you open sharklist from menu.
        $sortedBy = $params->sortedDir() == null ? 'id' : $params->sortedBy();
        $sortedDir = $params->sortedDir() == null ? 'asc' : $params->sortedDir();

        $categories = Category::orderBy(
            $sortedBy, $sortedDir
        );

        collect($params->searchWords())
            ->each(function($word) use($categories) {
                $categories->where(function ($query) use ($word) {
                    $query->orWhere('name', 'like', $word);
                });
            });

        return $this->transform($categories->paginate(24));
    }

    /**
     * Build list containers using ->addDataContainer()
     *
     * @return void
     */
    function buildListDataContainers()
    {
        $this->addDataContainer(
            EntityListDataContainer::make('id')->setLabel('Id')->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make('name')->setLabel('Name')->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make('created_at')->setLabel('Created at')->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make('updated_at')->setLabel('Updated at')->setSortable()
        );
    }

    /**
     * Build list layout using ->addColumn()
     *
     * @return void
     */
    function buildListLayout()
    {
        $this->addColumn("id", 1)
            ->addColumn('name', 3)
            ->addColumn('created_at', 3)
            ->addColumn('updated_at', 3);
    }

    /**
     * Build list config
     *
     * @return void
     */
    function buildListConfig()
    {
        $this->setPaginated()
            ->setSearchable();
    }
}
