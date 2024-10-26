<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        // Mengambil jadwal yang hanya dalam 24 jam
        $jadwal = Jadwal::where('tanggal', '>=', now())->get();
        return view('jadwal', compact('jadwal'));
    }

    public function create()
    {
        return view('jadwal_create'); // Buat view untuk menambah data
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pukul' => 'required|date_format:H:i',
            'tujuan' => 'required|string',
        ]);

        // Simpan jadwal
        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = Jadwal::findOrFail($id);
        return view('jadwal_edit', compact('item')); // Buat view untuk edit data
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pukul' => 'required|date_format:H:i',
            'tujuan' => 'required|string',
        ]);

        $item = Jadwal::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy($id)
    {
        $item = Jadwal::findOrFail($id);
        $item->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
