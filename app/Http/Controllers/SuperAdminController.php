<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function pasienIndex()
    {
        return view('superadmin.pasien.index');
    }

    public function pasienCreate()
    {
        return view('superadmin.pasien.create');
    }

    public function biayaIndex()
    {
        return view('superadmin.biaya.index');
    }

    public function biayaCreate()
    {
        return view('superadmin.biaya.create');
    }

    public function jadwalIndex()
    {
        return view('superadmin.jadwal.index');
    }

    public function jadwalCreate()
    {
        return view('superadmin.jadwal.create');
    }

    public function createUser()
    {
        return view('superadmin.user.create');
    }
}
