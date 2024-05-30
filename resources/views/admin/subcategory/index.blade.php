@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3>Sub-Category
                        <a href="{{url('admin/subcategory/create')}}"
                        class="btn btn-primary btn-sn text-white float-end">
                            Add SubCategory
                        </a>
                    </h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($subcategories as $item)
                                <tr>
                                    <th>{{$item->id}}</th>
                                    <th>{{$item->category->name}}</th>
                                    <th>{{$item->name}}</th>
                                    <th>{{$item->slug}}</th>
                                    <th>{{$item->created_at}}</th>
                                    <th>{{$item->updated_at}}</th>
                                    <td>
                                        <a href="{{url('admin/subcategory/edit/' . $item->id)}}"
                                        class="btn btn-success btn-sm text-white float-end">
                                        EDIT
                                        </a>
                                        <form action="{{url('admin/subcategory/delete/'.$item->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm text-white float-end" onclick="return confirm('Are you sure you want to delete this subcategory?')">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection