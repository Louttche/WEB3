<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <h1 style="text-align:center; padding-top: 5%; padding-bottom: 10px;">{{$post->title}}</h1>

    <img class="cover_image" src="{{$post->cover_image}}">

    <p style="padding-top: 30px; padding-bottom: 30px">
        {{$post->content}}
    </p>
    
  </body>
</html>