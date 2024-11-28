<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Pasien;
use App\Models\Biaya;
use App\Models\User;
use App\Models\Jadwal;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function pasienIndex(Request $request)
    {
        $search = $request->get('search');
        $patients = Pasien::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%");
        })->paginate(10);
    
        return view('superadmin.pasien', compact('patients'));
    }

    public function pasienCreate()
    {
        $drivers = User::where('role', 'admin')->get();
        $coordinators = User::where('role', 'superadmin')->get();
        return view('superadmin.pasien_create', compact('drivers', 'coordinators'));
    }

    public function biayaIndex(Request $request)
    {
        $search = $request->get('search');
        $tanggal = $request->get('tanggal'); // Get the date input if available

        $biayaOperasional = Biaya::when($search, function ($query) use ($search) {
            $query->where('keterangan', 'like', "%{$search}%"); // Search by description
        })->when($tanggal, function ($query) use ($tanggal) {
            $query->whereDate('tanggal', $tanggal); // Search by date
        })->paginate(10);
    
        return view('superadmin.biaya', compact('biayaOperasional'));
    }

    public function biayaCreate()
    {
        $drivers = User::where('role', 'admin')->get();
        $coordinators = User::where('role', 'superadmin')->get();

        return view('superadmin.biaya_create', compact('drivers', 'coordinators'));
    }

    public function jadwalIndex(Request $request)
    {
        $tanggal = $request->get('tanggal');
        $tujuan = $request->get('tujuan');
    
        $jadwal = Jadwal::when($tanggal, function ($query) use ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        })
        ->when($tujuan, function ($query) use ($tujuan) {
            $query->where('tujuan', 'like', "%{$tujuan}%");
        })
        ->paginate(10);
    
        return view('superadmin.jadwal', compact('jadwal', 'tanggal', 'tujuan'));
    }    

    public function jadwalCreate()
    {
        $drivers = User::where('role', 'admin')->get();
        return view('superadmin.jadwal_create', compact('drivers'));
    }

    public function createUser()
    {
        return view('superadmin.user_create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);
    
        return redirect()->route('superadmin.userIndex')->with('success', 'User baru berhasil ditambahkan.');
    }    
    
    public function userIndex(Request $request)
    {
        $search = $request->get('search');
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(10);
        
        return view('superadmin.user', compact('users'));
    }    

    public function updateUserRole(Request $request, User $user)
    {
        // Prevent role update for user with id = 3
        if ($user->id == 3) {
            return redirect()->route('superadmin.userIndex')->with('error', 'Cannot modify the role of this user.');
        }

        $request->validate([
            'role' => 'required|in:admin,superadmin',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('superadmin.userIndex')->with('success', 'User role updated successfully.');
    }
}
