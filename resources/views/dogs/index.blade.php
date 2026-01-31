@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div class="container">

        <div class="row">
            <form class="d-flex justify-content-center w-100">
                <div class="position-relative w-100">
                    <input id="searchInput" class="form-control me-2 rounded-5 form-control-lg" type="search" placeholder="Search" aria-label="Search">
                    <i class="ph ph-magnifying-glass position-absolute searchInput-icon"></i>
                </div>
            </form>
        </div>

        <div class="row">
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

        </div>
    </div>


@endsection
