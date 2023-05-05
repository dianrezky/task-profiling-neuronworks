<?php
include_once('../koneksi.php');



if ((isset($_POST['id'])) || (isset($_POST['email']))) {

    $email = $_POST['email'];
    $id = $_POST['id'];
    

} 
else {
    $id = "kosong";
}


if ($_POST['action'] == 'edit') {

   // mengedit data dari database

   $delete_data = mysqli_query($koneksi, 
   "UPDATE employees SET email ='$email' where employeeNumber='$id'");

   if ($delete_data) {
       echo "
           <script>
           alert('Data berhasil Diupdate');
           document.location.href='week1.php';
           </script>
           ";
   } else {
       echo "
           <script>
               alert('Gagal Update Data');
               document.location.href='week1.php';
           </script>";
       exit;
   }

} 

else if ($_POST['action'] == 'delete') {

    // menghapus data dari database

    $delete_data = mysqli_query($koneksi, "DELETE FROM employees where employeeNumber='$id'");

    if ($delete_data) {
        echo "
            <script>
            alert('Data berhasil dihapus');
            document.location.href='week1.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('Gagal Menghapus Data');
                document.location.href='week1.php';
            </script>";
        exit;
    }
}
