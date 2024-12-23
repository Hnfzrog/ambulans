@extends('layouts.app')

@section('content')
<style>
    .container{
        min-height:70vh /* Light background for contrast */
    }
</style>
<h1 class="text-center mt-4 mb-4">Edit Biaya Operasional</h1>

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

    <form action="{{ route('admin.biaya.update', $operasional->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ $operasional->tanggal }}" required>
        </div>

        <div class="row g-3">
            <div class="col-md">
                <label for="id_kru" class="form-label">ID Kru</label>
                <select id="id_kru" name="id_kru" class="form-select" required>
                    <option value="" disabled selected>Pilih Driver</option>
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ $driver->id == $operasional->id_kru ? 'selected' : '' }}>{{ $driver->name }}</option>
                    @endforeach
                </select>
                @error('id_kru')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md">
                <label for="id_koordinator" class="form-label">ID Koordinator</label>
                <select id="id_koordinator" name="id_koordinator" class="form-select" required>
                    <option value="" disabled selected>Pilih Koordinator</option>
                    @foreach ($coordinators as $coordinator)
                        <option value="{{ $coordinator->id }}" {{ $coordinator->id == $operasional->id_koordinator ? 'selected' : '' }}>{{ $coordinator->name }}</option>
                    @endforeach
                </select>
                @error('id_koordinator')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" id="keterangan" value="{{ old('keterangan', $operasional->keterangan) }}" placeholder="Keterangan" required>
            @error('keterangan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="uang_masuk" class="form-label">Uang Masuk</label>
            <input type="number" name="uang_masuk" class="form-control" id="uang_masuk" value="{{ old('uang_masuk', $operasional->uang_masuk) }}" placeholder="Rp." required>
            @error('uang_masuk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="uang_keluar" class="form-label">Uang Keluar</label>
            <input type="number" name="uang_keluar" class="form-control" id="uang_keluar" value="{{ old('uang_keluar', $operasional->uang_keluar) }}" placeholder="Rp." required>
            @error('uang_keluar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.biaya') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

@endsection
