<?php

namespace Modulatte\Module\MainModule\Controllers;

use Modulatte\Bootstrap;

class MainController extends \mmaurice\modulatte\Support\Controllers\Controller
{
    protected $position = 0;
    protected $slug = 'main';
    protected $name = 'Главная';

    public function index()
    {
        return $this->render('index', [
            'modules' => Bootstrap::modules()
                ->sort(function ($left, $right) {
                    return $left->position() <=> $right->position();
                })
                ->filter(function ($item) {
                    return !($item->id() === $this->module->id());
                })
                ->values(),
        ]);
    }
}
