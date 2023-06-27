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
                @foreach ($data as $tanggal => $item)
                    <div class="mb-3">
                        <small class="text-muted">
                            {{ tanggal(substr($tanggal, 0, 10), true) }}
                        </small>
                        <ol class="list-group list-group-flush">
                            @foreach ($item as $detail)
                                @if ($detail->produk)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <p class="text-{{ $detail->produk->stok == 0 ? 'danger' : 'primary' }}">
                                            {{ $detail->produk->nama }}
                                        </p>
                                        <span
                                            class="badge bg-{{ $detail->produk->stok == 0 ? 'danger' : 'primary' }} rounded-pill">
                                            {{ $detail->produk->stok }}
                                        </span>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                @endforeach
                {{-- @foreach ($data as $item => $notifikasi)
                    <div class="mb-3">
                        <small class="text-muted">
                            {{ tanggal(substr($item, 0, 10), true) }}
                        </small>
                        <ol class="list-group list-group-flush">
                            @foreach ($notifikasi as $detail)
                                @foreach ($detail->penjualan_details as $produk)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <p class="text-{{ $produk->produk->stok == 0 ? 'danger' : 'primary' }}">
                                            {{ $produk->produk->nama }}
                                        </p>
                                        <span
                                            class="badge bg-{{ $produk->produk->stok == 0 ? 'danger' : 'primary' }} rounded-pill">
                                            {{ $produk->produk->stok }}
                                        </span>
                                    </li>
                                @endforeach
                            @endforeach
                        </ol>
                    </div>
                @endforeach --}}
            </div>
        </div>
    </div>
</div>
