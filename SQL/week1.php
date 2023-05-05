<?php
require_once('../template/header.php');


//OFFICE

//query total pegawai
$total_employees = mysqli_query($koneksi, "SELECT COUNT(*) FROM employees");
$total_employees = mysqli_fetch_array($total_employees);

if ($total_employees == NULL) {
    $total_employees = 'No Employees Available';
} else {
    $total_employees = $total_employees[0];
}

//query search president

$president_name = mysqli_query($koneksi, "SELECT * FROM employees WHERE jobTitle='President'");
$president_name = mysqli_fetch_array($president_name);

//query amount of payment

$total_payment = mysqli_query($koneksi, "SELECT SUM(amount) as total_income FROM payments");
$total_payment = mysqli_fetch_assoc($total_payment);

//query total target product vendor

$total_product_vendor = mysqli_query($koneksi, "SELECT COUNT(DISTINCT productVendor) as totalProductVendor FROM products");
$total_product_vendor = mysqli_fetch_assoc($total_product_vendor);

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
$total_customers = mysqli_query($koneksi, "SELECT COUNT(*) FROM customers");
$total_customers = mysqli_fetch_array($total_customers);

if ($total_customers == NULL) {
    $total_customers = 'No Customers Available';
} else {
    $total_customers = $total_customers[0];
}

//query customers which have highest limit

$customer_highest_limit = mysqli_query($koneksi, "SELECT * FROM customers ORDER BY creditLimit DESC LIMIT 1");
$customer_highest_limit = mysqli_fetch_array($customer_highest_limit);

//query total order by highest limit
$customer_number_highest_limit = $customer_highest_limit['customerNumber'];
$customer_order = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) FROM orders INNER JOIN customers ON orders.customerNumber = customers.customerNumber 
    WHERE orders.customerNumber='$customer_number_highest_limit' AND orders.status='Shipped'"
);
$customer_order = mysqli_fetch_array($customer_order);

//query total uang pesanan oleh user credit limit tertinggi

$customer_total_income = mysqli_query(
    $koneksi,
    "SELECT SUM(amount) as customer_payment FROM payments INNER JOIN customers ON payments.customerNumber = customers.customerNumber 
    WHERE payments.customerNumber='$customer_number_highest_limit'"
);

$customer_total_income = mysqli_fetch_array($customer_total_income);





?>


<!-- AREA CONTENT START -->

<div class="content-dashboard">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
        <hr>
        <!-- Content OFFICE Information Row -->
        <div class="card">
            <h5 class="card-header">
                <a class="collapsed d-block" data-toggle="collapse" href="#collapse-collapsed-office" aria-expanded="true" aria-controls="collapse-collapsed-office" id="heading-collapsed">
                    <i class="fa fa-chevron-down pull-right"></i>
                    Offices Information
                </a>
            </h5>
            <div id="collapse-collapsed-office" class="collapse show" aria-labelledby="heading-collapsed">
                <div class="row card-body">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total of Employees</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_employees; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Name of President</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $president_name['firstName'] . " " . $president_name['lastName']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="far fa-id-badge fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Target of Product Vendor</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_product_vendor['totalProductVendor'] . "/100"  ?></div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $total_product_vendor['totalProductVendor'] ?>%" aria-valuenow="<?php echo $total_product_vendor['totalProductVendor'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">The Office Income</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "Rp. " . number_format($total_payment['total_income'], 2, ".", ".") ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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

        <div class="card">
            <h5 class="card-header">
                <a class="collapsed d-block" data-toggle="collapse" href="#collapse-collapsed-customer" aria-expanded="true" aria-controls="collapse-collapsed-customer" id="heading-collapsed">
                    <i class="fa fa-chevron-down pull-right"></i>
                    Customers Information
                </a>
            </h5>
            <div id="collapse-collapsed-customer" class="collapse show" aria-labelledby="heading-collapsed">
                <div class="row card-body">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total of Customers</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_customers; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Customer Have The Highest Limit</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $customer_highest_limit['customerName']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="far fa-id-badge fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total of Order By Customer</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $customer_order[0] . "/100"  ?></div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $customer_order[0] ?>%" aria-valuenow="<?php echo $customer_order[0] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">The Customer Spend</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "Rp. " . number_format($customer_total_income['customer_payment'], 2, ".", ".") ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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

                                        // while ($reportsTo_employees = mysqli_fetch_array($reportsTo_employees)) {
                                        //     if ($get_all_employees['reportsTo'] == $reportsTo_employees) {

                                        //         $reportsToName = $get_all_employees['firstName'] + $get_all_employees['lastName'];


                                        //     }

                                        // }
                                        echo
                                        '<tr>
                                            <td>' . $employees['firstName'] . ' ' . $employees['lastName'] . '</td>
                                            <td>' . $employees['email'] . '</td>
                                            <td>' . $employees['officeCode'] . '</td>
                                            <td>' . $employees['city'] . '</td>
                                            <td>' . $employees['jobTitle'] . '</td>'
                                        ?>
                                            <form action="sql_query.php" method="POST">
                                                <input type="hidden" name="id" value="<?php echo $employees['employeeNumber']?>" class="form-control">
                                               
                                                <td> 
                                                    <a href="update_data.php?id=<?php echo $employees['employeeNumber']?>" onclick="return confirm('Are you sure you want to edit this item?')">
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
                                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                    <a class="page-link"
                                        href="<?php if($page <= 1){ echo '#'; } else { echo "?halaman=" . $prev; } ?>">Previous</a>
                                </li>

                                <?php for($i = 1; $i <= $pages; $i++ ): ?>
                                <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                                    <a class="page-link" href="?halaman=<?= $i; ?>"> <?= $i; ?> </a>
                                </li>
                                <?php endfor; ?>
                                <li class="page-item <?php if($page >= $pages) { echo 'disabled'; } ?>">
                                    <a class="page-link"
                                        href="<?php if($page >= $pages){ echo '#'; } else {echo "?halaman=". $next; } ?>">Next</a>
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


<!-- AREA CONTENT END -->


<!-- <include src="../template/footer.php"></include> -->
<?php include "../template/footer.php"; ?>