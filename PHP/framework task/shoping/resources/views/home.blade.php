@extends('layout.main')

@section('container')
    <!-- Banner Section Begin -->
    <div class="banner-section spad">
        @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif    
        <div class="container-fluid">
            <div class="row"> 
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="{{ asset('img/banner1.jpg') }}" alt="">
                        <div class="inner-text">
                            <h4>J</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="{{ asset('img/banner2.png') }}" alt="">
                        <div class="inner-text">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="{{ asset('img/banner1.jpg') }}" alt="">
                        <div class="inner-text">
                            <h4>H</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->

    <!-- Table Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{ asset('img/table_banner.jpg') }}">
                        <h2>Table</h2>
                        <a>Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="filter-control">
                        <ul>
                            <li class="active">Table</li>
                            <li>Chair</li>
                            <li>Bed</li>
                            <li>Storage</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel">
                        @foreach ($furniture as $table)
                            @if($table->type =="Table")
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('storage/' . $table->image) }}" alt="">
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                        <ul>
                                            @can('admin')
                                            <li class="w-icon active"><a href="/furniture-edit/{{ $table->id }}"><i class="icon_pencil-edit_alt"></i></a></li>
                                            @endcan
                                            @cannot('admin')
                                                <li class="w-icon active">
                                                    <form action="/cart/{{ $table->id }}" method="POST">
                                                        @csrf
                                                        <button onclick><i class="icon_bag_alt"></i></button>
                                                    </form>
                                                </li>
                                            @endcannot
                                            <li class="quick-view"><a href="/furniture/{{ $table->id }}">+ Quick View</a></li>
                                            @can('admin')
                                            <li class="w-icon">
                                                <form action="/furniture-delete/{{ $table->id }}" method="POST">
                                                   
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure want to delete this data ?')"><i class="icon_trash_alt"></i></button>
                                                </form>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{ $table->type }}</div>
                                        <a href="/furniture/{{ $table->id }}">
                                            <h5>{{ $table->name }}</h5>
                                        </a>
                                        <div class="product-price">
                                            Rp. {{ number_format($table->price) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Table Banner Section End -->

    <!-- Chair Banner Section Begin -->
    <section class="man-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="filter-control">
                        <ul>
                            <li>Table</li>
                            <li class="active">Chair</li>
                            <li>Bed</li>
                            <li>Storage</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel">
                        @foreach ($furniture as $chair)
                            @if($chair->type =="Chair")
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('storage/' . $chair->image) }}" alt="">
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                        <ul>
                                            @can('admin')
                                            <li class="w-icon active"><a href="/furniture-edit/{{ $chair->id }}"><i class="icon_pencil-edit_alt"></i></a></li>
                                            @endcan
                                            @cannot('admin')
                                                <li class="w-icon active">
                                                    <form action="/cart/{{ $chair->id }}" method="POST">
                                                        @csrf
                                                        <button onclick><i class="icon_bag_alt"></i></button>
                                                    </form>
                                                </li>
                                            @endcannot
                                            <li class="quick-view"><a href="/furniture/{{ $chair->id }}">+ Quick View</a></li>
                                            @can('admin')
                                            <li class="w-icon">
                                                <form action="/furniture-delete/{{ $chair->id }}" method="POST">
                                                   
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure want to delete this data ?')"><i class="icon_trash_alt"></i></button>
                                                </form>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{ $chair->type }}</div>
                                        <a href="/furniture/{{ $chair->id }}">
                                            <h5>{{ $chair->name }}</h5>
                                        </a>
                                        <div class="product-price">
                                            Rp. {{ number_format($chair->price) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach   
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg m-large" data-setbg="{{ asset('img/chair_banner.jpg') }}">
                        <h2>Chair</h2>
                        <a>Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Chair Banner Section End -->

    <!-- Bed Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{ asset('img/bed_banner.jpg') }}">
                        <h2>Bed</h2>
                        <a>Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="filter-control">
                        <ul>
                            <li>Table</li>
                            <li>Chair</li>
                            <li class="active">Bed</li>
                            <li>Storage</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel">
                        @foreach ($furniture as $bed)
                            @if($bed->type =="Bed")
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('storage/' . $bed->image) }}" alt="">
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                        <ul>
                                            @can('admin')
                                            <li class="w-icon active"><a href="/furniture-edit/{{ $bed->id }}"><i class="icon_pencil-edit_alt"></i></a></li>
                                            @endcan
                                            @cannot('admin')
                                                <li class="w-icon active">
                                                    <form action="/cart/{{ $bed->id }}" method="POST">
                                                        @csrf
                                                        <button onclick><i class="icon_bag_alt"></i></button>
                                                    </form>
                                                </li>
                                            @endcannot
                                            <li class="quick-view"><a href="/furniture/{{ $bed->id }}">+ Quick View</a></li>
                                            @can('admin')
                                            <li class="w-icon">
                                                <form action="/furniture-delete/{{ $bed->id }}" method="POST">
                                                   
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure want to delete this data ?')"><i class="icon_trash_alt"></i></button>
                                                </form>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{ $bed->type }}</div>
                                        <a href="/furniture/{{ $bed->id }}">
                                            <h5>{{ $bed->name }}</h5>
                                        </a>
                                        <div class="product-price">
                                            Rp. {{ number_format($bed->price) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bed Banner Section End -->

    <!-- Storage Banner Section Begin -->
    <section class="man-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="filter-control">
                        <ul>
                            <li>Table</li>
                            <li>Chair</li>
                            <li>Bed</li>
                            <li class="active">Storage</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel">
                        @foreach ($furniture as $storage)
                            @if($storage->type =="Storage")
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="{{ asset('storage/' . $storage->image) }}" alt="">
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                        <ul>
                                            @can('admin')
                                            <li class="w-icon active"><a href="/furniture-edit/{{ $storage->id }}"><i class="icon_pencil-edit_alt"></i></a></li>
                                            @endcan
                                            @cannot('admin')
                                                <li class="w-icon active">
                                                    <form action="/cart/{{ $storage->id }}" method="POST">
                                                        @csrf
                                                        <button onclick><i class="icon_bag_alt"></i></button>
                                                    </form>
                                                </li>
                                            @endcannot
                                            <li class="quick-view"><a href="/furniture/{{ $storage->id }}">+ Quick View</a></li>
                                            @can('admin')
                                            <li class="w-icon">
                                                <form action="/furniture-delete/{{ $storage->id }}" method="POST">
                                                   
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure want to delete this data ?')"><i class="icon_trash_alt"></i></button>
                                                </form>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{ $storage->type }}</div>
                                        <a href="/furniture/{{ $storage->id }}">
                                            <h5>{{ $storage->name }}</h5>
                                        </a>
                                        <div class="product-price">
                                            Rp. {{ number_format($storage->price) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach   
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg m-large" data-setbg="{{ asset('img/storage_banner.jpg') }}">
                        <h2>Storage</h2>
                        <a>Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Storage Banner Section End -->
@endsection
