@extends('layouts.app')

@section('content')
<style>
    .container{
        min-height:70vh /* Light background for contrast */
    }
</style>
<div class="container">
    <h1 class="my-4 text-center">Edit Data Pasien</h1>

    <form action="{{ route('admin.pasien.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ $patient->tanggal }}" required>
        </div>

        <div class="row g-3">
            <div class="col-md mb-3">
                <label for="id_kru" class="form-label">ID Kru</label>
                <select id="id_kru" name="id_kru" class="form-select" required>
                    <option value="" disabled selected>Pilih Driver</option>
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ $driver->id == $patient->id_kru ? 'selected' : '' }}>{{ $driver->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md mb-3">
                <label for="id_koordinator" class="form-label">ID Koordinator</label>
                <select id="id_koordinator" name="id_koordinator" class="form-select" required>
                    <option value="" disabled selected>Pilih Koordinator</option>
                    @foreach ($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}" {{ $coordinator->id == $patient->id_koordinator ? 'selected' : '' }}>{{ $coordinator->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Pasien</label>
            <input type="text" name="nama" class="form-control" id="nama" value="{{ $patient->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Pasien</label>
            <input type="text" name="alamat" class="form-control" id="alamat" value="{{ $patient->alamat }}" required>
        </div>

        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" name="tujuan" class="form-control" id="tujuan" value="{{ $patient->tujuan }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" id="keterangan" value="{{ $patient->keterangan }}">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Dokumentasi</label>
            <input class="form-control" name="photo" type="file" id="photo">
            @if ($patient->photo)
                <img src="{{ asset('storage/' . $patient->photo) }}" alt="Patient Photo" width="100" class="mt-2">
            @endif
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.pasien') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
