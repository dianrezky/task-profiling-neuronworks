<?php
include_once '../template/header.php';
include_once 'api.php';

if (!isset($_SESSION['status'])) {
    echo "
    <script>
    alert('Anda Belum Login');
    document.location.href='../index.php';
    </script>
    ";
}

$userData = new User();
$data = $userData->profileUser();

//OFFICE
$database = new Database("sql_task");
$table = "employees";
$columns = "COUNT(*) AS total_employees";
//query total pegawai
$total_employees = $database->selectCount($table);

if (empty($total_employees)) {
    $total_employees = 'No Employees Available';
}

//query search president
$president_name = $database->selectOne($table, ["jobTitle" => "President"]);

//query amount of payment
$total_payment = $database->selectSum("payments", "amount");

//query total target product vendor
$total_product_vendor = $database->selectCountDistinct("products", "productVendor", "totalProductVendor");

//query get all employees

$halaman = 10; //batasan halaman
$page = isset($_GET['halaman']) ? (int)$_GET["halaman"] : 1;
$mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;

$prev = $page - 1;
$next = $page + 1;

$result = mysqli_query($koneksi, "SELECT * FROM employees");
$total = mysqli_num_rows($result);
$pages = ceil($total / $halaman);

$get_all_employees = mysqli_query(
    $koneksi,
    "SELECT * FROM employees INNER JOIN offices ON offices.officeCode = employees.officeCode
    LIMIT $mulai, $halaman"
);


//query get reportsTo employees

$reportsTo_employees = mysqli_query($koneksi, "SELECT reportsTo FROM employees");


//CUSTOMER

//query total CUSTOMER

$table = "customers";
$columns = "COUNT(*) as total_customers";


$total_customers = $database->selectCount($table);

if (empty($total_customers)) {
    $total_customers = 'No Customers Available';
}

//query customers which have highest limit

$customer_highest_limit = mysqli_query($koneksi, "SELECT * FROM customers ORDER BY creditLimit DESC LIMIT 1");
$customer_highest_limit = mysqli_fetch_array($customer_highest_limit);

//query total order by highest limit
$customer_number_highest_limit = $customer_highest_limit['customerNumber'];
$customer_order = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) FROM orders 
    INNER JOIN customers 
    ON orders.customerNumber = customers.customerNumber 
    WHERE orders.customerNumber='$customer_number_highest_limit' 
    AND orders.status='Shipped'"
);
$customer_order = mysqli_fetch_array($customer_order);

//query total uang pesanan oleh user credit limit tertinggi

$customer_total_income = mysqli_query(
    $koneksi,
    "SELECT SUM(amount) 
    as customer_payment 
    FROM payments 
    INNER JOIN customers 
    ON payments.customerNumber = customers.customerNumber 
    WHERE payments.customerNumber='$customer_number_highest_limit'"
);

$customer_total_income = mysqli_fetch_array($customer_total_income);



$information = new Information();
$healthy = new Healthy();


// $podcast= $information->podcastAction("kesehatan");


$bmi = $healthy->bmi();
$healthy = new Healthy();
$heart = $healthy->heartDisplay();
$healthy = new Healthy();
$activity = $healthy->calories();
$healthy = new Healthy();
$disease = $healthy->diseaseDetect();


if (isset($_GET['category'])) {

    $category = $_GET['category'];
} else {
    $category = "psikologi";
}
$news = $information->displayNews($category);

?>
<!-- Content Row -->
<main>
    <div class="content-dashboard">
        <div class="container-fluid">
            <div class="row">
                <!-- Area Chart -->

                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Profile Overview</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <section>
                                <div class="container py-5">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="card mb-4">
                                                <div class="card-body text-center">
                                                    <img src="../assets/image/user.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                                    <h5 class="my-3"><?php echo htmlspecialchars($data['username']) ?></h5>
                                                    <p class="text-muted mb-1"><?php echo htmlspecialchars($data['level']) ?></p>
                                                    <p class="text-muted mb-4"><?php echo htmlspecialchars($data['phone_number']) ?></p>
                                                    <div class="d-flex justify-content-center mb-2">
                                                        <button type="button" class="btn btn-primary">Edit</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-8">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">Full Name</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <p class="text-muted mb-0"><?php echo htmlspecialchars($data['username']) ?></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">Email</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <p class="text-muted mb-0"><?php echo htmlspecialchars($data['email']) ?></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">Phone</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <p class="text-muted mb-0"><?php echo htmlspecialchars($data['phone_number']) ?></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">Address</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <p class="text-muted mb-0"><?php echo htmlspecialchars($data['alamat']) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Todays News</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">


                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Daily Podcast</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="font-weight-light"><b><?php echo "a"; ?></b></h3>
                                <div class="text-white mb-3"><span class="text-black-opacity-05"><small>By Tangan Belang<span class="sep">/</span> 18 February 2020 <span class="sep">/</span> 28:28</small></span></div>
                                <p class="mb-4">kebahagiaan bisa mengatasi masalah? Bagaimana cara kami menjaga kesehatan mental di era digital saat ini? Sumber: <a target="_blank" href="https://www.youtube.com/watch?v=OrY0CfvY6TI&t=3s">Link</a></p>
                                <p class="mb-4"></p>
                                <div class="player">
                                    <audio id="player2" preload="none" controls style="max-width: 100%">
                                        <source src="<?php echo "a"; ?>" type="audio/mp3">
                                    </audio>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content OFFICE Information Row -->
            <div class="card">
                <h5 class="card-header">
                    <a class="collapsed d-block" data-toggle="collapse" href="#collapse-collapsed-office" aria-expanded="true" aria-controls="collapse-collapsed-office" id="heading-collapsed">
                        <i class="fa fa-chevron-down pull-right"></i>
                        Today News
                    </a>
                </h5>
                <div id="collapse-collapsed-office" class="collapse show" aria-labelledby="heading-collapsed">
                    <div class="row card-body">
                        <div class="col-xl-10 col-md-8 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $news['title']; ?></div>
                                            <div class="p mb-0 font-weight-bold text-gray-800"><?php echo "by: " . $news['writer'] . " (" . $news['date'] . ")"; ?></div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" style="text-align: justify;">
                                            <?php echo $news['content']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Category</div>
                                            </div>
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <ul>
                                                <li><a href="?category=psikologi">Psikologi</a></li>
                                                <li><a href="?category=gizi">Nutrisi dan Gizi</a></li>
                                                <li><a href="?category=covid">Covid</a></li>
                                                <li><a href="?category=penyakit">Penyakit</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>

            <!-- Content KESEHATAN -->
            <div class="card">
                <h5 class="card-header">
                    <a class="collapsed d-block" data-toggle="collapse" href="#collapse-collapsed-office" aria-expanded="true" aria-controls="collapse-collapsed-office" id="heading-collapsed">
                        <i class="fa fa-chevron-down pull-right"></i>
                        Care Your Body
                    </a>
                </h5>
                <div id="collapse-collapsed-office" class="collapse show" aria-labelledby="heading-collapsed">
                    <div class="row card-body">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 text-xs font-weight-bold text-warning text-uppercase mb-1">BMI Calculator</div>
                                                    <div class="p mb-0 font-weight-bold text-gray-800">Check your BMI to indentify your health</div>
                                                </div>
                                            </div>
                                            <div class="row"><br></div>
                                            <form method="POST" action="week2.php" class="">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="text" name="bb" class="form-control" placeholder="Berat Badan" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="text" name="tb" class="form-control" placeholder="Tinggi Badan" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-field">
                                                            <div class="select-wrap">
                                                                <select name="kelamin" class="form-control">
                                                                    <option value="">Jenis kelamin</option>
                                                                    <option value="Laki-laki">Laki-laki</option>
                                                                    <option value="Perempuan">Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row"><br></div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="submit" name="submit" value="Hitung BMI" class="btn btn-primary py-3 px-4" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row">
                                                <div class="col">
                                                    <?php
                                                    // Tampilkan hasil di bawah formulir jika sudah ada
                                                    if ($bmi != null) {
                                                        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                                        " . htmlspecialchars($bmi) . "
                                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                        </button>
                                                    </div>";
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row"><br></div>
                            <div class="row">
                                <div class="col">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 text-xs font-weight-bold text-warning text-uppercase mb-1">Activity Calculator</div>
                                                    <div class="p mb-0 font-weight-bold text-gray-800">Knows the burn calories by your body to do the activity </div>
                                                </div>
                                            </div>
                                            <div class="row"><br></div>
                                            <form method="POST" action="week2.php" class="">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="text" name="bbActivity" class="form-control" placeholder="Berat Badan">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="nunber" name="timeActivity" class="form-control" placeholder="Durasi Kegiatan (Menit)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-field">
                                                            <div class="select-wrap">
                                                                <select name="categoryActivity" class="form-control">
                                                                    <option value="">Jenis Aktivitas</option>
                                                                    <option value="olahraga">Sports (Basket, Sepak Bola, dll)</option>
                                                                    <option value="home">Home Activities (Menyapu, Mengepel, dll)</option>
                                                                    <option value="inactive">Inactivity (Duduk, dll)</option>
                                                                    <option value="berkebun">Gardening</option>
                                                                    <option value="menari">Dancing</option>
                                                                    <option value="berkendara">Berkendara (Mobil, Motor, Pesawat, dll)</option>
                                                                    <option value="volunteer">Kegiatan Volunteer</option>
                                                                    <option value="agama">Kegiatan Beragama</option>
                                                                    <option value="berjalan">Berjalan</option>
                                                                    <option value="berlari">Berlari</option>
                                                                    <option value="music">Bermain Music (Drum, Gitar, dll)</option>
                                                                    <option value="bekerja">Bekerja (chef, karyawan, dll)</option>
                                                                    <option value="self">Self Care (Makan, Mandi, dll)</option>
                                                                    <option value="water">Water Activities (Berenang, Snorkeling, dll)</option>
                                                                    <option value="winter">Winter Activities (Skating, Ski, dll)</option>
                                                                    <option value="sepeda">Bersepeda</option>
                                                                    <option value="latihan">Conditioning Exercise (Sit Up, Pull Up, dll)</option>
                                                                    <option value="fishhunt">Fishing and Hunting (Memancing Ikan, Berburu, dll)</option>
                                                                    <option value="lainnya">Lainnya (Bermain Catur, Menulis, dll)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row"><br></div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="submit" name="submit" value="Hitung Kalori Kegiatan" class="btn btn-primary py-3 px-4">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row">
                                                <div class="col">
                                                    <?php
                                                    // Tampilkan hasil di bawah formulir jika sudah ada
                                                    if ($activity != null) {
                                                        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                                    <p>Detak Jantung Aktivitas Berat: " . htmlspecialchars($activity['keterangan']) . "</p>
                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>";
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row"><br></div>
                            <div class="row">
                                <div class="col">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 text-xs font-weight-bold text-warning text-uppercase mb-1">Heart Beat Calculator</div>
                                                    <div class="p mb-0 font-weight-bold text-gray-800">Check your normal heart beat</div>
                                                </div>
                                            </div>
                                            <div class="row"><br></div>
                                            <form method="POST" action="week2.php" class="">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-field">
                                                            <div class="select-wrap">kategori Usia
                                                                <select name="kategoriHeart" class="form-control">
                                                                    <option value="">Jawab</option>
                                                                    <option value="satu">1 - 2 Tahun</option>
                                                                    <option value="dua">3 - 4 Tahun</option>
                                                                    <option value="tiga">5 - 6 Tahun</option>
                                                                    <option value="empat">7 - 9 Tahun</option>
                                                                    <option value="lima">10 Tahun Keatas</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-field">
                                                            <div class="select-wrap">Jenis Kelamin
                                                                <select name="kelaminHeart" class="form-control">
                                                                    <option value="">Jawab</option>
                                                                    <option value="Laki-laki">Laki-laki</option>
                                                                    <option value="Perempuan">Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-field">
                                                            <div class="select-wrap">Atlet Pro
                                                                <select name="atletHeart" class="form-control">
                                                                    <option value="">Jawab</option>
                                                                    <option value="ya">Ya</option>
                                                                    <option value="tidak">Tidak</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row"><br></div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="submit" name="submit" value="Hitung Detak Jantung" class="btn btn-primary py-3 px-4" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row">
                                                <div class="col">
                                                    <?php
                                                    // Tampilkan hasil di bawah formulir jika sudah ada
                                                    if ($heart != null) {
                                                        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                                    <p>Detak Jantung Aktivitas Berat: " . htmlspecialchars($heart['min_atas']) . " - " . htmlspecialchars($heart['max_atas']) . " BPM</p>
                                                    <p>Detak Jantung Aktivitas Sedang: " . htmlspecialchars($heart['min_sedang']) . " - " . htmlspecialchars($heart['max_sedang']) . " BPM</p>
                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>";
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">

                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 text-xs font-weight-bold text-warning text-uppercase mb-1">Disease Detection</div>
                                            <div class="p mb-0 font-weight-bold text-gray-800">Check whats going on in your body early.</div>
                                        </div>
                                    </div>
                                    <div class="row"><br></div>
                                    <form method="POST" action="week2.php" class="">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" name="bb" class="form-control" placeholder="Berat Badan">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="nunber" name="tb" class="form-control" placeholder="Durasi Kegiatan (Menit)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Demam ?
                                                            <select name="demam" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="dy">Ya</option>
                                                                <option value="dt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Nyeri Tenggorokan ?
                                                            <select name="nt" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="nty">Ya</option>
                                                                <option value="ntt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Batuk Kering ?
                                                            <select name="bk" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="bky">Ya</option>
                                                                <option value="bkt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Indera Perasa atau Penciuman Hilang ?
                                                            <select name="hpp" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="hppy">Ya</option>
                                                                <option value="hppt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Sesak Napas ?
                                                            <select name="sn" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="sny">Ya</option>
                                                                <option value="snt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Ada Ruam Pada Kulit atau Perubahan Warna Pada Jari Tangan atau Jari Kaki ?
                                                            <select name="ruam" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="ruamy">Ya</option>
                                                                <option value="ruamt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Ada Rasa Tidak Nyaman dan Nyeri ?
                                                            <select name="tnn" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="tnny">Ya</option>
                                                                <option value="tnnt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Ada Nyeri Dada atau Rasa Tertekan Pada Dada ?
                                                            <select name="nyar" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="nyary">Ya</option>
                                                                <option value="nyart">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Tenggorokan Tampak Merah ?
                                                            <select name="ttm" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="ttmy">Ya</option>
                                                                <option value="ttmt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Ada Pembengkakan Kelenjar Getah Bening ?
                                                            <select name="pkgb" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="pkgby">Ya</option>
                                                                <option value="pkgbt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Sakit Kepala ?
                                                            <select name="sk" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="sky">Ya</option>
                                                                <option value="skt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Hidung Meler ?
                                                            <select name="hm" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="hmy">Ya</option>
                                                                <option value="hmt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Batuk ?
                                                            <select name="batuk" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="by">Ya</option>
                                                                <option value="bt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Nyeri Otot ?
                                                            <select name="no" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="noy">Ya</option>
                                                                <option value="not">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Mata Merah ?
                                                            <select name="mm" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="mmy">Ya</option>
                                                                <option value="mmt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Fotofobia (Rentan Terhadap Cahaya, Silau) ?
                                                            <select name="foto" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="fotoy">Ya</option>
                                                                <option value="fotot">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Nyeri Sendi ?
                                                            <select name="ns" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="nsy">Ya</option>
                                                                <option value="nst">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Kulit Kemerahan ?
                                                            <select name="kk" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="kky">Ya</option>
                                                                <option value="kkt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Muncul Bintik - Bintik Merah ?
                                                            <select name="bbm" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="bbmy">Ya</option>
                                                                <option value="bbmt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Tubuh Menggigil ?
                                                            <select name="tm" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="tmy">Ya</option>
                                                                <option value="tmt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Nafsu Makan Berkurang ?
                                                            <select name="nmb" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="nmby">Ya</option>
                                                                <option value="nmbt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Nyeri Ketika Mengunyah ?
                                                            <select name="nkm" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="nkmy">Ya</option>
                                                                <option value="nkmt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Ada Bengkak Pada Posisi Antara Telinga dan Rahang ?
                                                            <select name="bppatdr" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="bppatdry">Ya</option>
                                                                <option value="bbpatdrt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Muntah ?
                                                            <select name="muntah" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="muntahy">Ya</option>
                                                                <option value="muntaht">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Diare ?
                                                            <select name="diare" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="diarey">Ya</option>
                                                                <option value="diaret">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Rewel atau Tidak Bisa Mengendalikan Emosi ?
                                                            <select name="rewel" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="rewely">Ya</option>
                                                                <option value="rewelt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12">
                                                    <div class="form-field">
                                                        <div class="select-wrap">Mengalami Kejang Otot Terutama Otot Betis, Leher atau Punggung ?
                                                            <select name="kejang" class="form-control">
                                                                <option value="">Jawab</option>
                                                                <option value="kejangy">Ya</option>
                                                                <option value="kejangt">Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><br></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" name="submit" value="Analisa Penyakit" class="btn btn-primary py-3 px-4">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <?php
                                        // Tampilkan hasil di bawah formulir jika sudah ada
                                        if ($hasil != null) {
                                            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    " . htmlspecialchars($hasil) . "
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                    </button>
                                  </div>";
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <!-- Content CUSTOMER InformationRow -->



    <br>
    <br>

    <!-- Content Row -->

    <div class="row">
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Tables</h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Employees Data</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="text-align:center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th rowspan="2">Name</th>
                                    <th rowspan="2">Email</th>
                                    <th colspan="2">Office</th>
                                    <!-- <th rowspan="2">Report To</th> -->
                                    <th rowspan="2">Position</th>
                                    <th colspan="2" rowspan="2">Action</th>
                                </tr>
                                <tr>
                                    <th>Code</th>
                                    <th>City</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                while ($employees = mysqli_fetch_array($get_all_employees)) {

                                    echo
                                    '<tr>
                                            <td>' . $employees['firstName'] . ' ' . $employees['lastName'] . '</td>
                                            <td>' . $employees['email'] . '</td>
                                            <td>' . $employees['officeCode'] . '</td>
                                            <td>' . $employees['city'] . '</td>
                                            <td>' . $employees['jobTitle'] . '</td>'
                                ?>
                                    <form action="sql_query.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $employees['employeeNumber'] ?>" class="form-control">

                                        <td>
                                            <a href="update_data.php?id=<?php echo $employees['employeeNumber'] ?>" onclick="return confirm('Are you sure you want to edit this item?')">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                        </td>
                                        <td>
                                            <button type="submit" name="action" value="delete" class="btn btn-success" onclick="return confirm('Are you sure you want to delete this item?')">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </td>
                                    </form>
                                    </tr>
                                <?php
                                }


                                ?>
                            </tbody>

                        </table>

                        <nav aria-label="Page navigation example ">
                            <ul class="pagination float-right">
                                <li class="page-item <?php if ($page <= 1) {
                                                            echo 'disabled';
                                                        } ?>">
                                    <a class="page-link" href="<?php if ($page <= 1) {
                                                                    echo '#';
                                                                } else {
                                                                    echo "?halaman=" . $prev;
                                                                } ?>">Previous</a>
                                </li>

                                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                    <li class="page-item <?php if ($page == $i) {
                                                                echo 'active';
                                                            } ?>">
                                        <a class="page-link" href="?halaman=<?= $i; ?>"> <?= $i; ?> </a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php if ($page >= $pages) {
                                                            echo 'disabled';
                                                        } ?>">
                                    <a class="page-link" href="<?php if ($page >= $pages) {
                                                                    echo '#';
                                                                } else {
                                                                    echo "?halaman=" . $next;
                                                                } ?>">Next</a>
                                </li>
                            </ul>
                        </nav>


                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $('.alert').alert()
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">