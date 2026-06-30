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
            --s-ink: #0f172a;
            --s-muted: #64748b;
            --s-border: #e5e7eb;
            --s-bg: #f8fafc;
            --s-radius: 16px;
            --s-shadow: 0 1px 2px rgba(15,23,42,.04), 0 8px 24px -12px rgba(79,70,229,.18);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--s-ink);
        }
        .sislac-dashboard .s-card {
            background: #fff;
            border: 1px solid var(--s-border);
            border-radius: var(--s-radius);
            box-shadow: var(--s-shadow);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .sislac-dashboard .s-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(15,23,42,.05), 0 16px 32px -16px rgba(79,70,229,.28);
        }
        .sislac-dashboard .s-hero {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #8b5cf6 100%);
            border-radius: var(--s-radius);
            color: #fff;
            padding: 28px 24px 20px;
            position: relative;
            overflow: hidden;
        }
        .sislac-dashboard .s-hero::after {
            content: "";
            position: absolute;
            inset: auto -40px -60px auto;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(255,255,255,.25), transparent 70%);
            border-radius: 50%;
        }
        .sislac-dashboard .s-hero h5 {
            color: #fff; font-weight: 700; font-size: 20px; margin: 0 0 4px;
        }
        .sislac-dashboard .s-hero p { color: rgba(255,255,255,.85); margin: 0; font-size: 13px; }
        .sislac-dashboard .s-profile {
            padding: 20px 24px 24px; display: flex; align-items: center; gap: 14px;
        }
        .sislac-dashboard .s-profile img {
            width: 56px; height: 56px; border-radius: 50%; object-fit: cover;
            border: 3px solid #fff; box-shadow: 0 4px 14px rgba(79,70,229,.25);
        }
        .sislac-dashboard .s-profile .s-name { font-weight: 700; font-size: 15px; color: var(--s-ink); margin: 0; }
        .sislac-dashboard .s-profile .s-role { font-size: 12px; color: var(--s-muted); margin: 2px 0 0; text-transform: uppercase; letter-spacing: .04em; }

        .sislac-dashboard .s-stat {
            padding: 20px;
            display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
            height: 100%;
        }
        .sislac-dashboard .s-stat .s-label {
            font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em;
            color: var(--s-muted); margin: 0 0 10px;
        }
        .sislac-dashboard .s-stat .s-value {
            font-size: 28px; font-weight: 700; color: var(--s-ink); line-height: 1; margin: 0;
        }
        .sislac-dashboard .s-stat .s-sub {
            font-size: 13px; color: var(--s-muted); margin-top: 6px; line-height: 1.5;
        }
        .sislac-dashboard .s-stat .s-sub strong { color: var(--s-ink); font-weight: 600; }
        .sislac-dashboard .s-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: var(--s-primary-50);
            color: var(--s-primary);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 22px; flex-shrink: 0;
        }
        .sislac-dashboard .s-section-title {
            font-size: 16px; font-weight: 700; color: var(--s-ink); margin: 0;
        }
        .sislac-dashboard .s-btn-primary {
            background: var(--s-primary); border: none; color: #fff;
            padding: 10px 18px; border-radius: 10px; font-weight: 600; font-size: 13px;
            box-shadow: 0 4px 12px rgba(79,70,229,.25);
            transition: all .2s ease;
        }
        .sislac-dashboard .s-btn-primary:hover {
            background: var(--s-primary-600); color: #fff;
            transform: translateY(-1px); box-shadow: 0 6px 18px rgba(79,70,229,.35);
        }
        .sislac-dashboard .s-table {
            width: 100%;
        }
        .sislac-dashboard .s-table thead th {
            background: var(--s-primary-50);
            color: var(--s-primary-600);
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em;
            padding: 12px 14px; border: none;
        }
        .sislac-dashboard .s-table tbody td {
            padding: 14px; border-top: 1px solid var(--s-border);
            font-size: 13.5px; vertical-align: middle;
        }
        .sislac-dashboard .s-table tbody tr:hover { background: #fafbff; }
        .sislac-dashboard .s-pill {
            display: inline-block; padding: 4px 10px; border-radius: 999px;
            font-size: 11px; font-weight: 700; letter-spacing: .03em;
        }
        .sislac-dashboard .s-pill-warn { background: #fef3c7; color: #92400e; }
        .sislac-dashboard .s-pill-ok   { background: #d1fae5; color: #065f46; }
        .sislac-dashboard .s-pill-bad  { background: #fee2e2; color: #991b1b; }
        .sislac-dashboard .s-campaign {
            border-radius: var(--s-radius); overflow: hidden; margin-top: 20px;
            box-shadow: var(--s-shadow);
        }
        .sislac-dashboard .s-campaign img { display: block; width: 100%; height: 140px; object-fit: cover; }
        .sislac-dashboard .s-chart-card { padding: 24px; }
        .sislac-dashboard .s-page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
        }
        .sislac-dashboard .s-page-header h4 {
            font-size: 24px; font-weight: 700; color: var(--s-ink); margin: 0;
        }
        .sislac-dashboard .s-page-header .s-crumb {
            color: var(--s-muted); font-size: 13px;
        }
        .sislac-dashboard .pagination { gap: 4px; }
        .sislac-dashboard .pagination .page-link {
            border: 1px solid var(--s-border); border-radius: 8px;
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
