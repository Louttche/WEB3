<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="{{ route('blog.index') }}" class="navbar-brand">Home</a>
            <ul class="nav navbar-nav">
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li><a href="{{ route('other.about') }}">About</a></li>
                @if(!Auth::check())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li><a href="{{ route('admin.index') }}">Posts</a></li>
                    <li>
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    <li><a href="{{ route('admin.profile') }}">Profile</a></li>
                    <li class="active" style="position:fixed;right:0;width:100px;"> <a>
                    @if (auth()->user()->image)
                    <img src="{{ asset(auth()->user()->image) }}" style="width: 20px; height: 20px; border-radius: 50%;">
                    @endif {{ Auth::user()->name }} </a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
