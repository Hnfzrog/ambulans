@extends('layouts.app')

@section('content')
<style>
    .container{
        min-height:70vh /* Light background for contrast */
    }
</style>

<h1 class="text-center mt-4 mb-4">Tambah Jadwal Operasional</h1>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('superadmin.jadwal.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" required>
            @error('tanggal')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pukul" class="form-label">Pukul</label>
            <input type="time" name="pukul" class="form-control" id="pukul" required>
            @error('pukul')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" name="tujuan" class="form-control" id="tujuan" placeholder="Tujuan" required>
            @error('tujuan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kru" class="form-label">Kru</label>
            <select id="kru" name="kru" class="form-select" required>
                <option value="" disabled selected>Pilih Kru</option>
                @foreach ($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
            @error('kru')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
            <a href="{{ route('superadmin.jadwal') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

@endsection
