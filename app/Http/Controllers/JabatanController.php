<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Jabatan';
        $data = Jabatan::latest()->get();
        return view('admin.jabatan.index',compact('title','data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Jabatan';
        return view('admin.jabatan.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $q = new Jabatan();
        $q->name = $request->name;
        $q->save();
        return response()->json(['success' => true]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Jabatan::findOrFail($id);
        $title = 'Edit Jabatan';
        return view('admin.jabatan.edit',compact('title','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $q = Jabatan::findOrFail($id);
        $q->name = $request->name;
        $q->save();
        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $q = Jabatan::findOrFail($request->id);
        $q->delete();
        return response()->json(['success' => true]);
    }
}
