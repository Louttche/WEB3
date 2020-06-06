@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p class="quote">{{ $post->title }}</p>
        </div>
    </div>
    <div class="row">
        @if ($post->cover_image)
            <div class="col-md-12">
                <img src="{{asset($post->image)}}" class="cover_image">
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <p>{{ $post->content }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="padding-top:40px;">
            <p>{{ count($post->likes) }} Likes |
                <a href="{{ route('blog.post.like', ['id' => $post->id]) }}">Like</a></p>
        </div>
    </div>
@endsection
