<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI Penjadwalan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        /* Header Styling */
        .header {
            background-color: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .header h4 {
            margin: 0;
            font-weight: bold;
            color: #343a40;
        }
        .profile-section {
            display: flex;
            align-items: center;
        }
        .profile-section i {
            font-size: 24px;
            margin-right: 10px;
            color: #495057;
        }

        /* Layout Wrapper */
        .layout {
            display: flex;
            margin-top: 75px; /* Space for the fixed header */
            height: calc(100vh - 75px); /* Adjust height to fill remaining viewport */
            overflow: hidden; /* Prevent overall layout from scrolling */
        }

        .sidebar {
            width: 200px;
            background-color: #343a40;
            color: #fff;
            padding: 20px 15px;
            position: fixed; /* Make sidebar fixed */
            top: 75px; /* Align with header */
            bottom: 0;
            overflow-y: auto; /* Allow sidebar to scroll if content is too long */
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            margin-left: 200px; /* Match sidebar width */
            overflow-y: auto; /* Enable scrolling for main content */
            height: calc(100vh - 75px); /* Full height minus header */
        }
        .sidebar a {
            display: block;
            color: #cfd8dc;
            font-weight: 500;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .sidebar a.active,
        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar a.buat-jadwal {
            background-color: #0471ff;
        }
        .sidebar a i {
            margin-right: 10px;
        }

        /* Card Styling */
        .card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: none;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                display: none; /* Hide sidebar on smaller screens */
            }
        }
        .title-with-underline {
            border-bottom: 2px solid #000;
            width: 27%;
            padding-bottom: 5px;
        }

    </style>

</head>
<body>
    <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center">
        <div class="logo-section">
            <img src="{{ asset('images/unib.png') }}" alt="Logo" style="height: 50px;">
            <span>SISTEM INFORMASI PENJADWALAN KULIAH</span>
        </div>
        <div class="profile-section">
            <i class="bi bi-person-circle"></i>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Administrator
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="#" id="logout-button">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Layout Wrapper -->
    <div class="layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="dashboard" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}" id="dashboard-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="matakuliah" class="sidebar-link {{ request()->is('matakuliah') ? 'active' : '' }}" id="matakuliah-link"><i class="bi bi-book"></i> Mata Kuliah</a>
            <a href="dosen" class="sidebar-link {{ request()->is('dosen') ? 'active' : '' }}" id="dosen-link"><i class="bi bi-person"></i> Dosen</a>
            <a href="prodi" class="sidebar-link {{ request()->is('prodi') ? 'active' : '' }}" id="prodi-link"><i class="bi bi-diagram-2"></i> Program Studi</a>
            <a href="ruang" class="sidebar-link {{ request()->is('ruang') ? 'active' : '' }}" id="ruang-link"><i class="bi bi-building"></i> Ruangan</a>
            <a href="kelas" class="sidebar-link {{ request()->is('kelas') ? 'active' : '' }}" id="kelas-link"><i class="bi bi-person-lines-fill"></i> Kelas</a>
            <a href="jam" class="sidebar-link {{ request()->is('jam') ? 'active' : '' }}" id="jam-link"><i class="bi bi-clock"></i> Waktu</a>
            <a href="pengampu" class="sidebar-link {{ request()->is('pengampu') ? 'active' : '' }}" id="pengampu-link"><i class="bi bi-person-check"></i> Pengampu</a>

            <a href="jadwal" class="buat-jadwal"><i class="bi bi-calendar-event"></i> Buat Jadwal</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin logout dari sistem?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="login" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom JS -->
    <script>
        document.getElementById('logout-button').addEventListener('click', function(event) {
            event.preventDefault();
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        });
    </script>
</body>
</html>
