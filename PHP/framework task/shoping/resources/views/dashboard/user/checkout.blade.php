@extends('layout.main')

@section('container')

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/view">Shop</a>
                        <span>Check Out</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="checkout-section spad">
        <div class="container">
            <form action="/checkout/{{ $user->id }}" method="POST" class="checkout-form">
                <div class="row">
                    <div class="col-lg-6">
                        <h4>Biiling Details</h4>
                        <br><br>
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" disabled value="{{ $user->name }}" required="required">
                                </div>
                                <div class="col-lg-12">
                                    <label for="address">Street Address</label>
                                    <input type="text" id="address" class="street-first" disabled value="{{ $user->address }}" required="required">
                                </div>
                                <div class="col-lg-6">
                                    <label for="email">Email Address</label>
                                    <input type="text" id="email" name="email" disabled value="{{ $user->email }}" required="required">
                                </div>
                                <div class="col-lg-6">
                                    <label for="method">Payment Method<span>*</span></label>
                                    <select name="method" class="dropdown-content form-control rounded-top @error('method') is-invalid @enderror" required>
                                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                        <option value="Debit">Debit</option>
                                        <option value="Credit">Credit</option>
                                    </select>
                                </div>          
                                @error('method')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror                      
                                <div class="col-lg-12">
                                    <label for="card">Card Number<span>*</span></label>
                                    <input type="number" id="card" name="card" placeholder="Enter Your Card Number" value="{{ old('card') }}"required="required" class="dropdown-content form-control rounded-top @error('card') is-invalid @enderror">
                                    @error('card')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                
                            </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Product <span>Subtotal</span></li>
                                    @foreach ($cart as $cart)
                                        <li class="fw-normal"><img src="{{ asset('storage/' . $cart->image) }}" height="80" alt=""> {{ $cart->name }} ( {{ $cart->quantity }} x Rp. {{ number_format($cart->price) }} )<span>Rp. {{ number_format($cart->subtotal) }}</span></li>
                                    @endforeach
                                    <li class="total-price">Total <span>Rp. {{ number_format($total) }}</span></li>
                                </ul>
                                <div class="order-btn">
                                    <input type="hidden" name="id" value="aa">
                                    <button type="submit" class="site-btn place-btn">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
    
@endsection