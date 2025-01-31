@extends('puzzels.layout')

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
    <div class="col-lg-6">
        <img class="card-img-top img-responsive" src="{{ url('images/' . $puzzel->image) }}" alt="Italian Trulli">
    </div>
    <form action="{{ route('puzzels.update', $puzzel->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row mb-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="image">Choose a photo!</label>
                    <input type="file" class="form-control" name="image">
                </div>
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="title" class="form-control"value="{{ $puzzel->title }}"
                        placeholder="Name">
                </div>
                <div class="form-group">
                    <strong>Stukjes:</strong>
                    <input type="text" name="stukjes" class="form-control" value= "{{ $puzzel->stukjes }}"
                        placeholder="Stukjes">
                </div>
                <div class="form-group">
                    <strong>Nummer:</strong>
                    <input type="text" name="nummer" class="form-control" value= "{{ $puzzel->nummer }}"
                        placeholder="Nummer">
                </div>
                <div class="form-group">
                    <strong>Eigen:</strong>
                    <input type="checkbox" name="eigen" id="eigen" value="1"
                        {{ $puzzel->own == 1 ? ' checked' : '' }}>
                    {{-- <input type="checkbox" name="eigen" class="form-control" value= "{{$puzzel->own}}" placeholder="Eigen" value="1"> --}}
                </div>
                <div class="form-group">
                    <strong>Gelegd:</strong>
                    <input type="checkbox" name="gelegd" id="gelegd" value="1"
                        {{ $puzzel->gelegd == 1 ? ' checked' : '' }}>
                    {{-- <input type="checkbox" name="gelegd" class="form-control"value= "{{$puzzel->gelegd}}" placeholder="Gelegd" value="1"> --}}
                </div>
                <div class="form-group">
                    <strong>Note:</strong>
                    <input class="form-control" type="text" name="note" value= "{{ $puzzel->note }}">
                </div>
                <div class="col-xs-12 col-sm-12
                        col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>

    <div class="container">
        <h3> zie alle puzzels uit de lijst</h3>
        @isset($allePuzzels)
            @foreach ($allePuzzels->chunk(3) as $chunk)
                <div class="row">
                    @foreach ($chunk as $puzzelall)
                        <div class="col-sm-12 col-lg-4  d-flex align-items-stretch">

                            <div class="card  mb-3" style="width: 18rem;">
                                <a href="{{ route('puzzels.edit', $puzzelall->id) }}">
                                    <img class="card-img-top h-100" src="{{ url('images/' . $puzzelall->image) }}"
                                        alt="Italian Trulli" width="200px"></a>
                                <div class="card-body d-flex flex-column mb-2">
                                    <h5 class="card-title"> {{ $puzzelall->NaamNederlands }}</h5>
                                    <h5 class="card-title"> {{ $puzzelall->NaamEngels }}</h5>
                                    <ul class="list-group list-group-flush mt-auto">
                                        <li class="list-group-item">Nummer :
                                            {{ $puzzelall->Nr }}</li>
                                        <li class="list-group-item">Stukjes:
                                            {{ $puzzelall->Aant }}</li>
                                        <li class="list-group-item">Jaar:
                                            {{ $puzzelall->Jaar }}</li>
                                        <li class="list-group-item">Tekenaars:
                                            {{ $puzzelall->Tekenaars }}</li>

                                    </ul>

                                    <div class="mt-auto text-center">

                                        <form method="POST"
                                            action="{{ route('addfromallepuzzels', ['puzzelimage' => $puzzelall->image, 'name' => $puzzelall->NaamNederlands, 'nummer' => $puzzelall->Nr, 'aantal' => $puzzelall->Aant]) }}"
                                            accept-charset="UTF-8">

                                            {{-- <a class="btn btn-primary"
                                                href="{{ route('editallepuzzels', $puzzel->id) }}">Edit</a> --}}
                                            <button type="submit" class="btn btn-primary">Puzzel toevoegen aan mijn
                                                lijst</button>

                                            @csrf
                                        </form>
                                        {{-- <a class="btn btn-info" href="{{ route('addimage', ['puzzelid' => $puzzelall->id,'puzzelimage' => $puzzel->image]) }}">Add Image</a> --}}


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endisset
    @endsection
