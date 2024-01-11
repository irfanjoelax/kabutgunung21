@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-12 mb-3">
                <div class="bg-white p-3 rounded-4 shadow">
                    <h3 class="m-0 mb-3 fw-semibold">{{ $data->nama }}</h3>
                    <span class="badge bg-warning">
                        {{ $data->sku }}
                    </span>
                    <hr>
                    <table class="table table-borderless m-0">
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td>{{ $data->kategori->name }}</td>
                        </tr>
                        <tr>
                            <td>Harga Beli</td>
                            <td>:</td>
                            <td>Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td>:</td>
                            <td>{{ $data->stok }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-8 col-12 mb-3">
                <div class="bg-white p-3 rounded-4 shadow table-responsive">
                    <h1 class="mb-3 fw-bold">History Re-Stok</h1>
                    <table class="table table-bordered datatable align-middle datatable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="30%" class="text-start">Tanggal</th>
                                <th width="25%" class="text-start">Harga Awal</th>
                                <th width="25%" class="text-start">Harga Akhir</th>
                                <th width="10%" class="text-start">Stok Awal</th>
                                <th width="10%" class="text-start">Re-Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->restoks as $item)
                                <tr>
                                    <td class="text-start">{{ tanggal($item->created_at, true) }}</td>
                                    <td class="text-start">
                                        Rp. <span
                                            class="float-end">{{ number_format($item->harga_awal, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-start">
                                        Rp. <span
                                            class="float-end">{{ number_format($item->harga_akhir, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-start">
                                        <span class="float-end">{{ number_format($item->stok_awal, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-start">
                                        <span class="float-end">{{ number_format($item->restok, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
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
                ordering: false,
                processing: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
                }
            });
        });
    </script>
@endsection
