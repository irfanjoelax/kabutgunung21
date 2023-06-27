<?php

namespace App\Http\Livewire\Penjualan\Detail;

use App\Models\Notifikasi;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Livewire\Component;

class AddForm extends Component
{
    public $penjualan_id, $produk_sku, $stok, $qty, $hrg_jual;

    protected $rules = [
        'produk_sku' => 'required',
        'qty'        => 'required|numeric',
        'hrg_jual'   => 'required|numeric',
    ];

    protected $messages = [
        'produk_sku.required' => 'Harus di isi',
        'qty.required'        => 'Harus di isi',
        'hrg_jual.required'   => 'Harus di isi',
        'qty.numeric'         => 'Harus angka',
        'hrg_jual.numeric'    => 'Harus angka',
    ];

    public function render()
    {
        return view('livewire.penjualan.detail.add-form');
    }

    public function showStok()
    {
        $this->stok = 0;
        if ($this->produk_sku != null) {
            $produk = Produk::where('sku', $this->produk_sku)->first();

            if ($produk) {
                $this->stok = $produk->stok;
            } else {
                $this->stok = 0;
            }
        }
    }

    public function submit()
    {
        $this->validate();

        $produk = Produk::where('sku', $this->produk_sku)->first();

        $detail = PenjualanDetail::where('penjualan_id', $this->penjualan_id)
            ->where('produk_id', $produk->id)
            ->count();

        if ($detail == 1) {
            session()->flash('alert', ucwords('Produk sudah terdapat pada detail penjualan'));
        } else {
            if ($produk->stok < $this->qty) {
                session()->flash('alert', ucwords('stok Produk tidak mencukupi'));
            } else {
                if ($produk->harga_beli >= $this->hrg_jual) {
                    session()->flash('alert', ucwords('harga jual kurang dari atau sama dengan harga modal'));
                } else {
                    PenjualanDetail::create([
                        'penjualan_id' => $this->penjualan_id,
                        'produk_id'    => $produk->id,
                        'hrg_jual'     => $this->hrg_jual,
                        'qty'          => $this->qty,
                        'total'        => $this->hrg_jual * $this->qty,
                    ]);

                    $produk->decrement('stok', $this->qty);

                    if ($produk->stok <= 3) {
                        Notifikasi::updateOrCreate(
                            [
                                'tanggal' => date('Y-m-d'),
                                'produk_id' => $produk->id,
                            ],
                            [
                                'tanggal' => date('Y-m-d'),
                                'produk_id' => $produk->id,
                            ]
                        );
                    }

                    $this->emit('reloadList');
                    $this->emit('reloadSubmit');
                    $this->resetForm();
                }
            }
        }
    }

    public function resetForm()
    {
        $this->reset([
            'produk_sku',
            'stok',
            'qty',
            'hrg_jual',
        ]);
    }
}
