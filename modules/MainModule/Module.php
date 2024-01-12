<?php

namespace Modulatte\Module\MainModule;

class Module extends \mmaurice\modulatte\Support\Module
{
    public function name()
    {
        return 'Доступные модули';
    }

    public function icon()
    {
        return 'fa fa-cog';
    }

    public function position()
    {
        return 0;
    }

    public function catch()
    {
        if ($this->request->input('id') === $this->id()) {
            $this->render('empty');
            return true;
        }

        return false;
    }
}
