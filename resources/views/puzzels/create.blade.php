@extends('products.layout')

@section('content')
    <div class="row">
        <div class="margin-tb">
            <div class="pull-left">
                <h2>Add New Product</h2>
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
    <form action="{{ url('getJsonSearch') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 ">
                <div class="form-group">
                    <strong>Naam van de puzzel:</strong>
                    <input type="text" name="titlesearch" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
    @isset($images)
        <div class="container">
            <div class="row">
                @foreach ($images as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12 ">
                        <div class="card " id= "cardid"  style="width: 18rem;" onclick="getImageUrl(this)">
                            <img class="card-img-top" src="{{ $item->link }}" id="getimage" alt="Italian Trulli"
                                width="200px">
                            <div class="card-body">
                                <h5 class="card-title" id="gettitle"> {{ $item->title }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endisset
    <div id="testtext"> test </div>
    <form action="{{ route('puzzels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <img class="card-img-top" id="newimage" src=""  alt="Italian Trulli" width="400px">
        {{-- <input id="newimage" name="newimage" type="image" width="400" alt="Login"
            src="test.jpg" /> --}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="image">Choose a photo!</label>
                    <input type="file"  class="form-control" name="image">
                </div>
                {{-- <div class="form-group">
                    <label for="image">Choose a photo!</label>
                    <input type="image" id="newimage" class="form-control" name="image">
                </div> --}}
                <div class="form-group">
                    <input type="text" id="newurl" class="form-control" name="newurl">
                </div>
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text"  id="newname" name="newname" class="form-control">
                </div>
                <div class="form-group">
                    <strong>Stukjes:</strong>
                    <input type="text" name="stukjes" class="form-control" placeholder="Stukjes">
                </div>
                <div class="form-group">
                    <strong>Eigen:</strong>
                    <input type="checkbox" name="eigen" class="form-control" placeholder="Eigen" value="1">
                </div>
                <div class="form-group">
                    <strong>Gelegd:</strong>
                    <input type="checkbox" name="gelegd" class="form-control" placeholder="Gelegd" value="1">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
    <script type="text/javascript" src="/js/jquery.js"></script>

    {{-- <script> 
    console.log("test");
    </script> --}}

@endsection
