<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Ambulans MWC NU Salam</title>

    <link href="{{ asset('Ambulans/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 ms-2 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="">Dashboard</a>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                @if (Auth::check())
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @else
                        <li><a class="button" href="{{ route('auth.login') }}">Login</a></li>
            @endif
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin'))
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDataPasien" aria-expanded="false" aria-controls="collapseDataPasien">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Data Pasien
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDataPasien" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('admin.pasien') }}">Lihat data pasien</a>
                                    <a class="nav-link" href="{{ route('admin.pasien.create') }}">Tambah data pasien</a>
                                </nav>
                            </div>
                        @endif
        
                        @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin'))
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBiaya" aria-expanded="false" aria-controls="collapseBiaya">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                                Biaya Operasional
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseBiaya" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('admin.biaya') }}">Lihat biaya operasional</a>
                                    <a class="nav-link" href="{{ route('admin.biaya.create') }}">Tambah biaya operasional</a>
                                </nav>
                            </div>
                        @endif
        
                        @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin'))
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseJadwal" aria-expanded="false" aria-controls="collapseJadwal">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                                Jadwal Operasional
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseJadwal" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('admin.jadwal') }}">Lihat Jadwal operasional</a>
                                    <a class="nav-link" href="{{ route('admin.jadwal.create') }}">Tambah Jadwal operasional</a>
                                </nav>
                            </div>
                        @endif
        
                        @if (Auth::check() && (Auth::user()->role === 'superadmin'))
                            <a class="nav-link" href="{{ route('superadmin.user.create') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                                Lihat User
                            </a>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
        

        <div id="layoutSidenav_content">
            <main> 
                <div class="container-fluid px-4">
                    <h1 class="mt-3 mb-4">Dashboard Ambulans MWC NU Salam</h1>

                    <center><iframe width="70%" height="480"
                            src="https://www.youtube.com/embed/bfAioPWfj1c?si=dGXWPeRAbQ_ehMiV&autoplay=1&mute=1"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </center>

                    <aside class="text-center bg-gradient-primary-to-secondary">
                        <div class="row gx-5 justify-content-center">
                            <div class="col-xl-8">
                                <marquee width="100%" scrolldelay="110"><h4 class="text-white mt-3 mb-4">"Ambulans MWC NU Salam, Siap melayani Anda!" &emsp; 
                                    🚨Layanan Ambulance 24 Jam Gratis🚨&emsp;
                                    🚑Antar Jemput Pasien&emsp;
                                    🚑Antar Jemput Jenazah&emsp;
                                    ⛑️ Tanggap Darurat Kebencanaan&emsp;&emsp;&emsp; 
                                    📞Call center WA/Telepon
                                    (0878 8844 1926 / 0821 3521 3026)</h4></marquee>
                            </div>
                        </div>
                    </aside>

                    <div class="row justify-content-center mt-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Sejarah Ambulans</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Grafik Penggunaan</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="/grafik">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Jadwal Ambulans</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href={{ route ('admin.jadwal') }}>View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; 2024 Ambulans MWC NU Salam</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('Ambulans/js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-wnsNNtHhTmAZKNzz2tE8jtP/zE51C/OC/xPB93M0DflEK4dH4aW+u+d/hm/eeBgq" crossorigin="anonymous">
    </script>
</body>

</html>