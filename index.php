<?php

session_start();
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == "logout") {
        echo "<script>alert('Logout Berhasil, Anda telah keluar')</script>";
    } else if ($_GET['pesan'] == "notlogin") {
        echo "<script>alert('Anda Harus Login Untuk Akses Menu Ini')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK PROFILING</title>
    <link rel="icon" href="assets/image/logo.jpg" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">

    <!-- font -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <!-- datatable
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src=https://cdn.datatables.net/1.9.4//assets/js/jquery.dataTables.min.js></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.9.4/css/jquery.dataTables.css"> -->
    <!-- <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <!-- GRAPH -->

    <script type="text/javascript" src="assets/js/HTMLtable2chart/graficarBarras.js"></script>
    <script type="text/javascript" src="assets/js/HTMLtable2chart/tabla2array.js"></script>
    <script type="text/javascript" src="assets/js/HTMLtable2chart/graficarXY.js"></script>
    <script type="text/javascript" src="assets/js/HTMLtable2chart/graficarTortas.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <style>
    .modal-body p {
        margin-bottom: 0;
    }
</style>

</head>

<body>

    <!-- AREA HEADER START -->

    <header>
        <nav class="navbar navbar-expand-md fixed-top ">
            <a class="navbar-brand" href="index.php">
                <img class="logo-img-header" src="assets/image/nw-horizontal.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav navbar-item mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            HTML & CSS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="HTML CSS/registrasi.php">Week 1</a>
                            <a class="dropdown-item" href="HTML CSS/dashboard.php">Week 2</a>
                        </div>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            SQL
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="SQL/week1.php">Week 1</a>
                            <a class="dropdown-item disabled" href="#">Week 2</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            PHP
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php
                            if (isset($_SESSION['status']) == 'login') {
                                echo "
                                <a class='dropdown-item' href='PHP/week1.php'>Week 1</a>
                                <a class='dropdown-item' href='PHP/week2.php'>Week 2</a>";
                            }

                            ?>
                        </div>
                    </li>
                </ul>
                <div class="form-inline mt-2 mt-md-0">
                    <?php if (isset($_SESSION['status']) == 'login') {
                        echo "<a class='btn login-box my-2 my-sm-0' href='PHP/logout.php' id='task2' onclick=''>LOGOUT</a>";
                    } else {
                        echo "<a class='btn login-box my-2 my-sm-0' href='HTML CSS/login.php' id='task2' onclick=''>LOGIN</a>";
                    }
                    ?>

                </div>
            </div>
        </nav>
    </header>


    <!-- AREA HEADER END -->

    <!-- AREA CONTENT START -->

    <main role="main">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class=""></li>
                <li data-target="#myCarousel" data-slide-to="1" class=""></li>
                <li data-target="#myCarousel" data-slide-to="2" class="active"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item">
                    <img class="first-slide" src="assets/image/html-week1.png" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption text-left">
                            <h1>HTML CSS TASK : WEEK 1</h1>
                            <p>Membuat view untuk registrasi. Tidak boleh menggunakan Bootstrap. Hanya
                                diizinkan untuk menggunakan font dan harus membuat CSS sendiri</p>
                            <p><a class="btn btn-lg btn-primary" href="HTML CSS/registrasi.php" role="button">View More</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="second-slide" src="assets/image/html-week2.png" alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>HTML CSS TASK : WEEK 1</h1>
                            <p>Membuat table sesuai dengan tabel yang sudah diberikan. Boleh
                                menggunakan Bootstrap namun diharapkan juga masih menggunakan template css
                                sebelumnya. Dashboard boleh bebas</p>
                            <p><a class="btn btn-lg btn-primary" href="HTML CSS/dashboard.php" role="button">View More</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item active">
                    <img class="third-slide" src="assets/image/sql-week1.png" alt="Third slide">
                    <div class="container">
                        <div class="carousel-caption text-right">
                            <h1>SQL TASK : WEEK 1</h1>
                            <p>Membuat query sederhana untuk SQL. Data SQL menggunakan data dari mysqltutorial.org/mysql-sample-database.aspx </p>
                            <p><a class="btn btn-lg btn-primary" href="SQL/week1.php" role="button">View More</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>


        <div class="container marketing">
            <div class="container">
                <div class="row box-table-header">
                    <div class="row-dashboard">
                        <h2>HTML & CSS TASK</h2>
                    </div>
                </div>
                <hr class="featurette-divider">
                <div class="row box-welcome-page">
                    <div class="card-deck">
                        <div class="card">
                            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                            <img class="card-img-top" src="assets/image/html-week1.png" title="description">
                            <div class="card-body">
                                <h5 class="card-title">Task 1: Membuat Registrasi</h5>
                                <p class="card-text">Membuat view untuk registrasi. Tidak boleh menggunakan Bootstrap. Hanya
                                    diizinkan untuk menggunakan font dan harus membuat CSS sendiri</p>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <small class="text-muted">28 April 2023</small>
                                    </div>
                                    <div class="col">
                                        <a class="btn btn-primary button-card-task" target="_blank" href="HTML CSS/registrasi.php" role="button">View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                            <img class="card-img-top" src="assets/image/html-week2.png" title="description">
                            <div class="card-body">
                                <h5 class="card-title">Task 2: Membuat Table</h5>
                                <p class="card-text">Membuat table sesuai dengan tabel yang sudah diberikan. Boleh
                                    menggunakan Bootstrap namun diharapkan juga masih menggunakan template css
                                    sebelumnya. Dashboard boleh bebas</p>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <small class="text-muted">28 April 2023</small>
                                    </div>
                                    <div class="col">
                                        <a class="btn btn-primary button-card-task" target="_blank" href="HTML CSS/dashboard.php" role="button">View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <br><br>



            <!-- START SQL TASK SECTION -->

            <div class="container">
                <div class="row box-table-header">
                    <div class="row-dashboard">
                        <h2>SQL TASK</h2>
                    </div>
                </div>
                <hr>
                <div class="row box-welcome-page">
                    <div class="card-deck">
                        <div class="card">
                            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                            <img class="card-img-top" src="assets/image/sql-week1.png" title="description">
                            <div class="card-body">
                                <h5 class="card-title">Task 1: Membuat Query Sederhana</h5>
                                <p class="card-text">Membuat query sederhana untuk SQL. Data SQL menggunakan data dari mysqltutorial.org/mysql-sample-database.aspx </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">4 Mei 2023</small>
                                <a class="btn btn-primary button-card-task" href="SQL/week1.php" role="button">View
                                    More</a>
                            </div>
                        </div>
                        <div class="card">
                            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                            <img class="card-img-top" src="assets/image/upcoming.jpg" title="description">
                            <div class="card-body">
                                <h5 class="card-title">Task 2: Up Coming</h5>
                                <p class="card-text">Mmebuat table sesuai dengan tabel yang sudah diberikan. Boleh
                                    menggunakan Bootstrap namun diharapkan juga masih menggunakan template css
                                    sebelumnya. Dashboard boleh bebas</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">28 April 2023</small>
                                <a class="btn btn-primary button-card-task disabled" target="_blank" href="#" role="button">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>

            <!-- END SQL TASK -->


            <!-- START PHP TASK SECTION -->

            <div class="container">
                <div class="row box-table-header">
                    <div class="row-dashboard">
                        <h2>PHP TASK</h2>
                    </div>
                </div>
                <hr>
                <div class="row box-welcome-page">
                    <div class="card-deck">
                        <div class="card">
                            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                            <img class="card-img-top" src="assets/image/upcoming.jpg" title="description">
                            <div class="card-body">
                                <h5 class="card-title">Task 1: Membuat Modul 1 dan 2</h5>
                                <p class="card-text">Mengimplementasikan modul 1 dan 2 dan dicoba pada sonar</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">28 April 2023</small>
                                <a class="btn btn-primary button-card-task" href="PHP/week1.php" role="button">View
                                    More</a>
                            </div>
                        </div>
                        <div class="card">
                            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                            <img class="card-img-top" src="assets/image/upcoming.jpg" title="description">
                            <div class="card-body">
                                <h5 class="card-title">Task 2: Up Coming</h5>
                                <p class="card-text">Mmebuat table sesuai dengan tabel yang sudah diberikan. Boleh
                                    menggunakan Bootstrap namun diharapkan juga masih menggunakan template css
                                    sebelumnya. Dashboard boleh bebas</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">28 April 2023</small>
                                <a class="btn btn-primary button-card-task disabled" href="#" role="button">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <!-- END PHP TASK -->

            <!-- START JAVASCRIPT TASK SECTION -->

            <div class="container">
                <div class="row box-table-header">
                    <div class="row-dashboard">
                        <h2>JAVASCRIPT TASK</h2>
                    </div>
                </div>
                <hr>
                <div class="row box-welcome-page">
                    <div class="card-deck">
                        <div class="card">
                            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                            <img class="card-img-top" src="assets/image/javascript week 1.png" title="description">
                            <div class="card-body">
                                <h5 class="card-title">Task 1: Proses Penampilan Data Sesuai Form</h5>
                                <p class="card-text">
                                    Membuat kode javascript untuk Pada inputan pilihan, sumber opsi yang ditampilkan menggunakan Array di javascript (tidak boleh secara langsung menggunakan tag option) 
                                    dan Tampilkan hasil isian pada form beserta notifikasi sukses.
                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">2 Juni 2023</small>
                                <a class="btn btn-primary button-card-task" href="HTML CSS/registrasi.php" role="button">View
                                    More</a>
                            </div>
                        </div>
                        <div class="card">
                            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                            <img class="card-img-top" src="assets/image/upcoming.jpg" title="description">
                            <div class="card-body">
                                <h5 class="card-title">Task 2: Up Coming</h5>
                                <p class="card-text">Mmebuat table sesuai dengan tabel yang sudah diberikan. Boleh
                                    menggunakan Bootstrap namun diharapkan juga masih menggunakan template css
                                    sebelumnya. Dashboard boleh bebas</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">28 April 2023</small>
                                <a class="btn btn-primary button-card-task disabled" href="#" role="button">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <!-- END JAVASCRIPT TASK -->
        </div>
        <hr class="featurette-divider">

        <!-- AREA CONTENT END -->
        <!-- AREA FOOTER -->

        <footer class="container" style="margin-top: 50px;">
            <p class="copy-right text-center">
                Copyright <span id="get-year"></span> &copy Dian Rezky Wulandari - PT. Neuronworks
                Indonesia
            </p>
        </footer>

        <!-- AREA FOOTER END -->
    </main>



    <!-- JS here -->
    <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/ajax-form.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/scrollIt.js"></script>
    <script src="assets/js/jquery.scrollUp.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/nice-select.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/gijgo.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/chart-area-demo.js"></script>
    <script src="assets/js/chart-pie-demo.js"></script>
    <script src="assets/js/chart-bar-demo.js"></script>
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/demo/datatables-demo.js"></script>

    <script type="text/javascript">
        var $ = require('jquery');
        var dt = require('datatables.net')(window, $);
        var date = new Date().getFullYear();

        document.getElementById("get-year").innerHTML = date;
    </script>

</body>



</html>