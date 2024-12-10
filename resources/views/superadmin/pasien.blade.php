@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom Styles -->
<style>
    body {
        background-color: #f8f9fa; /* Light background for contrast */
    }
    .container{
        min-height:70vh /* Light background for contrast */
    }
    h1 {
        color: #343a40; /* Darker text for better readability */
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
    <h1 class="text-center mb-4">Data Pasien</h1>

    @if (Auth::check() && Auth::user()->role === 'superadmin')
    <div class="mb-4 d-flex justify-content-between">
        <a href="{{ route('superadmin.pasien.create') }}" class="btn btn-primary btn-custom">+ Tambah Data Pasien</a>
        <a href="{{ route('superadmin.pasien.export')}}" class="btn btn-success btn-custom">Cetak Data Pasien</a>
    </div>
    @elseif(Auth::user()->role === 'admin')
        <a href="{{ route('superadmin.pasien.create') }}" class="btn btn-primary btn-custom mb-4">+ Tambah Data Pasien</a>
    @endif
    
    <!-- Search Form -->
    <form method="GET" action="{{ route('superadmin.pasien.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama pasien" value="{{ request()->get('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Kru</th>
                    <th scope="col">Nama Koordinator</th>
                    <th scope="col">Nama Pasien</th>
                    <th scope="col">Alamat Pasien</th>
                    <th scope="col">Tujuan</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Dokumentasi</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $index => $patient)
                    <tr>
                        <td>{{ $index + 1 + ($patients->currentPage() - 1) * $patients->perPage() }}</td>
                        <td>{{ \Carbon\Carbon::parse($patient->tanggal)->locale('id')->translatedFormat('j F Y') }}</td>
                        <td>{{ optional($patient->kru)->name ?? 'N/A' }}</td>
                        <td>{{ optional($patient->koordinator)->name ?? 'N/A' }}</td>
                        <td>{{ $patient->nama }}</td>
                        <td>{{ $patient->alamat }}</td>
                        <td>{{ $patient->tujuan }}</td>
                        <td>{{ $patient->keterangan }}</td>
                        <td>
                            @if($patient->photo)
                                <a href="{{ asset('storage/' . $patient->photo) }}" target="_blank" class="btn btn-link">Lihat Foto</a>
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('superadmin.pasien.edit', $patient->id) }}" class="btn btn-warning btn-sm btn-custom">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm btn-custom" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $patient->id }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-between mt-4">
        <div>
            Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} entries
        </div>
        <div>
            {{ $patients->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data pasien ini?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const patientId = button.getAttribute('data-id');
            const action = `{{ url('/superadmin/pasien') }}/${patientId}`;
            document.getElementById('deleteForm').action = action;
        });
    });
</script>

@endsection
