<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; 
use App\Models\User; 
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $patients = Pasien::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%");
        })->paginate(10);

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

        // Process file upload and store in public/photos
        if ($request->hasFile('photo')) {
            $filename = time() . '-' . $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->move(public_path('photos'), $filename);
            $patient->photo = 'photos/' . $filename;
        }

        $patient->save();
        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil ditambahkan.');
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
            if ($patient->photo && file_exists(public_path($patient->photo))) {
                unlink(public_path($patient->photo));
            }

            // Store the new photo in public/photos
            $filename = time() . '-' . $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->move(public_path('photos'), $filename);
            $patient->photo = 'photos/' . $filename;
        }

        $patient->save();
        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $patient = Pasien::findOrFail($id);

        // Delete photo if it exists
        if ($patient->photo && file_exists(public_path($patient->photo))) {
            unlink(public_path($patient->photo));
        }

        $patient->delete();
        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil dihapus.');
    }
}
