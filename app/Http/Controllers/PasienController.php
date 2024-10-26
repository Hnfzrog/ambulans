<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienController extends Controller
    {
        public function index()
        {
            $patients = Pasien::all(); // Ambil semua data pasien
            return view('superadmin.data_pasien', compact('patients'));
        }
    
        // Tambahkan metode lainnya untuk create, edit, store, update, dan destroy
        public function create()
        {
            return view('superadmin.create_pasien');
        }
    
        public function store(Request $request)
        {
            // Validasi dan simpan data pasien
            // Misalnya:
            $request->validate([
                'name' => 'required',
                'alamat' => 'required',
                'tujuan' => 'required',
                'keterangan' => 'nullable',
                'photo' => 'image|nullable|max:2048', // validasi foto
            ]);
    
            $patient = new Pasien();
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->purpose = $request->purpose;
            $patient->notes = $request->notes;
    
            // Proses upload foto
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('photos', 'public');
                $patient->photo = $path;
            }
    
            $patient->save();
            return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil ditambahkan.');
        }
    
        public function edit($id)
        {
            $patient = Pasien::findOrFail($id);
            return view('admin.edit_pasien', compact('patient'));
        }
    
        public function update(Request $request, $id)
        {
            // Validasi dan update data pasien
            $request->validate([
                'nama' => 'required',
                'alamat' => 'required',
                'tujuan' => 'required',
                'keterangan' => 'nullable',
                'photo' => 'image|nullable|max:2048', // validasi foto
            ]);
    
            $patient = Pasien::findOrFail($id);
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->purpose = $request->purpose;
            $patient->notes = $request->notes;
    
            // Proses upload foto jika ada
            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($patient->photo) {
                    Storage::disk('public')->delete($patient->photo);
                }
                $path = $request->file('photo')->store('photos', 'public');
                $patient->photo = $path;
            }
    
            $patient->save();
            return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil diperbarui.');
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

        public function cetak()
        {
            $patients = Pasien::Pasien::all();
            return view('superadmin.pasien.cetak', compact('patients'));
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