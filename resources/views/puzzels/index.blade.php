@extends('puzzels.layout')

@section('content')
    <div class="row margin-tb">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <h2>Puzzel app</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('puzzels.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- <table class="table table-bordered">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Stukjes</th>
            <th>eigen</th>
            <th>gelegd</th>

            <th width="280px">Action</th>
        </tr>
    </table> --}}

    <div class="container">
        @foreach ($puzzels->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $puzzel)
                <div class="col-sm-12 col-lg-4">

                    <div class="card  mb-3" style="width: 18rem;">
                        <img class="card-img-top" src="{{ url('images/' . $puzzel->image) }}" alt="Italian Trulli" width="200px">
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
                @endforeach
            </div>
        @endforeach
    </div>
    {{-- {!! $puzzels->links() !!} --}}
    <script>
        function myFunction() {
            if(!confirm("Are You Sure to delete this"))
            event.preventDefault();
        }
       </script>
@endsection
