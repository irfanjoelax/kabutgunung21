<div class="modal fade" id="notifikasiModal" tabindex="-1" aria-labelledby="notifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-semibold" id="notifikasiModalLabel">
                    Notifikasi Stok Menipis
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($data as $item)
                    <div class="mb-3">
                        <small class="text-muted">
                            {{ tanggal(substr($item->created_at, 0, 10), true) }}
                        </small>
                        <ol class="list-group list-group-flush">
                            @foreach ($item->penjualan_details as $detail)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <p class="text-{{ $detail->produk->stok == 0 ? 'danger' : 'primary' }}">
                                        {{ $detail->produk->nama }}
                                    </p>
                                    <span
                                        class="badge bg-{{ $detail->produk->stok == 0 ? 'danger' : 'primary' }} rounded-pill">
                                        {{ $detail->produk->stok }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
