@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f8f9fa;
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

<h1 class="text-center mt-4 mb-4">Biaya Operasional</h1>

<div class="container">
    @if (Auth::check() && (Auth::user()->role === 'superadmin'))
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
            Uang Masuk: Rp {{ isset($totalUangMasuk) ? number_format($totalUangMasuk, 0, ',', '.') : '0' }}<br>
            Uang Keluar: Rp {{ isset($totalUangKeluar) ? number_format($totalUangKeluar, 0, ',', '.') : '0' }}<br>
            Saldo: Rp {{ isset($totalSaldo) ? number_format($totalSaldo, 0, ',', '.') : '0' }}
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
                    <th>Saldo (Rp)</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalUangMasuk = 0;
                    $totalUangKeluar = 0;
                @endphp

                @foreach($biayaOperasional as $index => $operasional)
                    @php
                        $totalUangMasuk += $operasional->uang_masuk;
                        $totalUangKeluar += $operasional->uang_keluar;
                        $saldo = $totalUangMasuk - $totalUangKeluar;

                        // Format date to "Hari Bulan Tanggal"
                        $formattedDate = \Carbon\Carbon::parse($operasional->tanggal)->locale('id')->translatedFormat('j F Y');
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $formattedDate }}</td>
                        <td>{{ optional($operasional->kru)->name ?? 'N/A' }}</td>
                        <td>{{ optional($operasional->koordinator)->name ?? 'N/A' }}</td>
                        <td>{{ $operasional->keterangan }}</td>
                        <td>{{ number_format($operasional->uang_masuk, 0, ',', '.') }}</td>
                        <td>{{ number_format($operasional->uang_keluar, 0, ',', '.') }}</td>
                        <td>{{ number_format($saldo, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.biaya.edit', $operasional->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $operasional->id }}">
                                Hapus
                            </button>

                            <!-- Delete Confirmation Modal -->
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

                {{-- <tr class="table-primary">
                    <td colspan="5"><strong>Total</strong></td>
                    <td><strong>{{ number_format($totalUangMasuk, 0, ',', '.') }}</strong></td>
                    <td><strong>{{ number_format($totalUangKeluar, 0, ',', '.') }}</strong></td>
                    <td><strong>{{ number_format($totalUangMasuk - $totalUangKeluar, 0, ',', '.') }}</strong></td>
                    <td></td>
                </tr> --}}
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-between mt-4">
        <div>
            Showing {{ $biayaOperasional->firstItem() }} to {{ $biayaOperasional->lastItem() }} of {{ $biayaOperasional->total() }} entries
        </div>
        <div>
            {{ $biayaOperasional->links('vendor.pagination.custom') }} <!-- Use custom pagination view -->
        </div>
    </div>
</div>
@endsection
