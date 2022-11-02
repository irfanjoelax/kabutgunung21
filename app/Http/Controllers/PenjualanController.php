<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PenjualanController extends Controller
{
    private function checkStatusKurir($value, $url)
    {
        if ($value == 'BELUM TERKIRIM') {
            return '<a onclick="return confirm(`Apakah benar penjualan ini telah dikirimkan ke jasa kurir?`)" href="' . url($url) . '" class="badge bg-warning text-decoration-none">' . $value . '</a>';
        } else {
            return '<span class="badge bg-success">' . $value . '</span>';
        }
    }

    private function checkStatusBayar($value, $url)
    {
        if ($value == 'BELUM TERBAYAR') {
            return '<a onclick="return confirm(`Apakah benar penjualan ini telah dibayarkan oleh Marketplace?`)" href="' . url($url) . '" class="badge bg-danger text-decoration-none">' . $value . '</a>';
        } else {
            return '<span class="badge bg-info">' . $value . '</span>';
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $penjualans = Penjualan::latest()->get();
            // if ($tanggal != null && $status != null) {
            //     $whereArr = [
            //         ['created_at', 'like', $tanggal . '%'],
            //         ['status_bayar', '=', $status],
            //     ];

            //     $penjualans = Penjualan::where($whereArr)->latest()->get();

            //     $url = url('admin/penjualan?tanggal=' . $tanggal . '&status=' . $status);
            // }

            $data       = [];

            foreach ($penjualans as $penjualan) {
                $row = [];

                $row[] = '<p class="text-center">' . $penjualan->no_pesanan . '</p>';
                $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($penjualan->total) . '</span>
                </p>';
                $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($penjualan->fee) . '</span>
                </p>';
                $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($penjualan->grand_total) . '</span>
                </p>';
                $row[] = '<p class="text-center">' . $this->checkStatusKurir($penjualan->status_kurir, 'admin/penjualan/update/kurir/' . $penjualan->id) . ' | ' . $this->checkStatusBayar($penjualan->status_bayar, 'admin/penjualan/update/bayar/' . $penjualan->id) . '</p>';
                $row[] = '<p class="text-start">' . $penjualan->remark . '</p>';
                $row[] = '<p class="text-center">
                    <a href="' . url('admin/penjualan/show/' . $penjualan->id) . '" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="' . url('admin/penjualan/detail/' . $penjualan->id) . '" class="btn btn-sm btn-warning">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                </p>';

                $data[] = $row;
            }

            return response()->json(["data" => $data]);
        }

        return view('admin.penjualan.index', [
            'activeMenu' => 'penjualan',
        ]);
    }

    public function filter($tanggal, $status)
    {
        $whereArr = [
            ['created_at', 'like', $tanggal . '%'],
            ['status_bayar', '=', $status],
        ];

        $penjualans = Penjualan::where($whereArr)->latest()->get();

        $data       = [];

        foreach ($penjualans as $penjualan) {
            $row = [];

            $row[] = '<p class="text-center">' . $penjualan->no_pesanan . '</p>';
            $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($penjualan->total) . '</span>
                </p>';
            $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($penjualan->fee) . '</span>
                </p>';
            $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($penjualan->grand_total) . '</span>
                </p>';
            $row[] = '<p class="text-center">' . $this->checkStatusKurir($penjualan->status_kurir, 'admin/penjualan/update/kurir/' . $penjualan->id) . ' | ' . $this->checkStatusBayar($penjualan->status_bayar, 'admin/penjualan/update/bayar/' . $penjualan->id) . '</p>';
            $row[] = '<p class="text-start">' . $penjualan->remark . '</p>';
            $row[] = '<p class="text-center">
                    <a href="' . url('admin/penjualan/show/' . $penjualan->id) . '" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="' . url('admin/penjualan/detail/' . $penjualan->id) . '" class="btn btn-sm btn-warning">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                </p>';

            $data[] = $row;
        }

        return response()->json(["data" => $data]);
    }

    public function create()
    {
        $id = Str::uuid();
        Penjualan::create(['id' => $id]);

        return redirect('admin/penjualan/detail/' . $id);
    }

    public function detail($id)
    {
        return view('admin.penjualan.detail', [
            'activeMenu'   => 'penjualan',
            'details'      => PenjualanDetail::where('penjualan_id', $id)->latest()->get(),
            'produks'      => Produk::latest()->get(),
            'penjualan_id' => $id,
            'grand_total'  => 0,
        ]);
    }

    public function show($id)
    {
        return view('admin.penjualan.show', [
            'activeMenu' => 'penjualan',
            'data'       => Penjualan::with('penjualan_details')->find($id),
        ]);
    }

    public function updateBayar($id)
    {
        Penjualan::find($id)->update([
            'status_bayar' => 'TERBAYAR',
        ]);

        return redirect('/admin/penjualan');
    }

    public function updateKurir($id)
    {
        Penjualan::find($id)->update([
            'status_kurir' => 'TERKIRIM',
        ]);

        return redirect('/admin/penjualan');
    }
}
