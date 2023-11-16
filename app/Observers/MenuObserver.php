<?php

namespace App\Observers;

use App\Models\Menu;
use Illuminate\Support\Facades\Log;

class MenuObserver
{
    public function save(Menu $menu)
    {

        $categories = $menu->categories;

        foreach ($categories as $category) {
            $category->update([
                'price' => $category->menus->sum('price')
            ]);
        }
    }
}
