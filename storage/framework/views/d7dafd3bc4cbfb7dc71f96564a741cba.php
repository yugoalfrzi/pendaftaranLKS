<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Sistem Pendaftaran LKS'); ?> - Provinsi Jawa Barat</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ICON PAGE -->
    <link rel="icon" href="<?php echo e(asset('assets/Apps/vendors/images/favicon.ico')); ?>" type="image/png">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f4f9fc;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Sidebar Modern */
        .sidebar {
            height: 100vh;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 20px rgba(0,0,0,0.03);
            border-right: 1px solid rgba(203, 213, 225, 0.4);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar .sidebar-header {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid rgba(203, 213, 225, 0.5);
            position: sticky;
            top: 0;
            background: inherit;
            z-index: 1;
        }

        .sidebar .sidebar-header .logo {
            color: #1e293b;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }

        .sidebar .sidebar-header .logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            border-radius: 12px;
        }

        .sidebar .sidebar-header .logo span {
            white-space: nowrap;
        }

        .sidebar nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 1rem 0.75rem;
        }

        .sidebar .nav-link {
            color: #334155;
            padding: 0.7rem 1rem;
            border-radius: 1rem;
            margin: 0.2rem 0;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            background: #eef2ff;
            color: #1e40af;
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: #1e40af;
            font-weight: 600;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .sidebar .nav-link .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.3s;
            font-size: 0.8rem;
        }

        .sidebar .nav-link.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* Submenu */
        .submenu {
            background: rgba(0, 0, 0, 0.02);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 0;
            border-radius: 1rem;
            margin-left: 0.5rem;
        }

        .submenu.active {
            max-height: 800px;
        }

        .submenu .nav-link {
            padding-left: 2.8rem;
            font-size: 0.85rem;
            margin: 0.1rem 0;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Top Navbar Glassmorphism */
        .top-navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 0 rgba(0,0,0,0.05);
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid rgba(203, 213, 225, 0.5);
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: #475569;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s;
        }

        .sidebar-toggle:hover {
            background: #eef2ff;
            color: #1e40af;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 1rem;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }

        .role-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            border-radius: 2rem;
            font-weight: 600;
        }

        .role-admin { background: #fee2e2; color: #b91c1c; }
        .role-kabkota { background: #e6f7e6; color: #2e7d32; }
        .role-provinsi { background: #e0e7ff; color: #1e40af; }
        .role-kemensos { background: #f3e8ff; color: #6b21a5; }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Alert Modern */
        .alert {
            border: none;
            border-radius: 1rem;
            padding: 1rem 1.2rem;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .alert-success { background: #e6f7e6; color: #2e7d32; border-left: 4px solid #2e7d32; }
        .alert-danger { background: #fee2e2; color: #b91c1c; border-left: 4px solid #b91c1c; }

        /* Responsive */
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
            }
            .content-area {
                padding: 1rem;
            }
            .top-navbar {
                padding: 0.8rem 1rem;
            }
        }

        /* Collapsed state */
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .sidebar-header .logo span,
        .sidebar.collapsed .nav-link .dropdown-arrow {
            display: none;
        }
        .sidebar.collapsed .submenu .nav-link {
            padding-left: 1rem;
        }
        .sidebar.collapsed .nav-link {
            justify-content: center;
        }
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        .sidebar.collapsed .submenu {
            margin-left: 0;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo e(route('dashboard')); ?>" class="logo">
                <img src="<?php echo e(asset('assets/Apps/vendors/images/lks-removebg-preview.png')); ?>" alt="e-LKS Jawa Barat">
                <span>E-LKS JABAR</span>
            </a>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>

            <!-- Pengumuman LKS -->
            <div class="nav-link dropdown-toggle" data-target="pengumumanSubmenu">
                <i class="bi bi-megaphone"></i>
                <span>Pengumuman LKS</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <div class="submenu" id="pengumumanSubmenu">
                <a class="nav-link <?php echo e(request()->routeIs('announcements.regulasi') ? 'active' : ''); ?>" href="<?php echo e(route('announcements.regulasi')); ?>">
                    <i class="bi bi-file-earmark-text"></i> <span>Regulasi</span>
                </a>
                <a class="nav-link <?php echo e(request()->routeIs('announcements.panduan') ? 'active' : ''); ?>" href="<?php echo e(route('announcements.panduan')); ?>">
                    <i class="bi bi-journal-text"></i> <span>Panduan</span>
                </a>
                <a class="nav-link <?php echo e(request()->routeIs('announcements.surat') ? 'active' : ''); ?>" href="<?php echo e(route('announcements.surat')); ?>">
                    <i class="bi bi-envelope"></i> <span>Surat</span>
                </a>
            </div>

            <a class="nav-link <?php echo e(request()->routeIs('lks.create') ? 'active' : ''); ?>" href="<?php echo e(route('lks.create')); ?>">
                <i class="bi bi-plus-circle"></i> <span>Pendaftaran LKS</span>
            </a>

            <!-- Data LKS JABAR -->
            <?php if(auth()->guard()->check()): ?>
                <div class="nav-link dropdown-toggle" data-target="dataLksSubmenu">
                    <i class="bi bi-database"></i>
                    <span>Data LKS JABAR</span>
                    <i class="bi bi-chevron-down dropdown-arrow"></i>
                </div>
                <div class="submenu" id="dataLksSubmenu">
                    <a class="nav-link <?php echo e(request()->routeIs('kewenangan-kabkota.*') ? 'active' : ''); ?>" href="<?php echo e(route('kewenangan-kabkota.index')); ?>">
                        <i class="bi bi-geo-alt"></i> <span>Kewenangan Kab/Kota</span>
                    </a>
                    <?php if(Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin')): ?>
                        <a class="nav-link <?php echo e(request()->routeIs('kewenangan-provinsi.*') ? 'active' : ''); ?>" href="<?php echo e(route('kewenangan-provinsi.index')); ?>">
                            <i class="bi bi-building"></i> <span>Kewenangan Provinsi</span>
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('kewenangan-kemensos.*') ? 'active' : ''); ?>" href="<?php echo e(route('kewenangan-kemensos.index')); ?>">
                            <i class="bi bi-house-heart"></i> <span>Kewenangan Kemensos</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Hibah LKS (Admin only) -->
            <?php if(auth()->guard()->check()): ?>
                <?php if(Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin')): ?>
                    <div class="nav-link dropdown-toggle" data-target="kewirausahaanSubmenu">
                        <i class="bi bi-cash-stack"></i>
                        <span>Hibah LKS</span>
                        <i class="bi bi-chevron-down dropdown-arrow"></i>
                    </div>
                    <div class="submenu" id="kewirausahaanSubmenu">
                        <a class="nav-link" href="<?php echo e(route('hibah.keuangan', ['tahun' => now()->year])); ?>">
                            <i class="bi bi-pie-chart"></i> <span>Data Keuangan Hibah</span>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Admin Panel (Super Admin only) -->
            <?php if(auth()->guard()->check()): ?>
                <?php if(Auth::user()->role === 'super_admin'): ?>
                    <a class="nav-link <?php echo e(request()->routeIs('admin.index') ? 'active' : ''); ?>" href="<?php echo e(route('admin.lks.index')); ?>">
                        <i class="bi bi-gear-wide-connected"></i>
                        <span>Admin Panel</span>
                    </a>
                    <a class="nav-link <?php echo e(request()->routeIs('superadmin.index') ? 'active' : ''); ?>" href="<?php echo e(route('superadmin.index')); ?>">
                        <i class="bi bi-shield-check"></i>
                        <span>Super Admin Panel</span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="mb-0 fw-semibold"><?php echo $__env->yieldContent('page-title', 'E-LKS'); ?></h4>
            </div>

            <div class="user-info">
                <div class="user-avatar">
                    <?php echo e(strtoupper(substr(Auth::user()->name ?? 'U', 0, 1))); ?>

                </div>
                <div class="d-none d-md-block">
                    <div class="fw-semibold small"><?php echo e(Auth::user()->name ?? 'User'); ?></div>
                    <div class="role-badge
                        <?php if(Auth::user()->hasRole('admin')): ?> role-admin
                        <?php elseif(Auth::user()->hasRole('kabkota')): ?> role-kabkota
                        <?php elseif(Auth::user()->hasRole('provinsi')): ?> role-provinsi
                        <?php elseif(Auth::user()->hasRole('kemensos')): ?> role-kemensos
                        <?php else: ?> role-admin <?php endif; ?>">
                        <?php echo e(ucfirst(Auth::user()->role ?? 'admin')); ?>

                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-md-inline ms-1">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="content-area">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Toggle collapsed (desktop)
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

            // Dropdown toggle functionality
            const dropdownToggles = document.querySelectorAll('.nav-link.dropdown-toggle');

            function closeAllSubmenus(except = null) {
                document.querySelectorAll('.submenu').forEach(sub => {
                    if (except !== sub) {
                        sub.classList.remove('active');
                        sub.style.maxHeight = null;
                    }
                });
                document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                    if (except && toggle.closest('.submenu')) return;
                    if (!except || toggle !== except) {
                        toggle.classList.remove('active');
                    }
                });
            }

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const targetId = this.getAttribute('data-target');
                    const targetSubmenu = document.getElementById(targetId);
                    if (!targetSubmenu) return;

                    const isActive = targetSubmenu.classList.contains('active');

                    if (!isActive) {
                        closeAllSubmenus(targetSubmenu);
                        targetSubmenu.classList.add('active');
                        targetSubmenu.style.maxHeight = targetSubmenu.scrollHeight + 'px';
                        this.classList.add('active');
                    } else {
                        targetSubmenu.classList.remove('active');
                        targetSubmenu.style.maxHeight = null;
                        this.classList.remove('active');
                    }
                });
            });

            // Close submenus when clicking on non-dropdown nav links (top level)
            document.querySelectorAll('.nav-link:not(.dropdown-toggle)').forEach(link => {
                link.addEventListener('click', () => {
                    if (!link.closest('.submenu')) {
                        closeAllSubmenus();
                    }
                });
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\pendaftaranLKS\resources\views/layouts/app.blade.php ENDPATH**/ ?>