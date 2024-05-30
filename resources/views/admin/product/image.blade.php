@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <form action="{{url('admin/product/image/'. $product->id)}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-10">
                            <label for="">Зураг оруулна уу /Олон байх боломжтой/</label>
                            <input type="file" name="image[]" multiple class="form-control">
                        </div>
                        @error('image') <small class="text-danger">{{message}}</small> @enderror

                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-success text-white">SAVE</button>
                        </div>
                    </div>
                </form>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($product->productImages as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    <img src="{{asset($item->image)}}" style="height:80px, width:80px" alt="image">
                                </td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    <form action="{{url('admin/product/image/delete/'.$item->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm text-white float-end" onclick="return confirm('Are you sure you want to delete this image?')">DELETE</button>
                                    </form>
                                </td>
                            </tr>
                                
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection