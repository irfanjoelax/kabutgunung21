@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <h3 class="fw-bold" class="d-flex flex-column">
                    <img class="mb-3"
                        src="data:image/png;base64,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">
                    <p class="text-black-50">Form Data User</p>
                </h3>
            </div>
            <div class="col-md-8 mb-3">
                @if ($errors->any())
                    <div class="alert alert-warning mb-3" role="alert">
                        <ul class="my-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    function is_checked($key, $value)
                    {
                        if ($key == $value) {
                            return 'checked';
                        }
                    }
                @endphp
                <form action="{{ $url }}" class="bg-white p-4 shadow-sm rounded-4" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <label for="name" class="col-sm-3 col-form-label">Full Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Full Name"
                                value="{{ $isEdit ? $data->name : old('name') }}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="username" placeholder="Masukkan Username"
                                value="{{ $isEdit ? $data->username : old('username') }}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="username" class="col-sm-3 col-form-label">Level</label>
                        <div class="col-sm-9 align-self-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="level" id="admin" value="admin"
                                    required {{ $isEdit ? is_checked('admin', $data->level) : '' }}>
                                <label class="form-check-label" for="admin">Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="level" id="owner" value="owner"
                                    required {{ $isEdit ? is_checked('owner', $data->level) : '' }}>
                                <label class="form-check-label" for="owner">Owner</label>
                            </div>
                        </div>
                    </div>
                    @if (!$isEdit)
                        <div class="row mb-4">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control-plaintext" id="password"
                                    value="Password Untuk User Baru Adalah 123456">
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-9 offset-sm-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? 'Ubah' : 'Simpan' }} Data
                            </button>
                            <a href="{{ url('admin/user') }}" class="btn btn-warning">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
