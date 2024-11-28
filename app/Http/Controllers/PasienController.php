<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; 
use App\Models\User; 
use Illuminate\Support\Facades\Storage;
use App\Exports\PatientsExport;
use Maatwebsite\Excel\Facades\Excel;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $patients = Pasien::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%");
        })->paginate(10); // Ensure you are using paginate here
    
        return view('superadmin.pasien', compact('patients'));
    }

    public function store(Request $request)
    {
        // Validate and save patient data
        $request->validate([
            'tanggal' => 'required|date',
            'id_kru' => 'required|exists:users,id',
            'id_koordinator' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'photo' => 'image|nullable|max:2048',
        ]);

        // Create new Pasien record
        $patient = new Pasien();
        $patient->tanggal = $request->tanggal;
        $patient->id_kru = $request->id_kru;
        $patient->id_koordinator = $request->id_koordinator;
        $patient->nama = $request->nama;
        $patient->alamat = $request->alamat;
        $patient->tujuan = $request->tujuan;
        $patient->keterangan = $request->keterangan;

        // Process file upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $patient->photo = $path;
        }

        $patient->save();
        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function storeSuper(Request $request)
    {
        // Validate and save patient data
        $request->validate([
            'tanggal' => 'required|date',
            'id_kru' => 'required|exists:users,id',
            'id_koordinator' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'photo' => 'image|nullable|max:2048',
        ]);

        // Create new Pasien record
        $patient = new Pasien();
        $patient->tanggal = $request->tanggal;
        $patient->id_kru = $request->id_kru;
        $patient->id_koordinator = $request->id_koordinator;
        $patient->nama = $request->nama;
        $patient->alamat = $request->alamat;
        $patient->tujuan = $request->tujuan;
        $patient->keterangan = $request->keterangan;

        // Process file upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $patient->photo = $path;
        }

        $patient->save();
        return redirect()->route('superadmin.pasien')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $patient = Pasien::findOrFail($id);
        $drivers = User::where('role', 'admin')->get();
        $coordinators = User::where('role', 'superAdmin')->get();

        return view('admin.edit_pasien', compact('patient', 'drivers', 'coordinators'));
    }

    public function editSuper($id)
    {
        $patient = Pasien::findOrFail($id);
        $drivers = User::where('role', 'admin')->get();
        $coordinators = User::where('role', 'superAdmin')->get();

        return view('superadmin.edit_pasien', compact('patient', 'drivers', 'coordinators'));
    }

    public function update(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'tanggal' => 'required|date',
            'id_kru' => 'required|exists:users,id',
            'id_koordinator' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'photo' => 'image|nullable|max:2048',
        ]);

        // Retrieve the patient record to update
        $patient = Pasien::findOrFail($id);
        $patient->tanggal = $request->tanggal;
        $patient->id_kru = $request->id_kru;
        $patient->id_koordinator = $request->id_koordinator;
        $patient->nama = $request->nama;
        $patient->alamat = $request->alamat;
        $patient->tujuan = $request->tujuan;
        $patient->keterangan = $request->keterangan;

        // Handle file upload if a new photo is provided
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($patient->photo) {
                Storage::disk('public')->delete($patient->photo);
            }
            // Store the new photo
            $path = $request->file('photo')->store('photos', 'public');
            $patient->photo = $path;
        }

        $patient->save();
        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function updateSuper(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'tanggal' => 'required|date',
            'id_kru' => 'required|exists:users,id',
            'id_koordinator' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'photo' => 'image|nullable|max:2048',
        ]);

        // Retrieve the patient record to update
        $patient = Pasien::findOrFail($id);
        $patient->tanggal = $request->tanggal;
        $patient->id_kru = $request->id_kru;
        $patient->id_koordinator = $request->id_koordinator;
        $patient->nama = $request->nama;
        $patient->alamat = $request->alamat;
        $patient->tujuan = $request->tujuan;
        $patient->keterangan = $request->keterangan;

        // Handle file upload if a new photo is provided
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($patient->photo) {
                Storage::disk('public')->delete($patient->photo);
            }
            // Store the new photo
            $path = $request->file('photo')->store('photos', 'public');
            $patient->photo = $path;
        }

        $patient->save();
        return redirect()->route('superadmin.pasien')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $patient = Pasien::findOrFail($id);
        // Hapus foto jika ada
        if ($patient->photo) {
            Storage::disk('public')->delete($patient->photo);
        }
        $patient->delete();
        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function destroySuper($id)
    {
        $patient = Pasien::findOrFail($id);
        // Hapus foto jika ada
        if ($patient->photo) {
            Storage::disk('public')->delete($patient->photo);
        }
        $patient->delete();
        return redirect()->route('superadmin.pasien')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function cetak()
    {
        $patients = Pasien::all();
        return view('superadmin.pasien.cetak', compact('patients'));
    }

    public function showGrafik()
    {
        $dailyData = Pasien::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->get();
    
        $monthlyData = Pasien::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->get()
            ->map(function ($d) {
                return [
                    'label' => $d->year . '-' . str_pad($d->month, 2, '0', STR_PAD_LEFT),
                    'total' => $d->total,
                ];
            });
    
        $yearlyData = Pasien::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->groupBy('year')
            ->get();
    
        return view('grafik', compact('dailyData', 'monthlyData', 'yearlyData'));
    }
    
    public function export()
    {
        return Excel::download(new PatientsExport, 'pasien.xlsx');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.pasien');
        } elseif ($user->role === 'superadmin') {
            return redirect()->route('superadmin.pasien');
        }
    }
}
