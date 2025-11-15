<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Izin::where('user_id', Auth::user()->id)->latest()->get();
        return view('pegawai.izin.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawai.izin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:15048',
        ]);
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('images', 'public');
        }
        $q = new Izin();
        $q->user_id = Auth::user()->id;
        $q->date = $request->date;
        $q->jenis = $request->jenis;
        $q->description = $request->description;
        $q->image = $filename ?? "";
        $q->status = "Pending";
        $q->save();
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Izin::findOrFail($id);
        return view('pegawai.izin.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Izin $izin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Izin $izin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Izin $izin)
    {
        //
    }
}
