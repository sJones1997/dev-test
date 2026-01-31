@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div class="container">

        <div class="row">
            <form
                class="d-flex justify-content-center w-100"
                method="GET"
                action="{{route('dogs.index')}}"
                >
                <div class="position-relative w-100 mb-4">
                    <input
                        id="searchInput"
                        class="form-control me-2 rounded-5 form-control-lg mb-0"
                        name="search"
                        type="search"
                        value="{{request('search')}}"
                        placeholder="Search by Breed"
                        aria-label="Search">
                    <small class="position-absolute end-0 top-50 translate-middle-y me-3 text-muted">
                        Press Enter to search
                    </small>
                </div>
            </form>
        </div>

        <div class="row">

            @if(!isset($error) && $dogs->count())

                @foreach($dogs as $dog)
                    <div class="col-3 mb-4">

                        <div class="card h-100">
                            <img src="{{$dog->image}}" class="card-img-top card-image-fixed" alt="{{$dog->name}}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{$dog->name}}</h5>
                                <p class="card-text">{{$dog->description}}</p>
                                <button class="btn btn-primary btn-sm mt-auto">Find out more</button>
                            </div>
                        </div>
                    </div>
                @endforeach

            @elseif (!isset($error) && !$dogs->count())

                <h1>You're barking mad! Not a dog in sight.</h1>
                <a href="{{route('dogs.index')}}">Click here to see some pooches</a>

            @else

                <div class="col-12 justify-content-center alert alert-danger">
                    <h2>Looks like something has gone wrong!</h2>
                    <p>{{$error}}</p>
                </div>

            @endif

        </div>
    </div>


@endsection
