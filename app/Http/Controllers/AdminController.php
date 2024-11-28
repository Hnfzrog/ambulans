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
        $query = Biaya::query();
    
        // Apply filters if present
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
    
        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', '%' . $request->keterangan . '%');
        }
    
        // Pagination with 10 items per page
        $biayaOperasional = $query->paginate(10);
    
        return view('admin.biaya', compact('biayaOperasional'));
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
