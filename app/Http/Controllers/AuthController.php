<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function viewLoginPage()
    {
        // dd(session()->all());
        return view('auth/login');
    }

    public function actionLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('login')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('username', 'password');
        $user = db::table('master_user')
            ->leftJoin('master_bagian', 'master_user.master_nama_bagian_id', '=', 'master_bagian.master_bagian_id')
            ->leftJoin('master_direktorat', 'master_user.master_direktorat_id', '=', 'master_direktorat.direktorat_id')
            ->leftJoin('master_sub_bagian', 'master_user.id_sub_divisi', '=', 'master_sub_bagian.id')
            ->where('master_user.master_user_nama', $credentials['username'])
            ->select(
                'master_user.*',
                'master_bagian.*',
                'master_direktorat.*',
                'master_sub_bagian.*'
            )  
            ->first();

        if ($user && password_verify($credentials['password'], $user->master_user_password)) {
            $request->session()->regenerate();
            $request->session()->put('id', $user->master_user_id);
            $request->session()->put('master_nama_bagian_id', $user->master_nama_bagian_id);
            $request->session()->put('bagian_nama', $user->master_bagian_nama);
            $request->session()->put('hak_akses_id', $user->master_hak_akses_id);
            $request->session()->put('master_direktorat_id', $user->direktorat_id);
            $request->session()->put('nama_sub_divisi', $user->sub_bagian_nama);
            $request->session()->put('nama_direktorat', $user->nama);
            $request->session()->put('username', $user->master_user_nama);
            $request->session()->put('id_sub_divisi', $user->id_sub_divisi);
            $request->session()->put('sub_bagian_id', $user->id_sub_divisi);

            return redirect()->intended('dashboard');
        }
        return redirect('login')
            ->withInput()
            ->withErrors([
                'message' => 'Username atau password salah!!!',
            ]);
    } 

    public function logout(Request $request)
    {
        session()->flush();
        session()->invalidate();
        session()->regenerate();

        return redirect('/login')->with('alert', 'Anda berhasil logout');
    }
}
