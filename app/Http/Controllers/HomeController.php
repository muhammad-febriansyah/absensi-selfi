<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\JamKerja;
use App\Models\LokasiPenempatan;
use App\Models\RadiusKantor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        return view('pegawai.home.index');
    }

    public function register()
    {
        $jabatan = Jabatan::all();
        $jamkerja = JamKerja::all();
        $lokasi = RadiusKantor::all();
        return view('pegawai.register.index', compact('jabatan', 'jamkerja', 'lokasi'));
    }

    public function saveregister(Request $request)
    {
        $check = User::where('nik', $request->nik)->first();
        if ($check) {
            return response()->json(['success' => false, 'error' => 'NIK already exists.']);
        }
        $q = new User();
        $q->nik = $request->nik;
        $q->email = $request->email;
        $q->name = $request->name;
        $q->jabatan_id = $request->jabatan_id;
        $q->jam_kerja_id = $request->jam_kerja_id;
        $q->radius_kantor_id = $request->lokasi_id;
        $q->password = Hash::make($request->password);
        $q->role = "Pegawai";
        $q->save();
        return response()->json(['success' => true]);
    }

    public function checklogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'],'role' => 'Pegawai'])) {
            $request->session()->regenerate();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
