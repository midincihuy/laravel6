<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Contracts\Events\Dispatcher;
use App\Menu;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $main_menu = Menu::whereNull('parent_id')->select([
                'id',
                'text',
                'label',
                'can',
                'url',
                'icon'])->get();
            $result = array();
            foreach($main_menu as $menu){
                $result = $menu->toArray();
                if($menu->submenu->count() > 0){
                foreach($menu->submenu as $submenu){
                    $result['submenu'][] = $submenu->toArray();
                }

                }
            }
            $event->menu->add($result);

            $event->menu->add([
                'text' => 'Configuration',
                'can' => 'configuration_manage',
                'icon' => 'gears',
                'submenu' => [
                [
                'text' => 'Schedulers',
                'url' => 'admin/schedulers',
                'can' => 'schedulers_manage',
                'icon' => 'calendar',
                ],
                [
                'text' => 'Reference',
                'url' => 'admin/references',
                'can' => 'references_manage',
                'icon' => 'gear',
                ],
                [
                'text' => 'Division',
                'url' => 'admin/divisions',
                'can' => 'positions_manage',
                'icon' => 'sitemap',
                ],
                [
                'text' => 'Position',
                'url' => 'admin/positions',
                'can' => 'positions_manage',
                'label' => 'Job',
                'icon' => 'suitcase',
                ],
                ]
            ]);
            $event->menu->add([
                'text' => 'Setting',
                'icon' => 'wrench',
                'can' => 'permissions_manage',
                'submenu' => [
                [
                'text' => 'Menu',
                'icon' => 'list',
                'url' => 'admin/menus',
                'can' => 'menus_manage',
                ],
                [
                'text' => 'Permissions',
                'icon' => 'lock',
                'url' => 'admin/permissions',
                'can' => 'permissions_manage',
                ],
                [
                    'text' => 'Roles',
                    'icon' => 'briefcase',
                    'url' => 'admin/roles',
                    'can' => 'roles_manage',
                ],
                [
                    'text' => 'Users',
                    'icon' => 'users',
                    'url' => 'admin/users',
                    'can' => 'users_manage',
                ]
                ]
            ]);
        });
    }
}
