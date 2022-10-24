@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-3">
                <h3 class="fw-bold" class="d-flex flex-column">
                    <img class="mb-3"
                        src="data:image/png;base64,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">
                    <p class="text-black-50">Form Data Produk</p>
                </h3>
            </div>
            <div class="col-md-9 mb-3">
                @if ($errors->any())
                    <div class="alert alert-warning mb-3" role="alert">
                        <ul class="my-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ $url }}" class="bg-white p-3 shadow-sm rounded" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <label for="sku" class="col-sm-3 col-form-label">SKU</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="sku" placeholder="Masukkan SKU Barang"
                                value="{{ $isEdit ? $data->sku : old('sku') }}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="nama" class="col-sm-3 col-form-label">Nama Produk</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Barang"
                                value="{{ $isEdit ? $data->nama : old('nama') }}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="date" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-6">
                            <select name="kategori_id" class="form-select" required>
                                <option value="" selected>-- Pilih Kategori Produk --</option>
                                @foreach ($kategoris as $item)
                                    <option
                                        value="{{ $item->id }}"{{ $isEdit ? isSelected($item->id, $data->kategori_id) : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="harga_beli" class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-text">Rp. </span>
                                <input type="number" class="form-control text-end" name="harga_beli" placeholder="0"
                                    value="{{ $isEdit ? $data->harga_beli : old('harga_beli') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="stok" class="col-sm-3 col-form-label">Stok Produk</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-text">PCS</span>
                                <input type="number" class="form-control text-end" name="stok" placeholder="0"
                                    value="{{ $isEdit ? $data->stok : old('stok') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 offset-sm-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? 'Ubah' : 'Simpan' }} Data
                            </button>
                            <a href="{{ url('admin/produk') }}" class="btn btn-warning">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
