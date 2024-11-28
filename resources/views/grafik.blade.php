@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container">
    <h1 class="text-center mb-5">Grafik Data Pasien</h1>

    <div class="row">
        <!-- Daily Chart -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Data Harian</h2>
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Monthly Chart -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Data Bulanan</h2>
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Yearly Chart -->
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Data Tahunan</h2>
                    <canvas id="yearlyChart" style="max-width: 300px; height: 300px; margin: auto;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Centered Back Button -->
    <div class="text-center mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
    </div>
</div>

<script>
    // Function to format date for daily data (e.g., "1 Januari 2024")
    const formatDateDaily = (dateString) => {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }).format(date);
    };

    // Function to format date for monthly data (e.g., "Januari 2024")
    const formatDateMonthly = (dateString) => {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' }).format(date);
    };

    // Daily data for line chart
    const dailyLabels = @json($dailyData->pluck('date')).map(formatDateDaily);
    const dailyTotals = @json($dailyData->pluck('total'));

    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Jumlah Pasien Harian',
                data: dailyTotals,
                borderColor: 'blue',
                fill: false,
                tension: 0.1
            }]
        }
    });

    // Monthly data for line chart
    const monthlyLabels = @json($monthlyData->pluck('label')).map(formatDateMonthly);
    const monthlyTotals = @json($monthlyData->pluck('total'));

    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Jumlah Pasien Bulanan',
                data: monthlyTotals,
                borderColor: 'green',
                fill: false,
                tension: 0.1
            }]
        }
    });

    // Yearly data for pie chart
    const yearlyLabels = @json($yearlyData->pluck('year'));
    const yearlyTotals = @json($yearlyData->pluck('total'));

    const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    new Chart(yearlyCtx, {
        type: 'pie',
        data: {
            labels: yearlyLabels,
            datasets: [{
                label: 'Jumlah Pasien Tahunan',
                data: yearlyTotals,
                backgroundColor: ['red', 'blue', 'green', 'yellow'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'center'
                }
            },
        }
    });
</script>
@endsection
