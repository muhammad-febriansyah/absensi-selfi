<?php

namespace App\Http\Controllers;

use App\Models\JamKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JamKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Jam Kerja';
        $data = JamKerja::latest()->get();
        return view('admin.jamkerja.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Jam Kerja';
        return view('admin.jamkerja.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'in' => 'required|date_format:H:i',
            'out' => 'required|date_format:H:i',
        ]);

        // Get the time inputs
        $in = $request->input('in');
        $out = $request->input('out');
        $lembur = $request->input('lembur');

        // Format the times
        try {
            $formattedTime = Carbon::createFromFormat('H:i', $in)->format('H:i:s');
            $formattedTime2 = Carbon::createFromFormat('H:i', $out)->format('H:i:s');
            $formattedTime3 = Carbon::createFromFormat('H:i', $lembur)->format('H:i:s');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Invalid time format.']);
        }

        // Update the first record
        $q = new JamKerja();
        if ($q) {
            $q->in = $formattedTime;
            $q->out = $formattedTime2;
            $q->lembur = $formattedTime3;
            $q->save();
        } else {
            return response()->json(['success' => false, 'error' => 'No record found.']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(JamKerja $jamKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = JamKerja::findOrFail($id);
        $title = 'Form Jam Kerja';
        return view('admin.jamkerja.edit', compact('title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'in' => 'required|date_format:H:i',
            'out' => 'required|date_format:H:i',
        ]);

        // Get the time inputs
        $in = $request->input('in');
        $out = $request->input('out');
        $lembur = $request->input('lembur');

        // Format the times
        try {
            $formattedTime = Carbon::createFromFormat('H:i', $in)->format('H:i:s');
            $formattedTime2 = Carbon::createFromFormat('H:i', $out)->format('H:i:s');
            $formattedTime3 = Carbon::createFromFormat('H:i', $lembur)->format('H:i:s');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Invalid time format.']);
        }

        // Update the first record
        $q = JamKerja::findOrFail($id);
        if ($q) {
            $q->in = $formattedTime;
            $q->out = $formattedTime2;
            $q->lembur = $formattedTime3;
            $q->save();
        } else {
            return response()->json(['success' => false, 'error' => 'No record found.']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $q = JamKerja::findOrFail($request->id);
        $q->delete();
        return response()->json(['success' => true]);
    }
}
