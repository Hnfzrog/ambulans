@extends('layouts.app')

@section('content')
<style>
    .container{
        min-height:70vh /* Light background for contrast */
    }
</style>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-3 mb-4 text-center">Dashboard Ambulans MWC NU Salam</h1>

        <center>
            <iframe width="70%" height="480"
                src="https://www.youtube.com/embed/bfAioPWfj1c?si=dGXWPeRAbQ_ehMiV&autoplay=1&mute=1"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </center>

        <aside class="text-center">
            <div class="bg-gradient bg-success p-3">
                <div class="row gx-5 justify-content-center">
                    <div class="col-xl-8">
                        <marquee width="100%" scrolldelay="110">
                            <h4 class="text-white mt-3 mb-0">"Ambulans MWC NU Salam, Siap melayani Anda!" &emsp;
                                🚨Layanan Ambulance 24 Jam Gratis🚨&emsp;
                                🚑Antar Jemput Pasien&emsp;
                                🚑Antar Jemput Jenazah&emsp;
                                ⛑️ Tanggap Darurat Kebencanaan&emsp;&emsp;&emsp;
                                📞Call center WA/Telepon
                                (0878 8844 1926 / 0821 3521 3026)
                            </h4>
                        </marquee>
                    </div>
                </div>
            </div>
        </aside>

        <div class="row justify-content-center mt-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-gradient bg-success text-white mb-4">
                    <div class="card-body">Sejarah Ambulans</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-gradient bg-warning text-white mb-4">
                    <div class="card-body">Grafik Penggunaan</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="/grafik">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-gradient bg-success text-white mb-4">
                    <div class="card-body">Jadwal Ambulans</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="/jadwal">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
