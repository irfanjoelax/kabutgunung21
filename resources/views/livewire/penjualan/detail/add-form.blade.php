<div>
    @if (session('alert'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong class="me-2"><i class="fa-solid fa-triangle-exclamation"></i></strong> {{ session('alert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (isset($_GET['type']))
        @if ($_GET['type'] == 'create' || ($_GET['type'] == 'edit' && auth()->user()->level == 'owner'))
            <form class="row g-3 align-items-center" wire:submit.prevent="submit">
                <div class="col-md-5 mb-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-text">
                            Produk
                        </div>
                        <input class="form-control @error('produk_sku') is-invalid @enderror" type="text"
                            wire:model="produk_sku" placeholder="Masukkan SKU Produk" wire:keydown="showStok">
                    </div>
                    @error('produk_sku')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-1 mb-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-text">
                            <div wire:loading wire:target="showStok">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </div>
                            <div wire:loading.remove wire:target="showStok">
                                Stok
                            </div>
                        </div>
                        <input class="form-control text-end readonly" type="text" wire:model="stok" readonly>
                    </div>
                </div>
                <div class="col-md-1 mb-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-text">
                            Qty
                        </div>
                        <input class="form-control @error('qty') is-invalid @enderror text-end" type="text"
                            wire:model="qty" placeholder="0">
                    </div>
                    @error('qty')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
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
        @endif
    @endif
</div>
