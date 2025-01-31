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
        <input name="searchnaam" type="search" placeholder="Search" aria-label="Search"
            value="{{ request()->input('searchnaam') }}">
        <label for="aantal">Aantal stukjes:</label>
        <select name="aantal" id="aantal">
            <option value="">--</option>
            <option value="<500" {{ old('aantal', request()->input('aantal')) == '<500' ? 'selected' : '' }}>lager dan 500
            </option>
            <option value="500" {{ old('aantal', request()->input('aantal')) == 500 ? 'selected' : '' }}>500</option>
            <option value="1000" {{ old('aantal', request()->input('aantal')) == 1000 ? 'selected' : '' }}>1000</option>
            <option value="1500" {{ old('aantal', request()->input('aantal')) == 1500 ? 'selected' : '' }}>1500</option>
            <option value="2000" {{ old('aantal', request()->input('aantal')) == 2000 ? 'selected' : '' }}>2000</option>
            <option value=">2000" {{ old('aantal', request()->input('aantal')) == '>2000' ? 'selected' : '' }}>Meer dan
                2000</option>

        </select>
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <div class="container">
        @isset($allePuzzels)
            @foreach ($allePuzzels->chunk(3) as $chunk)
                <div class="row">
                    @foreach ($chunk as $puzzel)
                        <div class="col-sm-12 col-lg-4  d-flex align-items-stretch">
                            <div class="card  mb-3" style="width: 18rem;">
                                {{-- <a href="{{ route('editallepuzzels', $puzzel->id) }}"> --}}
                                <img class="card-img-top h-100" src="{{ url('images/' . $puzzel->image) }}"
                                    alt="Italian Trulli" width="200px">
                                {{-- </a> --}}
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
                                        <form method="POST"
                                            action="{{ route('addfromallepuzzels', ['puzzelimage' => $puzzel->image, 'name' => $puzzel->NaamNederlands, 'nummer' => $puzzel->Nr, 'aantal' => $puzzel->Aant]) }}"
                                            accept-charset="UTF-8">

                                            {{-- <a class="btn btn-primary"
                                                href="{{ route('editallepuzzels', $puzzel->id) }}">Edit</a> --}}
                                            <button type="submit" class="btn btn-primary">Puzzel toevoegen aan mijn
                                                lijst</button>

                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endisset
    </div>
    {{-- {!! $puzzels->links() !!} --}}

@endsection
