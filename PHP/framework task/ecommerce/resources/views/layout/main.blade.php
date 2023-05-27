<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Furniture">
    <meta name="keywords" content="Furniture, table, chair, bed">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
</head>

<body>

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="nav-item">
            <div class="container">
                <img src="{{ asset('img/logos.png') }}" alt="">
                <nav class="nav-menu mobile-menu center">
                    <ul>
                        <li class="nav-link {{ (Request::is('/')) ? 'active' : '' }}"><a href="/">Home</a></li>
                        <li class="nav-link {{ (Request::is('view')) ? 'active' : '' }}"><a href="/view">View</a></li>
                        @auth
                            @cannot('admin')
                                <li class="nav-link {{ (Request::is('cart')) ? 'active' : '' }}"><a href="/cart">Cart</a></li>
                            @endcannot
                            @can('admin')
                                <li class="nav-link {{ (Request::is('furniture')) ? 'active' : '' }}"><a href="/furniture">Furniture</a>
                                    <ul class="dropdown">
                                        <li><a href="/furniture-create">Add Furniture</a></li>
                                    </ul>
                                </li>
                            @endcan
                            <li class="nav-link {{ (Request::is('profile')) ? 'active' : '' }}"><a href="/profile">Profile</a>
                                <ul class="dropdown">
                                    @can('user')
                                    <li><a href="#">View Transaction History</a></li>
                                    @endcan
                                    @can('admin')
                                    <li><a href="#">View All Transaction History</a></li>
                                    @endcan
                                    <li><a href="/edit_profile">Update Profile</a></li>
                                    <li><a href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                                </ul>
                            </li>
                        @else
                            <li class = "nav-link {{ (Request::is('login')) ? 'active' : '' }}"><a href="/login">Login</a></li>
                            <li class = "nav-link {{ (Request::is('register')) ? 'active' : '' }}"><a href="/register">Register</a></li>
                        @endauth

                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <div class="container">
        @yield('container')
    </div>

   <!-- Footer Section Begin -->
   <footer class="footer-section">
        <div class="copyright-reserved">
            <div class="container">
                <div class="row">
                        <div class="copyright-text">
                            Copyright &copy; Bluejack 20-1
                        </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>


    