@extends('layouts.app')

@section('content')
<div class="container py-3">
    <h2 class="text-center">Latest News</h2>
    <div class="justify-content-center">
        @foreach ($newNewss as $News)
        <div class="p-2">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="row">
                        @if ($News->image_path)
                        <div class="col-3 py-auto">
                                <img src="{{ $News->image_path }}" class="img-fluid rounded-start my-auto" alt="{{ $News->title }}">
                        </div>
                        @endif
                        <div class="col-9">
                            <a href="{{ route('news.show', $News->slug ) }}" class="text-decoration-none text-dark">
                                <h5 class="card-title">{{ $News->title }}</h5>
                                <p class="card-text">{{ $News->author->name }}</p>
                                <p class="card-text">{{ Str::limit($News->body, 200) }}</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-end container-fluid mt-3">
            <a href="{{route('news.index')}}" class="btn btn-outline-dark btn-lg w-100">View All</a>
        </div>
    </div>
</div>
@endsection

