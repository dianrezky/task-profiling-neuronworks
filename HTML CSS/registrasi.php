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
                    <form action="">
                        <img src="..\assets\image\logomark-sign.png" alt="" width="112px" height="33.17px">
                        <div class="form-recruitment">
                            <h3 class="title-form">Form Rekrutasi <?php ?></h3>
                            <p>Isi data di bawah sesuai dengan identitas diri anda dan lowongan yang akan anda pilih
                            </p>
                            <div class="form-group">
                                <label for="fullname">
                                    Fullname
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <input type="text" placeholder="Masukkan Nama" name="fullname" required>
                            </div>
                            <div class="form-group">
                                <label>
                                    Email
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <input type="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Masukkan Email" title="Please Fill With Valid Email" required>
                            </div>
                            <div class="form-group">
                                <label>
                                    Phone Number
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <input type="text" id="email" pattern="\+?([ -]?\d+)+|\(\d+\)([ -]\d+)" title="Please Fill With Valid Phone Number" placeholder="Masukkan No Handphone" required>
                            </div>
                            <div class="form-group">
                                <label>
                                    Vacancy
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <select>
                                    <option selected disabled>- Choose The Vacancy -</option>
                                    <option value="">A</option>
                                    <option value="">B</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    Position
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <select>
                                    <option selected disabled>- Choose The Position</option>
                                    <option value="">Posisi 1</option>
                                    <option value="">Posisi 2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button>SUBMIT</button>
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