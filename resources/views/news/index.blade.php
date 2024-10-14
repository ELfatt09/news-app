@extends('layouts.app')

@section('content')
<div class="container py-3">
    <h2 class="text-center">{{ $page }}</h2>
    <div class="justify-content-center">
        @foreach ($Newss as $News)
        <div class="p-2">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 col-md-2 py-auto">
                            @if ($News->image_path)
                            <img src="{{ $News->image_path }}" class="img-fluid rounded-start my-auto" style="max-height: 150px;" alt="{{ $News->title }}">
                            @endif
                        </div>
                        <div class="col-9 col-md-10">
                            <a href="{{ route('news.show', $News->slug ) }}" class="text-decoration-none text-dark">
                                <h5 class="display-6 card-title">{{ $News->title }}</h5>
                                <p class="card-text"><a class="text-dark" href="{{ route('news.author', $News->author->id) }}">{{ $News->author->name }}</a> | <a class="text-dark" href="{{ route('news.category', $News->category) }}">{{ $News->category }}</a> | {{ $News->created_at->diffForHumans() }}</p>
                                <p class="card-text">{{ Str::limit($News->body, 200) }}</p>
                            </a>
                            @if (Auth::check() && Auth::user()->id == $News->author_id)
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('news.edit', $News->slug) }}" class="btn btn-outline-primary btn-sm mr-2">Edit</a>
                                <form action="{{ route('news.destroy', $News->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
