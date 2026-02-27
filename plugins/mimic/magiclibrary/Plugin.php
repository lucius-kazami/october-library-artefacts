<?php namespace Mimic\MagicLibrary;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    /**
     * Registers back-end navigation items for this plugin.
     */
    public function registerNavigation()
    {
        return [
            'magiclibrary' => [
                'label'       => 'Библиотека артифактов',
                'url'         => \Backend::url('mimic/magiclibrary/items'),
                'icon'        => 'icon-magic',
                'permissions' => ['mimic.magiclibrary.*'],
                'order'       => 500,

                'sideMenu' => [
                    'items' => [
                        'label'       => 'Предметы',
                        'icon'        => 'icon-cube',
                        'url'         => \Backend::url('mimic/magiclibrary/items'),
                        'permissions' => ['mimic.magiclibrary.items'],
                    ],
                    'categories' => [
                        'label'       => 'Категории',
                        'icon'        => 'icon-tags',
                        'url'         => \Backend::url('mimic/magiclibrary/categories'),
                        'permissions' => ['mimic.magiclibrary.categories'],
                    ],
                ],
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'mimic.magiclibrary.items' => [
                'label' => 'Управление артифактоми',
                'tab' => 'Библиотека артифактов'
            ],
            'mimic.magiclibrary.categories' => [
                'label' => 'Управление категориями',
                'tab' => 'Библиотека артифактов'
            ],
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('magiclibrary.seed', 'Mimic\MagicLibrary\Console\SeedMagicLibrary');
    }
}
