@extends('layouts.app')
@section('content')
<div class="container py-3">
 <h1 class="display-3 mb-3" align="center">{{ $News->title }}</h1>
 <h3 class="text-secondary text-center"><small>{{ $News->category }}</small></h1>
 @if ($News->image_path != null)
 <div class="bg-gray mb-4" align="center">
    <img src="{{ $News->image_path }}" class="rounded-start my-auto"  style="max-height: 500px; height: 100%; max-width: 100%" alt="{{ $News->title }}">

 </div>
 @endif
 <h6 class="text-secondary mb-3 text-center">Ditulis oleh: <a class="text-dark" href="{{ route('news.author', $News->author->id) }}">{{ $News->author->name }}</a> | <a class="text-dark" href="{{ route('news.category', $News->category) }}">{{ $News->category }}</a> | {{ $News->created_at->diffForHumans() }} | Dilihat {{ $News->views }} kali</h6>
 @if (Auth::check() && Auth::user()->id == $News->author_id)
 <div class="d-flex justify-content-end">
     <a href="{{ route('news.edit', $News->slug) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
     <form action="{{ route('news.destroy', $News->id) }}" method="post">
         @csrf
         @method('delete')
         <button type="submit" class="btn btn-danger btn-sm">Delete</button>
     </form>
 </div>
 @endif
    <p class="container lead">{!! nl2br(e($News->body)) !!}</p>
</div>
@endsection