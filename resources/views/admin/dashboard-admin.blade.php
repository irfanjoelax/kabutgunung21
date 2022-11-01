@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-7 col-12 mb-3 align-self-center">
                <h1 class="display-2 fw-bold mb-1">
                    Welcome!
                </h1>
                <p class="text-muted mb-4">
                    Sistem Informasi Penjualans {{ env('APP_NAME') }} untuk memantau semua transaksi yang dilakukan mulai
                    dari penjualan hingga pengeluaran dengan laporan data setiap bulannya
                </p>
                <a href="{{ url('admin/penjualan', []) }}" class="btn btn-primary">
                    + Input Penjualan Baru
                </a>
            </div>
            <div class="col-md-5 col-12 mb-2">
                <img src="{{ asset('img/hello.svg') }}" alt="" class="img-fluid">
            </div>
        </div>
    </div>
@endsection
