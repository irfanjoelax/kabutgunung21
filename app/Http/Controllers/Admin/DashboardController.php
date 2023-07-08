<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard-admin', [
            'activeMenu' => 'dashboard',
        ]);
    }

    public function keuangan()
    {
        return view('admin.dashboard-keuangan', [
            'activeMenu' => 'dashboard',
        ]);
    }

    public function owner()
    {
        $awal  = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');

        $total_pendapatan  = 0;
        $grand_modal       = 0;
        $grand_penjualan   = 0;
        $grand_pengeluaran = 0;
        $grand_pendapatan  = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal    = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $modal   = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('modal');
            $penjualan   = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('grand_total');
            $pengeluaran = Pengeluaran::where('created_at', 'LIKE', "$tanggal%")->sum('nominal');

            $pendapatan        = $penjualan - ($pengeluaran + $modal);
            $total_pendapatan += $pendapatan;

            $grand_modal       += $modal;
            $grand_penjualan   += $penjualan;
            $grand_pengeluaran += $pengeluaran;
            $grand_pendapatan  += $total_pendapatan;
        }

        $options1 = [
            'chart_title' => 'Grafik Penjualan',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Penjualan',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'grand_total',
            'chart_type' => 'line',
        ];

        $chart1 = new LaravelChart($options1);

        $options2 = [
            'chart_title' => 'Grafik Pengeluaran',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Pengeluaran',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'nominal',
            'chart_type' => 'line',
        ];

        $chart2 = new LaravelChart($options2);

        $options3 = [
            'chart_title'       => 'Marketplace',
            'report_type'       => 'group_by_relationship',
            'model'             => 'App\Models\Penjualan',
            'relationship_name' => 'marketplace',
            'group_by_field'    => 'name',
            'chart_type'        => 'pie',
            'filter_field'      => 'created_at',
            'filter_period'     => 'month',
        ];

        $chart3 = new LaravelChart($options3);
        // $produk_laris = PenjualanDetail::selectRaw('count(id) as count_of_trx, produk_id')
        //     ->groupBy('produk_id')
        //     ->orderBy('count_of_trx', 'DESC')
        //     ->limit(15)
        //     ->get();
        $produk_laris = PenjualanDetail::selectRaw('count(id) as count_of_trx, produk_id')
            ->groupBy('produk_id')
            ->orderBy('count_of_trx', 'DESC')
            ->limit(15)
            ->get();

        return view('admin.dashboard-owner', [
            'activeMenu'        => 'dashboard',
            'grand_modal'       => $grand_modal,
            'grand_penjualan'   => $grand_penjualan,
            'grand_pengeluaran' => $grand_pengeluaran,
            'grand_pendapatan'  => $total_pendapatan,
            'chart1'            => $chart1,
            'chart2'            => $chart2,
            'chart3'            => $chart3,
            'produk_laris'      => $produk_laris,
        ]);
    }
}
