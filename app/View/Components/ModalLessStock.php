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
        $this->data = Notifikasi::whereMonth('tanggal', date('n'))
            ->with(['produk' => function ($query) {
                $query->where('stok', '<=', 10);
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
    }
}
