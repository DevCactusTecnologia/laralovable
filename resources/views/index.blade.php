@extends('layouts.master-layouts')
@section('title') Dashboard @endsection
@section('body') <body data-topbar="dark" data-layout="horizontal"> @endsection

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .sislac-dashboard {
            --s-primary: #4f46e5;
            --s-primary-600: #4338ca;
            --s-primary-50: #eef2ff;
            --s-primary-100: #e0e7ff;
            --s-accent: #8b5cf6;
            --s-ink: #0f172a;
            --s-ink-2: #1e293b;
            --s-muted: #64748b;
            --s-border: #e5e7eb;
            --s-border-soft: #eef0f4;
            --s-bg: #f8fafc;
            --s-radius: 18px;
            --s-radius-sm: 12px;
            --s-shadow: 0 1px 2px rgba(15,23,42,.04), 0 12px 28px -16px rgba(79,70,229,.18);
            --s-shadow-lg: 0 2px 4px rgba(15,23,42,.04), 0 24px 48px -24px rgba(79,70,229,.28);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--s-ink);
            position: relative;
            min-height: 100%;
        }
        /* sutil grade de fundo igual appsislac */
        .sislac-dashboard::before {
            content: "";
            position: absolute; inset: 0;
            background-image:
                radial-gradient(circle at 1px 1px, rgba(79,70,229,.08) 1px, transparent 0);
            background-size: 22px 22px;
            mask-image: linear-gradient(180deg, rgba(0,0,0,.6), rgba(0,0,0,0) 60%);
            pointer-events: none;
            z-index: 0;
        }
        .sislac-dashboard > * { position: relative; z-index: 1; }

        .sislac-dashboard .s-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 14px; border-radius: 999px;
            background: #fff; border: 1px solid var(--s-primary-100);
            color: var(--s-primary-600); font-size: 12.5px; font-weight: 600;
            box-shadow: 0 1px 2px rgba(15,23,42,.04);
        }
        .sislac-dashboard .s-badge::before {
            content: ""; width: 7px; height: 7px; border-radius: 50%;
            background: var(--s-primary); box-shadow: 0 0 0 4px rgba(79,70,229,.15);
        }

        .sislac-dashboard .s-page-header {
            display: flex; align-items: flex-end; justify-content: space-between;
            margin-bottom: 28px; flex-wrap: wrap; gap: 16px;
        }
        .sislac-dashboard .s-page-header h4 {
            font-size: clamp(28px, 3.4vw, 40px);
            font-weight: 800; letter-spacing: -.02em;
            color: var(--s-ink); margin: 12px 0 6px;
            line-height: 1.1;
        }
        .sislac-dashboard .s-page-header h4 .s-grad {
            background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 60%, #a855f7 100%);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .sislac-dashboard .s-page-header .s-crumb {
            color: var(--s-muted); font-size: 14px;
        }

        .sislac-dashboard .s-card {
            background: #fff;
            border: 1px solid var(--s-border-soft);
            border-radius: var(--s-radius);
            box-shadow: var(--s-shadow);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }
        .sislac-dashboard .s-card:hover {
            transform: translateY(-2px);
            border-color: var(--s-primary-100);
            box-shadow: var(--s-shadow-lg);
        }

        .sislac-dashboard .s-hero {
            background:
                radial-gradient(120% 80% at 0% 0%, rgba(255,255,255,.25), transparent 60%),
                linear-gradient(135deg, #4f46e5 0%, #6366f1 45%, #8b5cf6 100%);
            border-radius: var(--s-radius);
            color: #fff;
            padding: 30px 26px 22px;
            position: relative; overflow: hidden;
        }
        .sislac-dashboard .s-hero::after {
            content: "";
            position: absolute; inset: auto -60px -80px auto;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(255,255,255,.28), transparent 70%);
            border-radius: 50%;
        }
        .sislac-dashboard .s-hero h5 { color: #fff; font-weight: 700; font-size: 22px; margin: 0 0 6px; letter-spacing: -.01em; }
        .sislac-dashboard .s-hero p { color: rgba(255,255,255,.88); margin: 0; font-size: 13.5px; }

        .sislac-dashboard .s-profile {
            padding: 22px 26px 26px; display: flex; align-items: center; gap: 14px;
        }
        .sislac-dashboard .s-profile img {
            width: 60px; height: 60px; border-radius: 50%; object-fit: cover;
            border: 3px solid #fff; box-shadow: 0 6px 18px rgba(79,70,229,.28);
        }
        .sislac-dashboard .s-profile .s-name { font-weight: 700; font-size: 16px; color: var(--s-ink); margin: 0; }
        .sislac-dashboard .s-profile .s-role { font-size: 11.5px; color: var(--s-muted); margin: 3px 0 0; text-transform: uppercase; letter-spacing: .08em; font-weight: 600; }

        .sislac-dashboard .s-stat {
            padding: 22px;
            display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
            height: 100%;
        }
        .sislac-dashboard .s-stat .s-label {
            font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
            color: var(--s-muted); margin: 0 0 12px;
        }
        .sislac-dashboard .s-stat .s-value {
            font-size: 32px; font-weight: 800; color: var(--s-ink); line-height: 1; margin: 0;
            letter-spacing: -.02em;
        }
        .sislac-dashboard .s-stat .s-sub {
            font-size: 13px; color: var(--s-muted); margin-top: 8px; line-height: 1.55;
        }
        .sislac-dashboard .s-stat .s-sub strong { color: var(--s-ink); font-weight: 700; }
        .sislac-dashboard .s-icon {
            width: 46px; height: 46px; border-radius: 13px;
            background: linear-gradient(135deg, var(--s-primary-50), #f5f3ff);
            color: var(--s-primary);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 22px; flex-shrink: 0;
            border: 1px solid var(--s-primary-100);
        }

        .sislac-dashboard .s-section-title {
            font-size: 17px; font-weight: 700; color: var(--s-ink); margin: 0; letter-spacing: -.01em;
        }
        .sislac-dashboard .s-btn-primary {
            background: var(--s-primary); border: none; color: #fff;
            padding: 10px 18px; border-radius: 999px; font-weight: 600; font-size: 13px;
            box-shadow: 0 6px 16px rgba(79,70,229,.28);
            transition: all .2s ease;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .sislac-dashboard .s-btn-primary:hover {
            background: var(--s-primary-600); color: #fff;
            transform: translateY(-1px); box-shadow: 0 8px 20px rgba(79,70,229,.38);
        }

        .sislac-dashboard .s-table { width: 100%; }
        .sislac-dashboard .s-table thead th {
            background: transparent;
            color: var(--s-muted);
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            padding: 14px 14px; border: none;
            border-bottom: 1px solid var(--s-border-soft);
        }
        .sislac-dashboard .s-table tbody td {
            padding: 16px 14px; border-top: 1px solid var(--s-border-soft);
            font-size: 13.5px; vertical-align: middle;
        }
        .sislac-dashboard .s-table tbody tr:hover { background: #fafbff; }

        .sislac-dashboard .s-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 10px 4px 8px; border-radius: 999px;
            font-size: 11.5px; font-weight: 700; letter-spacing: .02em;
        }
        .sislac-dashboard .s-pill::before {
            content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: .9;
        }
        .sislac-dashboard .s-pill-warn { background: #fef3c7; color: #92400e; }
        .sislac-dashboard .s-pill-ok   { background: #d1fae5; color: #065f46; }
        .sislac-dashboard .s-pill-bad  { background: #fee2e2; color: #991b1b; }

        .sislac-dashboard .s-campaign {
            border-radius: var(--s-radius); overflow: hidden; margin-top: 20px;
            box-shadow: var(--s-shadow);
            border: 1px solid var(--s-border-soft);
        }
        .sislac-dashboard .s-campaign img { display: block; width: 100%; height: 140px; object-fit: cover; }
        .sislac-dashboard .s-chart-card { padding: 26px; }

        .sislac-dashboard .pagination { gap: 4px; }
        .sislac-dashboard .pagination .page-link {
            border: 1px solid var(--s-border-soft); border-radius: 10px;
            color: var(--s-ink); padding: 6px 12px; font-size: 13px;
        }
        .sislac-dashboard .pagination .page-item.active .page-link {
            background: var(--s-primary); border-color: var(--s-primary); color: #fff;
        }
    </style>

    <div class="sislac-dashboard">
        @if ($role == 'admin' || $role == 'doctor')
            @include('layouts.admin-dashboard')
        @elseif ($role == 'receptionist' || $role == 'biomedical')
            @include('layouts.receptionist-dashboard')
        @endif
    </div>
@endsection

@section('script')
    @if ($role == 'admin' || $role == 'doctor')
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
    @endif
@endsection
