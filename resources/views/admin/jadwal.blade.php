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

<div class="container mt-4">
    <h1 class="text-center mb-4">Jadwal Operasional</h1>

    <div class="mb-4">
        <form method="GET" action="{{ route('admin.jadwal') }}" class="d-flex">
            <input type="text" name="tujuan" class="form-control" value="{{ request('tujuan') }}" placeholder="Filter by Tujuan">&nbsp;
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" placeholder="Filter by Tanggal">&nbsp;
            <button type="submit" class="btn btn-primary">Filter</button>
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
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $index => $item)
                <tr>
                    <td>{{ $jadwal->firstItem() + $index }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('j F Y') }}</td> <!-- Format date -->
                    <td>{{ \Carbon\Carbon::parse($item->pukul)->format('H:i') }}</td>
                    <td>{{ $item->tujuan }}</td>
                    <td>{{ optional($item->kru)->name ?? 'N/A' }}</td>
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
