@extends('layouts.app')

@section('content')
<div class="container">
        <h1>Tambah Data Pasien</h1>
        
        <form action="{{ route('admin.pasien.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control bg-success p-2 text-dark bg-opacity-25" id="formGroupExampleInput" required>
            </div>
            <div class="row g-2">
                <div class="col-md mb-3">
                    <label for="inputState" class="form-label">id kru</label>
                    <select id="inputState" name="id_kru" class="form-select bg-success p-2 text-dark bg-opacity-25">
                        <option selected>Driver</option>
                        <option value="1">01 Nursalim</option>
                        <option value="2">02 Ahmad Khotim</option>
                        <option value="3">03 Muhrodin</option>
                        <option value="3">04 Dwika Aulia</option>
                        <option value="3">05 Andri Kurniawan</option>
                        <option value="3">06 Muhson</option>
                    </select>
                </div>
                <div class="col-md mb-3">
                    <label for="inputState" class="form-label">id koordinator</label>
                    <select id="inputState" name="id_koordinator" class="form-select bg-success p-2 text-dark bg-opacity-25">
                        <option selected>Koordinator</option>
                        <option value="1">01 Muhson</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Nama Pasien</label>
                <input type="text" name="nama_pasien" class="form-control bg-success p-2 text-dark bg-opacity-25"
                    id="formGroupExampleInput2" placeholder="Nama Lengkap"required>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Alamat Pasien</label>
                <input type="text" name="alamat_pasien" class="form-control bg-success p-2 text-dark bg-opacity-25"
                    id="formGroupExampleInput2" placeholder="Alamat Pasien" required>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Tujuan</label>
                <input type="text" name="tujuan" class="form-control bg-success p-2 text-dark bg-opacity-25"
                    id="formGroupExampleInput2" placeholder="Tujuan"required>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control bg-success p-2 text-dark bg-opacity-25"
                    id="formGroupExampleInput2" placeholder="Keterangan">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Dokumentasi</label>
                <input class="form-control bg-success p-2 text-dark bg-opacity-25" name="unggah_gambar" type="file" id="formFile">
            </div>

            <button type="submit" class="btn btn-success mb-4">Simpan</button>
            <a href="{{ route('admin.pasien') }}" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
@endsection