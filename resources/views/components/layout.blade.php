<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('css/layout.css')}}">
@yield('styles')
    <title>Student Marketplace</title>
</head>
<body>
    <nav id="myNav">
        <div id="navigation-bar">
            <div id="logo">
                <a href="/">
                    <img src="images/marketplace.png" alt="logo">
                    <h3>Student Marketplace</h3>
                </a>
            </div>

            <div id="search-bar">
                <form method="" action="/">
                    <i class="fa-solid fa-search"></i>
                    <input type="search" name="search" placeholder="Search something"/>
                    <input type="submit" hidden/>
                </form>
            </div>

            <ul id="list">
                @auth
                <li>
                    <a href="/profile">
                        <i class="fa-solid fa-user"></i> My Profile
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
            <div id="toggle-btn">
                <i class="fa-solid fa-bars"></i>
            </div>

            <div class="dropdown-nav-bar">
                <ul>
                    <li>
                        <button type="button" title="Search Button" id="nav-search-btn">Search</button>   
                    </li>
                    @auth
                    <li>
                        <a href="/profile">My Profile</a>
                    </li>
                    <li>
                        <!--//TODO: Add LOG OUT ROUTE -->
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit">
                                Log out
                            </button>
                        </form>
                    </li>
                    @else
                    <li>
                        <a href="/register">Register</a>
                    </li>
                    <li>
                        <a href="/login">Login</a>
                    </li>
                    @endauth
                </ul>
            </div>

            <dialog id="search-area">
                <!--//TODO: Add Action to this search-->
                <form action="/" method="get">
                    <i class="fa-solid fa-search"></i>
                    <input type="search" name="search" placeholder="Search something"/>
                    <input type="submit" hidden/>
                </form>
            </dialog>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
  
    <footer id="footer">
        <p>Copyright © 2024, All Rights reserved</p>
    </footer>
    <script src="js/layout.js"></script>
    @yield('js')
</body>
</html>