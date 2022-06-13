<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')->get();
        return view('dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $subcategories = DB::table('subcategories')->select('id', 'name_en')->orderBy('name_en')->get();
        $brands = DB::table('brands')->select('id', 'name_en')->orderBy('name_en')->get();
        return view('dashboard.products.create', compact('subcategories', 'brands'));
    }
    public function edit($id)
    {
        $subcategories = DB::table('subcategories')->select('id', 'name_en')->orderBy('name_en')->get();
        $brands = DB::table('brands')->select('id', 'name_en')->orderBy('name_en')->get();
        $product = DB::table('products')->where('id', $id)->first();
        if (is_null($product)) {
            abort(404);
        }
        return view('dashboard.products.edit', compact('subcategories', 'brands', 'product'));
    }

    public function store(REQUEST $request)
    {
        //dd(public_path('assets\images\products'));
        $request->validate([
            'name_en' => ['required', 'max:255'],
            'name_ar' => ['required', 'max:255'],
            'code' => ['required', 'digits:5', 'unique:products,code'],
            'price' => ['required', 'numeric', 'between:1,99999.99'],
            'quantity' => ['nullable', 'integer', 'between:1,999'],
            'details_en' => ['required'],
            'details_ar' => ['required'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'subcategory_id' => ['required', 'integer', 'exists:subcategories,id'],
            'image' => ['required', 'max:1000', 'mimes:png,jpg,jpeg']
        ]);
        $productImage = uniqid() . "." . $request->file('image')->extension();
        $request->file('image')->move(public_path('assets\images\products'), $productImage);
        $data = $request->except('_token', 'image');
        $data['image'] = $productImage;
        DB::table('products')->insert($data);
        return redirect()->route('dashboard.products.index')->with('success', 'product inserted successfully');
    }
    public function update(Request $request, $id)
    {
        //dd($request->all(), $id);
        //validate then upload image(optional) then insert ino database then message
        $request->validate([
            'name_en' => ['required', 'max:255'],
            'name_ar' => ['required', 'max:255'],
            'code' => ['required', 'digits:5', "unique:products,code,$id,id"],
            'price' => ['required', 'numeric', 'between:1,99999.99'],
            'quantity' => ['nullable', 'integer', 'between:1,999'],
            'details_en' => ['required'],
            'details_ar' => ['required'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'subcategory_id' => ['required', 'integer', 'exists:subcategories,id'],
            'image' => ['nullable', 'max:1000', 'mimes:png,jpg,jpeg']
        ]);
        $product = DB::table('products')->find($id);
        // if (is_null($product)) {
        //     abort(404);
        // }
        $data = $request->except('_token', '_method', 'image');
        if ($request->hasFile('image')) {
            //upload image
            $productImage = uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('assets\images\products'), $productImage);
            //remove image
            $removedPhotoPath = public_path("assets\images\products\\{$product->image}");
            if (file_exists($removedPhotoPath)) {
                unlink($removedPhotoPath);
            }
            //update image
            $data['image'] = $productImage;
        }
        DB::table('products')->where('id', $id)->update($data);
        return redirect()->route('dashboard.products.index')->with('success', 'product updated successfully');
    }

    public function destroy($id)
    {
        $product = DB::table('products')->find($id);
        if (is_null($product)) {
            abort(404);
        }
        $removedPhotoPath = public_path("assets\images\products\\{$product->image}");
        if (file_exists($removedPhotoPath)) {
            unlink($removedPhotoPath);
        }
        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('dashboard.products.index')->with('success', 'product deleted successfully');
    }
    public function toggleStatus(Request $request, $id)
    {
        DB::table('products')->where('id', $id)->update(['status' => (int)!$request->input('status')]);
        return redirect()->route('dashboard.products.index')->with('success', 'Product Status Updated Successfully');
    }
}
