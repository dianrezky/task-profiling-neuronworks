@extends('layout.main')

@section('container')

     <!-- Breadcrumb Section Begin -->
     <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="../../"><i class="fa fa-home"></i> Home</a>
                        <a href="../../all_user/detail_product/all_list.php">Shop</a>
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
                                    <th>Image</th>
                                    <th class="p-name">Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Delete</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            @foreach ($cart as $cart)
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
                                                    <form method="POST" action="proses.php">
                                                    
                                                        <input type="hidden" name="id_detail" value="11">
                                                        <input type="hidden" name="id" value="11">
                                                        <input type="hidden" name="max" value="11" >
                                                        <input type="number" name="jumlah" class="pro-qty" min ="1" placeholder="{{ $cart->quantity }}">

                                                </div>
                                            </div>
                                        </td>
                                        <td class="total-price first-row">Rp. {{ number_format($cart->price) }}</td>
                                        <td class="close-td first-row"><a href=""><i class="ti-close"></i></a></td>
                                        <td><input type="submit" name="submit" class="primary-btn up-cart" value="Update"><td>
                                    </form>
                                    </tr>
                                </tbody>
                            @endforeach
                            
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="cart-buttons">
                                
                                <a href="../../all_user/detail_product/all_list.php" class="primary-btn up-cart">Continue Shopping</a>
                            </div>
                            <div class="discount-coupon">
                                <h6>NOTES</h6>
                                <h7>Jika Ingin Mengganti Jumlah Barang Atau Menghapus, Tekan Tombol Update Chart Untuk Update Barang Mu</h7>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="cart-total">Total <span>22</span></li>
                                </ul>
                                <a href="../checkout/" class="proceed-btn">PROCEED TO CHECK OUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
    
@endsection