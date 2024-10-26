@extends('layouts.app')  

    @section('content')

    <h1 class="text-center mt-4 mb-4">Data Pasien</h1>
     
    <div class="container">
        @if (Auth::check() && (Auth::user()->role === 'superadmin'))
            <a href="{{ route ('admin.pasien.cetak')}}" class="btn btn-success mb-4">Cetak Data Pasien</a>
        @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary">+ Tambah Data Pasien</a>
        @endif
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">id kru</th>
                        <th scope="col">id koor</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Alamat pasien</th>
                        <th scope="col">Tujuan</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Dokumentasi</th>
                        <th scope="col">Opsi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $index => $patient)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $patient->created_at->format('d-m-Y') }}</td>
                            <td>{{ $patient->id_kru }}</td>
                            <td>{{ $patient->id_koor }}</td>
                            <td>{{ $patient->nama }}</td>
                            <td>{{ $patient->alamat }}</td>
                            <td>{{ $patient->tujuan }}</td>
                            <td>{{ $patient->keterangan }}</td>
                            <td>
                                @if($patient->photo)
                                    <a href="{{ asset('storage/' . $patient->photo) }}" target="_blank">Lihat Foto</a>
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pasien.edit', $patient->id) }}" class="btn btn-success">Edit</a>
                                <form action="{{ route('admin.pasien.destroy', $patient->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>
    @endsection
