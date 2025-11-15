<?php

namespace App\Http\Controllers;

use App\Models\LokasiPenempatan;
use App\Models\RadiusKantor;
use Illuminate\Http\Request;

class RadiusKantorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Radius Kantor';
        $data = RadiusKantor::latest()->get();
        return view('admin.radius.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Radius Kantor';
        $locations = LokasiPenempatan::all();
        return view('admin.radius.create',compact('title','locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $q = new RadiusKantor();
        $q->lokasi_penempatan_id = $request->lokasi_penempatan_id;
        $q->lat = $request->lat;
        $q->long = $request->long;
        $q->radius = $request->radius;
        $q->save();
        return response()->json(['success' => true]);

    }

    /**
     * Display the specified resource.
     */
    public function show(RadiusKantor $radiusKantor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = RadiusKantor::findOrFail($id);
        $title = 'Edit Radius Kantor';
        $locations = LokasiPenempatan::all();
        return view('admin.radius.edit',compact('title','data','locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $q = RadiusKantor::findOrFail($id);
        $q->lokasi_penempatan_id = $request->lokasi_penempatan_id;
        $q->lat = $request->lat;
        $q->long = $request->long;
        $q->radius = $request->radius;
        $q->save();
        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $q = RadiusKantor::findOrFail($request->id);
        $q->delete();
        return response()->json(['success' => true]);
    }
}
