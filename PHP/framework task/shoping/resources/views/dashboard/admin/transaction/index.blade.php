@extends('layout.main')

@section('container')

     <!-- Breadcrumb Section Begin -->
     <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>History</span>
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
                            <h2></h2>
                            <thead>
                                <tr>
                                    <th align="center">User's Name</th>
                                    <th align="center">More Detail</th>
                                </tr>
                            </thead>
                            @foreach ($user as $user)
                                <tbody>
                                    <tr>
                                        <td class="cart-pic first-row">
                                            <h5 align="center">{{ $user->name }}</h5>
                                        </td>
                                        <td class="qua-col first-row">
                                            <a href="/history-admin/{{ $user->id }}"><button align="right" type="submit" class="primary-btn up-cart">View</button></a>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach 
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
@endsection