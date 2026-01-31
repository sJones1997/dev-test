@extends('layouts.app')

@section('title', 'Home')


@section('content')
    <h3 class="typewriter mb-4">
        <span id="typewriterText">What pet are you looking for?</span>
    </h3>

    <form class="d-flex justify-content-center w-100" style="max-width: 800px;">
        <div class="position-relative w-100">
            <input id="searchInput" class="form-control me-2 rounded-5 form-control-lg" type="search" placeholder="Search" aria-label="Search">
            <i class="ph ph-magnifying-glass position-absolute searchInput-icon"></i>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('searchInput').focus();

            const titles = [
                "Looking for a Dog Breed?",
                "What Dog Breed Fits You?",
                "Discover Rare Dog Breeds",
                "Which Breed is Right for Your Family?",
                "Discover Dogs by Size and Temperament"
            ];

            const randomTitle = titles[Math.floor(Math.random() * titles.length)];
            document.getElementById('typewriterText').textContent = randomTitle;
        });
    </script>
@endpush
