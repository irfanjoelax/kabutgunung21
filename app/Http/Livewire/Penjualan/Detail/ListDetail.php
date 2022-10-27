<?php

namespace App\Http\Livewire\Penjualan\Detail;

use App\Models\PenjualanDetail;
use App\Models\Produk;
use Livewire\Component;

class ListDetail extends Component
{
    public $penjualan_id, $hrg_jual;

    protected $listeners = [
        'reloadList'  => 'render'
    ];

    public function render()
    {
        $details = PenjualanDetail::with('produk')->where('penjualan_id', $this->penjualan_id)->latest()->get();

        return view('livewire.penjualan.detail.list-detail', [
            'details' => $details,
        ]);
    }

    public function deleteItem($id_detail)
    {
        $detail = PenjualanDetail::find($id_detail);

        Produk::find($detail->produk_id)->increment('stok', $detail->qty);

        $detail->delete();
        $this->emit('reloadSubmit');
        $this->emit('reloadAdd');
    }
}
