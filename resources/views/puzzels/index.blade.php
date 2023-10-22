@extends('products.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 8 CRUD Example from scratch - ItSolutionStuff.com</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Stukjes</th>
            <th>eigen</th>
            <th>gelegd</th>

            <th width="280px">Action</th>
        </tr>
        @foreach ($puzzels as $puzzel)
        <tr>
            {{-- <td>{{ ++$i }}</td> --}}
            <td><img src="{{ $puzzel->image}}" alt="Italian Trulli"></td>

            <td>{{ $puzzel->title }}</td>
            <td>{{ $puzzel->stukjes }}</td>
            <td>{{ $puzzel->eigen }}</td>
            <td>{{ $puzzel->gelegd }}</td>

            <td>
                <form action="{{ route('products.destroy',$puzzel->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('products.show',$puzzel->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('products.edit',$puzzel->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $puzzels->links() !!}
      
@endsection