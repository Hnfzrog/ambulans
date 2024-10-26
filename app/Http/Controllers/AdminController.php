<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function pasienIndex()
    {
        return view('admin.pasien.index');
    }

    public function pasienCreate()
    {
        return view('admin.pasien.create');
    }

    public function biayaIndex()
    {
        return view('admin.biaya.index');
    }

    public function biayaCreate()
    {
        return view('admin.biaya.create');
    }

    public function jadwalIndex()
    {
        return view('admin.jadwal.index');
    }
    public function jadwalCreate()
    {
        return view('admin.jadwal.create');
    }
}
