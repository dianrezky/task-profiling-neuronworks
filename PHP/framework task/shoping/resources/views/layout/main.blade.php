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
    <link rel="shortcut icon" href="{{ asset('img/logos web.png') }}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>


    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="nav-item">
            <div class="container">
                <a href="/"><img src="{{ asset('img/logos web.png') }}" alt="" style="margin-bottom: 10px;"></a>
                <nav class="nav-menu mobile-menu center">
                    <ul>
                        <li class="nav-link {{ (Request::is('/')) ? 'active' : '' }}"><a href="/">Home</a></li>
                        <li class="nav-link {{ (Request::is('view')) ? 'active' : '' }}"><a href="/view">View</a>
                            <ul class="dropdown">
                                <li><a href="/furniture-type/{{ 'Chair' }}">Chair</a></li>
                                <li><a href="/furniture-type/{{ 'Table' }}">Table</a></li>
                                <li><a href="/furniture-type/{{ 'Bed' }}">Bed</a></li>
                                <li><a href="/furniture-type/{{ 'Storage' }}">Storage</a></li>
                            </ul>
                        </li>
                        @auth
                        @cannot('admin')
                        <li class="nav-link {{ (Request::is('cart')) ? 'active' : '' }}"><a href="/cart">Cart</a></li>
                        @endcannot
                        @can('admin')
                        <li class="nav-link {{ (Request::is('furniture')) ? 'active' : '' }}"><a href="/view">Furniture</a>
                            <ul class="dropdown">
                                <li><a href="/furniture-create">Add Furniture</a></li>
                            </ul>
                        </li>
                        @endcan
                        <li class="nav-link {{ (Request::is('profile')) ? 'active' : '' }}"><a href="/profile">Profile</a>
                            <ul class="dropdown">
                                @cannot('admin')
                                <li><a href="/history">View Transaction History</a></li>
                                @endcannot
                                @can('admin')
                                <li><a href="/history-admin">View All Transaction History</a></li>
                                @endcan
                                <li><a href="/edit_profile/{{ auth()->user()->id }}">Update Profile</a></li>
                                <li><a href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </li>
                        @else
                        <li class="nav-link {{ (Request::is('login')) ? 'active' : '' }}"><a href="/login">Login</a></li>
                        <li class="nav-link {{ (Request::is('register')) ? 'active' : '' }}"><a href="/register">Register</a></li>
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
                        Copyright <span id="get-year"></span> &copy Dian Rezky Wulandari - PT. Neuronworks
                        Indonesia
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
    <script type="text/javascript">
        var $ = require('jquery');
        var dt = require('datatables.net')(window, $);
        var date = new Date().getFullYear();

        document.getElementById("get-year").innerHTML = date;
    </script>
</body>

</html>