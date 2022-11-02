<div class="card">
    <div class="card-body">
        <p class="mb-2 text-start display-6 fw-semibold">
            Rp. <span class="float-end">{{ number_format($grand_total) }}</span>
        </p>
        <hr>
        <form class="row g-3" wire:submit.prevent="submit">
            <div class="col-md-12">
                <label class="form-label">No. Pesanan</label>
                <input type="text" class="form-control" wire:model="no_pesanan">
                @error('no_pesanan')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">Market Place</label>
                <select wire:model="marketplace_id" class="form-select">
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
                <input type="text" class="form-control" wire:model="kurir" placeholder="JNE / J&T / TIKI ...">
                @error('kurir')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">No. Resi</label>
                <input type="text" class="form-control" wire:model="no_resi">
                @error('no_resi')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label class="form-label">Catatan (Remark)</label>
                <textarea class="form-control" rows="2" wire:model="remark"></textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label">Fee (Biaya) Penjualan</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp.</span>
                    {{-- <input type="text" class="form-control" wire:model.lazy="fee" wire:keydown="reloadTotal"> --}}
                    <input type="text" class="form-control" wire:model="fee">
                </div>
                @error('fee')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled">
                            <div wire:loading wire:target="submit">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </div>
                            <div wire:loading.remove wire:target="submit">
                                <i class="fa fa-check"></i> Simpan
                            </div>
                        </button>
                    </div>
                    <div class="col-md-6 mb-2">
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
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
