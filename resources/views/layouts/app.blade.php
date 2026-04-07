<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pendaftaran LKS') - Provinsi Jawa Barat</title>
     <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ICON PAGE -->
    <link rel="icon" href="{{ asset('assets/Apps/vendors/images/favicon.ico') }}" type="image/png">
    
    <style>
        .sidebar {
            height: 100vh;
            background: #f8f9fa;
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            border-right: 1px solid #dee2e6;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 1;
        }

        .sidebar nav {
            flex: 1 1 auto;
            overflow-y: auto;
            overflow-x: hidden;
            padding-bottom: 1rem;
        }

        .sidebar .sidebar-header .logo {
            color: #495057;
            font-size: 1.2rem;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .sidebar .sidebar-header .logo:hover {
            color: #000;
        }

        .sidebar .sidebar-header .logo img {
            width: 50px;
            height: 45px;
            object-fit: contain;
            background: transparent;
            padding: 2px;
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.125rem 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: transparent;
            width: calc(100% - 1rem);
        }

        .sidebar .nav-link:hover {
            color: #000;
            background: #e9ecef;
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            color: #000;
            background: #dee2e6;
            font-weight: 600;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
            font-size: 0.875rem;
        }

        .sidebar .nav-link.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* Submenu Styling */
        .submenu {
            background-color: rgba(0, 0, 0, 0.03);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 0;
        }

        .submenu.active {
            max-height: 1000px;
        }

        .submenu .nav-link {
            padding-left: 2.5rem;
            font-size: 0.9rem;
            margin: 0.1rem 0.5rem;
        }

        /* Nested Submenu Level 2 */
        .submenu .submenu {
            background-color: rgba(0, 0, 0, 0.02);
            margin-left: 0.5rem;
        }

        .submenu .submenu .nav-link {
            padding-left: 3.5rem;
            font-size: 0.85rem;
        }

        .submenu .submenu .nav-link i {
            font-size: 0.8rem;
        }

        /* Scrollable submenu for years */
        .dropdown-submenu {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            background: rgba(0, 0, 0, 0.02);
        }

        .dropdown-submenu .nav-link {
            padding: 0.5rem 1rem 0.5rem 3.5rem;
            font-size: 0.8rem;
            margin: 0;
            border-radius: 0;
        }

        .dropdown-submenu .nav-link:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .main-content {
            margin-left: 300px;
            min-height: 100vh;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-area {
            padding: 2rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: #e9ecef;
            color: #495057;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1rem;
        }

        .role-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-weight: 500;
        }

        .role-admin {
            background: #dc3545;
            color: white;
        }

        .role-kabkota {
            background: #198754;
            color: white;
        }

        .role-provinsi {
            background: #0d6efd;
            color: white;
        }

        .role-kemensos {
            background: #6f42c1;
            color: white;
        }

        body {
            overflow-x: hidden;
            background: #f8f9fa;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .content-area {
                padding: 1rem;
            }

            .top-navbar {
                padding: 1rem;
            }
        }

        /* Collapsed State */
        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .sidebar-header .logo span {
            display: none;
        }

        .sidebar.collapsed .submenu .nav-link {
            padding-left: 1rem;
        }

        .sidebar.collapsed .nav-link .dropdown-arrow {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('assets/Apps/vendors/images/lks-removebg-preview.png') }}" alt="e-LKS Jawa Barat" class="logo-img">
                <span>E-LKS Jawa Barat</span>
            </a>
        </div>
        
        <nav class="nav flex-column mt-3">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>

            <!-- Menu Pengumuman LKS dengan submenu-->
            <div class="nav-link dropdown-toggle" data-target="pengumumanSubmenu">
                    <i class="bi bi-megaphone"></i>
                    <span>Pengumuman LKS</span>
                    <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>    
            <div class="submenu" id="pengumumanSubmenu">
               <a class="nav-link {{ request()->routeIs('announcements.regulasi') ? 'active' : '' }}" href="{{ route('announcements.regulasi') }}">
                   <i class="bi bi-file-earmark-text"></i>
                   <span>Regulasi</span>
               </a>
               <a class="nav-link {{ request()->routeIs('announcements.panduan') ? 'active' : '' }}" href="{{ route('announcements.panduan') }}">
                   <i class="bi bi-journal-text"></i>
                   <span>Panduan</span>
                </a>
                <a class="nav-link {{ request()->routeIs('announcements.surat') ? 'active' : '' }}" href="{{ route('announcements.surat') }}">
                    <i class="bi bi-envelope"></i>
                    <span>Surat</span>
                </a>
            </div>

            <a class="nav-link {{ request()->routeIs('lks.create') ? 'active' : '' }}" href="{{ route('lks.create') }}">
                <i class="bi bi-plus-circle"></i>
                <span>Pendaftaran LKS</span>
            </a>

            <!-- Menu Data LKS JABAR - Untuk semua user, tapi konten dibatasi -->
            @auth
                <div class="nav-link dropdown-toggle" data-target="dataLksSubmenu">
                    <i class="bi bi-database"></i>
                    <span>Data LKS JABAR</span>
                    <i class="bi bi-chevron-down dropdown-arrow"></i>
                </div>
                <div class="submenu" id="dataLksSubmenu">
                    <!-- Kewenangan Kab/Kota - Tampil untuk semua user -->
                    <a class="nav-link {{ request()->routeIs('kewenangan-kabkota.*') ? 'active' : '' }}" href="{{ route('kewenangan-kabkota.index') }}">
                        <i class="bi bi-geo-alt"></i>
                        <span>Kewenangan Kab/Kota</span>
                    </a>
                    
                    <!-- Kewenangan Provinsi & Kemensos - Hanya untuk admin -->
                    @if(Auth::user()->hasRole('admin'))
                        <a class="nav-link {{ request()->routeIs('kewenangan-provinsi.*') ? 'active' : '' }}" href="{{ route('kewenangan-provinsi.index') }}">
                            <i class="bi bi-building-fill"></i>
                            <span>Kewenangan Provinsi</span>
                        </a>
                        <a class="nav-link {{ request()->routeIs('kewenangan-kemensos.*') ? 'active' : '' }}" href="{{ route('kewenangan-kemensos.index') }}">
                            <i class="bi bi-house-door"></i>
                            <span>Kewenangan Kemensos</span>
                        </a>
                    @endif
                </div>
            @endauth

            <!-- Menu Hibah LKS - Hanya untuk ADMIN -->
            @auth
                @if(Auth::user()->hasRole('admin'))
                    <div class="nav-link dropdown-toggle" data-target="kewirausahaanSubmenu">
                        <i class="bi bi-cash-coin"></i>
                        <span>Hibah LKS</span>
                        <i class="bi bi-chevron-down dropdown-arrow"></i>
                    </div>
                    <div class="submenu" id="kewirausahaanSubmenu">
                        <a class="nav-link" href="{{ route('hibah.keuangan', ['tahun' => now()->year]) }}">
                            <i class="bi bi-pie-chart"></i>
                            <span>Data Keuangan Hibah LKS</span>
                        </a>
                    </div>
                @endif
            @endauth

            <!-- Admin Panel - Hanya untuk ADMIN -->
            @auth
                @if(Auth::user()->hasRole('admin'))
                    <a class="nav-link {{ request()->routeIs('admin.lks.index') ? 'active' : '' }}" href="{{ route('admin.lks.index') }}">
                        <i class="bi bi-gear"></i>
                        <span>Admin Panel Pendaftaran LKS</span>
                    </a>
                @endif
            @endauth
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="mb-0">@yield('page-title', 'E-LKS')</h4>
            </div>
            
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="d-none d-md-block">
                    <div class="fw-bold">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="role-badge 
                        @if(Auth::user()->hasRole('admin')) role-admin
                        @elseif(Auth::user()->hasRole('kabkota')) role-kabkota
                        @elseif(Auth::user()->hasRole('provinsi')) role-provinsi
                        @elseif(Auth::user()->hasRole('kemensos')) role-kemensos
                        @else role-admin @endif">
                        {{ Auth::user()->role ?? 'admin' }}
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline ms-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-md-inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });
        
            // Mobile sidebar toggle
            if (window.innerWidth <= 768) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
        
            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        
            // SIMPLIFIED DROPDOWN FUNCTIONALITY
            const dropdownToggles = document.querySelectorAll('.nav-link.dropdown-toggle');
        
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const targetId = this.getAttribute('data-target');
                    const targetSubmenu = document.getElementById(targetId);

                    if (!targetSubmenu) return;
                
                    // Toggle current submenu
                    const isActive = targetSubmenu.classList.contains('active');

                    if (isActive) {
                        // Close this submenu
                        targetSubmenu.classList.remove('active');
                        targetSubmenu.style.maxHeight = null;
                        this.classList.remove('active');
                    } else {
                        // Open this submenu
                        targetSubmenu.classList.add('active');
                        targetSubmenu.style.maxHeight = targetSubmenu.scrollHeight + 'px';
                        this.classList.add('active');
                    }
                });
            });
        
            // Close submenus when clicking on regular nav links
            document.querySelectorAll('.nav-link:not(.dropdown-toggle)').forEach(link => {
                link.addEventListener('click', function() {
                    // Only close submenus if it's a top-level navigation
                    if (!this.closest('.submenu')) {
                        closeAllSubmenus();
                    }
                });
            });
        
            // Close all submenus when clicking outside sidebar
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target)) {
                    closeAllSubmenus();
                }
            });
        
            function closeAllSubmenus() {
                document.querySelectorAll('.submenu').forEach(submenu => {
                    submenu.classList.remove('active');
                    submenu.style.maxHeight = null;
                });

                document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                    toggle.classList.remove('active');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>