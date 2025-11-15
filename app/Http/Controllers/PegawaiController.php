<?php

namespace App\Http\Controllers;

use App\Http\Middleware\PegawaiMiddleware;
use App\Models\Izin;
use App\Models\Jabatan;
use App\Models\JamKerja;
use App\Models\Presensi;
use App\Models\RadiusKantor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware(PegawaiMiddleware::class);
    }

    public function index()
    {
        $userId = Auth::user()->id;
        $currentDate = now()->format('Y-m-d'); // atau gunakan date('Y-m-d') jika tidak menggunakan Carbon
        $checkmasuk = Presensi::where('user_id', $userId)->whereDate('datein', $currentDate)->count();
        $checkpulang = Presensi::where('user_id', $userId)->whereDate('dateout', $currentDate)->count();
        $masuk = Presensi::where('user_id', Auth::user()->id)->whereDate('datein', $currentDate)->get();
        $pulang = Presensi::where('user_id', Auth::user()->id)->whereDate('dateout', $currentDate)->get();
        $izin = Izin::where('user_id', Auth::user()->id)->where('jenis', "Izin")->count();
        $sakit = Izin::where('user_id', Auth::user()->id)->where('jenis', "Sakit")->count();
        return view('pegawai.dashboard.index', compact('masuk', 'pulang', 'checkmasuk', 'checkpulang', 'izin', 'sakit'));
    }

    public function absen()
    {
        $userId = Auth::user()->id;
        $currentDate = now()->format('Y-m-d'); // atau gunakan date('Y-m-d') jika tidak menggunakan Carbon
        $check = Presensi::where('user_id', $userId)
            ->whereDate('datein', $currentDate) // Cek absen masuk pada tanggal hari ini
            ->whereNull('dateout') // Pastikan dateout belum diisi
            ->count();
        return view('pegawai.absen.index', compact('check'));
    }

    public function saveabsen(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        $imageData = $request->input('image');
        $image = explode(',', $imageData)[1]; // Get the base64 part
        $image = base64_decode($image);

        // Define the folder and ensure it exists
        $folderPath = 'images/';
        Storage::disk('public')->makeDirectory($folderPath);

        // Generate a filename
        $filename = $folderPath . 'snapshot_' . time() . '.png';

        // Store the image in storage
        Storage::disk('public')->put($filename, $image);
        $jamKerja = Auth::user()->jamKerja;

        // Mendapatkan waktu saat ini
        $currentTime = date('H:i:s');
        $currentDateTime = date('Y-m-d H:i:s');

        // Periksa apakah waktu saat ini melewati batas jam kerja
        if ($currentTime > $jamKerja->in) {
            // Jika terlambat, simpan data absensi dengan status keterlambatan
            $terlambat = true;
        } else {
            $terlambat = false;
        }

        // Cek apakah user sudah absen hari ini
        $check = Presensi::where('user_id', Auth::user()->id)
            ->whereDate('datein', date('Y-m-d'))
            ->first();

        if ($check) {
            return response()->json(['status' => 2, 'message' => 'Anda sudah melakukan absensi hari ini.']);
        }

        // Ambil data radius kantor
        $radius = RadiusKantor::where('id', Auth::user()->radius_kantor_id)->first();

        if (!$radius) {
            return response()->json(['status' => 3, 'message' => 'Radius kantor tidak ditemukan.']);
        }

        // Koordinat kantor
        $officeLat = $radius->lat;  // Ganti dengan nama kolom latitude
        $officeLong = $radius->long; // Ganti dengan nama kolom longitude
        $radiusValue = $radius->radius;   // Radius dalam satuan meter

        // Hitung jarak menggunakan rumus Haversine
        $earthRadius = 6371000; // Radius Bumi dalam meter

        $latFrom = deg2rad($officeLat);
        $latTo = deg2rad($request->lat);
        $lonFrom = deg2rad($officeLong);
        $lonTo = deg2rad($request->long);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // Jarak dalam meter

        // Cek apakah jarak lebih besar dari radius
        if ($distance > $radiusValue) {
            return response()->json(['status' => 4, 'message' => 'Anda berada di luar radius absensi.']);
        }

        // Jika semua cek lulus, simpan data absensi
        $q = new Presensi();
        $q->user_id = Auth::user()->id;
        $q->in = $currentTime;
        $q->foto_in = $filename;
        $q->lat = $request->lat;
        $q->long = $request->long;
        $q->datein = $currentDateTime;

        // Menandai apakah terlambat atau tidak
        if ($terlambat) {
            $q->masuk = "Terlambat";
            $q->keterangan = "Terlambat pada jam " . $currentTime;
        } else {
            $q->masuk = "Masuk";
            $q->keterangan = "Masuk tepat waktu";
        }

        $q->save();

        // Jika terlambat, beri respons khusus
        if ($terlambat) {
            return response()->json(['status' => 3, 'message' => 'Anda terlambat melakukan absensi, namun absensi berhasil disimpan.']);
        }

        return response()->json(['status' => 0, 'success' => true, 'message' => 'Absensi Masuk Berhasil, Selamat bekerja.']);
    }

    public function absenout(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $imageData = $request->input('image');
        $imageParts = explode(',', $imageData);
        if (count($imageParts) < 2) {
            return response()->json(['status' => 4, 'message' => 'Format image tidak valid.']);
        }
        $image = base64_decode($imageParts[1]);

        $folderPath = 'images/';
        Storage::disk('public')->makeDirectory($folderPath);

        // Buat nama file
        $filename = $folderPath . 'snapshot_' . time() . '.png';

        // Simpan gambar di storage
        Storage::disk('public')->put($filename, $image);

        // Ambil data jam kerja pengguna
        $jamKerja = Auth::user()->jamKerja;

        $currentTime = date('H:i:s');
        $currentDateTime = date('Y-m-d H:i:s');

        // Cek apakah waktu saat ini sudah lewat dari jam kerja keluar
        if ($currentTime < $jamKerja->out) {
            return response()->json(['status' => 1, 'message' => 'Anda tidak dapat absensi pulang karena belum waktunya.']);
        }

        // Cek apakah sudah ada presensi untuk hari ini
        $checkIn = Presensi::where('user_id', Auth::user()->id)
            ->whereDate('datein', date('Y-m-d'))
            ->first();

        if (!$checkIn) {
            return response()->json(['status' => 2, 'message' => 'Anda harus melakukan absensi masuk sebelum melakukan absensi pulang.']);
        }

        // Cek apakah sudah melakukan absensi pulang
        if ($checkIn->out != null) {
            return response()->json(['status' => 3, 'message' => 'Anda sudah melakukan absensi pulang hari ini.']);
        }

        $radius = RadiusKantor::where('id', Auth::user()->radius_kantor_id)->first();

        if (!$radius) {
            return response()->json(['status' => 3, 'message' => 'Radius kantor tidak ditemukan.']);
        }

        // Koordinat kantor
        $officeLat = $radius->lat;  // Ganti dengan nama kolom latitude
        $officeLong = $radius->long; // Ganti dengan nama kolom longitude
        $radiusValue = $radius->radius;   // Radius dalam satuan meter

        // Hitung jarak menggunakan rumus Haversine
        $earthRadius = 6371000; // Radius Bumi dalam meter

        $latFrom = deg2rad($officeLat);
        $latTo = deg2rad($request->lat);
        $lonFrom = deg2rad($officeLong);
        $lonTo = deg2rad($request->long);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // Jarak dalam meter

        // Cek apakah jarak lebih besar dari radius
        if ($distance > $radiusValue) {
            return response()->json(['status' => 4, 'message' => 'Anda berada di luar radius absensi.']);
        }

        // Tentukan apakah absensi adalah lembur
        $lembur = false;
        if ($currentTime > $jamKerja->out) {
            $lembur = true;
        }

        // Update record untuk absensi pulang
        $checkIn->out = $currentTime; // Atur waktu pulang
        $checkIn->foto_out = $filename; // Simpan foto pulang
        $checkIn->dateout = $currentDateTime; // Jika ada kolom dateout
        $checkIn->latout = $request->lat;
        $checkIn->longout = $request->long;
        $checkIn->keluar = "Pulang";

        // Menandai apakah absensi ini lembur
        if ($lembur) {
            $checkIn->lembur = 1; // Kolom 'lembur' perlu ada di tabel Presensi
            // $checkIn->keterangan = 'Lembur'; // Opsional: bisa ditambahkan keterangan lembur
        } else {
            $checkIn->lembur = 0;
            // $checkIn->keterangan = 'Pulang Tepat Waktu'; // Opsional
        }

        $checkIn->save();

        // Mengembalikan respons
        if ($lembur) {
            return response()->json(['status' => 0, 'message' => 'Absensi pulang (lembur) berhasil dilakukan.']);
        }

        return response()->json(['status' => 0, 'message' => 'Absensi pulang berhasil dilakukan.']);
    }


    public function lokasi()
    {
        return view('pegawai.lokasi.index');
    }

    public function histori()
    {
        $masuk = Presensi::where('user_id', Auth::user()->id)->where('masuk', "!=", null)->latest()->get();
        $pulang = Presensi::where('user_id', Auth::user()->id)->where('keluar', "!=", null)->latest()->get();
        return view('pegawai.absen.histori', compact('masuk', 'pulang'));
    }

    public function cuti()
    {
        $data = Izin::where('user_id', Auth::user()->id)->where('jenis', 'Cuti')->latest()->get();
        return view('pegawai.cuti.index', compact('data'));
    }

    public function create()
    {
        return view('pegawai.cuti.create');
    }

    public function store(Request $request)
    {
        $q = new Izin();
        $q->user_id = Auth::user()->id;
        $q->date = date('Y-m-d');
        $q->start = $request->start;
        $q->end = $request->end;
        $q->jenis = "Cuti";
        $q->description = $request->description;
        $q->status = "Pending";
        $q->save();
        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $data = Izin::findOrFail($id);
        return view('pegawai.cuti.detail', compact('data'));
    }

    public function profile()
    {
        $jabatan = Jabatan::all();
        $jamkerja = JamKerja::all();
        $lokasi = RadiusKantor::all();
        $data = User::findOrFail(Auth::user()->id);
        return view('pegawai.profile.index', compact('data', 'jabatan', 'jamkerja', 'lokasi'));
    }

    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:3072', // Max 3MB
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Update user data here (replace with your model)
        $user = User::find(Auth::user()->id);
        $user->nik = $request->nik;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->jabatan_id = $request->jabatan_id;
        $user->jam_kerja_id = $request->jam_kerja_id;
        $user->radius_kantor_id = $request->radius_kantor_id;
        if (isset($imagePath)) {
            $user->image = $imagePath;
        }
        $user->save();

        return response()->json(['message' => 'Profile berhasil diperbarui!']);
    }
}
