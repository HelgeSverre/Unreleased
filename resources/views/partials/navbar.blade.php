<nav class="navbar navbar-expand-md bg-dark navbar-dark ">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="{{ route("track.index") }}">
            Un:Released.io
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse">

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item mr-2">
                  <search-field></search-field>

                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="{{ route('track.create') }}">
                        <i class="fas fa-fw fa-plus"></i> {{ __('Add track') }}
                    </a>
                </li>

                <li class="nav-item mr-2">
                    <a class="nav-link" href="{{ route('artist.index') }}">
                        <i class="fas fa-fw fa-user"></i> {{ __('Artists') }}
                    </a>
                </li>
                <li class="nav-item mr-2">
                    <genre-index></genre-index>
                </li>
                @guest
                    <li class="nav-item ml-4 border-left pl-4 border-white">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else

                    <li class="nav-item dropdown ml-4 border-left pl-4 border-white">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
