@extends('products.layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('puzzels.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <img class="card-img-top" src="{{ url('images/' . $puzzel->image) }}" alt="Italian Trulli" width="500px">

    <form action="{{ route('puzzels.update',$puzzel->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="image">Choose a photo!</label>
                    <input type="file" class="form-control" name="image">
                </div>
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="title" class="form-control"value="{{$puzzel->title}}" placeholder="Name">
                </div>
                <div class="form-group">
                    <strong>Stukjes:</strong>
                    <input type="text" name="stukjes" class="form-control" value= "{{$puzzel->stukjes}}" placeholder="Stukjes">
                </div>            <div class="form-group">
                    <strong>Eigen:</strong>
                    <input type="checkbox" name="eigen" id="eigen" value="1" {{  ($puzzel->own == 1 ? ' checked' : '') }}>
                    {{-- <input type="checkbox" name="eigen" class="form-control" value= "{{$puzzel->own}}" placeholder="Eigen" value="1"> --}}
                </div>            <div class="form-group">
                    <strong>Gelegd:</strong>
                    <input type="checkbox" name="gelegd" id="gelegd" value="1" {{  ($puzzel->gelegd == 1 ? ' checked' : '') }}>
                    {{-- <input type="checkbox" name="gelegd" class="form-control"value= "{{$puzzel->gelegd}}" placeholder="Gelegd" value="1"> --}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
           </div>
        </div>
     </form>
@endsection