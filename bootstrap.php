<?php

namespace Modulatte;

class Bootstrap
{
    protected static function autoload()
    {
        require_once realpath(dirname(__FILE__) . '/vendor/autoload.php');
    }

    public static function modules()
    {
        $modulesPath = realpath(dirname(__FILE__) . '/modules');

        return collect(scandir($modulesPath))
            ->map(function ($item) use ($modulesPath) {
                return (!in_array($item, ['.', '..']) ? (is_dir(realpath("{$modulesPath}/{$item}")) ? $item : null) : null);
            })
            ->filter()
            ->map(function ($item) {
                $className = __NAMESPACE__ . "\\Module\\{$item}\\Module";

                return class_exists($className) ? (new $className) : null;
            })
            ->filter()
            ->values();
    }

    public static function runModule()
    {
        static::autoload();

        static::modules()
            ->each(function ($item) {
                return !$item->catch();
            });
    }

    public static function initModules()
    {
        static::autoload();

        return static::modules()
            ->sort(function ($left, $right) {
                return $left->position() <=> $right->position();
            })
            ->filter()
            ->values()
            ->map(function ($item) {
                return [
                    'slug' => $item->slug(),
                    'name' => $item->name(),
                    'path' => realpath(dirname(__FILE__) . '/index.php'),
                    'icon' => $item->icon(),
                    'position' => $item->position(),
                ];
            });
    }
}
