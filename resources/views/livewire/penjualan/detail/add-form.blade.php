<div>
    @if (session('alert'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fa-solid fa-triangle-exclamation"></i></strong> {{ session('alert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form class="row g-3 align-items-center" wire:submit.prevent="submit">
        <div class="col-md-6 mb-3">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                    Produk
                </div>
                <select wire:model="produk_id" class="form-select @error('produk_id') is-invalid @enderror">
                    <option value="" selected>-- Pilih Nama Produk --</option>
                    @foreach ($produks as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            @error('produk_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-2 mb-3">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                    Qty
                </div>
                <input class="form-control @error('qty') is-invalid @enderror text-end" type="text" wire:model="qty"
                    placeholder="0">
            </div>
            @error('qty')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-3 mb-3">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                    Harga Jual
                </div>
                <input class="form-control @error('hrg_jual') is-invalid @enderror text-end" type="text"
                    wire:model="hrg_jual" placeholder="0">
            </div>
            @error('hrg_jual')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-1 mb-3">
            <button type="submit" class="btn btn-sm btn-primary">
                <div wire:loading wire:target="submit">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </div>
                <div wire:loading.remove wire:target="submit">
                    <i class="fa fa-plus"></i>
                </div>
            </button>
        </div>
    </form>

</div>
