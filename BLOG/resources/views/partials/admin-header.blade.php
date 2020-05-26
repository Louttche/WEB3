<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('blog.index') }}">Home</a>
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ route('admin.index') }}">Posts</a></li>
                <li class="active"><a href="{{ route('admin.profile') }}">Profile</a></li>
                <li class="active"><a href="{{ url('/logout') }}">Logout</a></li>
                <li class="active" style="position:fixed;right:0;width:100px;"> <a>
                @if (auth()->user()->image)
                    <img src="{{ asset(auth()->user()->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                 @endif {{ Auth::user()->name }} </a></li>
            </ul>
        </div>
    </div><!-- /.container-fluid -->
</nav>
