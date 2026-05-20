<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pendaftaran LKS') - Provinsi Jawa Barat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ICON PAGE -->
    <link rel="icon" href="{{ asset('assets/Apps/vendors/images/silaskar-icon.png') }}" type="image/jpeg">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f4f9fc;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            position: fixed;
            top: 0; left: 0;
            width: 220px;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 2px 0 20px rgba(0,0,0,0.04);
            border-right: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            flex-direction: column;
        }
        .sidebar.collapsed { 
            width: 64px; 
        }

        .sidebar .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            background: #fff;
            flex-shrink: 0;
        }
        .sidebar .sidebar-header .logo {
            color: #1e293b;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .sidebar-header .logo img {
            width: 48px; height: 48px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(37,99,235,0.15);
            flex-shrink: 0;
        }
        .sidebar .sidebar-header .logo span {
            white-space: nowrap;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Nav scroll area */
        .sidebar nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0.65rem 0.6rem;
            min-height: 0;
            height: 0;
        }
        .sidebar nav::-webkit-scrollbar { 
            width: 3px; 
        }
        .sidebar nav::-webkit-scrollbar-track { 
            background: transparent; 
        }
        .sidebar nav::-webkit-scrollbar-thumb { 
            background: rgba(203,213,225,0.7); 
            border-radius: 4px; 
        }

        /* Nav links */
        .sidebar .nav-link {
            color: #475569;
            padding: 0.5rem 0.7rem;
            border-radius: 0.65rem;
            margin: 0.08rem 0;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            font-size: 0.78rem;
            font-weight: 500;
        }
        .sidebar .nav-link span { 
            flex: 1; 
            min-width: 0; 
            line-height: 1.3; 
        }
        .sidebar .nav-link i { 
            font-size: 0.95rem; 
            width: 17px; 
            min-width: 17px; 
            text-align: center; 
        }
        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1e40af;
            transform: translateX(3px);
        }
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(37,99,235,0.22);
        }
        .sidebar .nav-link.active:hover { 
            transform: translateX(3px); 
        }
        .sidebar .nav-link .badge {
            margin-left: auto;
            font-size: 0.6rem;
            padding: 0.18rem 0.4rem;
            border-radius: 1rem;
            font-weight: 600;
        }

        /* Section label */
        .nav-section-label {
            font-size: 0.58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            padding: 0.55rem 0.7rem 0.2rem;
        }

        /* Dropdown toggle arrow */
        .sidebar .nav-link .dd-arrow {
            margin-left: auto;
            font-size: 0.65rem;
            opacity: 0.6;
            transition: transform 0.25s;
            min-width: 12px;
        }
        .sidebar .nav-link.dd-open .dd-arrow { 
            transform: rotate(180deg); opacity: 1; 
        }

        /* Submenu */
        .sidebar .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0.05rem 0 0.05rem 0.5rem;
            border-left: 2px solid rgba(37,99,235,0.15);
            border-radius: 0 0 0.5rem 0.5rem;
        }
        .sidebar .submenu.open { 
            max-height: 400px; 
        }
        .sidebar .submenu .nav-link {
            padding: 0.42rem 0.65rem 0.42rem 1rem;
            font-size: 0.75rem;
            border-radius: 0.55rem;
            margin: 0.05rem 0;
            gap: 8px;
        }
        .sidebar .submenu .nav-link i { 
            font-size: 0.85rem; 
            width: 15px; 
            min-width: 15px; 
        }

        /* Collapsed: hide submenu & arrow */
        .sidebar.collapsed .dd-arrow,
        .sidebar.collapsed .submenu { 
            display: none; 
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 220px;
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .main-content.expanded { 
            margin-left: 64px; 
        }

        /* Top Navbar */
        .top-navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 rgba(226,232,240,0.8);
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid rgba(226,232,240,0.6);
        }
        .sidebar-toggle {
            background: none; border: none;
            font-size: 1.2rem; color: #64748b;
            cursor: pointer; padding: 0.45rem;
            border-radius: 0.75rem; transition: all 0.2s; line-height: 1;
        }
        .sidebar-toggle:hover { 
            background: linear-gradient(135deg,#eff6ff,#dbeafe); 
            color: #1e40af; 
        }

        .user-info { 
            display: flex; 
            align-items: center; 
            gap: 0.85rem; 
        }
        .user-avatar {
            width: 36px; 
            height: 36px; 
            border-radius: 0.85rem;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex; 
            align-items: center; 
            justify-content: center;
            color: white; 
            font-weight: 700; 
            font-size: 0.95rem;
            box-shadow: 0 3px 8px rgba(37,99,235,0.25);
        }
        .role-badge { 
            font-size: 0.65rem; 
            padding: 0.18rem 0.55rem; 
            border-radius: 2rem; 
            font-weight: 600; 
        }
        .role-admin    { 
            background: #fee2e2; 
            color: #b91c1c; 
        }
        .role-kabkota  { 
            background: #dcfce7; 
            color: #15803d; 
        }
        .role-provinsi { 
            background: #dbeafe; 
            color: #1d4ed8; 
        }
        .role-kemensos { 
            background: #f3e8ff; 
            color: #7c3aed; 
        }

        /* Content Area */
        .content-area { 
            padding: 1.75rem; 
        }

        /* Alert */
        .alert { 
            border: none; 
            border-radius: 1rem; 
            padding: 0.9rem 1.1rem; 
            font-weight: 500; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); 
        }
        .alert-success { 
            background: #f0fdf4; 
            color: #15803d; 
            border-left: 4px solid #16a34a; 
        }
        .alert-danger  { 
            background: #fff1f2; 
            color: #b91c1c; 
            border-left: 4px solid #dc2626; 
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { 
                transform: translateX(-100%); 
                width: 240px; 
            }
            .sidebar.show { 
                transform: translateX(0); 
            }
            .main-content { 
                margin-left: 0; 
            }
            .content-area { 
                padding: 1rem; 
            }
            .top-navbar { 
                padding: 0.7rem 1rem; 
            }
        }

        /* Collapsed state */
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .sidebar-header .logo span,
        .sidebar.collapsed .nav-section-label { 
            display: none; 
        }
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.6rem;
        }
        .sidebar.collapsed .nav-link i { 
            margin-right: 0; 
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('assets/Apps/vendors/images/silaskar.jpeg') }}" alt="SI LASKAR">
                <span>SI-LASKAR</span>
            </a>
        </div>

        <nav class="nav flex-column">

            {{-- DASHBOARD --}}
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door"></i><span>Dashboard</span>
            </a>

            {{-- INFORMASI (dropdown) --}}
            @php $infoActive = request()->routeIs('announcements.*'); @endphp
            <button class="nav-link dd-toggle {{ $infoActive ? 'dd-open active' : '' }}" data-target="infoSubmenu">
                <i class="bi bi-megaphone"></i><span>Pengumuman</span>
                <i class="bi bi-chevron-down dd-arrow"></i>
            </button>
            <div class="submenu {{ $infoActive ? 'open' : '' }}" id="infoSubmenu">
                @if(auth()->user()->role === 'super_admin')
                <a class="nav-link {{ request()->routeIs('announcements.index') ? 'active' : '' }}" href="{{ route('announcements.index') }}">
                    <i class="bi bi-gear"></i><span>Kelola Pengumuman</span>
                </a>
                @endif
                <a class="nav-link {{ request()->routeIs('announcements.regulasi') ? 'active' : '' }}" href="{{ route('announcements.regulasi') }}">
                    <i class="bi bi-file-earmark-text"></i><span>Regulasi</span>
                </a>
                <a class="nav-link {{ request()->routeIs('announcements.panduan') ? 'active' : '' }}" href="{{ route('announcements.panduan') }}">
                    <i class="bi bi-journal-text"></i><span>Panduan</span>
                </a>
                <a class="nav-link {{ request()->routeIs('announcements.surat') ? 'active' : '' }}" href="{{ route('announcements.surat') }}">
                    <i class="bi bi-envelope"></i><span>Surat</span>
                </a>
            </div>

            @auth

            {{-- LAYANAN LKS --}}
            <div class="nav-section-label">Layanan LKS</div>

            @if(Auth::user()->hasRole('user'))
                <a class="nav-link {{ request()->routeIs('lks.create') ? 'active' : '' }}" href="{{ route('lks.create') }}">
                    <i class="bi bi-plus-circle"></i><span>Pendaftaran LKS</span>
                </a>
            @endif

            <a class="nav-link {{ request()->routeIs('lks.terdaftar') ? 'active' : '' }}" href="{{ route('lks.terdaftar') }}">
                <i class="bi bi-patch-check"></i>
                @if(auth()->user()->hasRole('user'))
                    <span>Download Tanda Daftar</span>
                    @php $perluPerhatianCount = \App\Models\LKS::where('user_id', auth()->id())->whereIn('status_permohonan', ['Ditolak', 'Dikembalikan'])->count(); @endphp
                    @if($perluPerhatianCount > 0)
                        <span class="badge bg-danger">{{ $perluPerhatianCount }}</span>
                    @endif
                @else
                    <span>LKS Terdaftar</span>
                @endif
            </a>

            {{-- DATA LKS JABAR (dropdown) --}}
            @php $dataLksActive = request()->routeIs('kewenangan-*'); @endphp
            <button class="nav-link dd-toggle {{ $dataLksActive ? 'dd-open active' : '' }}" data-target="dataLksSubmenu">
                <i class="bi bi-database"></i><span>Data LKS JABAR</span>
                <i class="bi bi-chevron-down dd-arrow"></i>
            </button>
            <div class="submenu {{ $dataLksActive ? 'open' : '' }}" id="dataLksSubmenu">
                @if(Auth::user()->hasRole('user'))
                    <a class="nav-link {{ request()->routeIs('kewenangan-kabkota.create') ? 'active' : '' }}" href="{{ route('kewenangan-kabkota.create') }}">
                        <i class="bi bi-geo-alt"></i><span>Input kewenangan Kab/Kota</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('kewenangan-provinsi.create') ? 'active' : '' }}" href="{{ route('kewenangan-provinsi.create') }}">
                        <i class="bi bi-map"></i><span>Input kewenangan Provinsi</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('kewenangan-kemensos.create') ? 'active' : '' }}" href="{{ route('kewenangan-kemensos.create') }}">
                        <i class="bi bi-house-heart"></i><span>Input kewenangan Kemensos</span>
                    </a>
                @else
                    <a class="nav-link {{ request()->routeIs('kewenangan-kabkota.*') ? 'active' : '' }}" href="{{ route('kewenangan-kabkota.index') }}">
                        <i class="bi bi-geo-alt"></i><span>Kewenangan Kab/Kota</span>
                    </a>
                    @if(Auth::user()->hasRole('super_admin'))
                        <a class="nav-link {{ request()->routeIs('kewenangan-provinsi.*') ? 'active' : '' }}" href="{{ route('kewenangan-provinsi.index') }}">
                            <i class="bi bi-map"></i><span>Kewenangan Provinsi</span>
                        </a>
                        <a class="nav-link {{ request()->routeIs('kewenangan-kemensos.*') ? 'active' : '' }}" href="{{ route('kewenangan-kemensos.index') }}">
                            <i class="bi bi-house-heart"></i><span>Kewenangan Kemensos</span>
                        </a>
                    @endif
                @endif
            </div>

            {{-- RPTKA --}}
            <div class="nav-section-label">RPTKA</div>
            @if(Auth::user()->hasRole('user'))
                <a class="nav-link {{ request()->routeIs('rptka.index') || request()->routeIs('rptka.show') ? 'active' : '' }}" href="{{ route('rptka.index') }}">
                    <i class="bi bi-file-earmark-person"></i><span>Permohonan Rekomendasi RPTKA</span>
                </a>
            @endif
            @if(Auth::user()->hasRole('admin'))
                <a class="nav-link {{ request()->routeIs('admin.rptka.*') ? 'active' : '' }}" href="{{ route('admin.rptka.index') }}">
                    <i class="bi bi-file-earmark-person"></i><span>Verifikasi RPTKA</span>
                </a>
            @endif
            @if(Auth::user()->hasRole('super_admin'))
                <a class="nav-link {{ request()->routeIs('superadmin.rptka.*') ? 'active' : '' }}" href="{{ route('superadmin.rptka.index') }}">
                    <i class="bi bi-file-earmark-person"></i><span>Verval RPTKA</span>
                </a>
            @endif

            {{-- HIBAH (super admin) --}}
            @if(Auth::user()->hasRole('super_admin'))
                <div class="nav-section-label">Hibah</div>
                <a class="nav-link {{ request()->routeIs('hibah.*') ? 'active' : '' }}" href="{{ route('hibah.keuangan', ['tahun' => now()->year]) }}">
                    <i class="bi bi-cash-stack"></i><span>Data Keuangan Hibah</span>
                </a>
            @endif

            {{-- ADMINISTRASI --}}
            @if(Auth::user()->role === 'admin')
                <div class="nav-section-label">Administrasi</div>
                <a class="nav-link {{ request()->routeIs('admin.lks.*') ? 'active' : '' }}" href="{{ route('admin.lks.index') }}">
                    <i class="bi bi-gear-wide-connected"></i><span>Admin Panel</span>
                </a>
            @endif

            @if(Auth::user()->role === 'super_admin')
                <div class="nav-section-label">Administrasi</div>
                <a class="nav-link {{ request()->routeIs('superadmin.index') ? 'active' : '' }}" href="{{ route('superadmin.index') }}">
                    <i class="bi bi-shield-check"></i><span>Super Admin Panel</span>
                </a>
                @php $pendingCount = \App\Models\User::where('approval_status','pending')->where('role','user')->count(); @endphp
                <a class="nav-link {{ request()->routeIs('superadmin.pending-users') ? 'active' : '' }}" href="{{ route('superadmin.pending-users') }}">
                    <i class="bi bi-person-check"></i><span>Persetujuan Akun</span>
                    @if($pendingCount > 0)
                        <span class="badge bg-warning text-dark">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a class="nav-link {{ request()->routeIs('users.manage') ? 'active' : '' }}" href="{{ route('users.manage') }}">
                    <i class="bi bi-people"></i><span>Kelola Akun</span>
                </a>
                <a class="nav-link {{ request()->routeIs('lks.index') ? 'active' : '' }}" href="{{ route('lks.index') }}">
                    <i class="bi bi-list-check"></i><span>Semua Pendaftaran LKS</span>
                </a>
            @endif

            @endauth

        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="mb-0 fw-semibold">@yield('page-title', 'E-LKS')</h4>
            </div>

            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="d-none d-md-block">
                    <div class="fw-semibold small">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="role-badge
                        @if(Auth::user()->hasRole('admin')) role-admin
                        @elseif(Auth::user()->hasRole('kabkota')) role-kabkota
                        @elseif(Auth::user()->hasRole('provinsi')) role-provinsi
                        @elseif(Auth::user()->hasRole('kemensos')) role-kemensos
                        @else role-admin @endif">
                        {{ ucfirst(Auth::user()->role ?? 'admin') }}
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-md-inline ms-1">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Sidebar collapse toggle
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                if (window.innerWidth > 768) {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                } else {
                    sidebar.classList.toggle('show');
                }
            });

            // Close sidebar on mobile click outside
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // Dropdown toggle
            document.querySelectorAll('.dd-toggle').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    const submenu = document.getElementById(targetId);
                    if (!submenu) return;

                    const isOpen = submenu.classList.contains('open');

                    // Tutup semua submenu lain
                    document.querySelectorAll('.sidebar .submenu.open').forEach(function(s) {
                        if (s !== submenu) {
                            s.classList.remove('open');
                            const otherBtn = document.querySelector('[data-target="' + s.id + '"]');
                            if (otherBtn) otherBtn.classList.remove('dd-open');
                        }
                    });

                    submenu.classList.toggle('open', !isOpen);
                    this.classList.toggle('dd-open', !isOpen);
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
