@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <form class="row row-cols-lg-auto g-3 align-items-center">
                    <div class="col-12">
                        <div class="input-group">
                            <div class="input-group-text">Tanggal</div>
                            <input type="date" class="form-control" name="tanggal" value="{{ $_GET['tanggal'] }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <div class="input-group-text">Pilih User</div>
                            <select class="form-select" name="user">
                                <option value="">Pilih</option>
                                @foreach ($users as $user)
                                <option value="{{$user->id}}" {{ ($_GET['user'] ?? '' == $user->id) ? 'selected' : '' }} >{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>

            <div class="col-md-12">
                <div class="bg-white p-3 rounded shadow-sm table-responsive">
                    <table class="table table-bordered datatable align-middle">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="5%" class="text-center">No.</th>
                                <th width="20%" class="text-center">User</th>
                                <th width="60%" class="text-start">Histori</th>
                                <th width="15%" class="text-center">Diakses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $history)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $history->user->name }}</td>
                                <td>{{ $history->histori }}</td>
                                <td class="text-center">{{ $history->created_at }}</td>
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
                processing: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
                }
            });
        });
    </script>
@endsection
