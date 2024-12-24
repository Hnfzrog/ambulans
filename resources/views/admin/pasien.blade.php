@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f8f9fa; /* Light background for contrast */
    }
    h1 {
        color: #343a40; /* Darker text for better readability */
    }

    .container {
        min-height: 70vh; /* Light background for contrast */
    }
    .table {
        border-radius: 0.5rem; /* Rounded corners for the table */
        overflow: hidden; /* Prevent overflow of borders */
    }
    .table th, .table td {
        vertical-align: middle; /* Center content vertically */
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

<h1 class="text-center mt-4 mb-4">Data Pasien</h1>

<div class="container">
    @if (Auth::check())
        @if (Auth::user()->role === 'superadmin')
            <a href="{{ route('admin.pasien.cetak') }}" class="btn btn-success mb-4">Cetak Data Pasien</a>
        @elseif (Auth::user()->role === 'admin')
            <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary mb-4">+ Tambah Data Pasien</a>
        @endif
    @endif
    
    <!-- Search form -->
    <form method="GET" action="{{ route('admin.pasien') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama Pasien" value="{{ request('search') }}">
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
                        <td>{{ ($patients->currentPage() - 1) * $patients->perPage() + $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($patient->tanggal)->locale('id')->translatedFormat('j F Y') }}</td>
                        <td>{{ optional($patient->kru)->name ?? 'N/A' }}</td>
                        <td>{{ optional($patient->koordinator)->name ?? 'N/A' }}</td>
                        <td>{{ $patient->nama }}</td>
                        <td>{{ $patient->alamat }}</td>
                        <td>{{ $patient->tujuan }}</td>
                        <td>{{ $patient->keterangan }}</td>
                        <td>
                            @if($patient->photo)
                                @php
                                    // Assuming photo path is stored as 'photos/filename.png' in the database
                                    $photoPath = 'storage/photos/' . basename($patient->photo);
                                    // Determine full URL based on environment
                                    $photoUrl = app()->environment('local') 
                                        ? asset($photoPath) 
                                        : url($photoPath);
                                @endphp
                                <a href="{{ $photoUrl }}" target="_blank">Lihat Foto</a>
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pasien.edit', $patient->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $patient->id }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
                      
        </table>
    </div>

    <!-- Pagination links -->
    <div class="d-flex justify-content-between mt-4">
        <div>
            Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} entries
        </div>
        <div>
            {{ $patients->appends(['search' => request('search')])->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
            const action = `{{ url('/admin/pasien') }}/${patientId}`;
            document.getElementById('deleteForm').action = action;
        });
    });
</script>

@endsection
