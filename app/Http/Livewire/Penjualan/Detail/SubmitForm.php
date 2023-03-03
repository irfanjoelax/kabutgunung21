<?php

namespace App\Http\Livewire\Penjualan\Detail;

use App\Models\Marketplace;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SubmitForm extends Component
{
    public $penjualan_id, $no_pesanan, $no_invoice, $kurir, $no_resi, $marketplace_id, $remark, $modal, $fee = 0, $total, $grand_total, $type_rules;

    protected $listeners = [
        'reloadSubmit'  => 'mount'
    ];

    protected $messages = [
        'no_pesanan.required'     => 'No Pesanan harus di isi',
        'no_pesanan.unique'       => 'No Pesanan sudah terdaftar pada sistem',
        'kurir.required'          => 'Jasa kurir harus di isi',
        'no_resi.required'        => 'Nomor Resi harus di isi',
        'no_resi.unique'          => 'Nomor Resi sudah terdaftar pada sistem',
        'marketplace_id.required' => 'Marketplace harus di isi',
        'fee.required'            => 'Fee (biaya penjualan) harus di isi',
        'fee.numeric'             => 'Fee (biaya penjualan) harus angka',
    ];

    public function mount(Request $request)
    {
        // GET PENJUALAN DETAIL
        $details = PenjualanDetail::where('penjualan_id', $this->penjualan_id)->get();

        $this->total = $details->sum('total');

        // GET DATA PENJUALAN
        $penjualan = Penjualan::find($this->penjualan_id);

        $this->marketplace_id = $penjualan->marketplace_id;
        $this->kurir          = $penjualan->kurir;
        $this->no_resi        = $penjualan->no_resi;
        $this->modal          = $penjualan->modal;
        $this->fee            = $penjualan->fee;
        $this->remark         = $penjualan->remark;
        $this->grand_total    = $this->total - $this->fee;
        $this->no_pesanan     = $penjualan->no_pesanan;
        $this->type_rules     = $request->type;

        if ($request->type == 'create') $this->no_invoice = $this->noInvoice();
        if ($request->type == 'edit') $this->no_invoice = $penjualan->no_invoice;
    }

    public function rules()
    {
        if ($this->type_rules == 'create') {
            $rules =  [
                'no_pesanan'     => 'required|unique:penjualans,no_pesanan,' . $this->no_pesanan,
                'kurir'          => 'required',
                'no_resi'        => 'required|unique:penjualans,no_resi,' . $this->no_resi,
                'marketplace_id' => 'required',
                'fee'            => 'required|numeric',
            ];
        }

        if ($this->type_rules == 'edit') {
            $rules =  [
                'no_pesanan'     => 'required',
                'kurir'          => 'required',
                'no_resi'        => 'required',
                'marketplace_id' => 'required',
                'fee'            => 'required|numeric',
            ];
        }

        return $rules;
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

        $modal = 0;
        $penjualan    = Penjualan::find($this->penjualan_id);

        foreach ($penjualan->penjualan_details as $item) {
            $modal += $item->produk->harga_beli * $item->qty;
        }

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
            'no_invoice'     => $this->no_invoice,
            'user_id'        => Auth::id(),
            'kurir'          => $this->kurir,
            'no_resi'        => $this->no_resi,
            'marketplace_id' => $this->marketplace_id,
            'status_kurir'   => $status_kurir,
            'modal'          => $modal,
            'total'          => $this->total,
            'fee'            => $this->fee,
            'grand_total'    => $this->total - $this->fee,
            'status_bayar'   => $status_bayar,
            'remark'         => $this->remark,
        ]);

        return redirect()->to('/admin/penjualan');
    }

    public function noInvoice()
    {
        $kodeBarang = Penjualan::whereYear('created_at', date('Y'))->count();

        $kodeBarang++;

        $huruf = "INV";
        $kodeBarang = $huruf . sprintf("%06s", $kodeBarang);

        return $kodeBarang;
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
