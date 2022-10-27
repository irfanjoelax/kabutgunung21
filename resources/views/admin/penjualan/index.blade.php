@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('admin/penjualan/create') }}" class="btn btn-primary mb-3">
                    <i class="fa-solid fa-plus"></i>
                    <span class="ms-1">Tambah</span>
                </a>
                <div class="bg-white p-3 rounded shadow-sm table-responsive">
                    <table class="table table-bordered datatable align-middle" width="100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="16%" class="text-center">No. Pesanan</th>
                                <th width="13%" class="text-start">Total</th>
                                <th width="10%" class="text-start">Fee</th>
                                <th width="13%" class="text-start">Grand Total</th>
                                <th width="21%" class="text-center">Status</th>
                                <th width="20%" class="text-start">Remark</th>
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
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                processing: true,
                ajax: {
                    url: "{{ url('admin/penjualan') }}",
                    type: "GET"
                },
                ordering: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
                }
            });
        });
    </script>
@endsection
