@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-3">
                <h3 class="fw-bold" class="d-flex flex-column">
                    <img class="mb-1"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAABmJLR0QA/wD/AP+gvaeTAAADpklEQVR4nO3az2/TZhgH8MfOGy+JXdOElVZtpk1Kd6pWUvvQRoX+ACGknUFIaDlPopU4TJs2EBc4gZAQh9L9AW1VIf4BVOhCBQNUlpZDJTRlaJqSDYlBWmPHjvPW7w4DhGhTG1koSf18rn5iPfrqffP4FwBCCCGEEEIIIYQQQgghhNDux3kpGhwclCmlGx+7mWZiWVbb2tqa7lZHvJyMUtqdkKl+48Kfkv/Wmt+xc1/oGyGxGwB+d6vlvZyQMaZ+mbQd3521iFS37TiOo3qp9RSgLLLsSFqX/bXVOkbSuizFNrNeal0DVBSl16bc6Fja9e9g1xgf0MG2uXFVVVNuta4BilE2nT1aJtFPArODIRZx4OSRMhGjbMqtdscAh4eUM53tNHN8rOxp2OwmJw6vk71y7eBwRv1pp7pQvQPDQ8qZWNQ5e/V0UWyLBWf1vRHiGQx/pYdvPpQznV1drFh6dne7ui3XgYqi9IpRNt3ZTjMXT5XET/dsfvxum9jz9RD8cK3H+HcjfE83YSKfzxfePc719fVJkUgkyRhT94gsW6XcaPZomRwfK5MwYY3qu6nYlIPri3E6t5CgYeLkNIOb4TjuN8uyipyqqiwhU723p+qMDhjyWFqHIA2MD1GxeMitSrC0KmmFksC/1IjEqarKFq8W3H+Ntjh0utfbrZzbSVqZ38XjO8Cgr15Pt3KoPgzQJwzQJxwiOEQaC7ewTxigTxigTzhEcIg0Fm5hnzBAnzBAn3CI4BBprLeP9FPdtjOS1uXxAR1iEXykvx3D5CG3IsGdx5L29O/Xj/T7+/tFQRCSAKC0RTe/qda4QyePlMmJw+tEIBgkAIBNeZi/Hafzt+JUCLPbryr8LADkbdsubnmtqapqSoyyqURb7cDliZLY0R7015oEvpvqMV5ooaWqTSaXl5efvnu87veBmcGBH8UIO/fz93/Fghri83UC3176rGLa3PlfH6xc3K6m7pcJxdKzu51dXezBmjT0dUYTQgG74LEpD5NXksaGwV+oFx7ADgEC/B9ix77kKHDw+f6UGagIZxcSdPlJ9Jd791dO7VTnGopuwsTcQpxWrODkZ5g8zN+K06pNJt1qXVPJ5/MFgbBcbjUQX/cCAEBuRQIh7Cy+PzC242lZaQY3s7Qqaf5baw13Hkvaq0poxkutpwB5nn9UKAmB2cN/lASeUvrIS62nWznTNEuMRaRWv+/9AFKtZv3T6CYQQgghhBBCCCGEEEIIIYSaxX/jr0626z6TcgAAAABJRU5ErkJggg==">
                    <p class="text-black-50">Form Data Kategori</p>
                </h3>
            </div>
            <div class="col-md-9 mb-3">
                @if ($errors->any())
                    <div class="alert alert-warning mb-3" role="alert">
                        <ul class="my-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ $url }}" class="bg-white p-3 shadow-sm rounded" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <label for="name" class="col-sm-3 col-form-label">Nama Kategori</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama kategori"
                                value="{{ $isEdit ? $data->name : old('name') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 offset-sm-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? 'Ubah' : 'Simpan' }} Data
                            </button>
                            <a href="{{ url('admin/kategori') }}" class="btn btn-warning">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
