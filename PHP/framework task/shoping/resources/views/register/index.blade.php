@extends('layout.main')

@section('container')

    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                        <h2>Register</h2>
                        <br><br>
                        <form action="/register" method="POST">
                            @csrf
                            <div class="group-input">
                                <label for="name">Fullname *</label>
                                <input type="text" id="name" placeholder="Enter Your Full Name" name="name" class="form-control rounded-top @error('name') is-invalid @enderror" required>
                                @error('name')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="group-input">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" placeholder="Enter Your Email" class="form-control rounded-top @error('email') is-invalid @enderror" required>
                                @error('email')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="group-input">
                                <label for="password">Password *</label>
                                <input type="password" id="password" name="password" placeholder="Enter Your Password" class="form-control rounded-top @error('password') is-invalid @enderror" required>
                                @error('password')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="group-input-address">
                                <label for="address">Address *</label>
                                <input type="text" id="address" name="address" placeholder="Enter Your Address" class="form-control rounded-top @error('address') is-invalid @enderror" required>
                                @error('address')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="group-input">
                                <label for="gender">Gender *</label>
                            </div>
                            <div>
                                <input type="radio" id="male" name="gender" value="Male" class="rounded-top @error('gender') is-invalid @enderror" required>
                                <label for="male">&ensp;Male &ensp;&ensp;&ensp;</label>
                                <input type="radio" id="female" name="gender" value="Female" >
                                <label for="female">&ensp;Female</label>
                                @error('gender')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <br><br>
                            
                            <button type="submit" class="site-btn register-btn">REGISTER</button>
                        </form>
                        <div class="switch-login">
                            <a href="/login" class="or-login">Or Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

@endsection