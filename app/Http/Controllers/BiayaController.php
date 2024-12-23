<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BiayaExport;

class BiayaController extends Controller
{
    public function index(Request $request)
    {
        // Initialize the query
        $query = Biaya::query();

        dd($request);
    
        // Apply search filter if the "search" parameter is provided
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }
    
        // Apply date filter if the "start_date" parameter is provided
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }
    
        // Paginate the filtered results
        $biayaOperasional = $query->paginate(10);
    
        // Calculate total amounts
        $totalUangMasukAll = $query->sum('uang_masuk');
        $totalUangKeluarAll = $query->sum('uang_keluar');
        $totalSaldoAll = $totalUangMasukAll - $totalUangKeluarAll;
    
        // Return the view with the filtered data and totals
        return view('admin.biaya', compact(
            'biayaOperasional',
            'totalUangMasukAll',
            'totalUangKeluarAll',
            'totalSaldoAll'
        ));
    }

    public function indexSuper(Request $request)
    {
        // Start the base query
        $query = Biaya::query();
    
        // Clone the query for totals calculation
        $totalsQuery = clone $query;
    
        // Calculate total amounts
        $totalUangMasukAll = $totalsQuery->sum('uang_masuk');
        $totalUangKeluarAll = $totalsQuery->sum('uang_keluar');
        $totalSaldoAll = $totalUangMasukAll - $totalUangKeluarAll;
        
        // Search by 'keterangan' if the user submits the search input
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }
        
        // Filter by date range if the user selects a start date
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }
    
        // Paginate the result and append query parameters to pagination links
        $biayaOperasional = $query->paginate(10)->appends($request->all());
    
        // Return the filtered data along with totals to the view
        return view('superadmin.biaya', compact(
            'biayaOperasional',
            'totalUangMasukAll',
            'totalUangKeluarAll',
            'totalSaldoAll'
        ));
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
