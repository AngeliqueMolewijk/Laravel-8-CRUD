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
    <form action="{{ route('searchallepuzzels') }}" method="GET" class="d-flex mb-2" enctype="multipart/form-data">
        <input  name="searchnaam" type="search" placeholder="Search" aria-label="Search" value="<?php if (isset($_POST['searchnaam'])) echo $_POST['searchnaam']; ?>">
        <label for="aantal">Aantal stukjes:</label>
        <select name="aantal" id="aantal">
            <option value="">--</option>
            <option value="500">500</option>
            <option value="1000">1000</option>
            <option value="1500">1500</option>
            <option value="2000">2000</option>
        </select>
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <div class="container">
        @foreach ($allePuzzels->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $puzzel)
                    <div class="col-sm-12 col-lg-4  d-flex align-items-stretch">

                        <div class="card  mb-3" style="width: 18rem;">
                            <a href="{{ route('puzzels.edit', $puzzel->id) }}">
                                <img class="card-img-top h-100" src="{{ url('images/' . $puzzel->image) }}"
                                    alt="Italian Trulli" width="200px"></a>
                            <div class="card-body d-flex flex-column mb-2">
                                <h5 class="card-title"> {{ $puzzel->NaamNederlands }}</h5>
                                <h5 class="card-title"> {{ $puzzel->NaamEngels }}</h5>
                                <ul class="list-group list-group-flush mt-auto">
                                    <li class="list-group-item">Nummer :
                                        {{ $puzzel->Nr }}</li>
                                    <li class="list-group-item">Stukjes:
                                        {{ $puzzel->Aant }}</li>
                                    <li class="list-group-item">Jaar:
                                        {{ $puzzel->Jaar }}</li>
                                    <li class="list-group-item">Tekenaars:
                                        {{ $puzzel->Tekenaars }}</li>


                                </ul>

                                <div class="mt-auto text-center">

                                    <form action="{{ route('puzzels.destroy', $puzzel->id) }}" method="POST">
                                        <a class="btn btn-primary" href="{{ route('puzzels.edit', $puzzel->id) }}">Edit</a>

                                        @csrf

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

@endsection
