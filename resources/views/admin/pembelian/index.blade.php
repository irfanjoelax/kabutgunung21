@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-12">
                <form class="rounded bg-white p-3 shadow-sm" method="post" action="{{ url('admin/pembelian') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU Produk</label>
                        <input type="text" class="form-control" name="sku" id="sku"
                            placeholder="Masukkan SKU Produk">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <textarea class="form-control" name="nama" id="nama" rows="3" readonly></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stok" id="stok" placeholder="0"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="stok" class="form-label">Re-Stok</label>
                                <input type="number" class="form-control" name="restok" id="restok" placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="mb-3">
                                <label for="harga_beli" class="form-label">Harga Modal/Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="harga_beli" id="harga_beli"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <div class="col-md-8 col-12">
                <div class="table-responsive rounded bg-white p-3 shadow-sm">
                    <table class="table-bordered datatable table align-middle">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="7%" class="text-center">No.</th>
                                <th width="33%" class="text-start">Nama Produk / SKU</th>
                                <th width="20%" class="text-center">Kategori</th>
                                <th width="15%" class="text-start">Hrg. Beli</th>
                                <th width="8%" class="text-start">Stok</th>
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
                    url: "{{ url('admin/pembelian') }}",
                    type: "GET"
                },
                ordering: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
                }
            });

            $('#sku').on('change', function() {
                var sku = $(this).val();

                $.get('/admin/produk/show/' + sku, function(response) {
                    $('#nama').val(response.nama);
                    $('#harga_beli').val(response.harga_beli);
                    $('#stok').val(response.stok);
                });
            });
        });
    </script>
@endsection
