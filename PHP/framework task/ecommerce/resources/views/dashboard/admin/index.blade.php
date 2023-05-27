@extends('layout.main')

@section('container')
    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h4 align="center" class="fw-title">Add Furniture</h4>
                        <div class="box-profile">
                            <a href="/furniture-create"><button class="site-btn register-btn">Add Furniture</button></a>
                        </div>
                        <br>
                        <p align="center">Klik Tombol Diatas Untuk Menambahkan Data Furniture</p>
                    </div>
                </div>
                
                <div class="col-lg-9 order-1 order-lg-2">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="product-list">
                        <div class="row">
                            @foreach ($product as $product)
                                <div class="col-lg-4 col-sm-6">
                                    <div class="product-item">
                                        <div class="pi-pic">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="">
                                            <div class="icon">
                                                <i class="icon_heart_alt"></i>
                                            </div>
                                            <ul>
                                                <li class="w-icon active"><a href="/furniture-edit/{{ $product->id }}"><i class="icon_pencil-edit_alt"></i></a></li>
                                                <li class="quick-view"><a href="/furniture/{{ $product->id }}">+ Quick View</a></li>
                                                <li class="w-icon">
                                                    <form action="/furniture-delete/{{ $product->id }}" method="POST">
                                                       
                                                        @csrf
                                                        <button onclick="return confirm('Are you sure want to delete this data ?')"><i class="icon_trash_alt"></i></button>
                                                    </form>
                                                    
                                                </li>
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

    