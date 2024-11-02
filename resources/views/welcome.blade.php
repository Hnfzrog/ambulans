<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat datang</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensure body takes at least full viewport height */
            background-color: #f8f9fa;
            margin: 0; /* Remove default body margin */
        }
        /* Main Content */
        .main-content {
            padding-top: 56px; /* Height of navbar */
            flex-grow: 1; /* Allows the content to take up available space */
            padding-bottom: 60px; /* Prevent content from hiding behind the footer */
        }
        /* Navbar and Footer styling */
        .navbar {
            background-color: #004d18 !important; /* Updated navbar background color */
        }
        footer {
            background-color: #004d18 !important; /* Updated footer background color */
            color: #ffffff;
            text-align: center;
            padding: 1rem;
            width: 100%;
            position: relative;
            bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand ms-2" href="{{ Auth::check() ? (Auth::user()->role === 'superadmin' ? route('superadmin.dashboard') : route('admin.dashboard')) : '#' }}">
                MWC NU Salam
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login/Register</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container-fluid main-content" id="mainContent">
        <div class="container-fluid px-4">
            <h1 class="mt-3 mb-4 text-center">Ambulans MWC NU Salam</h1>
    
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
    </div>

    <!-- Footer -->
    <div id="layoutAuthentication_footer">
        <footer style="background-color: #004d18 !important;" class="py-4 bg-dark mt-auto text-white">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div>Copyright &copy; Sistem Informasi Pangkalan Data Penggunaan Ambulans MWC NU Salam</div>
                    <div>
                        <a href="#" class="text-white">Privacy Policy</a>
                        &middot;
                        <a href="#" class="text-white">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
