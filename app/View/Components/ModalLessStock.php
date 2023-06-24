<?php

namespace App\View\Components;

use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class ModalLessStock extends Component
{
    public $data;

    public function __construct()
    {
        $this->data = Penjualan::whereMonth('penjualans.created_at', date('n'))
            ->whereHas('penjualan_details', function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('stok', '<=', 3);
                });
            })->with(['penjualan_details' => function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('stok', '<=', 3);
                })->with('produk');
            }])
            ->groupBy(DB::raw('DATE(penjualans.created_at)'))
            ->orderBy(DB::raw('DATE(penjualans.created_at)'), 'DESC')
            ->get();
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
