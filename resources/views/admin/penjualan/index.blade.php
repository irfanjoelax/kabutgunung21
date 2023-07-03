@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form class="row" id="form-filter">
                    {{-- <div class="col-12">
                            <div class="input-group">
                                <div class="input-group-text">No. Invoice</div>
                                <select class="form-select" multiple name="no_invoice">
                                    <option value="" selected>Cari No. Invoice</option>
                                    @foreach ($penjualans as $penjualan)
                                        <option value="{{ $penjualan->id }}">{{ $penjualan->no_invoice }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">No. Pesanan Marketplace</div>
                            <select class="js-example-basic-multiple" name="no_pesanan[]" id="no_pesanan"
                                multiple="multiple">
                                @foreach ($penjualans as $penjualan)
                                    <option value="{{ $penjualan->no_pesanan }}">{{ $penjualan->no_pesanan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">Awal</div>
                            <input type="date" class="form-control" name="awal" id="awal"
                                value="{{ $_REQUEST['awal'] ?? $awal }}" required>
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">Akhir</div>
                            <input type="date" class="form-control" name="akhir" id="akhir"
                                value="{{ $_REQUEST['akhir'] ?? $akhir }}" required>
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">Status</div>
                            <select name="status" id="status" class="form-select">
                                <option value="BELUM TERBAYAR" selected>BELUM TERBAYAR</option>
                                <option value="TERBAYAR">TERBAYAR</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ url('admin/penjualan') }}" class="btn btn-warning">Reset</a>
                    </div>
                </form>
            </div>

            <div class="col-md-12 mb-3">
                <div class="rounded-4 table-responsive bg-white p-3 shadow-sm">
                    <a href="{{ url('admin/penjualan/create') }}" class="btn btn-primary mb-3">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-1">Tambah</span>
                    </a>
                    <table class="table-bordered datatable table align-middle" width="100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="22%" class="text-center">No. Pesanan/Invoice</th>
                                <th width="10%" class="text-center">User</th>
                                <th width="13%" class="text-start">Total</th>
                                <th width="13%" class="text-start">Grand Total</th>
                                <th width="7%" class="text-center">Status Kirim</th>
                                <th width="7%" class="text-center">Status Bayar</th>
                                <th width="21%" class="text-start">Remark</th>
                                <th width="7%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            const urlAjax = "{{ url('admin/penjualan') }}";

            const datatable = $('.datatable').DataTable({
                processing: true,
                ajax: {
                    url: urlAjax,
                    type: "GET"
                },
                ordering: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
                }
            });

            $('#form-filter').on('submit', function(event) {
                event.preventDefault();

                const awal = document.getElementById('awal').value;
                const akhir = document.getElementById('akhir').value;
                const status = document.getElementById('status').value;
                const noPesanan = $('select[name="no_pesanan[]"]').val();

                const urlFilter = "{{ url('admin/penjualan') }}" + "/" + awal + "/" + akhir + "/" + status +
                    "?no_pesanan=" + noPesanan.join(',');

                datatable.ajax.url(urlFilter).load()
            })

            $('.datatable').on('change', '.status-kurir', function() {
                var penjualanId = $(this).data('penjualan-id');
                var status = $(this).prop('checked') ? 'TERKIRIM' : 'BELUM TERKIRIM';

                $.ajax({
                    url: '/admin/penjualan/update/kurir/' + penjualanId,
                    type: 'GET',
                    data: {
                        status: status
                    }
                });
            });

            $('.datatable').on('change', '.status-bayar', function() {
                var penjualanId = $(this).data('penjualan-id');
                var status = $(this).prop('checked') ? 'TERBAYAR' : 'BELUM TERBAYAR';

                $.ajax({
                    url: '/admin/penjualan/update/bayar/' + penjualanId,
                    type: 'GET',
                    data: {
                        status: status
                    }
                });
            });

            $('.js-example-basic-multiple').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
@endsection
