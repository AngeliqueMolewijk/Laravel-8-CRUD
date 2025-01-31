@extends('puzzels.layout')

@section('content')
    <div class="row margin-tb">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <h2>Puzzel app</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('puzzels.create') }}"> Nieuwe Puzzel</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <form action="{{ route('puzzels.index') }}">
        <div class="row mb-5">
            <div class="col-md-2">
                Search:
                <input class="form-control form-control-sm" type="search" name="q" value="{{ $q }}">
            </div>
            <div class="col-md-1 col-1">
                Aantal:
                <select name="aantal" class="form-control form-control-sm">
                    <option {{ old('aantal', $aantalReturn) == '' ? 'selected' : '' }} value="">-</option>
                    <option {{ old('aantal', $aantalReturn) == '<500' ? 'selected' : '' }} value="<500">
                        < 500</option>
                    <option {{ old('aantal', $aantalReturn) == '500' ? 'selected' : '' }} value="500">500</option>
                    <option {{ old('aantal', $aantalReturn) == '1000' ? 'selected' : '' }} value="1000">1000</option>
                    <option {{ old('aantal', $aantalReturn) == '1500' ? 'selected' : '' }} value="1500">1500</option>
                    <option {{ old('aantal', $aantalReturn) == '>=2000' ? 'selected' : '' }} value=">=2000">=>2000</option>
                </select>
            </div>
            <div class="col-md-1 col-1">
                Gelegd:
                <select id='gelegd' name="gelegd" class="form-control form-control-sm">
                    <option {{ old('gelegd', $gelegd) == '' ? 'selected' : '' }} value="">-</option>
                    <option {{ old('gelegd', $gelegd) == '0' ? 'selected' : '0' }} value="0">niet gelegd
                    </option>
                    <option {{ old('aantal', $gelegd) == '1' ? 'selected' : '1' }} value="1">gelegd</option>
                </select>
            </div>
            <div class="col-md-1 col-1">
                Eigen:
                <select id='eigen' name="eigen" class="form-control form-control-sm">
                    <option {{ old('eigen', $eigen) == '' ? 'selected' : '' }} value="">-</option>
                    <option {{ old('eigen', $eigen) == '0' ? 'selected' : '0' }} value="0">niet eigen
                    </option>
                    <option {{ old('eigen', $eigen) == '1' ? 'selected' : '1' }} value="1">eigen</option>
                </select>
            </div>
            <div class="col-md-1 col-1">
                sortBy:
                <select name="sortBy" class="form-control form-control-sm" value="{{ $sortBy }}">
                    @foreach (['id', 'title', 'stukjes'] as $col)
                        <option @if ($col == $sortBy) selected @endif value="{{ $col }}">
                            {{ ucfirst($col) }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-1 col-1">
                Orderby:
                <select name="orderBy" class="form-control form-control-sm" value="{{ $orderBy }}">
                    @foreach (['asc', 'desc'] as $order)
                        <option @if ($order == $orderBy) selected @endif value="{{ $order }}">
                            {{ ucfirst($order) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 col-2 pt-3">

                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ url('/') }}" class="btn btn-xs btn-info pull-right">Reset</a>

            </div>
        </div>
    </form>

    <div class="container">
        @foreach ($puzzels->chunk(3) as $chunk)
            <div class="row">
                @foreach ($chunk as $puzzel)
                    <div class="col-sm-12 col-lg-4  d-flex align-items-stretch">

                        <div class="card  mb-3" style="width: 18rem;">
                            <a href="{{ route('puzzels.edit', $puzzel->id) }}">
                                <img class="card-img-top h-100" src="{{ url('images/' . $puzzel->image) }}"
                                    alt="Italian Trulli" width="200px"></a>
                            <div class="card-body d-flex flex-column mb-2">
                                <h5 class="card-title"> {{ $puzzel->title }}</h5>
                                <p class="card-title"> {{ $puzzel->note }}</p>

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
        $("select").change(function() {
            this.form.submit();
        });
    </script>
@endsection
