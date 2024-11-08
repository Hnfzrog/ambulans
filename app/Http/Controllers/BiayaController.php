<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BiayaExport;

class BiayaController extends Controller
{
    public function index()
    {
        $biayaOperasional = Biaya::all();
        return view('admin.biaya', compact('biayaOperasional'));
    }

    public function indexSuper(Request $request)
    {
        $query = Biaya::query();

        // Search by keterangan
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }

        $biayaOperasional = $query->paginate(10);

        return view('superadmin.biaya', compact('biayaOperasional'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_kru' => 'required|exists:users,id', // Adjust based on your user table
            'id_koordinator' => 'required|exists:users,id',
            'keterangan' => 'required|string|max:255',
            'uang_masuk' => 'required|numeric|min:0',
            'uang_keluar' => 'required|numeric|min:0',
        ]);

        Biaya::create($request->all());
        return redirect()->route('admin.biaya')->with('success', 'Data berhasil ditambahkan');
    }
    public function storeSuper(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_kru' => 'required|exists:users,id', // Adjust based on your user table
            'id_koordinator' => 'required|exists:users,id',
            'keterangan' => 'required|string|max:255',
            'uang_masuk' => 'required|numeric|min:0',
            'uang_keluar' => 'required|numeric|min:0',
        ]);

        Biaya::create($request->all());
        return redirect()->route('superadmin.biaya')->with('success', 'Data berhasil ditambahkan');
    }
    

   public function edit($id)
    {
        $operasional = Biaya::findOrFail($id);
        $drivers = User::where('role', 'admin')->get();
        $coordinators = User::where('role', 'superAdmin')->get();

        return view('admin.biaya_edit', compact('operasional', 'drivers', 'coordinators'));
    }

   public function editSuper($id)
    {
        $operasional = Biaya::findOrFail($id);
        $drivers = User::where('role', 'admin')->get();
        $coordinators = User::where('role', 'superAdmin')->get();

        return view('superadmin.biaya_edit', compact('operasional', 'drivers', 'coordinators'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'uang_masuk' => 'required|numeric|min:0',
            'uang_keluar' => 'required|numeric|min:0',
        ]);

        $operasional = Biaya::findOrFail($id);
        $operasional->update($request->all());

        return redirect()->route('admin.biaya')->with('success', 'Data berhasil diupdate');
    }

    public function updateSuper(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'uang_masuk' => 'required|numeric|min:0',
            'uang_keluar' => 'required|numeric|min:0',
        ]);

        $operasional = Biaya::findOrFail($id);
        $operasional->update($request->all());

        return redirect()->route('superadmin.biaya')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $operasional = Biaya::findOrFail($id);
        $operasional->delete();

        return redirect()->route('admin.biaya')->with('success', 'Data berhasil dihapus');
    }

    public function destroySuper($id)
    {
        $operasional = Biaya::findOrFail($id);
        $operasional->delete();

        return redirect()->route('superadmin.biaya')->with('success', 'Data berhasil dihapus');
    }

    public function cetak()
    {
        $biayaOperasional = Biaya::all();
        return view('superadmin.biaya.cetak', compact('biayaOperasional'));
    }

    public function exportExcel()
    {
        return Excel::download(new BiayaExport, 'biaya-operasional-ambulan.xlsx');
    }
}
