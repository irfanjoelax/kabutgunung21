<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PembelianController extends Controller
{
    private function checkStok($qty)
    {
        if ($qty <= 3) {
            return 'text-danger';
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $produks = Produk::with('kategori')->where('stok', '<=', 3)->orderBy('stok', 'ASC')->get();
            $data    = [];
            $no      = 1;

            foreach ($produks as $produk) {
                $row = [];

                $row[] = '<p class="text-center">' . $no++ . '</p>';
                $row[] = '<p class="text-start"><strong>' . $produk->nama . '</strong> <br>
                    <small class="text-muted">' . $produk->sku . '</small>
                </p>';
                $row[] = '<p class="text-center">' . $produk->kategori->name . '</p>';

                $row[] = '<p class="text-start">
                        Rp. <span class="float-end">' . number_format($produk->harga_beli) . '</span>
                    </p>';

                $row[] = '<p class="text-end ' . $this->checkStok($produk->stok) . '">
                    <strong>' . $produk->stok . '</strong>
                </p>';

                $data[] = $row;
            }

            return response()->json(["data" => $data]);
        }

        return view('admin.pembelian.index', [
            'activeMenu' => 'pembelian'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Produk::where('sku', $request->sku)->firstOrFail()->update([
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok,
        ]);

        Alert::info('Sukses', 'Stok Produk Telah Berhasil Diperbarui');

        return redirect('admin/pembelian');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
