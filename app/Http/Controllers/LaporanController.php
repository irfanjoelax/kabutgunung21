<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $awal  = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');

        if ($request->awal != null && $request->akhir != null) {
            $awal  = $request->awal;
            $akhir = $request->akhir;
        }

        $data              = array();
        $pendapatan        = 0;
        $total_modal       = 0;
        $total_penjualan   = 0;
        $total_pengeluaran = 0;
        $total_fee         = 0;
        $total_pendapatan  = 0;
        $grand_modal       = 0;
        $grand_penjualan   = 0;
        $grand_fee         = 0;
        $grand_pengeluaran = 0;
        $grand_pendapatan  = 0;

        $grand_belum_bayar = Penjualan::where('created_at', '>=', $awal . " 00:00:00")
            ->where('created_at', '<=', $akhir . " 23:59:59")
            ->where('status_bayar', 'BELUM TERBAYAR')
            ->sum('total');

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal    = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $modal       = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('modal');
            $penjualan   = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('total');
            $fee         = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('fee');
            $pengeluaran = Pengeluaran::where('created_at', 'LIKE', "$tanggal%")->sum('nominal');
            $pendapatan  = $penjualan - ($fee + $pengeluaran + $modal);

            $row = [];
            $row['tanggal'] = $tanggal;
            $row['total_modal'] = $modal;
            $row['total_penjualan'] = $penjualan;
            $row['total_fee'] = $fee;
            $row['total_pengeluaran'] = $pengeluaran;
            $row['total_pendapatan'] = $pendapatan;
            $data[] = $row;

            $total_modal       += $modal;
            $total_penjualan   += $penjualan;
            $total_fee         += $fee;
            $total_pengeluaran += $pengeluaran;
            $total_pendapatan  += $pendapatan;
        }

        $grand_modal       = $total_modal;
        $grand_penjualan   = $total_penjualan;
        $grand_pengeluaran = $total_pengeluaran;
        $grand_fee         = $total_fee;
        $grand_pendapatan  = $total_pendapatan;

        return view('admin.laporan.index', [
            'activeMenu'        => 'laporan',
            'awal'              => $awal,
            'akhir'             => $akhir,
            'data'              => $data,
            'grand_modal'       => $grand_modal,
            'grand_penjualan'   => $grand_penjualan,
            'grand_fee'         => $grand_fee,
            'grand_pengeluaran' => $grand_pengeluaran,
            'grand_pendapatan'  => $grand_pendapatan,
            'grand_belum_bayar' => $grand_belum_bayar,
        ]);
    }
}
