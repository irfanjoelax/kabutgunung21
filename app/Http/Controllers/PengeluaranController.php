<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pengeluarans = Pengeluaran::latest()->get();
            $data         = [];
            $no           = 1;

            foreach ($pengeluarans as $pengeluaran) {
                $row = [];

                $row[] = '<p class="text-center">' . $no++ . '</p>';
                $row[] = '<p class="text-center">' . $pengeluaran->date . '</p>';
                $row[] = '<p class="text-start">' . $pengeluaran->detail . '</p>';
                $row[] = '<p class="text-start">
                    Rp. <span class="float-end">' . number_format($pengeluaran->nominal) . '</span>
                </p>';
                $row[] = '<p class="text-center">
                    <a href="' . url('admin/pengeluaran/edit/' . $pengeluaran->id) . '" class="btn btn-sm btn-success">
                        Ubah
                    </a>
                    <a onclick="return confirm(`Apakah yakin ingin menghapus data berikut ini?`)" href="' . url('admin/pengeluaran/delete/' . $pengeluaran->id) . '" class="btn btn-sm btn-danger">
                        Hapus
                    </a>    
                </p>';

                $data[] = $row;
            }

            return response()->json(["data" => $data]);
        }


        return view('admin.pengeluaran.index', [
            'activeMenu' => 'pengeluaran'
        ]);
    }

    public function create()
    {
        return view('admin.pengeluaran.form', [
            'activeMenu' => 'pengeluaran',
            'isEdit'     => false,
            'url'        => url('admin/pengeluaran/submit')
        ]);
    }

    public function edit($id)
    {
        return view('admin.pengeluaran.form', [
            'activeMenu' => 'pengeluaran',
            'isEdit'     => true,
            'url'        => url('admin/pengeluaran/submit/' . $id),
            'data'       => Pengeluaran::find($id),
        ]);
    }

    public function submit(Request $request, $id = null)
    {
        $dataID = Str::uuid();

        if ($id != null) {
            $dataID = $id;
        };

        $data = [
            'id'      => $dataID,
            'date'    => $request->date,
            'detail'  => $request->detail,
            'nominal' => $request->nominal,
        ];

        if ($id == null) {
            Pengeluaran::create($data);
            Alert::success('Sukses', 'Data Pengeluaran Telah Berhasil Ditambahkan');
        } else {
            Pengeluaran::find($id)->update($data);
            Alert::info('Sukses', 'Data Pengeluaran Telah Berhasil Diperbarui');
        }

        return redirect('admin/pengeluaran');
    }

    public function delete($id)
    {
        Pengeluaran::find($id)->delete();
        Alert::error('Sukses', 'Data Pengeluaran Telah Berhasil Dihapus');

        return redirect('admin/pengeluaran');
    }
}
