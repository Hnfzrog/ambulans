@extends('layouts.app')

@section('content')
<div class="container" style="height: 80vh; overflow-y: auto;">
    <h2 class="text-center mb-4">Jadwal Operasional</h2>

    <!-- Display Jadwal for the Next 24 Hours -->
    <h3 class="mt-4">Jadwal 24 Jam ke Depan</h3>
    @if($jadwal24->isEmpty())
        <p class="text-muted">Tidak ada jadwal untuk 24 jam ke depan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Pukul</th>
                        <th>Tujuan</th>
                        <th>Kru</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwal24 as $jadwal)
                        @php
                            // Define month names in Bahasa Indonesia
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];

                            // Parse the 'tanggal' field into a Carbon instance
                            $date = \Carbon\Carbon::parse($jadwal->tanggal);
                            
                            // Manually format the date as 'd M Y' with month names in Bahasa Indonesia
                            $formattedDate = $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
                        @endphp
                        <tr>
                            <td>{{ $formattedDate }}</td>
                            <td>{{ $jadwal->pukul }}</td>
                            <td>{{ $jadwal->tujuan }}</td>
                            <td>{{ $jadwal->kru->name ?? 'Tidak ada kru' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Display Jadwal for the Next 3 Days -->
    <h3 class="mt-4">Jadwal 3 Hari ke Depan</h3>
    @if($jadwal3Days->isEmpty())
        <p class="text-muted">Tidak ada jadwal untuk 3 hari ke depan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Pukul</th>
                        <th>Tujuan</th>
                        <th>Kru</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwal3Days as $jadwal)
                        @php
                            // Define month names in Bahasa Indonesia
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];

                            // Parse the 'tanggal' field into a Carbon instance
                            $date = \Carbon\Carbon::parse($jadwal->tanggal);
                            
                            // Manually format the date as 'd M Y' with month names in Bahasa Indonesia
                            $formattedDate = $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
                        @endphp
                        <tr>
                            <td>{{ $formattedDate }}</td>
                            <td>{{ $jadwal->pukul }}</td>
                            <td>{{ $jadwal->tujuan }}</td>
                            <td>{{ $jadwal->kru->name ?? 'Tidak ada kru' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Back Button -->
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
