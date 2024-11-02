@extends('layouts.app')

@section('content')
<style>
    .container{
        min-height:70vh /* Light background for contrast */
    }
</style>
<div class="container mt-4">
    <h1 class="mb-4">Tambah Data Pasien</h1>
    
    <form action="{{ route('admin.pasien.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control bg-light p-2" id="formGroupExampleInput" required>
        </div>

        <div class="row g-3">
            <div class="col-md">
                <label for="id_kru" class="form-label">ID Kru</label>
                <select id="id_kru" name="id_kru" class="form-select bg-light p-2" required>
                    <option value="" disabled selected>Pilih Driver</option>
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <label for="id_koordinator" class="form-label">ID Koordinator</label>
                <select id="id_koordinator" name="id_koordinator" class="form-select bg-light p-2" required>
                    <option value="" disabled selected>Pilih Koordinator</option>
                    @foreach ($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}">{{ $coordinator->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Pasien</label>
            <input type="text" name="nama" class="form-control bg-light p-2" id="nama" placeholder="Nama Lengkap" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Pasien</label>
            <input type="text" name="alamat" class="form-control bg-light p-2" id="alamat" placeholder="Alamat Pasien" required>
        </div>
        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" name="tujuan" class="form-control bg-light p-2" id="tujuan" placeholder="Tujuan" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control bg-light p-2" id="keterangan" placeholder="Keterangan">
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Dokumentasi</label>
            <input class="form-control bg-light p-2" name="photo" type="file" id="photo">
        </div>

        <button type="submit" class="btn btn-success mb-4">Simpan</button>
        <a href="{{ route('admin.pasien') }}" class="btn btn-secondary mb-4">Kembali</a>
    </form>
</div>
@endsection
