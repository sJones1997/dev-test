@extends('layouts.app')

@section('title', isset($dog->name) ?: '')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-12">

                <div class="card mb-4 shadow-sm" style="max-width: 800px; margin: auto;">


                    <div class="row g-0">

                        @if(isset($dog))

                            <div class="col-md-5">
                                <img src="{{ $dog->image }}" class="img-fluid h-100 w-100 object-fit-cover rounded-start" alt="{{ $dog->name }}">
                            </div>

                            <div class="col-md-7">
                                <div class="card-body">
                                    <h2 class="card-title mb-1 heading-breed-name">{{ $dog->name }}</h2>
                                    <p class="text-muted small mb-2">
                                        <strong>Life Span:</strong> {{ $dog->lifeSpan }} |
                                        <strong>Weight:</strong> {{ $dog->weight }} kg |
                                        <strong>Height:</strong> {{ $dog->height }} cm
                                    </p>

                                    @if(!empty($dog->temperament))
                                        <div class="mb-3">
                                            @foreach($dog->temperament as $trait)
                                                <span class="badge bg-primary me-1 mb-1">{{ trim($trait) }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($dog->description)
                                        <h6>Description</h6>
                                        <p class="small">{{ $dog->description }}</p>
                                    @endif

                                    @if($dog->history)
                                        <h6>History</h6>
                                        <p class="small">{{ $dog->history }}</p>
                                    @endif

                                    <div class="mt-auto">
                                        <a href="{{ route('dogs.index') }}" class="btn btn-outline-secondary">
                                            Take Me Back
                                        </a>
                                    </div>

                            @else

                                <div class="col-12 justify-content-center alert alert-warning mb-0">
                                    <h2>Missing dog!</h2>
                                    <p>{{$error}}</p>

                                    <div class="mt-auto">
                                        <a href="{{ route('dogs.index') }}" class="btn btn-outline-secondary">
                                            Take Me Back
                                        </a>
                                    </div>
                                </div>

                            @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
