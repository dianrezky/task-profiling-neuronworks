@extends('layout.main')

@section('container')

    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                        <h2>Add Furniture</h2>
                        <br><br>
                        <form action="/furniture-create" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="group-input">
                                <label for="username">Name</label>
                                <input type="text" id="name" placeholder="Masukkan Nama Furniture" name="name" value="{{ old('name') }}" class="form-control rounded-top @error('name') is-invalid @enderror" required>
                            </div>
                            <div class="group-input">
                                <label for="price">Price</label>
                                <input type="number" id="price" name="price" placeholder="Masukkan Harga Furniture" value="{{ old('price') }}" class="form-control rounded-top @error('price') is-invalid @enderror" required>
                            </div>
                            <div class="group-input">
                                <label for="type">Type</label>
                                <select name="type" value="{{ old('type') }}"class="dropdown-content form-control rounded-top @error('type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Tipe Barang</option>
                                    <option value="Table">Table</option>
                                    <option value="Chair">Chair</option>
                                    <option value="Bed">Bed</option>
                                    <option value="Storage">Storage</option>
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="color">Color</label>
                                <select name="color" value="{{ old('color') }}" class="dropdown-content form-control rounded-top @error('color') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Warna Barang</option>
                                    <option value="Black">Black</option>
                                    <option value="White">White</option>
                                    <option value="Blue">Blue</option>
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="image">Image *</label>
                                <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png" required class="form-control rounded-top @error('image') is-invalid @enderror">
                            </div>

                            <br><br>
                            <button type="submit" class="site-btn register-btn">Add Furniture</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Form Section End -->

@endsection