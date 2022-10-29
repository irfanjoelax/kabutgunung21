<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function index()
    {
        $awal  = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');

        $data              = array();
        $data_tanggal      = array();
        $pendapatan        = 0;
        $total_pendapatan  = 0;
        $grand_penjualan   = 0;
        $grand_pengeluaran = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal    = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $total_penjualan   = Penjualan::where('created_at', 'LIKE', "$tanggal%")->sum('grand_total');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "$tanggal%")->sum('nominal');

            $pendapatan        = $total_penjualan - $total_pengeluaran;
            $total_pendapatan += $pendapatan;

            $grand_penjualan += $total_penjualan;
            $grand_pengeluaran += $total_pengeluaran;

            $row = [];
            $row['tanggal'] = $tanggal;
            $row['total_penjualan'] = $total_penjualan;
            $row['total_pengeluaran'] = $total_pengeluaran;
            $row['total_pendapatan'] = $pendapatan;
            $data[] = $row;
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

        $options4 = [
            'chart_title'       => 'Produk Terlaris',
            'report_type'       => 'group_by_relationship',
            'model'             => 'App\Models\PenjualanDetail',
            'relationship_name' => 'produk',
            'group_by_field'    => 'nama',
            'chart_type'        => 'bar',
            'filter_field'      => 'created_at',
            'filter_period'     => 'month',
        ];

        $chart4 = new LaravelChart($options4);

        return view('admin.dashboard', [
            'activeMenu'        => 'dashboard',
            'total_produk'      => Produk::count(),
            'grand_penjualan'   => $grand_penjualan,
            'grand_pengeluaran' => $grand_pengeluaran,
            'grand_pendapatan'  => $total_pendapatan,
            'chart1'            => $chart1,
            'chart2'            => $chart2,
            'chart3'            => $chart3,
            'chart4'            => $chart4,
        ]);
    }
}
