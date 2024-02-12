<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    //index
    public function index(Request $request)
    {
        $categories = Category::when($request->input('q'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    //create
    public function create()
    {
        return view('pages.categories.create');
    }

    //store
    public function store(Request $request)
    {
        //validate the request...
        $request->validate([
            'name'  => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //store the request...
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    //show
    public function show($id)
    {
        return view('pages.categories.show');
    }

    //edit
    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.categories.edit', compact('category'));
    }

    //update
    public function update(Request $request, $id)
    {
        //validate the request...
        $request->validate([
            'name' => 'required',
        ]);

        //update the request...
        $category               = Category::find($id);
        $category->name         = $request->name;
        $category->description  = $request->description;
        $category->save();
        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            #delete image sebelumnya, jika ada update image
            $oldImagePath = public_path("{$category->image}");
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        #cek dahulu, category id ini, di pake gak di Product
        $cekData = Product::where('category_id', $id)->get();

        if(count($cekData) > 0){
            return redirect()->back()->with('error', 'Category cannot deleted!');
        }
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
