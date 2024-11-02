<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        /* Sidebar styling */
        .sb-sidenav {
            background: #343a40;
            height: 100vh;
            padding: 1rem;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            width: 250px;
            transition: transform 0.3s ease;
            position: fixed;
            top: 56px; /* Height of navbar */
            left: 0;
            z-index: 1050;
            transform: translateX(-100%);
        }
        .sb-sidenav.show {
            transform: translateX(0);
        }
        .sb-sidenav .nav-link {
            color: #ffffff;
            transition: background 0.3s;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sb-sidenav .nav-link:hover {
            background: #495057;
            border-radius: 0.25rem;
        }
        .sb-nav-link-icon {
            margin-right: 0.5rem;
        }
        /* Custom Toggler Button */
        .custom-toggler {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            flex-direction: column;
            width: 30px;
            padding: 5px;
        }
        .custom-toggler .bar {
            width: 100%;
            height: 3px;
            background-color: #fff;
            margin: 4px 0;
            transition: 0.4s;
        }
        .custom-toggler.active .bar:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .custom-toggler.active .bar:nth-child(2) {
            opacity: 0;
        }
        .custom-toggler.active .bar:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }
        /* Main Content */
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s;
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
            <button class="custom-toggler" type="button" id="sidebarToggle" aria-label="Toggle navigation">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            <a class="navbar-brand ms-2" href="{{ Auth::check() ? (Auth::user()->role === 'superadmin' ? route('superadmin.dashboard') : route('admin.dashboard')) : '#' }}">
                Dashboard
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="d-flex" id="navbarNav">
        <!-- Sidenav -->
        <div class="sb-sidenav accordion" id="sidenavAccordion">
            <div class="nav flex-column">
                @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin'))
                    <div class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDataPasien" aria-expanded="false" aria-controls="collapseDataPasien">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Data Pasien
                            <div class="sb-sidenav-collapse-arrow ms-auto"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDataPasien" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ Auth::user()->role === 'superadmin' ? route('superadmin.pasien') : route('admin.pasien') }}">Lihat data pasien</a>
                                <a class="nav-link" href="{{ Auth::user()->role === 'superadmin' ? route('superadmin.pasien.create') : route('admin.pasien.create') }}">Tambah data pasien</a>
                            </nav>
                        </div>
                    </div>
                @endif
    
                @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin'))
                    <div class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBiaya" aria-expanded="false" aria-controls="collapseBiaya">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                            Biaya Operasional
                            <div class="sb-sidenav-collapse-arrow ms-auto"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseBiaya" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ Auth::user()->role === 'superadmin' ? route('superadmin.biaya') : route('admin.biaya') }}">Lihat biaya operasional</a>
                                <a class="nav-link" href="{{ Auth::user()->role === 'superadmin' ? route('superadmin.biaya.create') : route('admin.biaya.create') }}">Tambah biaya operasional</a>
                            </nav>
                        </div>
                    </div>
                @endif
    
                @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin'))
                    <div class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#collapseJadwal" aria-expanded="false" aria-controls="collapseJadwal">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                            Jadwal Operasional
                            <div class="sb-sidenav-collapse-arrow ms-auto"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseJadwal" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ Auth::user()->role === 'superadmin' ? route('superadmin.jadwal') : route('admin.jadwal') }}">Lihat Jadwal operasional</a>
                            </nav>
                        </div>
                    </div>
                @endif
    
                @if (Auth::check() && Auth::user()->role === 'superadmin')
                    <div class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            User Pengguna
                            <div class="sb-sidenav-collapse-arrow ms-auto"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUser" aria-labelledby="headingFour" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('superadmin.userIndex') }}">Lihat User</a>
                            </nav>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="container-fluid main-content" id="mainContent">
            <div class="p-4">
                @yield('content')
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
    <script>
        $(document).ready(function() {
            $('#sidebarToggle').click(function() {
                $('#sidenavAccordion').toggleClass('show'); // Toggles sidebar visibility
                $('#mainContent').toggleClass('shifted');   // Shifts content area when sidebar is visible
                $(this).toggleClass('active');              // Toggles hamburger icon state
            });
        });
    </script>
    
</body>
</html>
