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
                        <span>History</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- History Section Begin -->
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
                                            <a href="/history/{{ $i }}"><button align="right" type="submit" class="primary-btn up-cart">View</button></a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php $i++; ?>
                            @endwhile  
                        </table>
                        <br><br><br><br><br><br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    
    <!-- History Section End -->
    
@endsection