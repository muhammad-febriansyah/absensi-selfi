<?php

namespace App\Http\Controllers;

use App\Models\LokasiPenempatan;
use Illuminate\Http\Request;

class LokasiPenempatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Lokasi Penempatan';
        $data = LokasiPenempatan::latest()->get();
        return view('admin.lokasi.index',compact('title','data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Lokasi Penempatan';
        return view('admin.lokasi.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $q = new LokasiPenempatan();
        $q->name = $request->name;
        $q->save();
        return response()->json(['success' => true]);

    }

    /**
     * Display the specified resource.
     */
    public function show(LokasiPenempatan $lokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = LokasiPenempatan::findOrFail($id);
        $title = 'Edit Lokasi Penempatan';
        return view('admin.lokasi.edit',compact('title','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $q = LokasiPenempatan::findOrFail($id);
        $q->name = $request->name;
        $q->save();
        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $q = LokasiPenempatan::findOrFail($request->id);
        $q->delete();
        return response()->json(['success' => true]);
    }
}
