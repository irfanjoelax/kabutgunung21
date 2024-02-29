<div class="table-responsive">
    <table class="table table-sm table-hover align-middle">
        <thead class="bg-primary text-white">
            <tr>
                <th class="text-start" width="45%">Nama Produk</th>
                <th class="text-center" width="17%">Harga</th>
                <th class="text-center" width="10%">Qty</th>
                <th class="text-center" width="18%">Total</th>
                @if (isset($_GET['type']) && $_GET['type'] == 'edit' && auth()->user()->level == 'admin')
                    <th class="text-center" width="10%">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $list)
                <tr>
                    <td>
                        <p class="text-start my-0">{{ $list->produk->nama }}</p>
                    </td>
                    <td>
                        Rp.
                        <span class="float-end">
                            {{ number_format($list->hrg_jual) }}
                        </span>
                    </td>
                    <td>
                        <p class="text-center my-0">{{ number_format($list->qty) }}</p>
                    </td>
                    <td>
                        Rp.
                        <span class="float-end">
                            {{ number_format($list->total) }}
                        </span>
                    </td>
                    @if (isset($_GET['type']) && $_GET['type'] == 'edit' && auth()->user()->level == 'admin')
                        <td class="text-center">
                            <button wire:click="deleteItem('{{ $list->id }}')" class="btn btn-sm btn-danger">
                                <div wire:loading wire:target="deleteItem('{{ $list->id }}')">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </div>
                                <div wire:loading.remove wire:target="deleteItem('{{ $list->id }}')">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
