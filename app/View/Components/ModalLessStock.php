<?php

namespace App\View\Components;

use App\Models\Notifikasi;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class ModalLessStock extends Component
{
    public $data;

    public function __construct()
    {
        // $this->data = Penjualan::whereMonth('penjualans.created_at', date('n'))
        //     ->whereHas('penjualan_details', function ($query) {
        //         $query->whereHas('produk', function ($query) {
        //             $query->where('stok', '<=', 3)->groupBy('id');
        //         });
        //     })->with(['penjualan_details' => function ($query) {
        //         $query->whereHas('produk', function ($query) {
        //             $query->where('stok', '<=', 3);
        //         })->with('produk');
        //     }])
        //     ->orderBy(DB::raw('DATE(penjualans.created_at)'), 'DESC')
        //     ->get()
        //     // ->groupBy(DB::raw('DATE(penjualans.created_at)'))
        //     ->groupBy(function ($item) {
        //         return $item->created_at->format('Y-m-d');
        //     });

        // $this->data = Notifikasi::whereMonth('notifikasis.tanggal', date('n'))
        //     ->groupBy(DB::raw('DATE(notifikasis.tanggal)'))
        //     ->with(['produk' => function ($query) {
        //         $query->where('stok', '<=', 3);
        //     }])
        //     ->orderBy(DB::raw('DATE(notifikasis.tanggal)'), 'DESC')
        //     ->get();

        $this->data = Notifikasi::whereMonth('tanggal', date('n'))
            ->with(['produk' => function ($query) {
                $query->where('stok', '<=', 3);
            }])
            ->orderBy('tanggal', 'DESC')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal->format('Y-m-d');
            });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-less-stock', [
            'data' => $this->data
        ]);

        // dd($this->data);
        // foreach ($this->data as $item => $notifikasi) {
        //     echo $item . '<br>';
        //     echo '<ul>';

        //     foreach ($notifikasi as $detail) {
        //         foreach ($detail->penjualan_details as $produk) {
        //             echo '<li>' . $produk->produk->nama . ' - ' . $produk->produk->stok . '</li>';
        //         }
        //     }

        //     echo '</ul>';
        // }
    }
}
