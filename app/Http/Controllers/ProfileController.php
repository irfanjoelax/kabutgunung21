<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile', [
            'activeMenu' => 'profile'
        ]);
    }

    public function update(Request $request)
    {
        $user     = Auth::user();
        $password = $user->password;

        History::create([
            'user_id' => auth()->user()->id,
            'histori' => auth()->user()->name . ' Mengubah profile akun.',
        ]);

        if ($request->password != NULL) {
            $password = Hash::make($request->password);
        }

        User::find($user->id)->update([
            'name'     => $request->name,
            'username'  => $request->username,
            'password' => $password,
        ]);

        Alert::success('Sukses', 'Profile User Anda Telah Diperbarui');

        return redirect()->back();
    }
}
