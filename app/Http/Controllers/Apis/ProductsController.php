<?php

namespace App\Http\Controllers\Apis;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Subcategory;
use App\Http\Services\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json()(compact('products'));
    }
    public function create()
    {
        $brands = Brand::select('id', 'name_en', 'name_ar')->orderBy('name_en')->get();
        $subcategories = Subcategory::select('id', 'name_en', 'name_ar')->orderBy('name_en')->get();
        return response()->json()(compact('brands', 'subcategories'));
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::select('id', 'name_en', 'name_ar')->orderBy('name_en')->get();
        $subcategories = Subcategory::select('id', 'name_en', 'name_ar')->orderBy('name_en')->get();
        return response()->json(compact('product', 'brands', 'subcategories'));
    }
    public function store(StoreProductRequest $request)
    {
        $productImage = Media::upload($request->file('image'), 'products');
        $data = $request->except('image');
        $data['image'] = $productImage;
        Product::create($data);
        return response()->json(['success' => 'true', 'Product Stored Successfully']);
    }
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $productImage = Media::upload($request->file('image'), 'products');
            $removedPhotoPath = public_path("assets\images\products\\{$product->image}");
            Media::delete($removedPhotoPath);
            $data['image'] = $productImage;
        }
        $product->update($data);
        return response()->json(['success' => 'true', 'Product Updated Successfully']);
    }
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $removedPhotoPath = public_path("assets\images\products\\{$product->image}");
        Media::delete($removedPhotoPath);
        $product->delete();
        return response()->json(['success' => 'true', 'Product Updated Successfully']);

    }
}
