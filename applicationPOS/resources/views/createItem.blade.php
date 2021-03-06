@extends('template.template')
@section('title')
    Create New Item
    @endsection
@section('title-body')
    Create New Item
    @endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="namaBarang">Nama Barang</label>
                    <input class="form-control" type="text" name="namaBarang" id="namaBarang" placeholder="enter item name" value="{{ old('namaBarang') }}">
                </div>
                <div class="form-group">
                    <label for="hargaBarang">Nama Barang</label>
                    <input class="form-control" type="number" name="hargaBarang" id="hargaBarang" placeholder="enter item price" value="{{ old('hargaBarang') }}">
                </div>
                <div class="form-group">
                    <label for="stokBarang">Stok Barang</label>
                    <input class="form-control" type="text" name="stokBarang" id="stokBarang" placeholder="enter starting item stock" {{ old('stokBarang') }}>
                </div>
                <div class="form-group">
                    <label for="gambarBarang">Gambar Barang</label>
                    <input type="file" class="form-control-file" id="gambarBarang" name="gambarBarang" aria-describedby="gambarBarangHelp">
                    <small id="gambarBarangHelp" class="form-text text-muted">Only Upload JPG|PNG. with size smaller than 15mb</small>
                </div>
                <div class="form-group">
                    <label for="tipeBarang">Tipe Barang</label>
                    <select class="form-control" id="tipeBarang" name="tipeBarang">
                        <option value="minuman">Minuman</option>
                        <option value="makanan">Makanan</option>
                        <option value="snack">Snack</option>
                        <option value="rokok">Rokok</option>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
    @endsection
