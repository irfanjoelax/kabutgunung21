<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Marketplace;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $marketplaces = Marketplace::with('kurirs')->latest()->get();
            $data         = [];
            $no           = 1;

            foreach ($marketplaces as $marketplace) {
                $row = [];

                $row[] = '<p class="text-center">' . $no++ . '</p>';
                $row[] = '<p class="text-start">' . $marketplace->name . '</p>';

                $kurirBadges = '';
                foreach ($marketplace->kurirs as $kurir) {
                    $kurirBadges .= '<span class="badge bg-pill bg-secondary me-1">' . $kurir->name . '</span>';
                }
                $row[] = '<p class="text-start">' . $kurirBadges . '</p>';

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
            'data'       => Marketplace::with('kurirs')->find($id),
        ]);
    }

    public function submit(Request $request, $id = null)
    {

        // dd($request->all());
        $dataID = Str::uuid();

        if ($id != null) {
            $dataID = $id;
        };

        $data = [
            'id'   => $dataID,
            'name' => $request->name,
        ];

        if ($id == null) {
            $marketplace = Marketplace::create($data);

            foreach ($request->kurirs as $kurir) {
                Kurir::create([
                    'marketplace_id' => $marketplace->id,
                    'name' => $kurir,
                ]);
            }

            Alert::success('Sukses', 'Data Marketplace Telah Berhasil Ditambahkan');
        } else {
            Marketplace::find($id)->update($data);

            Kurir::where('marketplace_id', $id)->delete();

            foreach ($request->kurirs as $kurir) {
                Kurir::create([
                    'marketplace_id' => $id,
                    'name' => $kurir,
                ]);
            }

            Alert::info('Sukses', 'Data Marketplace Telah Berhasil Diperbarui');
        }

        return redirect('admin/marketplace');
    }

    public function delete($id)
    {
        Marketplace::find($id)->delete();
        Alert::error('Sukses', 'Data Marketplace Telah Berhasil Dihapus');

        return redirect('admin/marketplace');
    }
}
