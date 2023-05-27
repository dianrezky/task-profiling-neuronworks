@extends('layout.main')

@section('container')

     <!-- Breadcrumb Section Begin -->
     <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/history">History</a>
                        <span>Detail</span>
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
                    <table>
                        <tr>
                            <th><b>Transaction Id</b></th>
                            <th><b>&emsp;: </b></th>
                            <th><b>&emsp;{{ $info->num_transaction }}</b></th>
                        </tr>
                        <td><br></td>
                        <tr>
                            <th>Transaction Date</th>
                            <th>&emsp;: </th>
                            <th>&emsp;{{ $info->created_at->format('Y-m-d') }}</th>
                        </tr>
                        <tr>
                            <th>Method</th>
                            <th>&emsp;: </th>
                            <th>&emsp;{{ $info->method }}</th>
                        </tr>
                        <tr>
                            <th>Card Number</th>
                            <th>&emsp;: </th>
                            <th>&emsp;{{ wordwrap($info->card_number,4,'-',true) }}</th>
                        </tr>
                        <tr>
                            <th>User's Name</th>
                            <th>&emsp;: </th>
                            <th>&emsp;{{ $user->name }}</th>
                        </tr>
                    </table>
                    <br><br>
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th align="center">Furniture's Name</th>
                                    <th align="center">Furniture's Price</th>
                                    <th align="center">Quantity</th>
                                    <th align="center">Total Price For Each Furniture</th>
                                </tr>
                            </thead>
                            @foreach ($history as $history)
                                <tbody>
                                    <tr>
                                        <td class="cart-pic first-row">
                                            <h5 align="center">{{ $history->name }}</h5>
                                        </td>
                                        <td class="cart-title first-row">
                                            <h5 align="center">Rp. {{ number_format($history->price) }}</h5>
                                        </td>
                                        <td class="p-price first-row">{{ $history->quantity }}</td>
                                        <td class="qua-col first-row">Rp. {{ number_format($history->subtotal) }}</td>
                                    </tr>
                                </tbody>  
                            @endforeach
                        </table>
                        <br><br><br>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="cart-buttons">
                                <a href="/" class="primary-btn up-cart">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="cart-total">Total <span>Rp. {{ number_format($history->total) }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
    <br><br><br><br><br><br><br><br><br>
    
@endsection