<?php

namespace testModule\Models;

use Illuminate\Http\Request;
use mmaurice\modulatte\Traits\Model\ModuleExtensionTrait;

class SiteContent extends \EvolutionCMS\Main\Components\Models\SiteContent
{
    use ModuleExtensionTrait;

    public function fieldsNames()
    {
        return [
            'id' => 'Идентификатор',
            'alias' => "Название",
            'title' => 'Заголовок',
            'description' => 'Описание',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего изменения',
            'deleted_at' => 'Дата удаления',
        ];
    }

    public function listFields()
    {
        return [
            'title',
            'alias',
            'description',
        ];
    }

    public function itemFields()
    {
        return [
            'title',
            'alias',
            'description',
        ];
    }

    public function filterFields()
    {
        return [
            'title',
        ];
    }

    public function listFieldsClasses()
    {
        return [
            'title' => 'fw-bolder text-truncate',
            'name' => 'short',
        ];
    }

    public function itemFieldsClasses()
    {
        return [];
    }

    public function filterFieldsClasses()
    {
        return [
            'title' => 'col-3',
        ];
    }

    public function filterRules()
    {
        return [];
    }

    public function getTitleFilterField()
    {
        return collect([
            'template' => 'partials.builder.filter.fields.inputSelect',
            'fields' => [
                'name' => 'title',
                'title' => collect($this->fieldsNames())->get('title'),
                'value' => Request::capture()->input('title'),
                'list' => static::published()
                    ->pluck('title', 'title'),
                'class' => (collect($this->filterFields())->has('title') ? collect($this->filterFields())->get('title') : ''),
                'comment' => '',
            ],
        ]);
    }
}
