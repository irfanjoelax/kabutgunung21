@extends('layouts.app')

@section('content')
    <div class="container">
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
                        <th class="py-3" width="40%">Tanggal</th>
                        <th class="py-3" width="20%"><span class="text-primary">Penjualan</span></th>
                        <th class="py-3" width="20%"><span class="text-danger">Pengeluaran</span></th>
                        <th class="py-3" width="20%"><span class="text-success">Pendapatan</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ tanggal($item['tanggal']) }}</td>
                            <td class="text-primary">
                                Rp. <span class="float-end">{{ number_format($item['total_penjualan']) }}</span>
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
                            <h4 class="fw-bold">Grand Total</h4>
                        </td>
                        <td class="text-primary py-3">
                            <h4 class="fw-bold">
                                Rp. <span class="float-end">{{ number_format($grand_penjualan) }}</span>
                            </h4>
                        </td>
                        <td class="text-danger py-3">
                            <h4 class="fw-bold">
                                Rp. <span class="float-end">{{ number_format($grand_pengeluaran) }}</span>
                            </h4>
                        </td>
                        <td class="text-success py-3">
                            <h4 class="fw-bold">
                                Rp. <span class="float-end">{{ number_format($grand_pendapatan) }}</span>
                            </h4>
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
