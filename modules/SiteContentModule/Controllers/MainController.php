<?php

namespace Modulatte\Module\SiteContentModule\Controllers;

use Modulatte\Module\SiteContentModule\Models\SiteContent;

class MainController extends \mmaurice\modulatte\Support\Controllers\CrudController
{
    protected $position = 0;
    protected $slug = 'main';
    protected $name = 'Страницы';
    protected $model = SiteContent::class;
}
