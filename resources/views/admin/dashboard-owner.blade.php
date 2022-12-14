@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-3 col-12 mb-2">
                <div class="card border-0 shadow p-0">
                    <div class="d-flex align-item-center justify-content-between">
                        <div class="align-self-center px-3">
                            <span class="text-muted">Modal</span>
                            <h4 class="text-primary m-0 fw-bold">
                                Rp. {{ number_format($grand_modal) }}
                            </h4>
                        </div>
                        <img src="https://img.icons8.com/bubbles/100/000000/open-box.png" />
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 mb-2">
                <div class="card border-0 shadow p-0">
                    <div class="d-flex align-item-center justify-content-between">
                        <div class="align-self-center px-3">
                            <span class="text-muted">Penjualan</span>
                            <h4 class="text-warning m-0 fw-bold">
                                Rp. {{ number_format($grand_penjualan) }}
                            </h4>
                        </div>
                        <img src="https://img.icons8.com/clouds/100/000000/favorite-cart.png" />
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 mb-2">
                <div class="card border-0 shadow p-0">
                    <div class="d-flex align-item-center justify-content-between">
                        <div class="align-self-center px-3">
                            <span class="text-muted">Pengeluaran</span>
                            <h4 class="text-danger m-0 fw-bold">
                                Rp. {{ number_format($grand_pengeluaran) }}
                            </h4>
                        </div>
                        <img src="https://img.icons8.com/bubbles/100/000000/bank-card-front-side.png" />
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 mb-2">
                <div class="card border-0 shadow p-0">
                    <div class="d-flex align-item-center justify-content-between">
                        <div class="align-self-center px-3">
                            <span class="text-muted">Pendapatan</span>
                            <h4 class="text-success m-0 fw-bold">
                                Rp. {{ number_format($grand_pendapatan) }}
                            </h4>
                        </div>
                        <img src="https://img.icons8.com/clouds/100/000000/graph-report.png" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6 col-12 mb-2">
                <div class="card border border-primary shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Grafik Penjualan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            {!! $chart1->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 mb-2">
                <div class="card border border-warning shadow mb-4">
                    <div class="card-header bg-warning text-white">
                        <h6 class="m-0 font-weight-bold">Grafik Pengeluaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            {!! $chart2->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6 col-12 mb-2">
                <div class="card border border-success shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="m-0 font-weight-bold">Marketplace Terlaris</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            {!! $chart3->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 mb-2">
                <div class="card border border-danger shadow mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="m-0 font-weight-bold">Produk Terlaris</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" width="100%">
                                @foreach ($produk_laris as $item)
                                    <tr>
                                        <td width="69%">{{ $item->produk->nama }}</td>
                                        <td width="1%">:</td>
                                        <td width="30%">
                                            <strong>{{ $item->count_of_trx }}</strong> <small
                                                class="text-muted">Transaksi</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
    {!! $chart2->renderJs() !!}
    {!! $chart3->renderJs() !!}
@endsection
