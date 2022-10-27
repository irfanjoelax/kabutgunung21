<?php

namespace App\Http\Livewire\Penjualan\Detail;

use App\Models\Marketplace;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Livewire\Component;

class SubmitForm extends Component
{
    public $penjualan_id, $no_pesanan, $nama_customer, $marketplace_id, $remark, $fee = 0, $total, $grand_total;

    protected $listeners = [
        'reloadSubmit'  => 'mount'
    ];

    protected $rules = [
        'no_pesanan'     => 'required',
        'nama_customer'  => 'required',
        'marketplace_id' => 'required',
        'fee'            => 'required|numeric',
    ];

    protected $messages = [
        'no_pesanan.required'     => 'No Pesanan harus di isi',
        'nama_customer.required'  => 'Nama Customer harus di isi',
        'marketplace_id.required' => 'Marketplace harus di isi',
        'fee.required'            => 'Fee (biaya penjualan) harus di isi',
        'fee.numeric'             => 'Fee (biaya penjualan) harus angka',
    ];

    public function mount()
    {
        // GET PENJUALAN DETAIL
        $details = PenjualanDetail::where('penjualan_id', $this->penjualan_id)->get();

        $this->total = $details->sum('total');

        // GET DATA PENJUALAN
        $penjualan = Penjualan::find($this->penjualan_id);

        $this->no_pesanan     = $penjualan->no_pesanan;
        $this->nama_customer  = $penjualan->nama_customer;
        $this->marketplace_id = $penjualan->marketplace_id;
        $this->fee            = $penjualan->fee;
        $this->remark         = $penjualan->remark;
        $this->grand_total    = $this->total - $this->fee;
    }

    public function render()
    {
        return view('livewire.penjualan.detail.submit-form', [
            'marketplaces' => Marketplace::latest()->get(),
        ]);
    }

    public function submit()
    {
        $this->validate();

        $penjualan    = Penjualan::find($this->penjualan_id);
        $status_kurir = $penjualan->status_kurir;
        $status_bayar = $penjualan->status_bayar;

        if ($penjualan->status_kurir == null) {
            $status_kurir = 'BELUM TERKIRIM';
        }

        if ($penjualan->status_bayar == null) {
            $status_bayar = 'BELUM TERBAYAR';
        }

        $penjualan->update([
            'no_pesanan'     => $this->no_pesanan,
            'nama_customer'  => $this->nama_customer,
            'marketplace_id' => $this->marketplace_id,
            'status_kurir'   => $status_kurir,
            'total'          => $this->total,
            'fee'            => $this->fee,
            'grand_total'    => $this->grand_total,
            'status_bayar'   => $status_bayar,
            'remark'         => $this->remark,
        ]);

        return redirect()->to('/admin/penjualan');
    }

    public function reloadTotal()
    {
        $penjualan = Penjualan::find($this->penjualan_id);
        $penjualan->update(['fee' => $this->fee]);

        $this->fee         = $penjualan->fee;
        $this->grand_total = $this->total - $this->fee;
    }

    public function cancel()
    {
        // GET PENJUALAN DETAIL
        $details = PenjualanDetail::where('penjualan_id', $this->penjualan_id);

        foreach ($details->get() as $item) {
            Produk::find($item->produk_id)->increment('stok', $item->qty);
        }

        $details->delete();
        Penjualan::find($this->penjualan_id)->delete();

        return redirect()->to('/admin/penjualan');
    }
}
