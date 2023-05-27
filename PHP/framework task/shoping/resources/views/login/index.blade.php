@extends('layout.main')

@section('container')

<!-- Login Section Begin -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <!-- Memunculkan Pesan Flash jika register berhasil -->
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <!-- Memunculkan Pesan Flash jika login gagal -->
                @if(session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="login-form">
                    <h2>Login</h2>
                    <br><br>
                    <form action="/login" method="POST">
                        @csrf
                        <div class="group-input">
                            <label for="email">Email address *</label>
                            <input type="email" id="email" name="email" placeholder="Enter Your Email" value="{{ old('email') }}" class="form-control rounded-top @error('email') is-invalid @enderror" required>
                            @error('email')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <label for="password">Password *</label>
                        <div class="group-input" style="position: relative; display: flex; align-items: center;">
                            
                            <div class="password-input">
                                <input type="password" id="password" name="password" placeholder="Enter Your Password" required>
                            </div>
                            <button type="button" id="showPasswordButton" onclick="togglePasswordVisibility()">
                            <i class="fa-solid fa-eye" id="eye"></i>
                            </button>
                        </div>

                        <div class="group-input gi-check">
                            <div class="gi-more">
                                <label for="save-pass">
                                    Remember Me
                                    <input type="checkbox" name="remember" id="save-pass">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="site-btn login-btn">Sign In</button>
                    </form>
                    <div class="switch-login">
                        <a href="/register" class="or-login">Or Create An Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Form Section End -->

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var showPasswordButton = document.getElementById("showPasswordButton");
        var showPasswordIcon = document.getElementById("showPasswordIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordIcon.textContent = "visibility";
        } else {
            passwordInput.type = "password";
            showPasswordIcon.textContent = "visibility_off";
        }
    }
</script>
@endsection