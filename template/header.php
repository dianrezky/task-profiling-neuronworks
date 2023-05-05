<?php include_once('../koneksi.php');  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK PROFILING</title>
    <link rel="icon" href="../assets/image/logo.jpg" type="image/x-icon">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/nice-select.css">
    <link rel="stylesheet" href="../assets/css/flaticon.css">
    <link rel="stylesheet" href="../assets/css/gijgo.css">
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <link rel="stylesheet" href="../assets/css/slick.css">
    <link rel="stylesheet" href="../assets/css/slicknav.css">

    <!-- font -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <!-- datatable
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src=https://cdn.datatables.net/1.9.4//assets/js/jquery.dataTables.min.js></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.9.4/css/jquery.dataTables.css"> -->
    <!-- <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <!-- GRAPH -->

    <script type="text/javascript" src="../assets/js/HTMLtable2chart/graficarBarras.js"></script>
    <script type="text/javascript" src="../assets/js/HTMLtable2chart/tabla2array.js"></script>
    <script type="text/javascript" src="../assets/js/HTMLtable2chart/graficarXY.js"></script>
    <script type="text/javascript" src="../assets/js/HTMLtable2chart/graficarTortas.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>

<body>


    <!-- AREA HEADER START -->

    <header>
        <nav class="navbar navbar-expand-md navbar-light fixed-top bg-dark">
            <a class="navbar-brand" href="../index.php">
                <img class="logo-img-header" src="../assets/image/nw-horizontal.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            HTML & CSS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../HTML CSS/login.php">Week 1</a>
                            <a class="dropdown-item" href="../HTML CSS/dashboard.php">Week 2</a>
                        </div>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            SQL
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../SQL/week1.php">Week 1</a>
                            <a class="dropdown-item disabled" href="#">Week 2</a>
                        </div>
                    </li>
                </ul>
                <div class="form-inline mt-2 mt-md-0">
                    <!-- <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search"> -->
                    <a class="btn btn-outline-success my-2 my-sm-0" href="../HTML CSS/login.php" id="task2" onclick="">
                        LOGIN
                    </a>
                </div>
            </div>
        </nav>
    </header>


    <!-- AREA HEADER END -->