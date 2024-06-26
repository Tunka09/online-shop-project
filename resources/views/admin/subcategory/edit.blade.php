@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                    <div class="card-header">
                        <h3>Edit SubCategory
                            <a href="{{url('admin/subcategory')}}" class="btn btn-primary text-white float-end">BACK</a>
                        </h3>
                    </div>

                    <div class="card-body">
                        <form action="{{url('admin/subcategory/') . $subcategory->id}}" method="POST" encType="multipart/form-data">
                            @csrf   
                            @method('PUT')
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" name="category" id="category" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}</option>
                                @endforeach
                                </select>
                                @error('category') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="{{$subcategory->name}}">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary text-white float-end">UPDATE</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection