<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuStoreRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        //$image = $request->file('image')->store('public/menus');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('public/menus/', $filename);
            $validatedData['image'] = "public/menus/$filename";
        }

        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $filename,
            'price' => $request->price
        ]);

        if ($request->has('categories')) {
            $menu->categories()->attach($request->categories);
            $this->updateCategoryPrices($request->categories);
        }


        return to_route('admin.menus.index')->with('success', 'Opção de comida criado com sucesso.');
    }

    private function updateCategoryPrices(array $categoryIds)
{
    $categories = Category::whereIn('id', $categoryIds)->get();

    foreach ($categories as $category) {
        $category->update([
            'price' => $category->menus->sum('price')
        ]);
    }
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required'
    ]);

    // Update the menu attributes
    $menu->fill([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price
    ]);

    if ($request->hasFile('image')) {
        Storage::delete($menu->image);
        $image = $request->file('image')->store('public/menus');
        $menu->image = $image;
    }

    // Save the updated menu
    $menu->save();

    // Sync categories
    if ($request->has('categories')) {
        $menu->categories()->sync($request->categories);
    }

    return redirect()->route('admin.menus.index')->with('success', 'Opção de comida atualizado com sucesso.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        Storage::delete($menu->image);
        $menu->categories()->detach();
        $menu->delete();
        return to_route('admin.menus.index')->with('danger', 'Opção de comida deletado com sucesso.');
    }
}
