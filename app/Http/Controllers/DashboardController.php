<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $cuti = Izin::where('jenis', 'Cuti')->count();
        $izin = Izin::where('jenis', 'Izin')->count();
        $sakit = Izin::where('jenis', 'Sakit')->count();
        $pegawai = User::where('role', 'Pegawai')->count();
        $today = now()->format('Y-m-d');
        $masuk = Presensi::whereDate('datein', $today) // Use whereDate for clarity
            ->latest()
            ->get();
        $pulang = Presensi::whereDate('dateout', $today) // Use whereDate for clarity
            ->latest()
            ->get();
        return view('admin.dashboard.index', compact('title', 'cuti', 'izin', 'sakit', 'pegawai', 'masuk', 'pulang'));
    }


    public function izin()
    {
        $title = 'Data Izin/Sakit';
        $data = Izin::where('jenis', '!=', 'Cuti')->latest()->get();
        return view('admin.izin.index', compact('title', 'data'));
    }

    public function approve(Request $request)
    {
        $pegawai = Izin::find($request->id);

        if ($pegawai) {
            $pegawai->status = "Disetujui"; // Example field
            $pegawai->save();
            return response()->json(['message' => 'Pegawai disetujui dengan sukses!']);
        }

        return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
    }

    public function reject(Request $request)
    {
        $pegawai = Izin::find($request->id); // Replace with your own logic
        if ($pegawai) {
            $pegawai->status = "Ditolak"; // Example field
            $pegawai->save();
            return response()->json(['message' => 'Pegawai ditolak dengan sukses!']);
        }

        return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
    }

    public function cuti()
    {
        $title = 'Data Cuti Pegawai';
        $data = Izin::where('jenis', 'Cuti')->latest()->get();
        return view('admin.cuti.index', compact('title', 'data'));
    }

    public function approveCuti(Request $request)
    {
        $pegawai = Izin::find($request->id);

        if ($pegawai) {
            $pegawai->status = "Disetujui"; // Example field
            $pegawai->save();
            return response()->json(['message' => 'Pengajuan cuti disetujui dengan sukses!']);
        }

        return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
    }

    public function rejectCuti(Request $request)
    {
        $pegawai = Izin::find($request->id); // Replace with your own logic
        if ($pegawai) {
            $pegawai->status = "Ditolak"; // Example field
            $pegawai->save();
            return response()->json(['message' => 'Pengajuan cuti ditolak dengan sukses!']);
        }

        return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
    }

    public function pegawai()
    {
        $title = 'Data Pegawai';
        $data = User::where('role', 'Pegawai')->latest()->get();
        return view('admin.pegawai.index', compact('title', 'data'));
    }

    public function detailpegawai($id)
    {
        $title = 'Detail Pegawai';
        $data = User::findOrFail($id);
        return view('admin.pegawai.detail', compact('title', 'data'));
    }

    public function absen(Request $request)
    {
        $title = 'Data Absensi Pegawai';

        // Ambil parameter start_date dan end_date dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query untuk absensi masuk dan pulang
        $masukQuery = Presensi::where('masuk', '=', 'Masuk'); // Absensi masuk
        $pulangQuery = Presensi::where('keluar', '!=', null); // Absensi pulang
        $telatQuery = Presensi::where('masuk', '=', 'Terlambat'); // Absensi pulang

        // Jika ada filter tanggal mulai dan selesai
        if ($startDate && $endDate) {
            // Pastikan format tanggal sesuai dengan yang digunakan dalam database (YYYY-MM-DD)
            $masukQuery->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay(),
            ]);
            $pulangQuery->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay(),
            ]);
            $telatQuery->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay(),
            ]);
        }

        $masuk = $masukQuery->latest()->get();
        $pulang = $pulangQuery->latest()->get();
        $telat = $telatQuery->latest()->get();

        return view('admin.absen.index', compact('title', 'masuk', 'pulang', 'telat'));
    }


    public function detailAbsen($id)
    {
        $title = 'Detail Absensi Masuk Pegawai';
        $data = Presensi::findOrFail($id);
        return view('admin.absen.detail', compact('title', 'data'));
    }

    public function detailAbsenPulang($id)
    {
        $title = 'Detail Absensi Pulang Pegawai';
        $data = Presensi::findOrFail($id);
        return view('admin.absen.detailpulang', compact('title', 'data'));
    }
}
