<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Marketplace;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            History::create([
                'user_id' => auth()->user()->id,
                'histori' => auth()->user()->name . ' Mengakses Daftar Marketplace.',
            ]);

            $marketplaces = Marketplace::latest()->get();
            $data         = [];
            $no           = 1;

            foreach ($marketplaces as $marketplace) {
                $row = [];

                $row[] = '<p class="text-center">' . $no++ . '</p>';
                $row[] = '<p class="text-start">' . $marketplace->name . '</p>';
                $row[] = '<p class="text-center">
                    <a href="' . url('admin/marketplace/edit/' . $marketplace->id) . '" class="btn btn-sm btn-success">
                        Ubah
                    </a>
                    <a onclick="return confirm(`Apakah yakin ingin menghapus data berikut ini?`)" href="' . url('admin/marketplace/delete/' . $marketplace->id) . '" class="btn btn-sm btn-danger">
                        Hapus
                    </a>
                </p>';

                $data[] = $row;
            }

            return response()->json(["data" => $data]);
        }


        return view('admin.marketplace.index', [
            'activeMenu' => 'marketplace'
        ]);
    }

    public function create()
    {
        return view('admin.marketplace.form', [
            'activeMenu' => 'marketplace',
            'isEdit'     => false,
            'url'        => url('admin/marketplace/submit')
        ]);
    }

    public function edit($id)
    {
        return view('admin.marketplace.form', [
            'activeMenu' => 'marketplace',
            'isEdit'     => true,
            'url'        => url('admin/marketplace/submit/' . $id),
            'data'       => Marketplace::find($id),
        ]);
    }

    public function submit(Request $request, $id = null)
    {
        $dataID = Str::uuid();

        if ($id != null) {
            $dataID = $id;
        };

        $data = [
            'id'       => $dataID,
            'name'     => $request->name,
        ];

        if ($id == null) {
            History::create([
                'user_id' => auth()->user()->id,
                'histori' => auth()->user()->name . ' Menambahkan Data Marketplace.',
            ]);
            Marketplace::create($data);
            Alert::success('Sukses', 'Data Marketplace Telah Berhasil Ditambahkan');
        } else {
            History::create([
                'user_id' => auth()->user()->id,
                'histori' => auth()->user()->name . ' Mengubah Data Marketplace.',
            ]);
            Marketplace::find($id)->update($data);
            Alert::info('Sukses', 'Data Marketplace Telah Berhasil Diperbarui');
        }

        return redirect('admin/marketplace');
    }

    public function delete($id)
    {
        History::create([
            'user_id' => auth()->user()->id,
            'histori' => auth()->user()->name . ' Menghapus Data Marketplace.',
        ]);
        Marketplace::find($id)->delete();
        Alert::error('Sukses', 'Data Marketplace Telah Berhasil Dihapus');

        return redirect('admin/marketplace');
    }
}
