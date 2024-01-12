<?php

namespace Modulatte\Module\SiteContentModule;

class Module extends \mmaurice\modulatte\Support\Module
{
    public function name()
    {
        return 'Страницы';
    }

    public function icon()
    {
        return 'fa fa-folder-open';
    }

    public function position()
    {
        return 9999;
    }
}
