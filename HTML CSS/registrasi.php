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
                <form id="recruitment-form">
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
                            <input type="text" id="fullname" placeholder="Masukkan Nama" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label>
                                Email
                                <span class="text-danger"><sup>*</sup></span>
                            </label>
                            <input type="email" id="email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Masukkan Email" title="Please Fill With Valid Email" required>
                        </div>
                        <div class="form-group">
                            <label>
                                Phone Number
                                <span class="text-danger"><sup>*</sup></span>
                            </label>
                            <input type="text" id="phoneNumber" pattern="\+?([ -]?\d+)+|\(\d+\)([ -]\d+)" title="Please Fill With Valid Phone Number" placeholder="Masukkan No Handphone" required>
                        </div>
                        <div class="form-group">
                            <label>
                                Vacancy
                                <span class="text-danger"><sup>*</sup></span>
                            </label>
                            <select id="vacancy-select"  required>
                                <option selected disabled>- Choose The Vacancy -</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                Position
                                <span class="text-danger"><sup>*</sup></span>
                            </label>
                            <select id="position-select"  required>
                                <option selected disabled>- Choose The Position</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit">SUBMIT</button>
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
                    <div class="form-group row">
                        <div class="form-group social-media">
                            <p> Anda sudah punya akun ? Silahkan Lakukan <a href="login.php">Login</a> </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel" style="color:green; font-weight:bold;">Terimakasih telah melakukan pengisian. Permintaan anda akan segera kami proses.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="result">
                <!-- Hasil inputan akan ditampilkan di sini -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    var vacancySelect = document.querySelector('#vacancy-select');

    var vacancyOptions = [{
            value: 'System Administrator',
            text: 'System Administrator'
        },
        {
            value: 'System Analyst',
            text: 'System Analyst'
        },
        {
            value: 'Business Analyst',
            text: 'Business Analyst'
        },
        {
            value: 'Junior Programmer',
            text: 'Junior Programmer'
        },
    ];

    vacancyOptions.forEach(function(option) {
        var optionElement = document.createElement('option');
        optionElement.value = option.value;
        optionElement.textContent = option.text;
        vacancySelect.appendChild(optionElement);
    });

    //UNTUK Posisi

    var positionSelect = document.querySelector('#position-select');

    var positionOptions = [{
            value: 'Jakarta',
            text: 'Jakarta'
        },
        {
            value: 'Bandung',
            text: 'Bandung'
        }
    ];

    positionOptions.forEach(function(option) {
        var optionElement = document.createElement('option');
        optionElement.value = option.value;
        optionElement.textContent = option.text;
        positionSelect.appendChild(optionElement);
    });


    // UNTUK PENAMPILAN 

    // UNTUK PENAMPILAN

    var form = document.getElementById('recruitment-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        var fullname = document.querySelector('input[name="fullname"]').value;
        var email = document.querySelector('#email').value;
        var phoneNumber = document.querySelector('#phoneNumber').value;
        var vacancy = document.querySelector('#vacancy-select').value;
        var position = document.querySelector('#position-select').value;

        var resultContainer = document.getElementById('result');
        resultContainer.innerHTML = `
        <p><b>Fullname:</b></p>
        <p>${fullname}</p>
        <p><b>Email: </b></p>
        <p>${email}</p>
        <p><b>Phone Number: </b></p>
        <p>${phoneNumber}</p>
        <p><b>Vacancy: </b></p>
        <p>${vacancy}</p>
        <p><b>Position: </b></p>
        <p>${position}</p>
    `;

        $('#resultModal').modal('show');
    });
</script>

<!-- AREA CONTENT END -->

<?php
require_once('../template/footer.php');
?>