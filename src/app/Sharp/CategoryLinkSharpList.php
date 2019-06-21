<?php

namespace App\Sharp;

use App\Models\Category;
use App\Models\CategoryLink;
use App\Models\Dealer;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListFilter;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Support\Facades\Log;

class CategoryLinkSharpList extends SharpEntityList implements EntityListFilter
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

        $categoryLinks = CategoryLink::orderBy(
            $sortedBy, $sortedDir
        );

        collect($params->searchWords())
            ->each(function($word) use($categoryLinks) {
                $categoryLinks->where(function ($query) use ($word) {
                    $query->orWhere('url', 'like', $word);
                });
            });

        return $this->setCustomTransformer("category_id", function ($categoryId) {
                return Category::findOrFail($categoryId)->name;
            })
            ->setCustomTransformer("dealer_id", function ($dealerId) {
                return Dealer::findOrFail($dealerId)->site_name;
            })
            ->transform($categoryLinks->paginate(24));
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
            EntityListDataContainer::make('category_id')->setLabel('Category')->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make('dealer_id')->setLabel('Dealer')->setSortable()
        )->addDataContainer(
            EntityListDataContainer::make('url')->setLabel('Url')->setSortable()
        );
    }

    /**
     * Build list layout using ->addColumn()
     *
     * @return void
     */
    function buildListLayout()
    {
        $this->addColumn('id', 1)
            ->addColumn('category_id', 2)
            ->addColumn('dealer_id', 2)
            ->addColumn('url', 4);
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
