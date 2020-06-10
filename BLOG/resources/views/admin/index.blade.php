@extends('layouts.master')

@section('content')
    @if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{ Session::get('info') }}</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.create') }}" class="btn btn-success">New Post</a>
        </div>
    </div>
    <hr>
    @foreach($posts as $post)
        <div class="row">
            <div class="col-md-12">
                <p><strong>{{ $post->title }}</strong>
                <a href="{{ route('blog.post', ['id' => $post ->id]) }}">View</a>
                @if (auth()->user()->id === $post->user_id)
                    <a href="{{ route('admin.edit', ['id' => $post ->id]) }}">Edit</a>
                    <a href="{{ route('admin.delete', ['id' => $post ->id]) }}">Delete</a>       
                @endif
                </p>
            </div>
        </div>
    @endforeach
@endsection


<!-- <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control">
        <br>
        <button class="btn btn-success">Import User Data</button>
        <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>
    </form> -->