@extends('layouts.app')

@section('content')

<h1 class="text-center mt-4 mb-4">Tambah Biaya Operasional</h1>
    
    <div class="container">
      <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Tanggal</label>
        <input type="text" class="form-control bg-success p-2 text-dark bg-opacity-25" id="formGroupExampleInput" placeholder="dd-mm-yyy">
      </div>
      <div class="row g-2">     
        <div class="col-md mb-3">
            <label for="inputState" class="form-label">id kru</label>
            <select id="inputState" class="form-select bg-success p-2 text-dark bg-opacity-25">
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
          <select id="inputState" class="form-select bg-success p-2 text-dark bg-opacity-25">
              <option selected>Koordinator</option>
              <option value="1">01 Muhson</option>
            </select>
          </div>
        </div>
      <div class="mb-3">
        <label for="formGroupExampleInput2" class="form-label">Keterangan</label>
        <input type="text" class="form-control bg-success p-2 text-dark bg-opacity-25" id="formGroupExampleInput2" placeholder="Keterangan" required>
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput2" class="form-label">Uang Masuk</label>
        <input type="text" class="form-control bg-success p-2 text-dark bg-opacity-25" id="formGroupExampleInput2" placeholder="Rp." required>
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput2" class="form-label">Uang Keluar</label>
        <input type="text" class="form-control bg-success p-2 text-dark bg-opacity-25" id="formGroupExampleInput2" placeholder="Rp." required>
      </div>

      <button type="submit" class="btn btn-primary mb-4" style="background: green">Simpan</button>
      <a href="{{ route('admin.biaya') }}" class="btn btn-secondary">Kembali</a>
    </div>
    
@endsection