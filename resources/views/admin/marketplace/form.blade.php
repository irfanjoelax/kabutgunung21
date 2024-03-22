@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h3 class="fw-bold" class="d-flex flex-column">
                    <img class="mb-3"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAABmJLR0QA/wD/AP+gvaeTAAAFMElEQVR4nO2aS2xUVRiAv3PuPDozLSktL1uwwoCRiqKpNCYmUmICceNO49oEdY0sVBQLYtyALtxp4sKNCzcYEzUkmmqM0SoVNhAIbRXaDraUoY95zz3HRWdKH3M7LactHed8m5m55/7nnPnmv/ee+e8Fi+V+IhZqHDwW3SYc/TFwEKhbnSmtGSbQ/KC1frP5VP8Vr508BRbkXQAaVmR6lUNcu2Jv8we9N0o1+ryiCpnX4GzIEmxNIGrUis1wLaLTksylCO6twHrhcAZ4qdR+coE+DgJVKQ9A1CiCrYnCJ33Ia7+FBNYVO6pWZnz3dV77LCTQsgisQEOsQENKXoU1iFjhfeJc4ypOZ+2iQQjQc7eXzMCh4zteXvkpVRZeTuYtpPWrbf7YlvhlIBp6Jo6MVO9VGEAlJalf1gP0J+Jy965PrmVmts/LwKEtd14Hor6N2aqXByDDCt+mHMD2cL17eG77rAwc7ny0Nq9S14DNoY7byMC8Q74qURlJ6qf1ACNBKXc2dl4bL7bNysCcSh0FNvua01beDGRQ4d+WBtiYVurIzLbpDIy9tXOj9qteoC78XBzh2MN3Fq4g8WMDaCZ9Uu3a1Pn3TZiRgcqv3gPqgruSVl4pHE0gmgKodbVzrLhZAtx8p2W7gMNIcFpS92uKax7fQymQCq31azc6ozuhIFBL+SEQqGlNIOx/E0+E1NTsTgH4fVq/DyAG3t2+VwrRI3xKhg/Ey9SoLVpDsqsRcmi02Ccl4jQgg49PWnmLQAgIPTYBIECdFkPHd9j1igH2jGfIdDUmcnD0fs6j4ihWqWwGGmIFGmIFGuJ5X7gc7kiA7OUImqlbn86GbFXFF5EUy9RLXMxkLkdQaTl9A3qpVHT8XVdagr4NoPNLOJrzYmpg7ZDRDjotwV3CKrzC42e4GpUCrgKoscUfze7k1L5jbohxtwYANelUTfwMV1ckWnwPkBsMLrqDfCwAQG+mgd5Mw6xt1RB/15X+TjqO+hRIu/8GcEf9ZYPVhI/8QBCFoCfVTE+qGYUgNxBCTZT/FSs93h314w4HAJJSys9kobJ6EiBzsQ73jvehrCZ8pHvWgRb8kdzKSD7CcL6WP5NbQUH6r3ULTqLS4924j/TFOtCgtTixpbN32AE4fSD+a0LXP6KV2JMfqkFnJMIPIqARSuCO+8n1h8heikBe0Jdp4OzYHnShfNOXbeTBwBj1Ok1+MAg5CT6Qfg26suM1AjXmJ9cXJnslAkoAfNnk9B090YWevvToF3FirdGTrtJvOx4XJMXUL3du/GHcObUvR2gO1V3lqfAA0mNNVOnxrgZH6lMPXOrvFF/hQokK4AvPPqGfb8nw9LYAG5xJXCR33BC92UZ6kk2M5BdeM23yJXgyNEg0eJt6Z+r2QCXHOyhuubX8diPHt/8E+ObnC7OczRPY1tamC68LDlRtnD9/vvg6y5n9L2yIFWiIFWjIPVdjiueE5aLcOXe5x1vq+F7YDDTknjOwyCtH3jCK//yjM6s6nun4c7EZaIgVaIgVaIgVaIgVaIgVaIgVaIgVaIgVaIgVaIgVaIgVaIgVaIhxNca0mrEatDQ10dHejkbT1d3N9aFY+aBFUhUZuL99H5FwiNpwmI729mXt+54z0N61m6IqMrCru5vJZJLJZJKu37uXtW/jc2AlcH0oxhdnv16RvqsiA1cSK9AQK9AQK9AQK9AQz6vw3v0dqzmPsqz0kwnlvq/X+DYDDbECDbECDbECDbECDbECDbECDfF8St9SGvuUvsXyv+I/mEIOCboQ9eUAAAAASUVORK5CYII=">
                    <p class="text-black-50">Form Data Marketplace</p>
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
                        <label for="name" class="col-sm-3 col-form-label">Nama Marketplace</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name"
                                placeholder="Masukkan nama marketplace" value="{{ $isEdit ? $data->name : old('name') }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="name" class="col-sm-3 col-form-label">Kurir</label>
                        <div class="col-sm-6 inputKurir">
                            @if ($isEdit)
                                @foreach ($data->kurirs as $kurir)
                                    <input type="text" class="form-control mb-4" name="kurirs[]"
                                        placeholder="Masukkan nama kurir" value="{{ $kurir->name }}">
                                @endforeach
                            @else
                                <input type="text" class="form-control mb-4" name="kurirs[]"
                                    placeholder="Masukkan nama kurir">
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-secondary w-100" type="button" id="addKurir">
                                + Tambah Kurir
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? 'Ubah' : 'Simpan' }} Data
                            </button>
                            <a href="{{ url('admin/marketplace') }}" class="btn btn-warning">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('addKurir').addEventListener('click', function() {
            var inputGroup = document.querySelector('.inputKurir');

            var newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.name = 'kurirs[]';
            newInput.className = 'form-control mb-4';
            newInput.placeholder = 'Masukkan nama kurir';

            inputGroup.appendChild(newInput);
        });
    </script>
@endsection
