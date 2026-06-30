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
        .sislac-dashboard .s-pill-soft { background: #f1f5f9; color: #475569; }

        /* ===== Botões extras ===== */
        .sislac-dashboard .s-btn-dark {
            display: inline-flex; align-items: center; gap: 8px;
            background: #0f172a; color: #fff; border: none;
            padding: 11px 18px; border-radius: 999px;
            font-size: 13.5px; font-weight: 600;
            box-shadow: 0 8px 20px rgba(15,23,42,.18);
            transition: all .2s ease;
        }
        .sislac-dashboard .s-btn-dark:hover { background: #1e293b; color: #fff; transform: translateY(-1px); }
        .sislac-dashboard .s-btn-glass {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.14); color: #fff;
            border: 1px solid rgba(255,255,255,.28);
            padding: 11px 18px; border-radius: 999px;
            font-size: 13.5px; font-weight: 600;
            backdrop-filter: blur(8px);
            transition: all .2s ease;
        }
        .sislac-dashboard .s-btn-glass:hover { background: rgba(255,255,255,.22); color: #fff; }

        /* ===== Banner hero (estilo appsislac) ===== */
        .sislac-dashboard .s-banner {
            position: relative; overflow: hidden;
            border-radius: var(--s-radius);
            background: linear-gradient(120deg, #5b50e8 0%, #6d5cf0 45%, #8b5cf6 100%);
            color: #fff;
            padding: 36px 36px 32px;
            min-height: 220px;
            box-shadow: 0 20px 50px -24px rgba(79,70,229,.55);
        }
        .sislac-dashboard .s-banner-content { position: relative; z-index: 2; max-width: 620px; }
        .sislac-dashboard .s-banner-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.28);
            color: #fff; font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .12em;
            padding: 5px 12px; border-radius: 999px;
            backdrop-filter: blur(6px);
        }
        .sislac-dashboard .s-banner h3 {
            color: #fff; font-weight: 800; letter-spacing: -.02em;
            font-size: clamp(22px, 2.6vw, 32px);
            margin: 16px 0 8px; line-height: 1.15;
        }
        .sislac-dashboard .s-banner p { color: rgba(255,255,255,.85); margin: 0 0 22px; font-size: 14px; }
        .sislac-dashboard .s-banner-actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .sislac-dashboard .s-banner-art {
            position: absolute; inset: 0 0 0 auto; width: 55%;
            background:
                radial-gradient(60% 80% at 80% 30%, rgba(255,255,255,.35), transparent 60%),
                repeating-linear-gradient(115deg, rgba(255,255,255,.08) 0 2px, transparent 2px 18px);
            mask-image: linear-gradient(90deg, transparent, #000 35%);
            pointer-events: none;
        }

        /* ===== Stat cards estilo appsislac (com arte) ===== */
        .sislac-dashboard .s-stat-2 {
            position: relative; overflow: hidden;
            padding: 22px 22px 24px;
            min-height: 158px;
        }
        .sislac-dashboard .s-stat-2 .s-label {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .1em; color: var(--s-muted); margin: 0 0 14px;
        }
        .sislac-dashboard .s-stat-2 .s-big {
            font-size: 34px; font-weight: 800; color: var(--s-ink);
            margin: 0; letter-spacing: -.02em; line-height: 1;
        }
        .sislac-dashboard .s-stat-2 .s-sub {
            font-size: 12.5px; color: var(--s-muted); margin: 10px 0 0;
        }
        .sislac-dashboard .s-stat-art {
            position: absolute; right: -12px; bottom: -12px;
            width: 110px; height: 70px; opacity: .65;
            pointer-events: none;
        }
        .sislac-dashboard .s-art-donut {
            background:
                radial-gradient(circle at 60% 60%, transparent 22px, var(--s-primary-100) 22px 32px, transparent 33px);
        }
        .sislac-dashboard .s-art-grid {
            background-image:
                linear-gradient(var(--s-primary-100) 1px, transparent 1px),
                linear-gradient(90deg, var(--s-primary-100) 1px, transparent 1px);
            background-size: 14px 14px;
        }
        .sislac-dashboard .s-art-line {
            background:
                linear-gradient(180deg, transparent 60%, rgba(139,92,246,.18) 100%),
                radial-gradient(60% 60% at 30% 70%, rgba(79,70,229,.22), transparent 70%);
        }
        .sislac-dashboard .s-art-bars {
            background:
                linear-gradient(to top, var(--s-primary-100) 30%, transparent 30%) 0    bottom/12px 30% no-repeat,
                linear-gradient(to top, var(--s-primary-100) 55%, transparent 55%) 18px bottom/12px 55% no-repeat,
                linear-gradient(to top, var(--s-primary-100) 40%, transparent 40%) 36px bottom/12px 40% no-repeat,
                linear-gradient(to top, var(--s-primary-100) 70%, transparent 70%) 54px bottom/12px 70% no-repeat,
                linear-gradient(to top, var(--s-primary-100) 50%, transparent 50%) 72px bottom/12px 50% no-repeat,
                linear-gradient(to top, var(--s-primary-100) 85%, transparent 85%) 90px bottom/12px 85% no-repeat;
        }

        /* ===== Painéis (Fluxo, Pacientes, Produtividade) ===== */
        .sislac-dashboard .s-panel { padding: 22px 22px 18px; }
        .sislac-dashboard .s-panel-head {
            display: flex; align-items: flex-start; justify-content: space-between;
            gap: 12px; margin-bottom: 16px;
        }
        .sislac-dashboard .s-panel-sub { font-size: 12.5px; color: var(--s-muted); margin: 4px 0 0; }
        .sislac-dashboard .s-link { color: var(--s-primary); font-size: 12.5px; font-weight: 600; }

        /* Fluxo operacional rows */
        .sislac-dashboard .s-flow { display: flex; flex-direction: column; gap: 10px; }
        .sislac-dashboard .s-flow-row {
            display: grid;
            grid-template-columns: 44px 1fr auto auto;
            align-items: center; gap: 14px;
            padding: 14px 16px;
            background: #fafbff;
            border: 1px solid var(--s-border-soft);
            border-radius: 14px;
            transition: all .2s ease;
        }
        .sislac-dashboard .s-flow-row:hover { background: #fff; border-color: var(--s-primary-100); transform: translateX(2px); }
        .sislac-dashboard .s-flow-ic {
            width: 38px; height: 38px; border-radius: 11px;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--s-primary-50); color: var(--s-primary);
            font-size: 20px; border: 1px solid var(--s-primary-100);
        }
        .sislac-dashboard .s-flow-ic-warn { background: #fef3c7; color: #b45309; border-color: #fde68a; }
        .sislac-dashboard .s-flow-ic-dark { background: #0f172a; color: #fff; border-color: #0f172a; }
        .sislac-dashboard .s-flow-text { font-weight: 600; font-size: 14px; color: var(--s-ink); }
        .sislac-dashboard .s-flow-val { font-weight: 800; font-size: 18px; color: var(--s-ink); min-width: 28px; text-align: right; }

        /* KPI blocks */
        .sislac-dashboard .s-kpi-block { margin-bottom: 16px; }
        .sislac-dashboard .s-kpi-block .s-label {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .1em; color: var(--s-muted); margin: 0 0 8px;
        }
        .sislac-dashboard .s-kpi-block .s-big {
            font-size: 36px; font-weight: 800; letter-spacing: -.02em; margin: 0; color: var(--s-ink);
        }
        .sislac-dashboard .s-kpi-line {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-top: 1px solid var(--s-border-soft);
            font-size: 13.5px; color: var(--s-muted);
        }
        .sislac-dashboard .s-kpi-line strong { color: var(--s-ink); font-weight: 700; }
        .sislac-dashboard .s-kpi-line .s-pos { color: #059669; }
        .sislac-dashboard .s-kpi-line i { margin-right: 6px; }

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
        <script>
            (function() {
                var el = document.querySelector("#monthly_users");
                if (!el) return;

                // limpa qualquer instância antiga (do dashboard.init.js)
                el.innerHTML = '';

                var months = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
                var atend = [0,0,0,0,0,0,0,0,0,0,0,0];
                var exam  = [0,0,0,0,0,0,0,0,0,0,0,0];

                function render() {
                    var opts = {
                        series: [
                            { name: 'Atendimentos', type: 'area', data: atend },
                            { name: 'Exames',       type: 'area', data: exam  }
                        ],
                        chart: {
                            height: 340, type: 'area',
                            fontFamily: 'Inter, system-ui, sans-serif',
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            dropShadow: {
                                enabled: true, top: 6, left: 0, blur: 12,
                                color: '#4f46e5', opacity: 0.18
                            },
                            animations: {
                                enabled: true, easing: 'easeinout', speed: 700,
                                animateGradually: { enabled: true, delay: 120 }
                            }
                        },
                        colors: ['#4f46e5', '#8b5cf6'],
                        stroke: { curve: 'smooth', width: [3, 3], lineCap: 'round' },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.45,
                                opacityTo: 0.02,
                                stops: [0, 95, 100]
                            }
                        },
                        markers: {
                            size: 0,
                            strokeWidth: 2, strokeColors: '#fff',
                            hover: { size: 7 }
                        },
                        dataLabels: { enabled: false },
                        grid: {
                            borderColor: '#eef0f4',
                            strokeDashArray: 4,
                            padding: { left: 10, right: 10, top: -10 },
                            xaxis: { lines: { show: false } },
                            yaxis: { lines: { show: true } }
                        },
                        xaxis: {
                            categories: months,
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: {
                                style: { colors: '#94a3b8', fontSize: '12px', fontWeight: 600 }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: { colors: '#94a3b8', fontSize: '12px' },
                                formatter: function(v) { return Math.round(v); }
                            }
                        },
                        legend: {
                            position: 'top', horizontalAlign: 'right',
                            fontSize: '13px', fontWeight: 600,
                            labels: { colors: '#475569' },
                            markers: { width: 10, height: 10, radius: 10, offsetX: -2 },
                            itemMargin: { horizontal: 14 }
                        },
                        tooltip: {
                            theme: 'light',
                            shared: true, intersect: false,
                            style: { fontSize: '13px', fontFamily: 'Inter, sans-serif' },
                            y: { formatter: function(v) { return v + ''; } },
                            marker: { show: true }
                        }
                    };
                    new ApexCharts(el, opts).render();
                }

                if (window.jQuery) {
                    jQuery.ajax({
                        type: 'GET', url: 'getMonthlyUsersRevenue', dataType: 'json',
                        success: function(data) {
                            for (var i = 0; i < 12; i++) {
                                if (data.total_appointment[i] !== undefined) {
                                    atend.splice(data.total_appointment[i].Month - 1, 1, data.total_appointment[i].total_appointment);
                                }
                                if (data.total_exams[i] !== undefined) {
                                    exam.splice(data.total_exams[i].Month - 1, 1, data.total_exams[i].total_exams);
                                }
                            }
                            render();
                        },
                        error: function() { render(); }
                    });
                } else { render(); }
            })();
        </script>
    @endif
@endsection
