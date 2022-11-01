@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form class="row row-cols-lg-auto g-3 align-items-center mb-3 mt-2" method="GET" action="{{ url('admin/laporan') }}">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-text">Mulai</div>
                    <input type="date" class="form-control" name="awal" value="{{ $_REQUEST['awal'] ?? '' }}" required>
                </div>
            </div>
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-text">Sampai</div>
                    <input type="date" class="form-control" name="akhir" value="{{ $_REQUEST['akhir'] ?? '' }}"
                        required>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ url('admin/laporan') }}" class="btn btn-warning">Reset</a>
                <button type="submit" class="btn btn-success" onclick="printArea()">Cetak</button>
            </div>
        </form>
        <div class="table-responsive" id="print-area">
            <table class="table table-sm table-striped table-bordered" width="100%" cellspacing="0">
                <thead class="bg-white text-dark">
                    <tr class="text-center py-3">
                        <th class="py-3" width="33%">Tanggal</th>
                        <th class="py-3" width="15%"><span class="text-warning">Modal</span></th>
                        <th class="py-3" width="15%"><span class="text-info">Penjualan</span></th>
                        <th class="py-3" width="10%"><span class="text-danger">Fee (Biaya)</span></th>
                        <th class="py-3" width="12%"><span class="text-danger">Pengeluaran</span></th>
                        <th class="py-3" width="15%"><span class="text-success">Pendapatan</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ tanggal($item['tanggal']) }}</td>
                            <td class="text-warning">
                                Rp. <span class="float-end">{{ number_format($item['total_modal']) }}</span>
                            </td>
                            <td class="text-info">
                                Rp. <span class="float-end">{{ number_format($item['total_penjualan']) }}</span>
                            </td>
                            <td class="text-danger">
                                Rp. <span class="float-end">{{ number_format($item['total_fee']) }}</span>
                            </td>
                            <td class="text-danger">
                                Rp. <span class="float-end">{{ number_format($item['total_pengeluaran']) }}</span>
                            </td>
                            <td class="text-success">
                                Rp. <span class="float-end">{{ number_format($item['total_pendapatan']) }}</span>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-white text-dark">
                        <td class="text-center py-3">
                            <h5 class="fw-bold">Grand Total</h5>
                        </td>
                        <td class="text-warning py-3">
                            <h5 class="fw-bold">
                                Rp. <span class="float-end">{{ number_format($grand_modal) }}</span>
                            </h5>
                        </td>
                        <td class="text-info py-3">
                            <h5 class="fw-bold">
                                Rp. <span class="float-end">{{ number_format($grand_penjualan) }}</span>
                            </h5>
                        </td>
                        <td class="text-danger py-3">
                            <h5 class="fw-bold">
                                Rp. <span class="float-end">{{ number_format($grand_fee) }}</span>
                            </h5>
                        </td>
                        <td class="text-danger py-3">
                            <h5 class="fw-bold">
                                Rp. <span class="float-end">{{ number_format($grand_pengeluaran) }}</span>
                            </h5>
                        </td>
                        <td class="text-success py-3">
                            <h5 class="fw-bold">
                                Rp. <span class="float-end">{{ number_format($grand_pendapatan) }}</span>
                            </h5>
                        </td>
                    </tr>
                </tbody>
            </table>
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
