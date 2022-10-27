<?php

namespace App\Http\Livewire\Penjualan\Detail;

use App\Models\PenjualanDetail;
use App\Models\Produk;
use Livewire\Component;

class AddForm extends Component
{
    public $penjualan_id, $produk_id, $qty, $hrg_jual, $produks;

    protected $listeners = [
        'reloadAdd'  => 'mount'
    ];

    protected $rules = [
        'produk_id' => 'required',
        'qty'       => 'required|numeric',
        'hrg_jual'  => 'required|numeric',
    ];

    protected $messages = [
        'produk_id.required' => 'Harus di isi',
        'qty.required'       => 'Harus di isi',
        'hrg_jual.required'  => 'Harus di isi',
        'qty.numeric'        => 'Harus angka',
        'hrg_jual.numeric'   => 'Harus angka',
    ];

    public function mount()
    {
        $this->produks = Produk::where('stok', '>', 0)->latest()->get();
    }

    public function render()
    {
        return view('livewire.penjualan.detail.add-form');
    }

    public function submit()
    {
        $this->validate();

        $detail = PenjualanDetail::where('penjualan_id', $this->penjualan_id)
            ->where('produk_id', $this->produk_id)
            ->count();

        if ($detail == 1) {
            session()->flash('alert', ucwords('Produk sudah terdapat pada detail penjualan'));
        } else {
            $produk = Produk::find($this->produk_id);

            if ($produk->stok < $this->qty) {
                session()->flash('alert', ucwords('stok Produk tidak mencukupi'));
            } else {
                PenjualanDetail::create([
                    'penjualan_id' => $this->penjualan_id,
                    'produk_id'    => $this->produk_id,
                    'hrg_jual'     => $this->hrg_jual,
                    'qty'          => $this->qty,
                    'total'        => $this->hrg_jual * $this->qty,
                ]);

                $produk->decrement('stok', $this->qty);

                $this->emit('reloadList');
                $this->emit('reloadSubmit');
                $this->emitSelf('reloadAdd');
                $this->resetForm();
            }
        }
    }

    public function resetForm()
    {
        $this->reset([
            'produk_id',
            'qty',
            'hrg_jual',
        ]);
    }
}
