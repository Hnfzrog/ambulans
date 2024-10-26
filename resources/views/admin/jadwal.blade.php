@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Jadwal</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pukul</th>
                <th>Tujuan</th>
                <th>id kru</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->pukul)->format('H:i') }}</td>
                    <td>{{ $item->tujuan }}</td>
                    <td>{{ $item->id }}</td>
                    <td>
                        <a href="{{ route('jadwal.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
