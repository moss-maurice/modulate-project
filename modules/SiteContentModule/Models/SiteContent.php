<?php

namespace Modulatte\Module\SiteContentModule\Models;

use Illuminate\Http\Request;
use mmaurice\modulatte\Support\Traits\Model\ModuleExtensionTrait;

class SiteContent extends \EvolutionCMS\Models\SiteContent
{
    use ModuleExtensionTrait;

    public function fieldsNames()
    {
        return [
            'type' => 'Тип',
            'pagetitle' => 'Заголовок',
            'alias' => 'Псевдоним',
            'published' => 'Опубликован',
        ];
    }

    public function listFields()
    {
        return [
            'type',
            'pagetitle',
            'alias',
            'published',
        ];
    }

    public function itemFields()
    {
        return [
            'type',
            'pagetitle',
            'alias',
            'published',
        ];
    }

    public function filterFields()
    {
        return [
            'type',
            'published',
        ];
    }

    public function orderFields()
    {
        return [];
    }

    public function listFieldsClasses()
    {
        return [
            'type' => 'short',
            'pagetitle' => 'fw-bolder text-truncate',
            'alias' => 'short',
            'published' => 'short',
        ];
    }

    public function itemFieldsClasses()
    {
        return [
            'type' => 'size-s',
            'pagetitle' => 'size-xl',
            'alias' => 'size-s',
            'published' => 'size-s',
        ];
    }

    public function filterFieldsClasses()
    {
        return [
            'type' => 'col-3',
            'published' => 'col-3',
        ];
    }

    public function getTypeListField()
    {
        return collect([
            'template' => 'partials.builder.table.fields.body',
            'attributes' => [
                'name' => 'type',
                'value' => collect([
                    'document' => 'Документ',
                    'reference' => 'Ссылка',
                ])->get($this->type ?? 0),
                'class' => $this->mappedListFieldClass('type'),
            ],
        ]);
    }

    public function getTypeEditorField()
    {
        return collect([
            'template' => 'partials.builder.form.fields.inputSelect',
            'fields' => [
                'name' => 'type',
                'title' => collect($this->fieldsNames())->get('type'),
                'value' => $this->type ?? true,
                'class' => $this->mappedEditorFieldClass('type'),
                'required' => false,
                'list' => collect([
                    'document' => 'Документ',
                    'reference' => 'Ссылка',
                ]),
                'noValue' => true,
            ],
        ]);
    }

    public function getTypeFilterField()
    {
        return collect([
            'template' => 'partials.builder.filter.fields.inputSelect',
            'fields' => [
                'name' => 'type',
                'title' => collect($this->fieldsNames())->get('type'),
                'value' => Request::capture()->input('type'),
                'list' => collect([
                    'document' => 'Документ',
                    'reference' => 'Ссылка',
                ]),
                'class' => $this->mappedFilterFieldClass('type'),
                'comment' => '',
            ],
        ]);
    }

    public function getPublishedListField()
    {
        return collect([
            'template' => 'partials.builder.table.fields.body',
            'attributes' => [
                'name' => 'published',
                'value' => collect([
                    0 => 'Не опубликова',
                    1 => 'Опубликован',
                ])->get($this->published ?? 0),
                'class' => $this->mappedListFieldClass('published'),
            ],
        ]);
    }

    public function getPublishedEditorField()
    {
        return collect([
            'template' => 'partials.builder.form.fields.inputSelect',
            'fields' => [
                'name' => 'published',
                'title' => collect($this->fieldsNames())->get('published'),
                'value' => $this->published ?? true,
                'class' => $this->mappedEditorFieldClass('published'),
                'required' => false,
                'list' => collect([
                    0 => 'Не опубликова',
                    1 => 'Опубликован',
                ]),
                'noValue' => true,
            ],
        ]);
    }

    public function getPublishedFilterField()
    {
        return collect([
            'template' => 'partials.builder.filter.fields.inputSelect',
            'fields' => [
                'name' => 'published',
                'title' => collect($this->fieldsNames())->get('published'),
                'value' => Request::capture()->input('published'),
                'list' => collect([
                    0 => 'Не опубликова',
                    1 => 'Опубликован',
                ]),
                'class' => $this->mappedFilterFieldClass('published'),
                'comment' => '',
            ],
        ]);
    }
}
