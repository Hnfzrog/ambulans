<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal; 
use App\Models\User; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalExport;

class JadwalController extends Controller
{
    public function index()
    {
        // Mengambil jadwal yang hanya dalam 24 jam
        $jadwal = Jadwal::where('tanggal', '>=', now())->get();
        return view('jadwal', compact('jadwal'));
    }

    public function indexSuper(Request $request)
    {
        // Get the search input
        $searchTanggal = $request->get('tanggal');
        $searchTujuan = $request->get('tujuan');

        // Query jadwal with optional search parameters
        $jadwal = Jadwal::when($searchTanggal, function ($query, $searchTanggal) {
                return $query->whereDate('tanggal', $searchTanggal);
            })
            ->when($searchTujuan, function ($query, $searchTujuan) {
                return $query->where('tujuan', 'like', '%' . $searchTujuan . '%');
            })
            ->paginate(10); // Adjust the number of items per page as needed

        return view('jadwal', compact('jadwal', 'searchTanggal', 'searchTujuan'));
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

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pukul' => 'required|date_format:H:i',
            'tujuan' => 'required|string',
            'kru' => 'required|exists:users,id',  // Ensure selected kru exists
        ]);

        Jadwal::create([
            'tanggal' => $request->tanggal,
            'pukul' => $request->pukul,
            'tujuan' => $request->tujuan,
            'id_kru' => $request->kru, // assuming the 'kru_id' column in `jadwal` table
        ]);

        return redirect()->route('superadmin.jadwal')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $drivers = User::where('role', 'admin')->get();
        return view('superadmin.jadwal_edit', compact('jadwal', 'drivers')); // Buat view untuk edit data
    }

    public function update(Request $request, $id)
    {
        // Temukan jadwal yang ingin diupdate
        $jadwal = Jadwal::findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'pukul' => 'nullable|date_format:H:i', // Use nullable
            'tujuan' => 'required|string',
            'kru' => 'required|exists:users,id',
        ]);

        // Update data
        $jadwal->update([
            'tanggal' => $validatedData['tanggal'],
            'pukul' => $request->pukul ? $request->pukul . ':00' : $jadwal->pukul, // Append ':00' for seconds
            'tujuan' => $validatedData['tujuan'],
            'id_kru' => $validatedData['kru'],
        ]);

        return redirect()->route('superadmin.jadwal')->with('success', 'Jadwal berhasil diupdate');
    }


    public function destroy($id)
    {
        $item = Jadwal::findOrFail($id);
        $item->delete();

        return redirect()->route('superadmin.jadwal')->with('success', 'Jadwal berhasil dihapus');
    }

    public function exportExcel()
    {
        return Excel::download(new JadwalExport, 'biaya-operasional-ambulan.xlsx');
    }
}
