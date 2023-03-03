@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (Auth::user()->level == 'owner')
                    <a href="{{ url('admin/produk/create') }}" class="btn btn-primary mb-3">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-1">Tambah</span>
                    </a>
                @endif
                <div class="bg-white p-3 rounded shadow-sm table-responsive">
                    <table class="table table-bordered datatable align-middle">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="7%" class="text-center">No.</th>
                                <th width="33%" class="text-start">Nama Produk / SKU</th>
                                <th width="20%" class="text-center">Kategori</th>
                                @if (Auth::user()->level == 'owner')
                                    <th width="15%" class="text-start">Hrg. Beli</th>
                                @endif
                                <th width="8%" class="text-start">Stok</th>
                                @if (Auth::user()->level == 'owner')
                                    <th width="17%" class="text-center">Action</th>
                                @endif
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
                    url: "{{ url('admin/produk') }}",
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
