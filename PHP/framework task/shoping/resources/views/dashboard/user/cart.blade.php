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
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                            
                                <tr>
                                    <th align="center">Image</th>
                                    <th align="center">Product Name</th>
                                    <th align="center">Price</th>
                                    <th align="center">Quantity</th>
                                    <th align="center">Total</th>
                                    <th align="center">Delete</th>
                                    <th align="center">Update</th>
                                </tr>
                            </thead>
                            
                            @foreach ($cart as $cart)
                                
                                <form method="POST" action="/chart-update/{{ $cart->id }}">
                                    @csrf
                                    <tbody>
                                        <tr>
                                            <td class="cart-pic first-row">
                                                <img src="{{ asset('storage/' . $cart->image) }}" alt="">
                                            </td>
                                            <td class="cart-title first-row">
                                                <h5 align="center">{{ $cart->name }}</h5>
                                            </td>
                                            <td class="p-price first-row"> Rp. {{ number_format($cart->price) }}</td>
                                            <td class="qua-col first-row">
                                                <div class="quantity">
                                                    <div>
                                                        <input type="number" name="jumlah" class="pro-qty" min ="1" value="{{ $cart->quantity }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="total-price first-row">Rp. {{ number_format($cart->subtotal) }}</td>
                                            <td class="close-td first-row"><a href="/cart-delete/{{ $cart->id }}"><i class="ti-close"></i></a></td>
                                            <td><input type="submit" name="submit" class="primary-btn up-cart" value="Update"><td>
                                        </tr>
                                    </tbody>                            
                                </form>
                            @endforeach
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="cart-buttons">
                                
                                <a href="/" class="primary-btn up-cart">Continue Shopping</a>
                            </div>
                            <div class="discount-coupon">
                                <h6>NOTES</h6>
                                <p>Jika Ingin Mengganti Jumlah Barang Tekan Tombol Update. Jika Ingin Menghapus Barang, Tekan Tombol Delete</p>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="cart-total">Total <span>Rp. {{ number_format($total) }}</span></li>
                                </ul>
                                <a href="/checkout/{{ auth()->user()->id }}"><button align="right" type="submit" class="proceed-btn">PROCEED TO CHECK OUT</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
    
@endsection