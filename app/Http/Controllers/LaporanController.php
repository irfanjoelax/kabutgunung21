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
        $total_penjualan   = 0;
        $total_pengeluaran = 0;
        $total_pendapatan  = 0;
        $grand_penjualan   = 0;
        $grand_pengeluaran = 0;
        $grand_pendapatan  = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal    = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $penjualan   = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('total');
            $pengeluaran = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('fee');
            $pendapatan = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('grand_total');
            // $total_penjualan   = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('grand_total');
            // $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "$tanggal%")->sum('nominal');

            // $pendapatan        = $total_penjualan - $total_pengeluaran;
            // $total_pendapatan += $pendapatan;

            $total_penjualan   += $penjualan;
            $total_pengeluaran += $pengeluaran;
            $total_pendapatan  += $pendapatan;

            $row = [];
            $row['tanggal'] = $tanggal;
            $row['total_penjualan'] = $penjualan;
            $row['total_pengeluaran'] = $pengeluaran;
            $row['total_pendapatan'] = $pendapatan;
            $data[] = $row;
        }

        $grand_penjualan = $total_penjualan;
        $grand_pengeluaran = $total_pengeluaran;
        $grand_pendapatan = $total_pendapatan;

        return view('admin.laporan.index', [
            'activeMenu'        => 'laporan',
            'awal'              => $awal,
            'akhir'             => $akhir,
            'data'              => $data,
            'grand_penjualan'   => $grand_penjualan,
            'grand_pengeluaran' => $grand_pengeluaran,
            'grand_pendapatan'  => $grand_pendapatan,
        ]);
        // dd($grand_pengeluaran);
    }
}
