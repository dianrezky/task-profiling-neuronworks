@extends('layout.main')

@section('container')
    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h2 align="center">List Of Furniture</h2>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-list">
                        <div class="row">
                            @foreach ($furniture as $product)
                                <div class="col-lg-4 col-sm-6">
                                    <div class="product-item">
                                        <div class="pi-pic">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="">
                                            <div class="icon">
                                                <i class="icon_heart_alt"></i>
                                            </div>
                                            <ul>
                                                @auth
                                                    @cannot('admin')
                                                    <li class="w-icon active"><a href="/cart-add/{{ $product->id }}"><i class="icon_bag_alt"></i></a></li>
                                                    @endcannot
                                                    <li class="quick-view"><a href="/furniture/{{ $product->id }}">+ Quick View</a></li>
                                                    @cannot('admin')
                                                    <li class="w-icon active"><a href="/cart-add/{{ $product->id }}"><i class="icon_bag_alt"></i></a></li>
                                                    @endcannot
                                                @endauth
                                            </ul>
                                        </div>
                                        <div class="pi-text">
                                            <div class="catagory-name">{{ $product->type }}</div>
                                            <a href="/detail">
                                                <h5>{{ $product->name }}</h5>
                                            </a>
                                            <div class="product-price">
                                                Rp. {{ number_format($product->price) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->
@endsection

    