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
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            min-height: 100vh;
            padding: 20px 15px;
            position: relative;
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

        /* Main Content Styling */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            position: relative;
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
            border-bottom: 2px solid #000; /* Ganti #000 dengan warna yang diinginkan */
            width: 27%; /* Agar border hanya muncul di bawah teks */
            padding-bottom: 5px; /* Jarak antara teks dan garis */
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
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Layout Wrapper -->
    <div class="layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="dashboard-dosen" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}" id="dashboard-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="jadwaldosen" class="buat-jadwal"><i class="bi bi-calendar-event"></i> Buat Jadwal</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')

            <!-- resources/views/layouts/app.blade.php (di bagian content) -->
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
    <script>
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function(event) {
                // Hapus class 'active' dari semua tautan
                document.querySelectorAll('.sidebar-link').forEach(item => {
                    item.classList.remove('active');
                });
                // Tambahkan class 'active' pada tautan yang diklik
                this.classList.add('active');

                // Navigasi ke halaman yang sesuai
                window.location.href = this.getAttribute('href');
            });
        });
    </script>
</body>
</html>
