@extends('dashboard.layouts.app')
@section('title', 'Edit Product')
@section('content')
    @include('includes.display-error-messages')
    <div class="col-12">
        <form action="{{ route('dashboard.products.update', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row my-3">
                <div class="col-6">
                    <input type="text" class="form-control" name="name_en" value="{{$product->name_en}}" id="" placeholder="Name In English">
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" name="name_ar" value="{{$product->name_ar}}" id="" placeholder="Name In Arabic">
                </div>
            </div>
            <div class="form-row my-3">
                <div class="col-4">
                    <input type="number" class="form-control" name="code" value="{{$product->code}}" id="" placeholder="Product Code">
                </div>
                <div class="col-4">
                    <input type="number" class="form-control" name="price" value="{{$product->price}}" id="" placeholder="Price">
                </div>
                <div class="col-4">
                    <input type="number" class="form-control" name="quantity" value="{{$product->quantity}}" id="" placeholder="Quantity">
                </div>
            </div>
            <div class="form-row my-3">
                <div class="col-4">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option @selected($product->status) === "1") value="1">Active</option>
                        <option @selected($product->status) === "0") value="0">Not Active</option>
                    </select>
                </div>
                <div class="col-4">
                    <label for="subcategory_id">Sub Category</label>
                    <select name="subcategory_id" id="subcategory_id" class="form-control">
                        @foreach ($subcategories as $sub)
                        <option @selected($product->subcategory_id == $sub->id) value="{{$sub->id}}">{{$sub->name_en}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label for="brand_id">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control">
                        @foreach ($brands as $brand)
                        <option @selected($product->brand_id == $brand->id) value="{{$brand->id}}">{{$brand->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row my-3">
                <div class="col-6">
                    <textarea name="details_en" id="" cols="30" class="form-control" rows="10" placeholder="Details In English">{{$product->details_en}}</textarea>
                </div>
                <div class="col-6">
                    <textarea name="details_ar" id="" cols="30" class="form-control" rows="10" placeholder="Details In Arabic">{{$product->details_ar}}</textarea>
                </div>
            </div>
            <div class="form-row my-3">
            <div class="col-12">
                        <label for="image"> Choose Product Image </label>
                        <input type="file" name="image" class="form-control" id="image">
                    </div>
                    <div class="col-4">
                        <img src="{{ asset('assets/images/products/' . $product->image) }}" alt="{{ $product->name_en }}"
                            class="w-100">
                    </div>
            </div>
            <div class="form-row">
                <div class="col-3 my-3">
                    <button class="btn btn-outline-primary rounded btn-sm"> Update </button>
                </div>
            </div>
        </form>
    </div>
@endsection