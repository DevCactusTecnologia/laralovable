{{-- SISLAC Modern: redesign minimalista — Cloud White + Sora/Manrope --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ============================================================
 *  TOKENS — Cloud White
 * ============================================================ */
:root{
    --s-bg:        #fafbfc;
    --s-surface:   #ffffff;
    --s-soft:      #f4f6fa;
    --s-border:    #e8ecf1;
    --s-border-2:  #dfe4ec;
    --s-text:      #0f172a;
    --s-text-2:    #475569;
    --s-muted:     #94a3b8;
    --s-primary:   #3b82f6;
    --s-primary-2: #2563eb;
    --s-primary-50:#eff6ff;
    --s-accent:    #0ea5e9;
    --s-ok:        #10b981;
    --s-warn:      #f59e0b;
    --s-err:       #ef4444;

    --s-radius:    14px;
    --s-radius-sm: 10px;
    --s-radius-xs: 8px;
    --s-shadow-1:  0 1px 2px rgba(15,23,42,.04);
    --s-shadow-2:  0 1px 2px rgba(15,23,42,.04), 0 8px 24px -12px rgba(15,23,42,.08);
    --s-shadow-3:  0 1px 2px rgba(15,23,42,.04), 0 20px 40px -20px rgba(59,130,246,.18);

    --s-font-head: 'Sora', system-ui, -apple-system, sans-serif;
    --s-font-body: 'Manrope', system-ui, -apple-system, sans-serif;
}

/* Dark theme override (já existe toggle no Phase 1) */
body.s-dark{
    --s-bg:        #0b1020;
    --s-surface:   #111733;
    --s-soft:      #0f1530;
    --s-border:    #1f2745;
    --s-border-2:  #2a3358;
    --s-text:      #e5e7eb;
    --s-text-2:    #cbd5e1;
    --s-muted:     #94a3b8;
    --s-primary-50:#172046;
}

/* ============================================================
 *  TIPOGRAFIA GLOBAL (escopo .s-page para não quebrar fora)
 * ============================================================ */
.s-page, .s-page *{font-family:var(--s-font-body);}
.s-page h1,.s-page h2,.s-page h3,.s-page h4,.s-page h5,.s-page h6,
.s-page .card-title,.s-page .page-title{
    font-family:var(--s-font-head);
    letter-spacing:-.015em;font-weight:700;color:var(--s-text);
}
.s-page{
    background:var(--s-bg);color:var(--s-text);
    font-size:14px;line-height:1.55;
    -webkit-font-smoothing:antialiased;text-rendering:optimizeLegibility;
}

/* ============================================================
 *  CARDS
 * ============================================================ */
.s-page .card{
    background:var(--s-surface);
    border:1px solid var(--s-border);
    border-radius:var(--s-radius);
    box-shadow:var(--s-shadow-1);
    transition:box-shadow .22s ease, transform .22s ease, border-color .22s ease;
}
.s-page .card:hover{box-shadow:var(--s-shadow-2);}
.s-page .card-body{padding:1.25rem 1.4rem;}
.s-page .card-title{font-size:15px;font-weight:700;margin-bottom:1rem;}

/* ============================================================
 *  TABELAS MODERNAS
 * ============================================================ */
.s-page .table-responsive{
    background:var(--s-surface);
    border:1px solid var(--s-border);
    border-radius:var(--s-radius);
    overflow:hidden;
}
.s-page .table{
    width:100%;margin:0;border-collapse:separate;border-spacing:0;
    color:var(--s-text);font-size:13.5px;
}
.s-page .table thead th{
    background:var(--s-soft);
    color:var(--s-text-2);
    font-family:var(--s-font-head);
    font-weight:600;font-size:11.5px;
    letter-spacing:.06em;text-transform:uppercase;
    padding:14px 16px;border:0;border-bottom:1px solid var(--s-border);
    white-space:nowrap;
}
.s-page .table tbody td{
    padding:14px 16px;
    border:0;border-bottom:1px solid var(--s-border);
    vertical-align:middle;color:var(--s-text);
    transition:background .15s ease;
}
.s-page .table tbody tr:last-child td{border-bottom:0;}
.s-page .table tbody tr{transition:background .15s ease;}
.s-page .table tbody tr:hover td{background:var(--s-primary-50);}
.s-page .table.table-bordered{border:0;}
.s-page .table.table-bordered td,.s-page .table.table-bordered th{border:0;border-bottom:1px solid var(--s-border);}
.s-page .table-striped tbody tr:nth-of-type(odd) td{background:transparent;}
.s-page .table-striped tbody tr:nth-of-type(odd):hover td{background:var(--s-primary-50);}

body.s-dark .s-page .table thead th{background:#0f1530;color:#cbd5e1;}
body.s-dark .s-page .table tbody tr:hover td{background:#172046;}

/* Paginação Bootstrap mais leve */
.s-page .pagination{gap:4px;}
.s-page .pagination .page-link{
    border:1px solid var(--s-border);background:var(--s-surface);
    color:var(--s-text-2);border-radius:var(--s-radius-xs)!important;
    margin:0;min-width:34px;height:34px;
    display:inline-flex;align-items:center;justify-content:center;
    font-weight:600;font-size:13px;transition:all .15s ease;
}
.s-page .pagination .page-link:hover{border-color:var(--s-primary);color:var(--s-primary);background:var(--s-primary-50);}
.s-page .pagination .page-item.active .page-link{
    background:var(--s-primary);border-color:var(--s-primary);color:#fff;
    box-shadow:0 4px 12px -4px rgba(59,130,246,.4);
}
.s-page .pagination .page-item.disabled .page-link{opacity:.45;}

/* ============================================================
 *  BOTÕES — formato pill suave
 * ============================================================ */
.s-page .btn{
    font-family:var(--s-font-head);font-weight:600;font-size:13px;
    border-radius:var(--s-radius-sm);
    padding:9px 16px;border-width:1px;
    transition:all .18s ease;letter-spacing:.005em;
    display:inline-flex;align-items:center;gap:6px;
}
.s-page .btn i{font-size:16px;}
.s-page .btn-primary{
    background:var(--s-primary);border-color:var(--s-primary);color:#fff;
    box-shadow:0 4px 14px -4px rgba(59,130,246,.4);
}
.s-page .btn-primary:hover{background:var(--s-primary-2);border-color:var(--s-primary-2);transform:translateY(-1px);box-shadow:0 8px 20px -6px rgba(59,130,246,.5);}
.s-page .btn-secondary,.s-page .btn-light{
    background:var(--s-surface);border-color:var(--s-border-2);color:var(--s-text);
}
.s-page .btn-secondary:hover,.s-page .btn-light:hover{background:var(--s-soft);border-color:var(--s-primary);color:var(--s-primary);}
.s-page .btn-danger{background:var(--s-err);border-color:var(--s-err);box-shadow:0 4px 14px -4px rgba(239,68,68,.4);}
.s-page .btn-success{background:var(--s-ok);border-color:var(--s-ok);box-shadow:0 4px 14px -4px rgba(16,185,129,.4);}
.s-page .btn-warning{background:var(--s-warn);border-color:var(--s-warn);color:#fff;}
.s-page .btn-outline-primary{color:var(--s-primary);border-color:var(--s-border-2);background:transparent;}
.s-page .btn-outline-primary:hover{background:var(--s-primary);border-color:var(--s-primary);color:#fff;}
.s-page .btn-sm{padding:6px 12px;font-size:12px;}

/* Ícones de ação — quadradinhos minimalistas */
.s-page .s-icon-btn,
.s-page a.btn-sm.btn-rounded,
.s-page .table .btn-sm.btn-icon{
    width:34px;height:34px;padding:0;border-radius:var(--s-radius-xs);
    display:inline-flex;align-items:center;justify-content:center;
    background:var(--s-soft);border:1px solid var(--s-border);color:var(--s-text-2);
    transition:all .15s ease;
}
.s-page .s-icon-btn:hover,.s-page a.btn-sm.btn-rounded:hover{
    background:var(--s-primary);border-color:var(--s-primary);color:#fff;transform:translateY(-1px);
}
.s-page .s-icon-btn i,.s-page a.btn-sm.btn-rounded i{font-size:16px;line-height:1;}

/* ============================================================
 *  INPUTS
 * ============================================================ */
.s-page .form-control,
.s-page .form-select,
.s-page select.form-control,
.s-page input.form-control,
.s-page textarea.form-control{
    background:var(--s-surface);
    border:1px solid var(--s-border-2);
    border-radius:var(--s-radius-sm);
    padding:10px 14px;font-size:13.5px;color:var(--s-text);
    transition:all .15s ease;box-shadow:none;
    font-family:var(--s-font-body);
}
.s-page .form-control:focus,.s-page .form-select:focus{
    border-color:var(--s-primary);
    box-shadow:0 0 0 4px rgba(59,130,246,.12);outline:0;
}
.s-page .form-control::placeholder{color:var(--s-muted);}
.s-page label,.s-page .form-label{
    font-family:var(--s-font-head);font-weight:600;font-size:12.5px;
    color:var(--s-text-2);letter-spacing:.01em;margin-bottom:6px;
}
.s-page .input-group-text{
    background:var(--s-soft);border-color:var(--s-border-2);
    color:var(--s-muted);border-radius:var(--s-radius-sm);
}

/* ============================================================
 *  BADGES — pílulas suaves
 * ============================================================ */
.s-page .badge{
    font-family:var(--s-font-head);font-weight:600;font-size:11px;
    padding:5px 10px;border-radius:999px;letter-spacing:.02em;
    display:inline-flex;align-items:center;gap:5px;
}
.s-page .badge-primary,.s-page .bg-primary{background:rgba(59,130,246,.12)!important;color:var(--s-primary-2)!important;}
.s-page .badge-success,.s-page .bg-success{background:rgba(16,185,129,.12)!important;color:#047857!important;}
.s-page .badge-warning,.s-page .bg-warning{background:rgba(245,158,11,.14)!important;color:#b45309!important;}
.s-page .badge-danger, .s-page .bg-danger {background:rgba(239,68,68,.12)!important;color:#b91c1c!important;}
.s-page .badge-info,   .s-page .bg-info   {background:rgba(14,165,233,.12)!important;color:#0369a1!important;}
.s-page .badge-secondary,.s-page .bg-secondary{background:var(--s-soft)!important;color:var(--s-text-2)!important;}
.s-page .badge-light, .s-page .bg-light{background:var(--s-soft)!important;color:var(--s-text-2)!important;}

/* ============================================================
 *  ÍCONES — modernização visual (sem trocar arquivos)
 *  Damos peso e cor consistentes.
 * ============================================================ */
.s-page .mdi, .s-page .fa, .s-page .fas, .s-page .far, .s-page .fab{
    line-height:1;vertical-align:middle;
}
.s-page i.mdi[class*="-outline"]{font-weight:400;}

/* ============================================================
 *  TOPBAR — clean
 * ============================================================ */
#page-topbar, .navbar-header{
    background:var(--s-surface)!important;
    border-bottom:1px solid var(--s-border);
    box-shadow:none!important;
    backdrop-filter:saturate(180%) blur(10px);
}
.topnav, .navbar-brand-box{background:var(--s-surface)!important;border-bottom:1px solid var(--s-border);}
.topnav .navbar-nav .nav-link{
    color:var(--s-text-2)!important;font-family:var(--s-font-head);
    font-weight:600;font-size:13px;
    padding:.6rem 1rem;border-radius:var(--s-radius-xs);transition:all .15s ease;
}
.topnav .navbar-nav .nav-link:hover,
.topnav .navbar-nav .nav-link.active,
.topnav .navbar-nav .nav-item.active > .nav-link{
    color:var(--s-primary)!important;background:var(--s-primary-50);
}
.topnav .navbar-nav .dropdown-menu{
    border:1px solid var(--s-border);border-radius:var(--s-radius);
    box-shadow:var(--s-shadow-3);padding:6px;
}
.topnav .navbar-nav .dropdown-menu .dropdown-item{
    border-radius:var(--s-radius-xs);padding:.5rem .75rem;font-size:13px;color:var(--s-text-2);
}
.topnav .navbar-nav .dropdown-menu .dropdown-item:hover{background:var(--s-primary-50);color:var(--s-primary);}

/* Header icon buttons (sino, busca, theme, perfil) */
.header-item{color:var(--s-text-2)!important;}
.header-item:hover{color:var(--s-primary)!important;background:var(--s-primary-50);}
.noti-icon .badge{
    background:var(--s-err)!important;color:#fff;font-size:9.5px;
    padding:3px 6px;border-radius:999px;border:2px solid var(--s-surface);
}

/* ============================================================
 *  BREADCRUMB — minimalista
 * ============================================================ */
.s-page .breadcrumb,
.s-page .page-title-box{
    background:transparent;padding:0;margin-bottom:1.25rem;
}
.s-page .page-title-box h4{
    font-size:20px;font-weight:700;letter-spacing:-.02em;margin:0;
}
.s-page .breadcrumb-item,.s-page .breadcrumb-item a{
    color:var(--s-muted);font-size:12.5px;font-family:var(--s-font-head);font-weight:500;
}
.s-page .breadcrumb-item.active{color:var(--s-text-2);}
.s-page .breadcrumb-item + .breadcrumb-item::before{color:var(--s-muted);}

/* ============================================================
 *  ALERTAS / TOASTR
 * ============================================================ */
.s-page .alert{border:0;border-radius:var(--s-radius-sm);padding:.85rem 1rem;font-size:13.5px;}
.s-page .alert-success{background:rgba(16,185,129,.1);color:#065f46;}
.s-page .alert-danger {background:rgba(239,68,68,.1); color:#991b1b;}
.s-page .alert-warning{background:rgba(245,158,11,.12);color:#92400e;}
.s-page .alert-info   {background:rgba(59,130,246,.1); color:#1e40af;}

/* ============================================================
 *  SIDEBAR / RIGHT PANEL
 * ============================================================ */
.right-bar{border-left:1px solid var(--s-border);background:var(--s-surface);}

/* ============================================================
 *  FOOTER
 * ============================================================ */
.footer{
    background:var(--s-surface);border-top:1px solid var(--s-border);
    color:var(--s-muted);font-size:12.5px;
}

/* ============================================================
 *  CONTAINER — respiro maior
 * ============================================================ */
.s-page .page-content,.s-page.container-fluid{padding-top:1.5rem;padding-bottom:2rem;}
.s-page .row{margin-left:-10px;margin-right:-10px;}
.s-page .row > [class*="col-"]{padding-left:10px;padding-right:10px;}

/* ============================================================
 *  SCROLLBAR sutil
 * ============================================================ */
.s-page ::-webkit-scrollbar{width:10px;height:10px;}
.s-page ::-webkit-scrollbar-track{background:transparent;}
.s-page ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:8px;border:2px solid var(--s-bg);}
.s-page ::-webkit-scrollbar-thumb:hover{background:#94a3b8;}

/* ============================================================
 *  ANIMAÇÕES suaves de entrada
 * ============================================================ */
.s-page .card,.s-page .table-responsive{animation:sFadeUp .35s ease both;}
@keyframes sFadeUp{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:none;}}

/* SweetAlert custom (combina com phase1) */
.swal2-popup{border-radius:var(--s-radius)!important;font-family:var(--s-font-body)!important;}
.swal2-title{font-family:var(--s-font-head)!important;font-weight:700!important;color:var(--s-text)!important;}
.swal2-styled.swal2-confirm{background:var(--s-primary)!important;border-radius:var(--s-radius-sm)!important;font-family:var(--s-font-head)!important;font-weight:600!important;}
.swal2-styled.swal2-cancel{background:var(--s-soft)!important;color:var(--s-text)!important;border-radius:var(--s-radius-sm)!important;font-family:var(--s-font-head)!important;font-weight:600!important;}

/* DataTables alinhamento ao novo estilo */
.s-page .dataTables_wrapper .dataTables_length,
.s-page .dataTables_wrapper .dataTables_filter,
.s-page .dataTables_wrapper .dataTables_info,
.s-page .dataTables_wrapper .dataTables_paginate{color:var(--s-text-2);font-size:12.5px;}
.s-page .dataTables_wrapper .dataTables_filter input{
    border:1px solid var(--s-border-2);border-radius:var(--s-radius-sm);
    padding:6px 12px;margin-left:8px;font-size:13px;
}
</style>
