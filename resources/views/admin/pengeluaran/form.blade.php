@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h3 class="fw-bold" class="d-flex flex-column">
                    <img class="mb-2"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAABmJLR0QA/wD/AP+gvaeTAAACjklEQVR4nO3bv2sTcRjH8fflx1mIpkcmQW7LUKKQQhZnZ3fBgptIJyf/CZ1cXQSxg7uu7g4HDVWnQKcbaimYS4UTco1Dc8e1Vkl46OWu/byWfLkf3MOH535x+YKIiIiIiIiIiBTHOb+g2+3eWF9ffwY8Bu4BrcKrKpdfwFdgZzwevxmNRr/zK88E2O/37zQajU9Av8ACq2R3Op0+HA6HYbogC3DeeV+Avuu6+L5Pu92mVqutpNKyODk5IYoiwjAkjmOA3fF4fD/txCyd+Wnbd12XXq+H53nXPjyAWq2G53lsbGzQbDYBNj3Pe5qtz227BeD7PvV6veAyy69er+P7PgCz2WwrXZ4PsAfQbreLraxCctncTQf5AG8COm3/I3dm3koHSsuoseoCznv15MOqSwDgxbtHC22nDjRSgEYK0Gjha2AQBKYDDQYD0/5lpQ40Wvou/Pn1aKntHzzvLnuISlEHGilAIwVoVLo3kUXfAMpCHWikAI0UoNHS18Cr/ly3LHWg0cIdeFXfZa3UgUYK0EgBGilAIwVotPBdeNmvZeffaau+/7+oA40UoJECNMr+HzgYDGbz39VVUwHp18kgCBxQB5opQCMFaHRpz4GXrSzfTtSBRgrQSAEaLXwNLMs1p2zUgUYK0EgBGuUDPIbTuWFysSRJ0uEkHeQD/A4QRVGBJVXLZJLl9i0d5AN8DxCGYT5pmUuShDA8neXqOM5Oujybu9RqtYZra2sPp9Pp7aOjI1zXxXXdaz/1K0kSoihif38/m+4ax/H24eFhAhdPuP4IbK6g1ir4a8L1mXmtBwcHk06n87bZbP4AOoAHuAUXWTbHjuMEjuO8jON4e29v7+eqCxIRERERERERub7+ACz0ow4P3pBHAAAAAElFTkSuQmCC">
                    <p class="text-black-50">Form Data Pengeluaran</p>
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
                <form action="{{ $url }}" class="bg-white p-3 shadow-sm rounded" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <label for="detail" class="col-sm-3 col-form-label">Detail Pengeluaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="detail"
                                placeholder="Masukkan detail pengeluaran"
                                value="{{ $isEdit ? $data->detail : old('detail') }}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="date" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="date"
                                value="{{ $isEdit ? $data->date : old('date') }}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="nominal" class="col-sm-3 col-form-label">Nominal</label>
                        <div class="col-sm-5">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp. </span>
                                <input type="number" class="form-control text-end" name="nominal" placeholder="0"
                                    value="{{ $isEdit ? $data->nominal : old('nominal') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 offset-sm-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? 'Ubah' : 'Simpan' }} Data
                            </button>
                            <a href="{{ url('admin/pengeluaran') }}" class="btn btn-warning">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
