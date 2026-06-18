{{-- resources/views/admin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Admin Panel') - Saung Angklung Udjo</title>

    <link rel="stylesheet" href="{{ asset('build/assets/app-DwZ0uyfv.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --brand: #22185d;
            --brand-hover: #1a1248;
            --brand-light: #2e2280;
            --accent: #7c6fff;
            --accent-soft: #ede9ff;
            --gold: #e8b84b;
            --gold-soft: #fdf4de;
            --bg: #f4f5f9;
            --surface: #ffffff;
            --surface2: #f9f9fc;
            --border: #e8e8f0;
            --border-focus: #7c6fff;
            --text: #1a1535;
            --text-muted: #8b8aaa;
            --success: #28a96b;
            --success-soft: #e6f7ef;
            --danger: #e5484d;
            --danger-soft: #fde8e8;
            --warning: #e8b84b;
            --warning-soft: #fdf4de;
            --sidebar-w: 240px;
            --topbar-h: 60px;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 4px rgba(34, 24, 93, .07);
            --shadow: 0 4px 16px rgba(34, 24, 93, .10);
            --font: 'Plus Jakarta Sans', sans-serif;
            --transition: .18s cubic-bezier(.4, 0, .2, 1);
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            font-size: 14px;
            line-height: 1.5;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        @media (min-width: 1920px) {
            body {
                font-size: 15px;
            }
        }

        @media (max-width: 1280px) {
            body {
                font-size: 13px;
            }
        }

        @media (max-width: 1024px) {
            body {
                font-size: 13px;
            }
        }

        /* ─────────────────────────── SIDEBAR ─────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--brand);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 40;
            transition: transform .28s cubic-bezier(.4, 0, .2, 1);
            flex-shrink: 0;
        }

        @media (max-width: 1366px) {
            .sidebar {
                width: 220px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
            }

            .sidebar.hidden-mobile {
                transform: translateX(-100%);
            }
        }

        /* Logo */
        .sidebar-logo {
            padding: 0 18px;
            height: var(--topbar-h);
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .sidebar-logo-inner {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .sidebar-logo-img {
            width: 34px;
            height: 34px;
            background: #fff;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
        }

        .sidebar-logo-img img {
            width: 26px;
            height: 26px;
            object-fit: contain;
        }

        .sidebar-logo-text .title {
            font-size: 13.5px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            letter-spacing: -.2px;
        }

        .sidebar-logo-text .sub {
            font-size: 10.5px;
            color: rgba(255, 255, 255, .4);
            margin-top: 1px;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 10px;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .12);
            border-radius: 4px;
        }

        .nav-section-label {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, .28);
            padding: 16px 12px 7px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255, 255, 255, .58);
            text-decoration: none;
            transition: all var(--transition);
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            transition: color var(--transition);
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, .09);
            color: rgba(255, 255, 255, .9);
        }

        .nav-item:hover svg {
            color: rgba(255, 255, 255, .9);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, .13);
            color: #fff;
            font-weight: 600;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: var(--gold);
            border-radius: 0 3px 3px 0;
        }

        .nav-item.active svg {
            color: var(--gold);
        }

        .nav-divider {
            height: 1px;
            background: rgba(255, 255, 255, .07);
            margin: 8px 2px;
        }

        /* Footer / User */
        .sidebar-footer {
            padding: 12px 10px;
            border-top: 1px solid rgba(255, 255, 255, .07);
            flex-shrink: 0;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .07);
            transition: background var(--transition);
        }

        .user-card:hover {
            background: rgba(255, 255, 255, .11);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(232, 184, 75, .25);
            color: var(--gold);
            font-weight: 700;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(232, 184, 75, .3);
        }

        .user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
        }

        .user-role {
            font-size: 10px;
            color: rgba(255, 255, 255, .38);
            margin-top: 1px;
        }

        .logout-btn {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255, 255, 255, .3);
            padding: 5px;
            border-radius: 7px;
            transition: all var(--transition);
            display: flex;
        }

        .logout-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, .1);
        }

        .logout-btn svg {
            width: 15px;
            height: 15px;
            display: block;
        }

        /* ─────────────────────────── MAIN WRAP ─────────────────────────── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-width: 0;
            width: calc(100% - var(--sidebar-w));
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        @media (max-width: 1366px) {
            .main-wrap {
                margin-left: 220px;
                width: calc(100% - 220px);
            }
        }

        @media (max-width: 768px) {
            .main-wrap {
                margin-left: 0;
                width: 100%;
            }
        }

        /* ─────────────────────────── TOPBAR ─────────────────────────── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            height: var(--topbar-h);
            flex-shrink: 0;
            gap: 12px;
            box-shadow: var(--shadow-sm);
        }

        .topbar-search {
            flex: 1;
            max-width: 300px;
            position: relative;
        }

        .topbar-search input {
            width: 100%;
            padding: 8px 14px 8px 36px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13px;
            color: var(--text);
            background: var(--surface2);
            outline: none;
            transition: all var(--transition);
            font-family: var(--font);
        }

        .topbar-search input:focus {
            border-color: var(--border-focus);
            background: var(--surface);
            box-shadow: 0 0 0 3px rgba(124, 111, 255, .12);
        }

        .topbar-search input::placeholder {
            color: var(--text-muted);
        }

        .topbar-search svg {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            color: var(--text-muted);
            pointer-events: none;
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--surface2);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            position: relative;
            transition: all var(--transition);
        }

        .topbar-icon-btn:hover {
            background: var(--accent-soft);
            border-color: var(--accent);
            color: var(--accent);
        }

        .topbar-icon-btn svg {
            width: 16px;
            height: 16px;
        }

        .notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 6px;
            height: 6px;
            background: var(--danger);
            border-radius: 50%;
            border: 1.5px solid #fff;
        }

        .topbar-divider {
            width: 1px;
            height: 22px;
            background: var(--border);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 5px 10px 5px 6px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: background var(--transition);
        }

        .topbar-user:hover {
            background: var(--surface2);
        }

        .topbar-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--brand), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 13px;
        }

        .topbar-username {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 4px;
            border-radius: 7px;
            transition: all var(--transition);
        }

        .mobile-menu-btn:hover {
            background: var(--surface2);
            color: var(--text);
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: flex;
            }
        }

        .mobile-menu-btn svg {
            width: 20px;
            height: 20px;
        }

        /* ─────────────────────────── PAGE CONTENT ─────────────────────────── */
        .page-content {
            flex: 1;
            overflow-y: auto;
            padding: 26px 28px;
            background: var(--bg);
        }

        @media (max-width: 1280px) {
            .page-content {
                padding: 20px;
            }
        }

        /* ─────────────────────────── ALERTS ─────────────────────────── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 16px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 22px;
            border: 1px solid transparent;
            animation: alertIn .25s ease;
        }

        @keyframes alertIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .alert-success {
            background: var(--success-soft);
            color: #1a7a4a;
            border-color: #c0e8d0;
        }

        .alert-error {
            background: var(--danger-soft);
            color: #b81c21;
            border-color: #f5c5bf;
        }

        /* ─────────────────────────── SHARED CARD STYLES ─────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .card-sub {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ─────────────────────────── TABLE BASE ─────────────────────────── */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 11px 18px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: var(--text-muted);
            background: var(--surface2);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background var(--transition);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #f7f6fd;
        }

        tbody td {
            padding: 13px 18px;
            font-size: 13.5px;
            color: var(--text);
            vertical-align: middle;
        }

        /* ─────────────────────────── BADGE BASE ─────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .badge-success {
            background: var(--success-soft);
            color: #1a7a4a;
        }

        .badge-success::before {
            background: var(--success);
        }

        .badge-warning {
            background: var(--warning-soft);
            color: #9a6c00;
        }

        .badge-warning::before {
            background: var(--warning);
        }

        .badge-danger {
            background: var(--danger-soft);
            color: #b81c21;
        }

        .badge-danger::before {
            background: var(--danger);
        }

        .badge-muted {
            background: #eeeef5;
            color: var(--text-muted);
        }

        .badge-muted::before {
            background: var(--text-muted);
        }

        .badge-brand {
            background: var(--accent-soft);
            color: var(--brand);
        }

        .badge-brand::before {
            background: var(--accent);
        }

        /* ─────────────────────────── BUTTONS BASE ─────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-family: var(--font);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
            border: none;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn svg {
            width: 14px;
            height: 14px;
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--brand-hover);
            box-shadow: 0 4px 14px rgba(34, 24, 93, .28);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .btn-outline {
            background: var(--surface);
            border: 1.5px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-soft);
        }

        .btn-danger {
            background: var(--danger-soft);
            color: var(--danger);
            border: 1.5px solid #f5c5bf;
        }

        .btn-danger:hover {
            background: var(--danger);
            color: #fff;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-icon-sm {
            width: 30px;
            height: 30px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
        }

        /* ─────────────────────────── FORM INPUTS BASE ─────────────────────────── */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .form-label .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            padding: 9px 13px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: var(--font);
            font-size: 13.5px;
            color: var(--text);
            background: var(--surface2);
            outline: none;
            transition: all var(--transition);
        }

        .form-control:focus {
            border-color: var(--border-focus);
            background: var(--surface);
            box-shadow: 0 0 0 3px rgba(124, 111, 255, .12);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
        }

        /* ─────────────────────────── PAGE HEADER ─────────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .page-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.4px;
        }

        .page-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .page-breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color var(--transition);
        }

        .page-breadcrumb a:hover {
            color: var(--accent);
        }

        .page-breadcrumb svg {
            width: 12px;
            height: 12px;
        }

        /* ─────────────────────────── MOBILE OVERLAY ─────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10, 8, 30, .5);
            z-index: 39;
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.active {
            display: block;
        }

        @media (min-width: 769px) {
            .sidebar-overlay {
                display: none !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div style="display:flex;height:100vh;overflow:hidden;">

        {{-- ─────────────── SIDEBAR ─────────────── --}}
        <aside id="sidebar" class="sidebar">

            {{-- Logo --}}
            <div class="sidebar-logo">
                <div class="sidebar-logo-inner">
                    <div class="sidebar-logo-img">
                        <img src="{{ asset('images/UdjoFullColor.png') }}" alt="SAU">
                    </div>
                    <div class="sidebar-logo-text">
                        <div class="title">Admin Panel</div>
                        <div class="sub">SAU Bandung</div>
                    </div>
                </div>
                <button id="close-sidebar"
                    style="display:none;background:none;border:none;cursor:pointer;color:rgba(255,255,255,.45);padding:4px;border-radius:6px;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Nav --}}
            <nav class="sidebar-nav">

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1.5" />
                        <rect x="14" y="3" width="7" height="7" rx="1.5" />
                        <rect x="3" y="14" width="7" height="7" rx="1.5" />
                        <rect x="14" y="14" width="7" height="7" rx="1.5" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                   <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                 Users
                </a>

                <a href="{{ route('admin.promo.index') }}"
                    class="nav-item {{ request()->routeIs('admin.promo.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Promo Klaim
                </a>

                <a href="{{ route('admin.hero.index') }}"
                    class="nav-item {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Hero Carousel
                </a>

                <div class="nav-divider"></div>
                <div class="nav-section-label">Segera Hadir 🚀</div>

                <div class="nav-item" style="cursor:not-allowed;opacity:.5;" title="Coming Soon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    Pertunjukan
                    <span
                        style="margin-left:auto;font-size:9px;font-weight:700;letter-spacing:.5px;background:rgba(232,184,75,.2);color:var(--gold);border:1px solid rgba(232,184,75,.3);padding:2px 7px;border-radius:20px;">SOON</span>
                </div>

              <a href="{{ route('admin.orders.index') }}"
    class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Booking
</a>

                <a href="{{ route('admin.tickets.scan.index') }}"
                    class="nav-item {{ request()->routeIs('admin.tickets.scan.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 4h12v16H6z" />
                        <path d="M9 8h6M9 12h6M9 16h3" />
                    </svg>
                    Scan Tiket
                </a>

                <div class="nav-item" style="cursor:not-allowed;opacity:.5;" title="Coming Soon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Produk
                    <span
                        style="margin-left:auto;font-size:9px;font-weight:700;letter-spacing:.5px;background:rgba(232,184,75,.2);color:var(--gold);border:1px solid rgba(232,184,75,.3);padding:2px 7px;border-radius:20px;">SOON</span>
                </div>

                <div class="nav-divider"></div>
                <div class="nav-section-label">Manajemen Konten</div>

                <a href="{{ route('admin.gallery.index') }}"
                    class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Galeri
                </a>

                <a href="{{ route('admin.articles.index') }}"
                    class="nav-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Artikel
                </a>

                <a href="{{ route('admin.testimonials.index') }}"
                    class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Testimoni
                </a>

                <div class="nav-divider"></div>

                <a href="{{ route('home') }}" target="_blank" class="nav-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Lihat Website
                </a>

            </nav>

            {{-- User Footer --}}
            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div>
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="logout-btn" title="Logout">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        {{-- ─────────────── MAIN ─────────────── --}}
        <div class="main-wrap">

            {{-- Topbar --}}
            <header class="topbar">
                <button id="toggle-sidebar" class="mobile-menu-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="topbar-search">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" placeholder="Cari sesuatu...">
                </div>

                <div class="topbar-right">
                    <button class="topbar-icon-btn" title="Notifikasi">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="notif-dot"></span>
                    </button>

                    <div class="topbar-divider"></div>

                    <div class="topbar-user">
                        <div class="topbar-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <span class="topbar-username">{{ auth()->user()->name }}</span>
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24" style="color:var(--text-muted)">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="page-content">

                @if (session('success'))
                    <div class="alert alert-success">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('toggle-sidebar');
        const closeBtn = document.getElementById('close-sidebar');

        const isMobile = () => window.innerWidth <= 768;

        function openSidebar() {
            sidebar.classList.remove('hidden-mobile');
            overlay.classList.add('active');
            if (closeBtn) closeBtn.style.display = 'block';
        }

        function closeSidebar() {
            sidebar.classList.add('hidden-mobile');
            overlay.classList.remove('active');
        }

        function initMobile() {
            if (isMobile()) {
                sidebar.classList.add('hidden-mobile');
                if (closeBtn) closeBtn.style.display = 'block';
            } else {
                sidebar.classList.remove('hidden-mobile');
                overlay.classList.remove('active');
                if (closeBtn) closeBtn.style.display = 'none';
            }
        }

        toggleBtn?.addEventListener('click', () => {
            if (sidebar.classList.contains('hidden-mobile')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });

        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        window.addEventListener('resize', initMobile);
        initMobile();
    </script>

    @stack('scripts')
</body>

</html>
