@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Super Admin Dashboard</h1>
    <ul>
        <li><a href="{{ route('superadmin.pasien') }}">Data Pasien</a></li>
        <li><a href="{{ route('superadmin.biaya') }}">Biaya Operasional</a></li>
        <li><a href="{{ route('superadmin.jadwal') }}">Jadwal</a></li>
        <li><a href="{{ route('superadmin.users.tambah') }}">Manage User</a></li>
    </ul>
</div>
@endsection
