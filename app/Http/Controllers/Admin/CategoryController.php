<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(CategoryStoreRequest $request)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'guest_number' => 'required',
        'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'image2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'image3' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $file1 = $request->file('image1');
    $file2 = $request->file('image2');
    $file3 = $request->file('image3');

    $filename1 = time() . '_1.' . $file1->getClientOriginalExtension();
    $file1->move('public/categories/', $filename1);

    $filename2 = time() . '_2.' . $file2->getClientOriginalExtension();
    $file2->move('public/categories/', $filename2);

    $filename3 = time() . '_3.' . $file3->getClientOriginalExtension();
    $file3->move('public/categories/', $filename3);

    Category::create([
        'name' => $validatedData['name'],
        'description' => $validatedData['description'],
        'guest_number' => $validatedData['guest_number'],
        'image1' => "$filename1",
        'image2' => "$filename2",
        'image3' => "$filename3",
    ]);

    return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'guest_number' => 'required',
            'image1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];
        $category->guest_number = $validatedData['guest_number'];

        Log::info(Storage::exists($category->image1));
        Log::info($category->image1);

        if ($request->hasFile('image1')) {

        if (File::exists($category->image1)) {
            File::delete($category->image1);
        }
        $file1 = $request->file('image1');
        $filename1 = time() . '_1.' . $file1->getClientOriginalExtension();
        $file1->move('public/categories/', $filename1);
        $category->image1 = "$filename1";
    }

        if ($request->hasFile('image2')) {
        if (Storage::exists($category->image2)) {
            Storage::delete($category->image2);
        }
        $file2 = $request->file('image2');
        $filename2 = time() . '_2.' . $file2->getClientOriginalExtension();
        $file2->move('public/categories/', $filename2);
        $category->image2 = "$filename2";
    }

        if ($request->hasFile('image3')) {
        if (Storage::exists($category->image3)) {
            Storage::delete($category->image3);
        }
        $file3 = $request->file('image3');
        $filename3 = time() . '_3.' . $file3->getClientOriginalExtension();
        $file3->move('public/categories/', $filename3);
        $category->image3 = "$filename3";
    }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Storage::delete($category->image1);
        Storage::delete($category->image2);
        Storage::delete($category->image3);
        $category->menus()->detach();
        $category->delete();

        return to_route('admin.categories.index')->with('danger', 'Category deleted successfully.');
    }
}
