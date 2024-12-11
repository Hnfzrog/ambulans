<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Biaya;
use App\Models\User;
use App\Models\Jadwal;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function pasienIndex(Request $request)
    {
        $search = $request->get('search');
        $patients = Pasien::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%");
        })->paginate(10); // Ensure you are using paginate here

        return view('admin.pasien', compact('patients'));
    }


    public function pasienCreate()
    {
        $drivers = User::where('role', 'admin')->get();
        $coordinators = User::where('role', 'superadmin')->get(); // Adjust the query if needed

        return view('admin.pasien_create', compact('drivers', 'coordinators'));
    }


    public function biayaIndex(Request $request)
    {
        $search = $request->get('search');
        $tanggal = $request->get('tanggal'); // Get the date input if available

        // Filter data based on search and date
        $biayaOperasional = Biaya::when($search, function ($query) use ($search) {
            $query->where('keterangan', 'like', "%{$search}%"); // Search by description
        })->when($tanggal, function ($query) use ($tanggal) {
            $query->whereDate('tanggal', $tanggal); // Search by date
        })->paginate(10);

        // Calculate totals for the filtered dataset
        $totalUangMasuk = Biaya::when($search, function ($query) use ($search) {
            $query->where('keterangan', 'like', "%{$search}%"); // Filter for calculation
        })->when($tanggal, function ($query) use ($tanggal) {
            $query->whereDate('tanggal', $tanggal); // Filter for calculation
        })->sum('uang_masuk');

        $totalUangKeluar = Biaya::when($search, function ($query) use ($search) {
            $query->where('keterangan', 'like', "%{$search}%"); // Filter for calculation
        })->when($tanggal, function ($query) use ($tanggal) {
            $query->whereDate('tanggal', $tanggal); // Filter for calculation
        })->sum('uang_keluar');

        $totalSaldo = $totalUangMasuk - $totalUangKeluar;

        return view('admin.biaya', compact('biayaOperasional', 'totalUangMasuk', 'totalUangKeluar', 'totalSaldo'));
    }
    
    public function biayaCreate()
    {
        $drivers = User::where('role', 'admin')->get();
        $coordinators = User::where('role', 'superadmin')->get(); // Adjust the query if needed

        return view('admin.biaya_create', compact('drivers', 'coordinators'));
    }

    public function jadwalIndex(Request $request)
    {
        $query = Jadwal::query();
    
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->input('tanggal'));
        }
    
        if ($request->filled('tujuan')) {
            $query->where('tujuan', 'like', '%' . $request->input('tujuan') . '%');
        }
    
        $jadwal = $query->paginate(10);
    
        return view('admin.jadwal', compact('jadwal'));
    }
    
    public function jadwalCreate()
    {
        return view('admin.jadwal.create');
    }
}
