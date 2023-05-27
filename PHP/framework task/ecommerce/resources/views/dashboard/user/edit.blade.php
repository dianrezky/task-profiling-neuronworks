@extends('layout.main')

@section('container')

    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                        <h2>Update Profile</h2>
                        <br><br>
                            <form action="/edit_profile/{{ $user->id }}" method="POST">
                                @csrf
                                <div class="group-input">
                                    <label for="name">Fullname *</label>
                                    <input type="text" id="name" placeholder="Enter Your Full Name" name="name" value="{{ $user->name }}" class="form-control rounded-top @error('name') is-invalid @enderror" required>
                                    @error('name')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="group-input">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control rounded-top @error('email') is-invalid @enderror" required>
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
                                @can('user')
                                <div class="group-input-address">
                                    <label for="address">Address *</label>
                                    <input type="text" id="address" name="address" value="{{ $user->address }}" class="form-control rounded-top @error('address') is-invalid @enderror" required>
                                    @error('address')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                @endcan
                                @can('admin')
                                <div class="group-input-address">
                                    <input type="hidden" id="address" name="address" value="{{ $user->address }}" class="form-control rounded-top @error('address') is-invalid @enderror" required>
                                </div>
                                @endcan
                               
                                <br><br>
                                
                                <button type="submit" class="site-btn register-btn">Update Profile</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

@endsection