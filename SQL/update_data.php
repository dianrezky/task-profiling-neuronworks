<?php
require_once('../template/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "kosong";
}



$get_user_data = mysqli_query($koneksi, "SELECT * FROM employees WHERE employeeNumber ='$id'")->fetch_assoc();

?>


<!-- AREA CONTENT START -->

<div class="row-form">
    <div class="col-form">
        <img src="..\assets\image\Starlid-illustration.svg" alt="" style="width: 100%; height: 100%; vertical-align:middle;object-fit: cover;">
    </div>
    <div class="col-form"></div>
    <div class="col-form">
        <div class="recruitment">
            <div class="container-form">
                <form action="sql_query.php" method="POST">
                    <img src="..\assets\image\logomark-sign.png" alt="" width="112px" height="33.17px">
                    <div class="form-recruitment">
                        <h3 class="title-form">Update Profile <?php ?></h3>
                        <p>silahkan update data profile anda
                        </p>
                        <div class="form-group">
                            <label for="fullname">
                                Fullname
                                <span class="text-danger"><sup>*</sup></span>
                            </label>
                            <div class="row">
                                <div class="col form-group">
                                    <input type="hidden" name="id" value="<?php echo $id ?>" class="form-control">
                                    <input type="text" value="<?php echo $get_user_data['firstName'] ?>" class="form-control" disabled>
                                </div>
                                <div class="col form-group">
                                    <input type="text" value="<?php echo $get_user_data['lastName'] ?>" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                Email
                                <span class="text-danger"><sup>*</sup></span>
                            </label>
                            <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php echo $get_user_data['email'] ?>" placeholder="Masukkan Email" title="Please Fill With Valid Email" required>
                        </div>

                        <div class="form-group">
                            <label>
                                Position
                                <span class="text-danger"><sup>*</sup></span>
                            </label>
                            <select>
                                <option selected disabled><?php echo $get_user_data['jobTitle'] ?></option>
                                <option value="" disabled>Sales Rep</option>
                                <option value="" disabled>VP Sales</option>
                                <option value="" disabled>Sales Manager (APAC)</option>
                                <option value="" disabled>Sales Manager (EMEA)</option>
                                <option value="" disabled></option>
                                <option value="" disabled></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="action" value="edit" class="btn btn-success" onclick="return confirm('Are you sure you want to update this item?')">UPDATE DATA</button>
                        </div>
                        <div class="form-group row">

                            <div class="form-group social-media">
                                <div class=" social-media">
                                    <ul role="tablist" id="horizontal-list">
                                        <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-facebook"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group social-media">
                                <a href="https://www.neuronworks.co.id/" class="neuron-link">
                                    <p> www.neuronworks.co.id </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- AREA CONTENT END -->

<?php
require_once('../template/footer.php');

?>