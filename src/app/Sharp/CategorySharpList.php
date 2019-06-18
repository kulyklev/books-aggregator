<?php

namespace App\Sharp;

use App\Models\Category;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListFilter;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;

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
        return $this->transform(Category::all());
    }

    /**
     * Build list containers using ->addDataContainer()
     *
     * @return void
     */
    function buildListDataContainers()
    {
        $this->addDataContainer(
            EntityListDataContainer::make('id')->setLabel('Id')
        )->addDataContainer(
            EntityListDataContainer::make('name')->setLabel('Name')
        )->addDataContainer(
            EntityListDataContainer::make('created_at')->setLabel('Created at')
        )->addDataContainer(
            EntityListDataContainer::make('updated_at')->setLabel('Updated at')
        );
    }

    /**
     * Build list layout using ->addColumn()
     *
     * @return void
     */
    function buildListLayout()
    {
        $this->addColumn("id", 3)
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
        // TODO: Implement buildListConfig() method.
    }
}
