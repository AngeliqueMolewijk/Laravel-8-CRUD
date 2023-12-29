@extends('puzzels.layout')

@section('content')
    <div class="row margin-tb">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <h2>Puzzel app</h2>
            </div>
            <div class="pull-right mb-2">
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
                    <div class="col-sm-12 col-lg-4  d-flex align-items-stretch">

                        <div class="card  mb-3" style="width: 18rem;">
                            <a href="{{ route('puzzels.edit', $puzzel->id) }}">
                            <img class="card-img-top h-100" src="{{ url('images/' . $puzzel->image) }}" alt="Italian Trulli"
                                width="200px"></a>
                            <div class="card-body d-flex flex-column mb-2">
                                <h5 class="card-title"> {{ $puzzel->title }}</h5>
                                <ul class="list-group list-group-flush mt-auto">
                                    <li class="list-group-item">Nummer :
                                        {{ $puzzel->nummer }}</li>
                                    <li class="list-group-item">Stukjes:
                                        {{ $puzzel->stukjes }}</li>
                                    <li class="list-group-item">
                                        Eigen:

                                        @if ($puzzel->own === 1)
                                            <span style="color: rgb(0, 128, 0);font-weight: bold;">
                                                    Ja
                                            </span>
                                        @else
                                            {{-- <span style="background-color: rgb(220, 217, 217);"> --}}
                                                    Nee
                                            </span>
                                        @endif
                                    </li>
                                    <li class="list-group-item">
                                        Gelegd:
                                        @if ($puzzel->gelegd === 1)
                                        
                                            <span style="color: rgb(0, 128, 0);font-weight: bold;">
                                                    Ja
                                            </span>
                                        @else
                                        
                                            {{-- <span style="background-color: rgb(220, 217, 217);"> --}}
                                                  Nee
                                            </span>
                                        @endif
                                    </li>
                                </ul>

                                <div class="mt-auto text-center">

                                    <form action="{{ route('puzzels.destroy', $puzzel->id) }}" method="POST">

                                        <a class="btn btn-info" href="{{ route('puzzels.show', $puzzel->id) }}">Show</a>

                                        <a class="btn btn-primary" href="{{ route('puzzels.edit', $puzzel->id) }}">Edit</a>

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger"
                                            onclick="return myFunction();">Delete</button>
                                    </form>
                                </div>
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
            if (!confirm("Are You Sure to delete this"))
                event.preventDefault();
        }
    </script>
@endsection
