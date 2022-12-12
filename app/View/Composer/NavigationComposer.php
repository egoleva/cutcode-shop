<?php

namespace App\View\Composer;


use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\View\View;

class NavigationComposer
{

    public function compose(View $view): void
    {
        $menu = Menu::make()
            ->add(MenuItem::make(route('home'), 'Главная'))
            ->addIf(true, MenuItem::make(route('catalog'), 'Каталог'));

        $view->with('menu', $menu);
    }
}