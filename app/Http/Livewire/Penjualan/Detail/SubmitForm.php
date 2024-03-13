<?php

namespace App\Http\Livewire\Penjualan\Detail;

use App\Models\Marketplace;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Livewire\Component;

class SubmitForm extends Component
{
    public $penjualan_id, $no_pesanan, $no_invoice, $kurir, $no_resi, $marketplace_id, $remark, $modal, $fee = 0, $total, $grand_total, $type_rules, $kurirs = [];

    # STATE HANDLE EDIT SUBMIT FORM
    public $inputNoInvoice = true, $inputNoPesanan = true, $inputMarketplace = true, $inputJasaKurir = true, $inputNoResi = true, $inputCatatan = true, $inputFee = true;

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
        $this->no_invoice     = $penjualan->no_invoice;

        if ($request->type === 'create') {
            $this->type_rules = [
                'no_pesanan'     => 'required|unique:penjualans,no_pesanan',
                'kurir'          => 'required',
                'no_resi'        => 'required|unique:penjualans,no_resi',
                'marketplace_id' => 'required',
                'fee'            => 'required|numeric',
            ];
        }

        if ($request->type === 'edit') {
            $this->type_rules = [
                'no_pesanan'     => 'required',
                'kurir'          => 'required',
                'no_resi'        => 'required',
                'marketplace_id' => 'required',
                'fee'            => 'required|numeric',
            ];

            if ($this->marketplace_id != null) {
                $marketplace  = Marketplace::with('kurirs')->find($this->marketplace_id);
                $this->kurirs = $marketplace->kurirs;
            } else {
                $this->kurirs = [];
            }

            if (auth()->user()->level != 'owner') {
                $this->inputNoInvoice = false;
                $this->inputNoPesanan = false;
                $this->inputMarketplace = false;
                $this->inputJasaKurir = false;
                $this->inputNoResi = false;
                $this->inputFee = false;
            }

            if (auth()->user()->level == 'admin') {
                $this->inputCatatan = true;
            }

            if (auth()->user()->level == 'owner') {
                $this->inputCatatan = true;
                $this->inputFee = true;
            }
        }

        // dd($this);
    }

    public function rules()
    {
        return $this->type_rules;
    }

    public function render()
    {
        return view('livewire.penjualan.detail.submit-form', [
            'marketplaces' => Marketplace::latest()->get(),
        ]);
    }

    public function loadKurir()
    {
        $marketplace = Marketplace::with('kurirs')->find($this->marketplace_id);
        $this->kurirs = $marketplace->kurirs;
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
