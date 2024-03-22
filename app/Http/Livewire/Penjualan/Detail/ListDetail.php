<?php

namespace App\Http\Livewire\Penjualan\Detail;

use App\Models\PenjualanDetail;
use App\Models\Produk;
use Livewire\Component;

class ListDetail extends Component
{
    public $penjualan_id, $hrg_jual, $editState;
    public $hargaJual, $qty;

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

    public function editDetail($id_detail)
    {
        $detail = PenjualanDetail::find($id_detail);

        $this->editState = $id_detail;
        $this->hargaJual = $detail->hrg_jual;
        $this->qty       = $detail->qty;
    }

    public function changeHargaJual($id_detail)
    {
        $detail = PenjualanDetail::find($id_detail);

        $detail->update([
            'hrg_jual' => $this->hargaJual,
            'qty'      => $detail->qty,
            'total'    => $this->hargaJual * $detail->qty
        ]);

        $this->emit('reloadSubmit');
        $this->emit('reloadAdd');

        $this->reset('editState');
    }

    public function changeQty($id_detail)
    {
        $detail = PenjualanDetail::find($id_detail);

        // Update Increment Stok Product
        Produk::find($detail->produk_id)->increment('stok', $detail->qty);

        $detail->update([
            'qty'   => $this->qty,
            'total' => $detail->hrg_jual * $this->qty
        ]);

        // Update Decrement Stok Product
        Produk::find($detail->produk_id)->decrement('stok', $this->qty);

        $this->emit('reloadSubmit');
        $this->emit('reloadAdd');

        $this->reset('editState');
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
