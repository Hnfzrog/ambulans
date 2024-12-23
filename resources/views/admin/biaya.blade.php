@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f8f9fa;
    }
    .container {
        min-height: 70vh;
    }
    h1 {
        color: #343a40;
    }
    .table {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-custom {
        transition: background-color 0.3s, transform 0.2s;
    }
    .btn-custom:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }
    .table-striped tbody tr:hover {
        background-color: #e9ecef;
    }
</style>

<h1 class="text-center mt-4 mb-4">Biaya Operasional</h1>

<div class="container">
    @if (Auth::check() && Auth::user()->role === 'superadmin')
        <a href="{{ route('biaya.pasien.cetak') }}" class="btn btn-success mb-4">Cetak Biaya Operasional</a>
    @endif
    <a href="{{ route('admin.biaya.create') }}" class="btn btn-primary mb-4">+ Tambah Biaya Operasional</a>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.biaya') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="keterangan" class="form-control" placeholder="Cari berdasarkan keterangan" value="{{ request()->get('keterangan') }}">
            </div>
            <div class="col-md-4">
                <input type="date" id="datePicker" name="tanggal" class="form-control" placeholder="Pilih Tanggal" value="{{ request()->get('tanggal') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </div>
    </form>    

    <div class="col-md-12">
        <!-- Display Total Data -->
        <div class="alert alert-info" role="alert">
            <strong>Total Keseluruhan:</strong><br>
            Uang Masuk: Rp {{ number_format($totalUangMasuk ?? 0, 0, ',', '.') }}<br>
            Uang Keluar: Rp {{ number_format($totalUangKeluar ?? 0, 0, ',', '.') }}<br>
            Saldo: Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>ID Kru</th>
                    <th>ID Koor</th>
                    <th>Keterangan</th>
                    <th>Uang Masuk (Rp)</th>
                    <th>Uang Keluar (Rp)</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($biayaOperasional as $index => $operasional)
                    @php
                        $formattedDate = \Carbon\Carbon::parse($operasional->tanggal)->locale('id')->translatedFormat('j F Y');
                    @endphp
                    <tr>
                        <td>{{ $biayaOperasional->firstItem() + $index }}</td>
                        <td>{{ $formattedDate }}</td>
                        <td>{{ optional($operasional->kru)->name ?? 'N/A' }}</td>
                        <td>{{ optional($operasional->koordinator)->name ?? 'N/A' }}</td>
                        <td>{{ $operasional->keterangan }}</td>
                        <td>{{ number_format($operasional->uang_masuk, 0, ',', '.') }}</td>
                        <td>{{ number_format($operasional->uang_keluar, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.biaya.edit', $operasional->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $operasional->id }}">Hapus</button>
                            <div class="modal fade" id="deleteModal{{ $operasional->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $operasional->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $operasional->id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus biaya operasional ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('admin.biaya.destroy', $operasional->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-between mt-4">
        <div>
            Showing {{ $biayaOperasional->firstItem() }} to {{ $biayaOperasional->lastItem() }} of {{ $biayaOperasional->total() }} entries
        </div>
        <div>
            {{ $biayaOperasional->appends(request()->all())->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
