<?php

namespace App\Sharp;

use App\Models\Category;
use App\Models\CategoryLink;
use App\Models\Dealer;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\SharpForm;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;

class CategoryLinkSharpForm extends SharpForm
{
    use WithSharpFormEloquentUpdater;

    /**
     * Retrieve a Model for the form and pack all its data as JSON.
     *
     * @param $id
     * @return array
     */
    public function find($id): array
    {
        return $this->transform(
            CategoryLink::findOrFail($id)
        );
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed the instance id
     */
    public function update($id, array $data)
    {
        $categoryLink = $id ? CategoryLink::findOrFail($id) : new CategoryLink;
        $this->save($categoryLink, $data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        CategoryLink::findOrFail($id)->find($id)->delete();
    }

    /**
     * Build form fields using ->addField()
     *
     * @return void
     */
    public function buildFormFields()
    {
        $this->addField(
            SharpFormTextField::make('url')
                ->setLabel('Url')
        )
            ->addField(
                SharpFormSelectField::make("category_id", Category::pluck("name", "id")->all())
                    ->setLabel("Category")
                    ->setDisplayAsDropDown()
            )
            ->addField(
                SharpFormSelectField::make("dealer_id", Dealer::pluck("site_name", "id")->all())
                ->setLabel("Dealer")
                ->setDisplayAsDropdown()
            );
    }

    /**
     * Build form layout using ->addTab() or ->addColumn()
     *
     * @return void
     */
    public function buildFormLayout()
    {
        $this->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('url')
                ->withFields("category_id|6", "dealer_id|6");
        });
    }
}
