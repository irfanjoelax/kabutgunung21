<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    private function checkStok($qty)
    {
        if ($qty <= 3) {
            return 'text-danger';
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $produks = Produk::with('kategori')->latest()->get();
            $data    = [];
            $no      = 1;

            foreach ($produks as $produk) {
                $row = [];

                $row[] = '<p class="text-center">' . $no++ . '</p>';
                $row[] = '<p class="text-start"><strong>' . $produk->nama . '</strong> <br>
                    <small class="text-muted">' . $produk->sku . '</small>
                </p>';
                $row[] = '<p class="text-center">' . $produk->kategori->name . '</p>';

                if (Auth::user()->level == 'owner') {
                    $row[] = '<p class="text-start">
                        Rp. <span class="float-end">' . number_format($produk->harga_beli) . '</span>
                    </p>';
                }

                $row[] = '<p class="text-end ' . $this->checkStok($produk->stok) . '">
                    <strong>' . $produk->stok . '</strong>
                </p>';

                if (Auth::user()->level == 'owner') {
                    $row[] = '<p class="text-center">
                        <a href="' . url('admin/produk/history/' . $produk->id) . '" class="btn btn-sm btn-warning">
                            Histori
                        </a>
                        <a href="' . url('admin/produk/edit/' . $produk->id) . '" class="btn btn-sm btn-success">
                            Ubah
                        </a>
                        <a onclick="return confirm(`Apakah yakin ingin menghapus data berikut ini?`)" href="' . url('admin/produk/delete/' . $produk->id) . '" class="btn btn-sm btn-danger">
                            Hapus
                        </a>    
                    </p>';
                }

                $data[] = $row;
            }

            return response()->json(["data" => $data]);
        }


        return view('admin.produk.index', [
            'activeMenu' => 'produk'
        ]);
    }

    public function create()
    {
        return view('admin.produk.form', [
            'activeMenu' => 'produk',
            'isEdit'     => false,
            'url'        => url('admin/produk/submit'),
            'kategoris'  => Kategori::latest()->get(),
        ]);
    }

    public function edit($id)
    {
        return view('admin.produk.form', [
            'activeMenu' => 'produk',
            'isEdit'     => true,
            'url'        => url('admin/produk/submit/' . $id),
            'kategoris'  => Kategori::latest()->get(),
            'data'       => Produk::find($id),
        ]);
    }

    public function history($id)
    {
        $data = Produk::with(['penjualan_details' => function ($query) {
            $query->take(100);
        }])->find($id);

        return view('admin.produk.history', [
            'activeMenu' => 'produk',
            'data'       => $data,
        ]);
    }

    public function submit(Request $request, $id = null)
    {
        $dataID = Str::uuid();

        if ($id != null) {
            $dataID = $id;
        };

        $data = [
            'id'          => $dataID,
            'sku'         => $request->sku,
            'nama'        => $request->nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli'  => $request->harga_beli,
            'stok'        => $request->stok,
        ];

        if ($id == null) {
            Produk::create($data);
            Alert::success('Sukses', 'Data Produk Telah Berhasil Ditambahkan');
        } else {
            Produk::find($id)->update($data);
            Alert::info('Sukses', 'Data Produk Telah Berhasil Diperbarui');
        }

        return redirect('admin/produk');
    }

    public function delete($id)
    {
        Produk::find($id)->delete();
        Alert::error('Sukses', 'Data Produk Telah Berhasil Dihapus');

        return redirect('admin/produk');
    }

    public function show($sku)
    {
        $produk = Produk::where('sku', $sku)->firstOrFail();

        // Jika produk ditemukan, kembalikan data stok
        if ($produk) {
            return response()->json([
                'nama'       => $produk->nama,
                'harga_beli' => $produk->harga_beli,
                'stok'       => $produk->stok,
            ]);
        }

        // Jika produk tidak ditemukan, kembalikan respon kosong atau pesan error
        return response()->json([], 404);
    }
}
