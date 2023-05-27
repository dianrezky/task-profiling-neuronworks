@extends('layout.main')

@section('container')

     <!-- Breadcrumb Section Begin -->
     <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="breadcrumb-text product-more">
                    <a href="/"><i class="fa fa-home"></i> Home</a>
                    <a href="/history-admin">History</a>
                    <span>Detail</span>
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
                                    <th align="center">Number Transaction</th>
                                    <th align="center">More Detail</th>
                                </tr>
                            </thead>
                            <?php $i=1;?>
                            @while($i<=$history)
                                <tbody>
                                    <tr>
                                        <td class="cart-pic first-row">
                                            <h5 align="center">{{ $i }}</h5>
                                        </td>
                                        <td class="qua-col first-row">
                                            <form method="POST" action="/detail-admin/{{ $i }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $user }}">
                                                <button align="right" type="submit" class="primary-btn up-cart">View</button>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            <?php $i++; ?>
                            @endwhile  
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Shopping Cart Section End -->
    
@endsection
