@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{ url('admin/user/create') }}" class="btn btn-primary mb-3">
                    <i class="fa-solid fa-plus"></i>
                    <span class="ms-1">Tambah</span>
                </a>
                <div class="bg-white p-3 rounded-4 shadow-sm table-responsive">
                    <table class="table table-bordered datatable align-middle">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="10%" class="text-center">No</th>
                                <th width="30%" class="text-start">Fullname</th>
                                <th width="25%" class="text-center">Username</th>
                                <th width="15%" class="text-center">Level</th>
                                <th width="20%" class="text-center">Action</th>
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
                    url: "{{ url('admin/user') }}",
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
