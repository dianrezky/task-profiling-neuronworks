@extends('layout.main')

@section('container')

    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                        <h2>Update Furniture</h2>
                        <br><br>
                        <form action="/furniture-edit/{{ $furniture->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="group-input">
                                <label for="username">Name</label>
                                <input type="text" id="name" placeholder="Masukkan Nama Furniture" name="name" value="{{ $furniture->name }}" class="form-control rounded-top @error('name') is-invalid @enderror" required>
                                @error('name')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="group-input">
                                <label for="price">Price</label>
                                <input type="number" id="price" name="price" placeholder="Masukkan Harga Furniture" value="{{ $furniture->price }}" class="form-control rounded-top @error('price') is-invalid @enderror" required>
                                @error('price')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="group-input">
                                <label for="type">Type</label>
                                <select name="type" value="{{ $furniture->type }}"class="dropdown-content form-control rounded-top @error('type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Tipe Barang</option>
                                    @if($furniture->type == "Table")
                                        <option value="Table"  selected>Table</option>
                                        <option value="Chair">Chair</option>
                                        <option value="Bed">Bed</option>
                                        <option value="Storage">Storage</option>
                                    @endif
                                    @if($furniture->type == "Chair")
                                        <option value="Table">Table</option>
                                        <option value="Chair" selected>Chair</option>
                                        <option value="Bed">Bed</option>
                                        <option value="Storage">Storage</option>
                                    @endif
                                    @if($furniture->type == "Bed")
                                        <option value="Table">Table</option>
                                        <option value="Chair">Chair</option>
                                        <option value="Bed" selected>Bed</option>
                                        <option value="Storage">Storage</option>
                                    @endif
                                    @if($furniture->type == "Storage")
                                        <option value="Table">Table</option>
                                        <option value="Chair">Chair</option>
                                        <option value="Bed">Bed</option>
                                        <option value="Storage" selected>Storage</option>
                                    @endif
                                    
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="color">Color</label>
                                <select name="color" value="{{ $furniture->color }}" class="dropdown-content form-control rounded-top @error('color') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Warna Barang</option>
                                    @if($furniture->color == "Black")
                                        <option value="Black" selected>Black</option>
                                        <option value="White">White</option>
                                        <option value="Blue">Blue</option>
                                    @endif
                                    @if($furniture->color == "White")
                                        <option value="Black">Black</option>
                                        <option value="White" selected>White</option>
                                        <option value="Blue">Blue</option>
                                    @endif
                                    @if($furniture->color == "Blue")
                                        <option value="Black">Black</option>
                                        <option value="White">White</option>
                                        <option value="Blue" selected>Blue</option>
                                    @endif
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="image">Image *</label>
                                <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png" class="form-control rounded-top @error('image') is-invalid @enderror">
                                @error('image')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <br><br>
                            <button type="submit" class="site-btn register-btn">Update Furniture</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

@endsection