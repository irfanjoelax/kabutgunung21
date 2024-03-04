<?php

namespace App\Http\Controllers;

use App\Models\Marketplace;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $awal  = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');

        if ($request->ajax()) {
            $penjualans = Penjualan::with('user')
                ->where('created_at', '>=', $awal . " 00:00:00")
                ->where('created_at', '<=', $akhir . " 23:59:59")
                ->latest()
                ->get();

            $data = [];

            foreach ($penjualans as $penjualan) {
                $row = [];

                $row[] = '<p class="text-center">' . $penjualan->no_pesanan . '<br>' . $penjualan->no_invoice . '</p>';

                if ($penjualan->user()->exists()) {
                    if ($penjualan->user_id != null) {
                        $row[] = '<p class="text-center">' . $penjualan->user->name . '<br><small style="font-size: 10px">' . $penjualan->updated_at . '</small></p>';
                    } else {
                        $row[] = '<p class="text-center"><br><small style="font-size: 10px">' . $penjualan->updated_at . '</small></p>';
                    }
                } else {
                    $row[] = '<p class="text-center"><span class="text-danger">User dihapus</span><br><small style="font-size: 10px">' . $penjualan->updated_at . '</small></p>';
                }

                $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($penjualan->total) . '</span>
                </p>';

                $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($penjualan->grand_total) . '</span>
                </p>';

                if (in_array(Auth::user()->level, ['owner', 'keuangan'])) {
                    $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-kurir" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_kurir == 'TERKIRIM' ? 'checked' : '') . '></p>';
                    $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-bayar" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_bayar == 'TERBAYAR' ? 'checked' : '') . '></p>';
                }

                // if (in_array(Auth::user()->level, ['owner', 'keuangan'])) {
                //     $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-kurir" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_kurir == 'TERKIRIM' ? 'checked' : '') . '></p>';
                //     $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-bayar" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_bayar == 'TERBAYAR' ? 'checked' : '') . '></p>';
                // }

                // if (in_array(Auth::user()->level, ['owner', 'keuangan'])) {
                //     if ($penjualan->status_kurir === 'TERKIRIM') {
                //         $row[] = '<p class="text-center"><span class="badge bg-secondary">TERKIRIM</span></p>';
                //     } else {
                //         $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-kirim" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_kurir == 'TERKIRIM' ? 'checked' : '') . '></p>';
                //     }

                //     $row[] = '<p class="text-center"><span class="badge bg-secondary">' . $penjualan->status_bayar . '</span></p>';
                // }

                $row[] = '<p class="text-start">' . $penjualan->remark . '</p>';

                if (in_array(Auth::user()->level, ['owner', 'keuangan'])) {
                    $row[] = '<p class="text-center">
                        <a href="' . url('admin/penjualan/show/' . $penjualan->id) . '" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="' . url('admin/penjualan/detail/' . $penjualan->id . '?type=edit') . '" class="btn btn-sm btn-warning">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                    </p>';
                }

                if (Auth::user()->level == 'admin') {
                    $row[] = '<p class="text-center">
                        <a href="' . url('admin/penjualan/show/' . $penjualan->id) . '" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </p>';
                }

                $data[] = $row;
            }

            return response()->json(["data" => $data]);
        }

        return view('admin.penjualan.index', [
            'activeMenu'   => 'penjualan',
            'awal'         => $awal,
            'akhir'        => $akhir,
            'penjualans'   => Penjualan::latest()->get(),
            'marketplaces' => Marketplace::latest()->get()
        ]);
    }

    public function filter($awal, $akhir, $status, $marketplace = 'Semua')
    {
        $whereArr = [
            ['created_at', '>=', $awal . " 00:00:00"],
            ['created_at', '<=', $akhir . " 23:59:59"],
            ['status_bayar', '=', $status],
        ];

        if ($marketplace != 'Semua') {
            $whereArr[] = ['marketplace_id', '=', $marketplace];
        }

        $penjualans = Penjualan::with('user')->where($whereArr);

        if (request('no_pesanan') != null) {
            $penjualans->whereIn('no_pesanan', explode(",", request('no_pesanan')));
        }

        $data = [];

        foreach ($penjualans->latest()->get() as $penjualan) {
            $row = [];

            $row[] = '<p class="text-center">' . $penjualan->no_pesanan . '<br>' . $penjualan->no_invoice . '</p>';

            if ($penjualan->user()->exists()) {
                if ($penjualan->user_id != null) {
                    $row[] = '<p class="text-center">' . $penjualan->user->name . '<br><small style="font-size: 10px">' . $penjualan->updated_at . '</small></p>';
                } else {
                    $row[] = '<p class="text-center"><br><small style="font-size: 10px">' . $penjualan->updated_at . '</small></p>';
                }
            } else {
                $row[] = '<p class="text-center"><span class="text-danger">User dihapus</span><br><small style="font-size: 10px">' . $penjualan->updated_at . '</small></p>';
            }

            $row[] = '<p class="text-start">
                Rp. <span class="float-end">' . number_format($penjualan->total) . '</span>
            </p>';

            $row[] = '<p class="text-start">
                Rp. <span class="float-end">' . number_format($penjualan->grand_total) . '</span>
            </p>';

            if (Auth::user()->level == 'owner') {
                $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-kurir" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_kurir == 'TERKIRIM' ? 'checked' : '') . '></p>';
                $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-bayar" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_bayar == 'TERBAYAR' ? 'checked' : '') . '></p>';
            }

            if (Auth::user()->level == 'keuangan') {
                $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-kurir" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_kurir == 'TERKIRIM' ? 'checked' : '') . '></p>';
                $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-bayar" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_bayar == 'TERBAYAR' ? 'checked' : '') . '></p>';
            }

            if (Auth::user()->level == 'admin') {
                if ($penjualan->status_kurir === 'TERKIRIM') {
                    $row[] = '<p class="text-center"><span class="badge bg-secondary">TERKIRIM</span></p>';
                } else {
                    $row[] = '<p class="text-center"><input type="checkbox" class="form-check-input status-kirim" data-penjualan-id="' . $penjualan->id . '"' . ($penjualan->status_kurir == 'TERKIRIM' ? 'checked' : '') . '></p>';
                }

                $row[] = '<p class="text-center"><span class="badge bg-secondary">' . $penjualan->status_bayar . '</span></p>';
            }

            $row[] = '<p class="text-start">' . $penjualan->remark . '</p>';

            if (in_array(Auth::user()->level, ['owner', 'keuangan'])) {
                $row[] = '<p class="text-center">
                        <a href="' . url('admin/penjualan/show/' . $penjualan->id) . '" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="' . url('admin/penjualan/detail/' . $penjualan->id . '?type=edit') . '" class="btn btn-sm btn-warning">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                    </p>';
            }

            if (Auth::user()->level == 'admin') {
                $row[] = '<p class="text-center">
                        <a href="' . url('admin/penjualan/show/' . $penjualan->id) . '" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </p>';
            }

            $data[] = $row;
        }

        return response()->json(["data" => $data]);
    }

    public function create()
    {
        $id = Str::uuid();

        Penjualan::create([
            'id'         => $id,
            'user_id'    => Auth::id(),
            'no_invoice' => $this->noInvoice(),
        ]);

        // return redirect('admin/penjualan/detail/' . $id);
        return redirect()->route('penjualan.detail', [
            'id' => $id,
            'type' => 'create'
        ]);
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
            'status_bayar' => request('status'),
        ]);

        // return redirect('/admin/penjualan');
    }

    public function updateKurir($id)
    {
        Penjualan::find($id)->update([
            'status_kurir' => request('status'),
        ]);

        // return redirect('/admin/penjualan');
    }

    public function noInvoice()
    {
        $urutan = Penjualan::whereYear('created_at', date('Y'))->count();
        // $urutan = Penjualan::count();

        $urutan++;

        $huruf = "INV";
        $kodeBarang = $huruf . sprintf("%06s", $urutan);

        return $kodeBarang;
    }
}
