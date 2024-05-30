@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Add SubCategory
                    <a href="{{url('admin/subcategory')}}" class="btn btn-primary btn-sm text-white float-end">
                        BACK
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{url('admin/subcategory')}}" method="Post">
                        @csrf

                        <div class="row">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" name="category_id" id="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{$category->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <small class="text-danger">{{$message}}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}" id="name">
                            @error('name') <small class="text-danger">{{$message}}</small> @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary text-white float-end">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection