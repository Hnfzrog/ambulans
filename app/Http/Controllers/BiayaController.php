<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BiayaController extends Controller
{
    public function index()
    {
        $biayaOperasional = Biaya::all();
        return view('biaya_operasional', compact('biayaOperasional'));
    }

    public function create()
    {
        return view('biaya_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'uang_masuk' => 'required|numeric',
            'uang_keluar' => 'required|numeric',
        ]);

        Biaya::create($request->all());

        return redirect()->route('biaya.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $operasional = Biaya::findOrFail($id);
        return view('biaya_edit', compact('operasional'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'uang_masuk' => 'required|numeric',
            'uang_keluar' => 'required|numeric',
        ]);

        $operasional = Biaya::findOrFail($id);
        $operasional->update($request->all());

        return redirect()->route('biaya.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $operasional = Biaya::findOrFail($id);
        $operasional->delete();

        return redirect()->route('biaya.index')->with('success', 'Data berhasil dihapus');
    }

    public function cetak()
        {
            $operasional = Biaya::Pasien::all(); 
            return view('superadmin.biaya.cetak', compact('biayaOperasional'));
        }

}
