<div class="card">
    <div class="card-body">
        <p class="display-6 fw-semibold mb-2 text-start">
            Rp. <span class="float-end">{{ number_format($grand_total) }}</span>
        </p>
        <hr>
        <form class="row g-3" wire:submit.prevent="submit">
            <div class="col-md-12">
                <label class="form-label">No. Invoice</label>
                <input type="text" class="form-control" wire:model="no_invoice" readonly>
                @error('no_invoice')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">No. Pesanan</label>
                <input type="text" class="form-control" wire:model="no_pesanan"
                    {{ $inputNoPesanan ? '' : 'readonly' }}>
                @error('no_pesanan')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">Market Place</label>
                <select wire:model="marketplace_id" wire:change="loadKurir" class="form-select"
                    {{ $inputMarketplace ? '' : 'disabled' }}>
                    <option value="" selected>-- Pilih Nama Market Place --</option>
                    @foreach ($marketplaces as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('marketplace_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">Jasa Kurir</label>
                <select wire:model="kurir" class="form-select" {{ $inputJasaKurir ? '' : 'disabled' }}>
                    <option value="" selected>-- Pilih Jasa Kurir --</option>
                    @foreach ($kurirs as $kurir)
                        <option value="{{ $kurir->name }}">{{ $kurir->name }}</option>
                    @endforeach
                </select>
                @error('kurir')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">No. Resi</label>
                <input type="text" class="form-control" wire:model="no_resi" {{ $inputNoResi ? '' : 'readonly' }}>
                @error('no_resi')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">Catatan (Remark)</label>
                <textarea class="form-control" rows="2" wire:model="remark" {{ $inputCatatan ? '' : 'readonly' }}></textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label">Fee (Biaya) Penjualan</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" class="form-control" wire:model="fee" {{ $inputFee ? '' : 'readonly' }}>
                </div>
                @error('fee')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled">
                        <div wire:loading wire:target="submit">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </div>
                        <div wire:loading.remove wire:target="submit">
                            <i class="fa fa-check"></i> Simpan
                        </div>
                    </button>
                    {{-- @if (in_array(Auth::user()->level, ['keuangan', 'owner'])) --}}
                    @if (in_array(Auth::user()->level, ['owner']))
                        <button type="button"
                            onclick="return confirm(`Apakah yakin ingin membatalkan dan menghapus penjualan ini?`) || event.stopImmediatePropagation()"
                            wire:click="cancel" class="btn btn-warning w-100">
                            <div wire:loading wire:target="cancel">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </div>
                            <div wire:loading.remove wire:target="cancel">
                                <i class="fa fa-times"></i> Batalkan
                            </div>
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
