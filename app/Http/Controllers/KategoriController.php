<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategoris = Kategori::latest()->get();
            $data      = [];
            $no        = 1;

            foreach ($kategoris as $kategori) {
                $row = [];

                $row[] = '<p class="text-center">' . $no++ . '</p>';
                $row[] = '<p class="text-start">' . $kategori->name . '</p>';
                $row[] = '<p class="text-center">
                    <a href="' . url('admin/kategori/edit/' . $kategori->id) . '" class="btn btn-sm btn-success">
                        Ubah
                    </a>
                    <a onclick="return confirm(`Apakah yakin ingin menghapus data berikut ini?`)" href="' . url('admin/kategori/delete/' . $kategori->id) . '" class="btn btn-sm btn-danger">
                        Hapus
                    </a>    
                </p>';

                $data[] = $row;
            }

            return response()->json(["data" => $data]);
        }


        return view('admin.kategori.index', [
            'activeMenu' => 'kategori'
        ]);
    }

    public function create()
    {
        return view('admin.kategori.form', [
            'activeMenu' => 'kategori',
            'isEdit'     => false,
            'url'        => url('admin/kategori/submit')
        ]);
    }

    public function edit($id)
    {
        return view('admin.kategori.form', [
            'activeMenu' => 'kategori',
            'isEdit'     => true,
            'url'        => url('admin/kategori/submit/' . $id),
            'data'       => Kategori::find($id),
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
            Kategori::create($data);
            Alert::success('Sukses', 'Data Kategori Telah Berhasil Ditambahkan');
        } else {
            Kategori::find($id)->update($data);
            Alert::info('Sukses', 'Data Kategori Telah Berhasil Diperbarui');
        }

        return redirect('admin/kategori');
    }

    public function delete($id)
    {
        Kategori::find($id)->delete();
        Alert::error('Sukses', 'Data Kategori Telah Berhasil Dihapus');

        return redirect('admin/kategori');
    }
}
