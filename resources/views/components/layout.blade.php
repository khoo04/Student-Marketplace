<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!--Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Alpine JS-->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/layout.css')}}">
@yield('head')
@yield('title')
</head>
<body>
    <nav id="myNav">
        <div id="navigation-bar">
            <div id="logo">
                <a href="/">
                    <img src="{{asset('images/logo.png')}}" alt="logo">
                </a>
            </div>
            @if(Route::current()->uri() != "login" && Route::current()->uri() != "register" && Route::current()->uri() != "search")
            <div id="search-bar">
                <form method="get" action="/search">
                    <i class="fa-solid fa-search"></i>
                    <input type="search" name="keyword" placeholder="Search something"/>
                    <input type="submit" hidden/>
                </form>
            </div>
            @endif

            <ul id="list">
                @auth
                <li>
                    <a href="/profile">
                        <i class="fa-solid fa-user"></i> {{auth()->user()->first_name . ' ' . auth()->user()->last_name}}
                    </a>
                </li>

                <li>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-right-from-bracket"></i> Log out
                        </button>
                    </form>
                </li>
                @else
                <li>
                    <a href="/register">
                        <i class="fa-solid fa-user-plus"></i> Register
                    </a>
                </li>

                <li>
                    <a href="/login">
                        <i class="fa-solid fa-right-to-bracket"></i> Login
                    </a>
                </li>
                @endauth
            </ul>
            <div id="toggle-menu-btn">
                <i class="fa-solid fa-bars"></i>
            </div>

            <div class="dropdown-nav-bar">
                <ul>
                    @if(Route::current()->uri() != "search")
                    <li>
                        <button type="button" title="Search Button" id="nav-search-btn">Search</button>   
                    </li>
                    @endif
                    @auth
                    <li>
                        <a href="/profile">My Profile</a>
                    </li>
                    <li>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit">
                                Log out
                            </button>
                        </form>
                    </li>
                    @else
                    @if(Route::current()->uri() != "register")
                    <li>
                        <a href="/register">Register</a>
                    </li>
                    @endif
                    @if(Route::current()->uri() != "login")
                    <li>
                        <a href="/login">Login</a>
                    </li>
                    @endif
                    @endauth
                </ul>
            </div>

            <dialog id="search-area">
                <form action="/search" method="get">
                    <i class="fa-solid fa-search"></i>
                    <input type="search" name="keyword" placeholder="Search something"/>
                    <input type="submit" hidden/>
                </form>
            </dialog>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
  
    <footer id="footer">
        <p>Copyright © 2024 Student Marketplace. All Rights Reserved.</p>
    </footer>
    <script src="{{asset("js/layout.js")}}"></script>
    @yield('js')
</body>
</html>