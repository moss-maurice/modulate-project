<?php

namespace testModule\Controllers;

use testModule\Models\Countries;

class MainController extends \mmaurice\modulatte\Support\Controllers\CrudController
{
    protected $position = 0;
    protected $slug = 'main';
    protected $name = 'Страницы';
    protected $model = SiteContent::class;
}
