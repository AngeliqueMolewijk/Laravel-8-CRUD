@extends('products.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('puzzels.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    {{-- <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $puzzel->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Details:</strong>
                {{ $puzzel->detail }}
            </div>
        </div>
    </div> --}}
    <div class="col-lg-4 col-sm 2 mb-3 mb-sm-0">

        <div class="card" style="width: 18rem;">
            <img class="card-img-top img-responsive" src="{{ url('images/' . $puzzel->image) }}" alt="Italian Trulli" width="1000PX">
            <div class="card-body">
                <h5 class="card-title"> {{ $puzzel->title }}</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Stukjes:
                        {{ $puzzel->stukjes }}</li>
                        <li class="list-group-item">Eigen:
                        @if($puzzel->own === 1)
                        Ja
                        @else
                        Nee    
                        @endif
                    </li>
                    <li class="list-group-item">Gelegd:
                        @if ($puzzel->gelegd ===1)
                        Ja
                        @else
                            Nee
                        @endif
                       </li>
                  </ul>
                
                
                

                <form action="{{ route('puzzels.destroy', $puzzel->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('puzzels.show', $puzzel->id) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('puzzels.edit', $puzzel->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger" onclick="return myFunction();">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection