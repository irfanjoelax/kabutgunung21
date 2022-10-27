@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-3">
                <h3 class="fw-bold" class="d-flex flex-column">
                    <img class="mb-3"
                        src="data:image/png;base64,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">
                    <p class="text-black-50">Form Data Kurir</p>
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
                        <label for="kurir" class="col-sm-3 col-form-label">Jasa Kurir</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="kurir"
                                placeholder="JNE / TIKI / J&T / SiCepat"
                                value="{{ $data->kurir != null ? $data->kurir : old('kurir') }}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="no_resi" class="col-sm-3 col-form-label">No. Resi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="no_resi" placeholder="Nomor Resi Pengiriman"
                                value="{{ $data->no_resi != null ? $data->no_resi : old('no_resi') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 offset-sm-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                Simpan Data
                            </button>
                            <a href="{{ url('admin/penjualan') }}" class="btn btn-warning">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
