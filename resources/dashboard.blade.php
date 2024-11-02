{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<div class="container">
    <h1 class="mb-4">Dashboard admin</h1>

    
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
</div>
{{-- @endsection --}}
