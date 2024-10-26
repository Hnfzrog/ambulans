@extends('layout.app')

@section('content')
<h1 class="text-center mt-4 mb-4">Biaya Operasional</h1>
     
<div class="container">
    @if (Auth::check() && (Auth::user()->role === 'superadmin'))
        <a href="{{ route ('biaya.pasien.cetak')}}" class="btn btn-success mb-4">Cetak Biaya Operasional</a>
    @endif
        <a href="{{ route('admin.biaya.create') }}" class="btn btn-primary">+ Tambah Biaya Operasional</a>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>id_kru</th>
            <th>id_koor</th>
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
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($operasional->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $operasional->id }}</td>
                <td>{{ $operasional->keterangan }}</td>
                <td>{{ number_format($operasional->uang_masuk, 0, ',', '.') }}</td>
                <td>{{ number_format($operasional->uang_keluar, 0, ',', '.') }}</td>
                <td>{{ number_format($saldo, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('edit', $operasional->id) }}">Edit</a>
                    <form action="{{ route('delete', $operasional->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Apakah Anda Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td><strong>{{ number_format($totalUangMasuk, 0, ',', '.') }}</strong></td>
            <td><strong>{{ number_format($totalUangKeluar, 0, ',', '.') }}</strong></td>
            <td><strong>{{ number_format($totalUangMasuk - $totalUangKeluar, 0, ',', '.') }}</strong></td>
            <td></td>
        </tr>
    </tbody>
</table>


@endsection