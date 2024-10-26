@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    @if(Auth::user()->role === 'superadmin')
        <h2>Super Admin Menu</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="{{ route('superadmin.pasien') }}">Data Pasien</a>
                <ul>
                    <li><a href="{{ route('superadmin.pasien') }}">Halaman Data Pasien (Cetak/Unduh)</a></li>
                    <li><a href="{{ route('superadmin.pasien.create') }}">Tambah Data Pasien</a></li>
                </ul>
            </li>
            <li class="list-group-item">
                <a href="{{ route('superadmin.biaya') }}">Biaya Operasional</a>
                <ul>
                    <li><a href="{{ route('superadmin.biaya') }}">Lihat (Cetak/Unduh)</a></li>
                    <li><a href="{{ route('superadmin.biaya.create') }}">Tambah</a></li>
                </ul>
            </li>
            <li class="list-group-item">
                <a href="{{ route('superadmin.jadwal') }}">Jadwal</a>
                <ul>
                    <li><a href="{{ route('superadmin.jadwal') }}">Lihat</a></li>
                    <li><a href="{{ route('superadmin.jadwal.create') }}">Tambah</a></li>
                </ul>
            </li>
            <li class="list-group-item">
                <a href="{{ route('superadmin.user.create') }}">Manage User</a>
                <ul>
                    <li><a href="{{ route('superadmin.user.create') }}">Tambah User Admin</a></li>
                </ul>
            </li>
        </ul>
    @elseif(Auth::user()->role === 'admin')
        <h2>Admin Menu</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="{{ route('admin.pasien') }}">Data Pasien</a>
                <ul>
                    <li><a href="{{ route('admin.pasien') }}">Halaman Data Pasien</a></li>
                    <li><a href="{{ route('admin.pasien.create') }}">Tambah Data Pasien</a></li>
                </ul>
            </li>
            <li class="list-group-item">
                <a href="{{ route('admin.biaya') }}">Biaya Operasional</a>
                <ul>
                    <li><a href="{{ route('admin.biaya') }}">Lihat</a></li>
                    <li><a href="{{ route('admin.biaya.create') }}">Tambah</a></li>
                </ul>
            </li>
            <li class="list-group-item">
                <a href="{{ route('admin.jadwal') }}">Jadwal</a>
                <ul>
                    <li><a href="{{ route('admin.jadwal') }}">Lihat</a></li>
                </ul>
            </li>
        </ul>
    @endif
</div>
@endsection
