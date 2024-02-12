<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::when($request->input('q'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('price', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('pages.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // validate the request...
        $request->validate([
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required|numeric',
            'category_id'   => 'required',
            'stock'         => 'required|numeric',
            'status'        => 'required|boolean',
            'is_favorite'   => 'required|boolean',

        ]);

        $product = new Product;
        $product->name          = $request->name;
        $product->description   = $request->description;
        $product->price         = $request->price;
        $product->category_id   = $request->category_id;
        $product->stock         = $request->stock;
        $product->status        = $request->status;
        $product->is_favorite   = $request->is_favorite;

        $product->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        return view('pages.products.show');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // validate the request...
        $request->validate([
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required|numeric',
            'category_id'   => 'required',
            'stock'         => 'required|numeric',
            'status'        => 'required|boolean',
            'is_favorite'   => 'required|boolean',
        ]);

        // update the request...
        $product                = Product::find($id);
        $product->name          = $request->name;
        $product->description   = $request->description;
        $product->price         = $request->price;
        $product->category_id   = $request->category_id;
        $product->stock         = $request->stock;
        $product->status        = $request->status;
        $product->is_favorite   = $request->is_favorite;
        $product->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            #delete image sebelumnya, jika ada update image
            $oldImagePath = public_path("{$product->image}");
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            #simpan image terbaru
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
