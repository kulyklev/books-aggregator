<?php

namespace App\Sharp;

use App\Models\Book;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListFilter;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;

class BookSharpList extends SharpEntityList  implements EntityListFilter
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
        return $this->transform(Book::paginate(24));
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
            EntityListDataContainer::make("isbn")->setLabel("ISBN")
        )->addDataContainer(
            EntityListDataContainer::make("name")->setLabel("Name")
//        )->addDataContainer(
//            EntityListDataContainer::make("original_name")->setLabel("Original Name")
        )->addDataContainer(
            EntityListDataContainer::make("author")->setLabel("Author")
        )->addDataContainer(
            EntityListDataContainer::make("language")->setLabel("Language")
//        )->addDataContainer(
//            EntityListDataContainer::make("original_language")->setLabel("Original language")
        )->addDataContainer(
            EntityListDataContainer::make("publishing_year")->setLabel("Publishing year")
        )->addDataContainer(
            EntityListDataContainer::make("paperback")->setLabel("Paperback")
        )->addDataContainer(
            EntityListDataContainer::make("publisher")->setLabel("Publisher")
//        )->addDataContainer(
//            EntityListDataContainer::make("category")->setLabel("Category")
//        )->addDataContainer(
//            EntityListDataContainer::make("weight")->setLabel("Weight")
//        )->addDataContainer(
//            EntityListDataContainer::make("product_dimensions")->setLabel("Product dimensions")
//        )->addDataContainer(
//            EntityListDataContainer::make("created_at")->setLabel("Created at")
//        )->addDataContainer(
//            EntityListDataContainer::make("updated_at")->setLabel("Updated at")
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
            ->addColumn("isbn", 2)
            ->addColumn("name", 3)
//            ->addColumn("original_name", 1)
            ->addColumn("author", 1)
            ->addColumn("language", 1)
//            ->addColumn("original_language", 1)
            ->addColumn("publishing_year", 1)
            ->addColumn("paperback", 1)
            ->addColumn("publisher", 1);
//            ->addColumn("category", 1)
//            ->addColumn("weight", 1)
//            ->addColumn("product_dimensions", 1);
//            ->addColumn("created_at", 1)
//            ->addColumn("updated_at", 1);
    }

    /**
     * Build list config
     *
     * @return void
     */
    function buildListConfig()
    {
        $this->setPaginated();
    }
}
