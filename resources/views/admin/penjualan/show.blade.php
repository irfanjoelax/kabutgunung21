@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="mb-3">
                    <a href="{{ url('admin/penjualan') }}" class="btn btn-warning">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span class="ms-1">Kembali</span>
                    </a>
                    <button onclick="printArea()" class="btn btn-primary ms-2">
                        <i class="fa-solid fa-print"></i>
                        <span class="ms-1">Cetak</span>
                    </button>
                </div>
                <div class="card border-0 shadow p-3" id="print-area">
                    {{-- HEADER --}}
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-start">
                            <img src="{{ asset(env('APP_LOGO')) }}" class="" width="50">
                            <h3 class="mt-2 fw-bold text-primary">
                                {{ env('APP_NAME') }}
                            </h3>
                            <small class="text-muted">Kontak: 0831 4061 7623</small>
                        </div>
                        <div class="text-end">
                            <h2 class="fw-bold">Detail Transaksi</h2>
                            <p class="text-muted">
                                {{ $data->no_pesanan }}
                            </p>
                            <span class="badge bg-secondary">
                                {{ tanggal(substr($data->created_at, 0, 10), true) }}
                            </span>
                        </div>
                    </div>

                    {{-- INFORMATION CUSTOMER DAN KURIR --}}
                    <div class="table-responsive mt-4">
                        <table class="table table-sm table-borderless" width="100%">
                            <tr>
                                <td width="19%"><strong>Nama Customer</strong></td>
                                <td width="1%">:</td>
                                <td width="71%" colspan="4">{{ $data->nama_customer }}</td>
                            </tr>
                            <tr>
                                <td width="19%"><strong>Marketplace</strong></td>
                                <td width="1%">:</td>
                                <td width="71%" colspan="4">{{ $data->marketplace_id }}</td>
                            </tr>
                            <tr>
                                <td width="19%"><strong>Kurir</strong></td>
                                <td width="1%">:</td>
                                <td width="20%">{{ $data->kurir }}</td>
                                <td width="19%"><strong>Nomor Resi</strong></td>
                                <td width="1%">:</td>
                                <td width="40%">{{ $data->no_resi }}</td>
                            </tr>
                            <tr>
                                <td width="19%"><strong>Status Kurir</strong></td>
                                <td width="1%">:</td>
                                <td width="20%">{{ $data->status_kurir }}</td>
                                <td width="19%"><strong>Status Bayar</strong></td>
                                <td width="1%">:</td>
                                <td width="40%">{{ $data->status_bayar }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- INFORMATION DETAIL PENJUALAN --}}
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-primary text-white">
                                <th width="45%" class="text-start">Nama Produk</th>
                                <th width="22%" class="text-start">Hrg Jual</th>
                                <th width="10%" class="text-center">Qty</th>
                                <th width="23%" class="text-start">Sub Total</th>
                            </thead>
                            <tbody>
                                @foreach ($data->penjualan_details as $item)
                                    <tr>
                                        <td class="text-start">{{ $item->produk->nama }}</td>
                                        <td class="text-start">
                                            Rp. <span class="float-end">{{ number_format($item->hrg_jual) }}</span>
                                        </td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-start">
                                            Rp. <span class="float-end">{{ number_format($item->total) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- CATATAN DAN PEMBAYARAN --}}
                    <div class="row mt-4">
                        <div class="col-5 mb-2">
                            <div class="card border-secondary">
                                <small class="mx-2 text-muted">Remark:</small> <br>
                                <p class="m-2">{{ $data->remark }}</p>
                            </div>
                        </div>
                        <div class="col-2"></div>
                        <div class="col-5 mb-2">
                            <table class="table table-sm table-striped" width="100%">
                                <tr>
                                    <td width="29%"><strong>Total</strong></td>
                                    <td width="1%">:</td>
                                    <td width="70%">
                                        Rp. <span class="float-end">{{ number_format($data->total) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="29%"><strong>Fee (Biaya)</strong></td>
                                    <td width="1%">:</td>
                                    <td width="70%">
                                        Rp. <span class="float-end">{{ number_format($data->fee) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="29%"><strong>Grand Total</strong></td>
                                    <td width="1%">:</td>
                                    <td width="70%">
                                        Rp. <span class="float-end">{{ number_format($data->grand_total) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function printArea() {
            const printContent = document.getElementById('print-area').innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = printContent;

            window.print()

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
