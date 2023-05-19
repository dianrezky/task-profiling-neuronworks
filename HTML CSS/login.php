<?php
require_once('../template/header.php');
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
                <form method="POST" action="../PHP/cek_login.php">
                    <img src="..\assets\image\logomark-sign.png" alt="" width="112px" height="33.17px">
                    <div class="form-recruitment">
                        <h3 class="title-form">Form Login <?php ?></h3>
                        <div class="form-group">
                            <label for="fullname">
                                Username
                                <span class="text-danger"><sup>*</sup></span>
                            </label>
                            <input type="text" placeholder="Masukkan Nama" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>
                                Password
                            </label>

                            <div class="password-container">
                                <input type="password"  placeholder="Masukkan Password" name="password" id="password" title="Please Fill With Valid Email" id="password" required>
                                <i class="fa-solid fa-eye" id="eye"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" value="SUBMIT" style="background-color:aqua" class="btn btn-dark py-3 px-4" required>
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

<script>
    const passwordInput = document.querySelector("#password")
    const eye = document.querySelector("#eye")

    eye.addEventListener("click", function(){
  this.classList.toggle("fa-eye-slash")
  const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
  passwordInput.setAttribute("type", type)
})
</script>