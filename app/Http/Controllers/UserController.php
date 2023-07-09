<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::latest()->get();
            $data      = [];
            $no        = 1;

            foreach ($users as $user) {
                $row = [];

                $row[] = '<p class="text-center">' . $no++ . '</p>';
                $row[] = '<p class="text-start">' . $user->name . '</p>';
                $row[] = '<p class="text-center">' . $user->username . '</p>';
                $row[] = '<p class="text-center">
                    <span class="badge bg-secondary">' . ucwords($user->level) . '</span>
                </p>';
                $row[] = '<p class="text-center">
                    <a href="' . url('admin/user/edit/' . $user->id) . '" class="btn btn-sm btn-success">
                        Ubah
                    </a>
                    <a onclick="return confirm(`Apakah yakin ingin menghapus data berikut ini?`)" href="' . url('admin/user/delete/' . $user->id) . '" class="btn btn-sm btn-danger">
                        Hapus
                    </a>    
                </p>';

                $data[] = $row;
            }

            return response()->json(["data" => $data]);
        }


        return view('admin.user.index', [
            'activeMenu' => 'user'
        ]);
    }

    public function create()
    {
        return view('admin.user.form', [
            'activeMenu' => 'user',
            'isEdit'     => false,
            'url'        => url('admin/user/submit')
        ]);
    }

    public function edit($id)
    {
        return view('admin.user.form', [
            'activeMenu' => 'user',
            'isEdit'     => true,
            'url'        => url('admin/user/submit/' . $id),
            'data'       => User::find($id),
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
            'username' => $request->username,
            'level'    => $request->level,
            'password' => Hash::make('123456'),
        ];

        if ($id == null) {
            User::create($data);
            Alert::success('Sukses', 'Data User Telah Berhasil Ditambahkan');
        } else {
            User::find($id)->update($data);
            Alert::info('Sukses', 'Data User Telah Berhasil Diperbarui');
        }

        return redirect('admin/user');
    }

    public function delete($id)
    {
        Schema::disableForeignKeyConstraints();

        User::find($id)->delete();
        Alert::error('Sukses', 'Data User Telah Berhasil Dihapus');

        return redirect('admin/user');
    }
}
