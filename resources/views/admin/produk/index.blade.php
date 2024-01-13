@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex align-items-center justify-content-between mb-3 gap-3">
                @if (Auth::user()->level == 'owner')
                    <a href="{{ url('admin/produk/create') }}" class="btn btn-primary flex-shrink-0">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-1">Tambah</span>
                    </a>
                @endif

                <div class="input-group align-self-start">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" type="checkbox" value="stok_habis" id="checkboxStokHabis">
                        <label class="ms-3" for="checkboxStokHabis">Stok Habis</label>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive rounded bg-white p-3 shadow-sm">
                    <table class="table-bordered datatable table align-middle">
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
            const datatable = $('.datatable').DataTable({
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


            $('#checkboxStokHabis').change(function() {
                if (this.checked) {
                    datatable.ajax.url("{{ url('admin/produk/stok-habis') }}").load()
                } else {
                    datatable.ajax.url("{{ url('admin/produk') }}").load()
                }
            });
        });
    </script>
@endsection
