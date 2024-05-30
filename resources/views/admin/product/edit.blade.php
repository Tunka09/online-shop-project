@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Edit Product
                        <a href="{{ url('admin/product') }}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/product/'.$product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="form-group">
                                <label for="subcategory">SubCategory Select</label>
                                <select class="form-control" name="subcategory" id="subcategory">
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{$subcategory->id}}" {{ $product->sub_category_id == $subcategory->id ? 'selected' : '' }}>
                                            {{$subcategory->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subcategory') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="brand">Brand Select</label>
                                <select class="form-control" name="brand" id="brand">
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{$brand->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" id="name" required>
                                @error('name') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="slug">Product Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ $product->slug }}" id="slug" required>
                                @error('slug') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="price">Product Price</label>
                                <input type="number" name="price" class="form-control" value="{{ $product->price }}" id="price" min="0" required>
                                @error('price') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="sale_percent">Product Sale Percent</label>
                                <input type="number" name="sale_percent" class="form-control" value="{{ $product->sale_percent }}" id="sale_percent" min="0" max="100" required>
                                @error('sale_percent') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="quantity">Product Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" id="quantity" min="1" required>
                                @error('quantity') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description">Product Description</label>
                                <textarea name="description" id="description" 
                                class="form-control" rows="4">{{ $product->description }}</textarea>
                                @error('description') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="image">Product Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                <img src="{{ asset("$product->image") }}" height="70px" width="70px" alt="image">
                                @error('image') <small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <input type="checkbox" name="status" id="status" value="1" {{ $product->status == "1" ? "checked":"" }}>
                                    (Checked = Private, Unchecked = Public)
                                    @error('Status') <small class="text-danger">{{$message}}</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trending">Trending</label>
                                    <input type="checkbox" name="trending" id="trending" value="1" {{ $product->trending == "1" ? "checked":"" }}>
                                    (Checked = Private, Unchecked = Public)
                                    @error('trending') <small class="text-danger">{{$message}}</small> @enderror
                                </div>
                            </div>

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary float-end text-white">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
