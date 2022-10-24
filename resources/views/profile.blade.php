@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h3 class="fw-bold" class="d-flex flex-column">
                    <img class="mb-3"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAABmJLR0QA/wD/AP+gvaeTAAAEa0lEQVR4nO2cXWxaZRjH/xwObFDoekqBdUArZWhTzNrFzG6N3ixR1y2Z7sZ4ZZa4G++t0cVLG026SxNvNOm8NCZNE9dNTLxwkax+ZF0NkY2uwArWinysxXXrCnhvy8fhOec9fLy/y/Lw8OSX857zfzn0AByOlugqvfDBzBdlloNoxadTlyo6qAex2ovvXnyT0rvp+Xz2a3IPQYE5OhoukAgXSIQLJFL1IrIfSpx4m4lKaaPeq7NsgQDwyXvvNPK2luHDK1/WXcuXMBEukAgXSIQLJMIFEuECiTQUY5SgVHyKVGQB6ytBFHJJAIBF8qDf/wpcw+cgCJqNJgtNpnzybwa3b1yGuUuEf8SHbukEAGAzl8WDlSBSkes4fmYaB8w2LcaTBfMlXCo+xe0bl3HE48Sx8VOQ+hzQ60Xo9SKkPgdGT55Cv9uOpe8+Qqm0y3o82TAXmIxcg7lLxID/2Yo1g/7ncNCkQyqywHCyxmAu8K/o9/D4fDXrBoaOYj0aZDARDeYCCw9T6JZ6a9Z1SxIK+SSDiWhoE2PKtW+3lAHoKt+yaRqYX4UtPS5s5nOQ+hxV67ZyWXT1uGv2C4Vjsj5/IuCVVV8L5gL7/a/iwUqwpsDE/fvo90/W7Ke0ELkwX8Ku4XPY3i4iEb1bsSZ+L4InjwH3cG2BWsNcoCCIOH5mGuvJNO4shpBLb6BY3EWxuItcegNLt0LY+DOLsdc+hq4FdiOaTHjAbMOLb3yGVGQB0T+CKORvAgCs0gAOH52Ee3iyJeQBGu6FBUGEZ+Q8PCPntRpBEfi3MUQ0OQKLpTLCsSyWVzNIpgvYfLQDHQCr2Qi33YJjQzYEvL3QCzwH7iEcy2I+FIfxoBGHXXaMej0wmYwAgO3HO8ikNxFcWse3txJ4feIZBLzVdy0dkwPLZWBhMYFf76Ux+oIftr5De2osFhMsFhMGvU5k0g/xzc0o4htbODs+CF2Fg7FjcuC1xQSWE3m8fHpsX3n/x2Y/hJdOj+H3RB7Xf04wmLAxmAgMx7L4LfoPxicCMBjqP+iNBhEnJkbwy900wvGsihM2juoCi6Uy5kNxPD/qg8Eo/4xhNBoQGPNh/qc4iqXm+82n6gLDsSwEgwiHs6fhHk6nBEHUIxxrvqNQdYHLqxm4PHZynyMeB5ZjGQUmUhbVBa6lC+jptZL7SDYr1v4uKDCRsqgeYwqPdvDjD3cU6WU06Pf8re1z4PSlk6r275gc2K5wgUS4QCJcIBEukAgXuA9vv3Wh7lrVY4zcnEaFdaxRXaBWOe3K+1+R3j8zdbWuby5a49ZXg1y4uP9S9AxZsba6Re4/NzvHz4FUuEAiXCARLpAIF0iE50AibZsDWcGXMJG2DtJzs3Oqf0ZbC+Q7kRaACyTCBRLhOZAIz4FE+BImwgUS4QKJcIFE2nonwrdyRFhs5aoKbLdH3alBRYGVnp/XKU/3rRd+ESHCBRLhAolwgUQaijFynjHKGjk/TVOC5v+H3AaZmbpa1jwHtjosdiL/AWKtNuJ7bVZVAAAAAElFTkSuQmCC">
                    <p class="text-black-50">Pengaturan Profile</p>
                </h3>
            </div>
            <div class="col-md-8 mb-3">
                <form action="{{ url('admin/profile', []) }}" class="bg-white p-3 shadow-sm rounded" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <label for="name" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}"
                                required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}"
                                required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" placeholder="*****">
                            <small class="text-danger">
                                Kosongkan jika tidak ingin mengubah password Anda.
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 offset-sm-3 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Profile</button>
                            <a href="{{ url('admin/dashboard') }}" class="btn btn-warning">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
