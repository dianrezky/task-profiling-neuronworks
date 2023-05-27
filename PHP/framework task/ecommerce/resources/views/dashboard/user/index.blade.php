@extends('layout.main')

@section('container')

    <!-- Login Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">

                        @foreach ($user as $user)
                        <h2>{{ $user->name }}'s Profile</h2>
                        <br><br>
                        <form>
                            <div class="group-input">
                                <label for="name">Full Name</label>
                                <input type="name" id="name" name="name" value="{{ $user->name }}"  disabled>
                            </div>
                            <div class="group-input">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}"  disabled>
                            </div>
                            <div class="group-input">
                                <label for="role">Role</label>
                                <input type="role" id="role" name="role" value="{{ $user->is_admin }}"  disabled>
                            </div>
                        </form>
                        @endforeach
                        
                    </div>
                    
                </div>
                <div class="box-profile">
                    <a href="/logout"><button class="site-btn register-btn">Logout</button></a>
                    <a href="/edit_profile/{{ $user->id }}"><button class="site-btn register-btn">Update Profile</button></a>  
                </div>
                <div class="box-profile">
                    <a href="/logout"><button class="site-btn register-btn">nsaction History</button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Form Section End -->
    
@endsection