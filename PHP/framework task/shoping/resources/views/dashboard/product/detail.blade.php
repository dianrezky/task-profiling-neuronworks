@extends('layout.main')

@section('container')

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="breadcrumb-text product-more">
                    <a href="/"><i class="fa fa-home"></i> Home</a>
                    <a href="/view">View</a>
                    <span>Detail</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->
    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <ul class="filter-catagories">
                            <li><a href="/furniture-type/{{ 'Chair' }}">Chair</a></li>
                            <li><a href="/furniture-type/{{ 'Table' }}">Table</a></li>
                            <li><a href="/furniture-type/{{ 'Bed' }}">Bed</a></li>
                            <li><a href="/furniture-type/{{ 'Storage' }}">Storage</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                <img class="product-big-img" src="{{ asset('storage/' . $furniture->image) }}" alt="">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    <div class="pt active" data-imgbigurl="{{ asset('storage/' . $furniture->image) }}">
                                    <img src="{{ asset('storage/' . $furniture->image) }}" alt=""></div>
                                    <div class="pt" data-imgbigurl="{{ asset('storage/' . $furniture->image) }}">
                                    <img  src="{{ asset('storage/' . $furniture->image) }}" alt=""></div>
                                    <div class="pt" data-imgbigurl="{{ asset('storage/' . $furniture->image) }}">
                                    <img src="{{ asset('storage/' . $furniture->image) }}" alt=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
                                    <span>{{ $furniture->type }}</span>
                                    <h3>{{ $furniture->name }}</h3>
                                    <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                                </div>
                                <div class="pd-desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur ing elit, sed do eiusmod tempor sum dolor
                                        sit amet, consectetur adipisicing elit, sed do mod tempor</p>
                                    <h4>Rp. {{ number_format($furniture->price) }}</h4>
                                </div>
                                <div class="pd-color">
                                    <h6>Color :</h6>
                                    <div class="pd-color-choose">
                                        <div class="cc-item">
                                            <h6>{{ $furniture->color }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="quantity">
                                @cannot('admin')
                                    <form action="/detail-add/{{ $furniture->id }}" method="POST">
                                        @csrf
                                        <input type="number" name="jumlah" class="pro-qty" value="1" min ="1">
                                        <input type="submit"  class="primary-btn pd-cart" value="Add To Cart">
                                    </form>
                                @endcannot
                                @can('admin')
                                <a href="/furniture-edit/{{ $furniture->id }}"><button class="primary-btn pd-cart">Update Furniture</button></a>
                                @endcannot
                                </div>
                                @can('admin')
                                <form action="/furniture-delete/{{ $furniture->id }}" method="POST">
                                    @csrf
                                    <input type="submit" class="primary-btn pd-cart" value="Delete Furniture" onclick="return confirm('Are you sure want to delete this data ?')">
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#tab-1" role="tab">DESCRIPTION</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-2" role="tab">SPECIFICATIONS</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-3" role="tab">NOTES</a>
                                </li>
                            </ul>
                        </div> 
                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="product-content">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <h5>About Furniture</h5>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                    ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                    aliquip ex ea commodo consequat. Duis aute irure dolor in </p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img src="img/product-single/tab-desc.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            <tr>
                                                <td class="p-catagory">Price</td>
                                                <td>
                                                    <div class="p-price">Rp. {{ number_format($furniture->price) }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Color</td>
                                                <td>{{ $furniture->color }}</td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Type</td>
                                                <td>{{ $furniture->type }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <div class="product-content">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p>Login First To Checkout This Furniture. If You Don't Have An Account, You Can Register First</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img src="img/product-single/tab-desc.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

    <!-- Related Products Section End -->
    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>More Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($furnitures as $furnitures)
                    <div class="col-lg-3 col-sm-6">
                        <div class="product-item">
                            <div class="pi-pic">
                                <img src="{{ asset('storage/' . $furnitures->image) }}" alt="">
                                <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div>
                                <ul>
                                    <li class="quick-view"><a href="#">+ Quick View</a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">{{ $furnitures->type }}</div>
                                <a href="#">
                                    <h5>{{ $furnitures->name }}</h5>
                                </a>
                                <div class="product-price">
                                    Rp. {{ number_format($furniture->price) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Related Products Section End -->
@endsection