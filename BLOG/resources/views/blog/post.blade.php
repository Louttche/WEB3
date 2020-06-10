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
            @php ($found = false)
            @php ($likeid = 0)
            @foreach ($post->likes as $like)                
                @if ($like->user_id === auth()->user()->id)
                    @php ($found = true)
                    @php ($likeid = $like->id)
                    @break
                @endif
            @endforeach
            @if ($found === true)
                <a href="{{ route('blog.post.unlike', ['id' => $likeid]) }}">unlike</a>
            @else
                <a href="{{ route('blog.post.like', ['id' => $post->id]) }}">like</a>
            @endif
            </p>
        </div>
    </div>
@endsection
