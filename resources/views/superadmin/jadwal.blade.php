@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* Light background for contrast */
    }
    h1 {
        color: #343a40; /* Darker text for better readability */
    }
    .container{
        min-height:70vh /* Light background for contrast */
    }
    .table {
        border-radius: 0.5rem; /* Rounded corners for the table */
        overflow: hidden; /* Prevent overflow of borders */
    }
    .btn-custom {
        transition: background-color 0.3s, transform 0.2s; /* Smooth transition for buttons */
    }
    .btn-custom:hover {
        background-color: #0056b3; /* Darker shade on hover */
        transform: translateY(-2px); /* Slight lift effect on hover */
    }
    .table-striped tbody tr:hover {
        background-color: #e9ecef; /* Highlight row on hover */
    }
</style>
<div class="container mt-4">
    <h1 class="text-center mb-4">Jadwal Operasional</h1>
    
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('superadmin.jadwal.create') }}" class="btn btn-primary">+ Tambah Data jadwal</a>
        <a href="{{ route('superadmin.jadwal.export') }}" class="btn btn-success">Cetak Jadwal Operasional</a>
    </div>

    <div class="mb-4">
        <form method="GET" action="{{ route('superadmin.jadwal') }}" class="row g-2">
            <div class="col-auto">
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control" placeholder="Search by date">
            </div>
            <div class="col-auto">
                <input type="text" name="tujuan" value="{{ $tujuan }}" class="form-control" placeholder="Cari berdasarkan tujuan">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">cari</button>
            </div>
        </form>
    </div>
    
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pukul</th>
                <th>Tujuan</th>
                <th>Nama Kru</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $index => $item)
                <tr>
                    <td>{{ $index + 1 + ($jadwal->currentPage() - 1) * $jadwal->perPage() }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('j F Y') }}</td> <!-- Format date -->
                    <td>{{ \Carbon\Carbon::parse($item->pukul)->format('H:i') }}</td>
                    <td>{{ $item->tujuan }}</td>
                    <td>{{ optional($item->kru)->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('superadmin.jadwal.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('superadmin.jadwal.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this schedule?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-4">
        <div>
            Showing {{ $jadwal->firstItem() }} to {{ $jadwal->lastItem() }} of {{ $jadwal->total() }} entries
        </div>
        <div>
            {{ $jadwal->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection
