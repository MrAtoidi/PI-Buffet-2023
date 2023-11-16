<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image1', 'image2', 'image3', 'price', 'guest_number', 'description'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'category_menu');
    }

    public function getTotalPriceAttribute()
    {
        // Obtém todos os menus associados a esta categoria
        $menus = $this->menus;

        // Calcula a soma dos preços dos menus
        $totalPrice = $menus->sum('price');

        return $totalPrice;
    }
}
