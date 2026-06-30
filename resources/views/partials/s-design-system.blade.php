{{-- 
    SISLAC Design System - Shared Styles
    Include with: @section('css') @include('partials.s-design-system') @endsection
--}}
<style>
:root{
    --s-primary:#4f46e5;
    --s-secondary:#8b5cf6;
    --s-accent:#4338ca;
    --s-bg:#f6f7fb;
    --s-surface:#ffffff;
    --s-border:#eceff5;
    --s-border-strong:#e2e6ef;
    --s-text:#0f172a;
    --s-muted:#6b7280;
    --s-soft:#f8fafc;
    --s-success:#10b981;
    --s-warn:#f59e0b;
    --s-danger:#ef4444;
    --s-info:#0ea5e9;
}

/* ===== Layout ===== */
.s-page{background:var(--s-bg);min-height:calc(100vh - 70px);padding:22px 8px;}
.s-head{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:18px;}
.s-head-title h1{font-size:1.35rem;font-weight:800;margin:0;color:var(--s-text);letter-spacing:-.01em;display:flex;align-items:center;gap:10px;}
.s-head-title h1::before{content:"";width:6px;height:24px;border-radius:4px;background:linear-gradient(180deg,var(--s-primary),var(--s-secondary));}
.s-head-title p{margin:4px 0 0 16px;color:var(--s-muted);font-size:.85rem;}
.s-head-actions{display:flex;gap:8px;flex-wrap:wrap;}

/* ===== Buttons ===== */
.s-btn{display:inline-flex;align-items:center;gap:8px;border:0;border-radius:11px;padding:9px 16px;font-weight:600;font-size:.85rem;cursor:pointer;transition:all .2s;text-decoration:none;white-space:nowrap;}
.s-btn i{font-size:1.05rem;}
.s-btn-primary{background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));color:#fff;box-shadow:0 6px 18px -8px rgba(79,70,229,.55);}
.s-btn-primary:hover{transform:translateY(-1px);color:#fff;box-shadow:0 10px 24px -10px rgba(79,70,229,.7);}
.s-btn-ghost{background:#fff;color:var(--s-text);border:1px solid var(--s-border-strong);}
.s-btn-ghost:hover{background:#f8fafc;color:var(--s-text);}
.s-btn-danger{background:linear-gradient(135deg,#ef4444,#f97316);color:#fff;}
.s-btn-danger:hover{transform:translateY(-1px);color:#fff;}

/* ===== Alerts ===== */
.s-alert{border-radius:12px;border:1px solid;padding:11px 16px;display:flex;align-items:center;gap:10px;margin-bottom:14px;font-size:.875rem;}
.s-alert.success{background:#ecfdf5;color:#065f46;border-color:#a7f3d0;}
.s-alert.danger{background:#fef2f2;color:#991b1b;border-color:#fecaca;}
.s-alert.info{background:#eff6ff;color:#1e40af;border-color:#bfdbfe;}

/* ===== Card ===== */
.s-card{background:var(--s-surface);border:1px solid var(--s-border);border-radius:16px;overflow:hidden;box-shadow:0 1px 2px rgba(15,23,42,.03);}
.s-card-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 18px;border-bottom:1px solid var(--s-border);flex-wrap:wrap;}
.s-card-head-left{display:flex;align-items:center;gap:10px;}
.s-card-head-left h2{margin:0;font-size:.95rem;font-weight:700;color:var(--s-text);}
.s-card-body{padding:18px;}
.s-count{background:#eef2ff;color:var(--s-accent);font-weight:700;font-size:.72rem;padding:3px 9px;border-radius:999px;}

/* ===== Search ===== */
.s-search{position:relative;min-width:220px;flex:1;max-width:360px;}
.s-search input{width:100%;border:1px solid var(--s-border-strong);background:#fff;border-radius:11px;padding:9px 12px 9px 36px;font-size:.875rem;outline:none;transition:.2s;color:var(--s-text);}
.s-search input:focus{border-color:var(--s-primary);box-shadow:0 0 0 3px rgba(79,70,229,.12);}
.s-search i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--s-muted);font-size:1rem;}

/* ===== Table ===== */
.s-table-wrap{overflow:auto;max-height:680px;}
.s-table{width:100%;border-collapse:separate;border-spacing:0;margin:0;}
.s-table thead th{position:sticky;top:0;background:#fbfbfd;z-index:1;font-size:.68rem;letter-spacing:.1em;text-transform:uppercase;color:#94a3b8;font-weight:700;padding:12px 18px;text-align:left;border-bottom:1px solid var(--s-border);}
.s-table tbody td{padding:14px 18px;font-size:.88rem;color:var(--s-text);border-bottom:1px solid #f3f4f8;vertical-align:middle;}
.s-table tbody tr{transition:background .15s;}
.s-table tbody tr:hover{background:#fafbff;}
.s-table tbody tr:last-child td{border-bottom:0;}
.s-table a{color:var(--s-accent);text-decoration:none;font-weight:600;}
.s-table a:hover{text-decoration:underline;}

/* ===== Table elements ===== */
.s-num{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:8px;background:#f1f5f9;color:#64748b;font-weight:700;font-size:.72rem;}
.s-avatar{display:flex;align-items:center;gap:11px;min-width:0;}
.s-av{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;color:#fff;font-weight:700;font-size:.82rem;flex-shrink:0;background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));box-shadow:0 4px 10px -4px rgba(79,70,229,.5);}
.s-av-info{min-width:0;}
.s-name{font-weight:600;color:var(--s-text);line-height:1.2;}
.s-meta{font-size:.74rem;color:var(--s-muted);margin-top:2px;}

.s-tag{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:8px;font-size:.74rem;font-weight:600;background:#f1f5f9;color:#475569;}
.s-tag.outline{background:#fff;border:1px solid var(--s-border-strong);}
.s-tag.indigo{background:#eef2ff;color:var(--s-accent);}
.s-tag.green{background:#d1fae5;color:#047857;}
.s-tag.amber{background:#fef3c7;color:#92400e;}
.s-tag.pink{background:#fce7f3;color:#9d174d;}

.s-status{display:inline-flex;align-items:center;gap:7px;padding:4px 10px;border-radius:999px;font-size:.74rem;font-weight:600;}
.s-status .s-dot{width:7px;height:7px;border-radius:50%;}
.s-status.on{background:#ecfdf5;color:#047857;}
.s-status.on .s-dot{background:#10b981;box-shadow:0 0 0 3px rgba(16,185,129,.15);}
.s-status.off{background:#fef2f2;color:#b91c1c;}
.s-status.off .s-dot{background:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.15);}
.s-status.pending{background:#fef3c7;color:#92400e;}
.s-status.pending .s-dot{background:#f59e0b;box-shadow:0 0 0 3px rgba(245,158,11,.15);}
.s-status.info{background:#eff6ff;color:#1e40af;}
.s-status.info .s-dot{background:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.15);}

.s-actions{display:inline-flex;gap:6px;}
.s-icon-btn{width:34px;height:34px;display:grid;place-items:center;border-radius:10px;background:#f8fafc;color:#64748b;border:1px solid var(--s-border);cursor:pointer;transition:.15s;text-decoration:none;font-size:1rem;}
.s-icon-btn:hover{transform:translateY(-1px);}
.s-icon-btn.view:hover{background:#e0f2fe;color:#0369a1;border-color:#bae6fd;}
.s-icon-btn.edit:hover{background:#eef2ff;color:var(--s-accent);border-color:#c7d2fe;}
.s-icon-btn.mail:hover{background:#fce7f3;color:#be185d;border-color:#fbcfe8;}
.s-icon-btn.del:hover{background:#fee2e2;color:#b91c1c;border-color:#fecaca;}

.s-empty{padding:60px 20px;text-align:center;color:var(--s-muted);}
.s-empty i{font-size:3rem;color:#cbd5e1;display:block;margin-bottom:8px;}

/* ===== Pagination Footer ===== */
.s-foot{padding:14px 18px;border-top:1px solid var(--s-border);display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;}
.s-foot-info{font-size:.8rem;color:var(--s-muted);}
.s-foot .pagination{margin:0;}
.s-foot .page-item .page-link{border-radius:9px!important;margin:0 2px;border:1px solid var(--s-border-strong);color:var(--s-text);font-size:.82rem;padding:6px 11px;background:#fff;}
.s-foot .page-item.active .page-link{background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));border-color:transparent;color:#fff;}
.s-foot .page-item.disabled .page-link{color:#cbd5e1;}

/* ===== Forms ===== */
.s-form-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:16px;}
.s-field{display:flex;flex-direction:column;gap:6px;}
.s-field label{font-size:.78rem;font-weight:600;color:var(--s-text);}
.s-field label .req{color:var(--s-danger);}
.s-field .form-control,.s-field input:not([type="checkbox"]):not([type="radio"]),.s-field select,.s-field textarea{
    width:100%;border:1px solid var(--s-border-strong);background:#fff;border-radius:11px;
    padding:10px 12px;font-size:.875rem;color:var(--s-text);outline:none;transition:.2s;
}
.s-field .form-control:focus,.s-field input:focus,.s-field select:focus,.s-field textarea:focus{
    border-color:var(--s-primary);box-shadow:0 0 0 3px rgba(79,70,229,.12);
}
.s-field .help{font-size:.72rem;color:var(--s-muted);}
.s-field .err{font-size:.74rem;color:var(--s-danger);}
.s-form-foot{display:flex;justify-content:flex-end;gap:8px;padding-top:18px;margin-top:18px;border-top:1px solid var(--s-border);}
.s-section-title{display:flex;align-items:center;gap:10px;font-size:.95rem;font-weight:700;color:var(--s-text);margin:0 0 14px;}
.s-section-title::before{content:"";width:4px;height:18px;border-radius:3px;background:linear-gradient(180deg,var(--s-primary),var(--s-secondary));}

/* ===== Profile header ===== */
.s-profile{
    background:linear-gradient(120deg,#4338ca 0%,#4f46e5 45%,#8b5cf6 100%);
    color:#fff;border-radius:18px;padding:22px;margin-bottom:18px;
    box-shadow:0 12px 30px -16px rgba(79,70,229,.5);position:relative;overflow:hidden;
}
.s-profile::after{content:"";position:absolute;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,.08);right:-80px;top:-80px;}
.s-profile-inner{display:flex;align-items:center;gap:18px;position:relative;z-index:1;flex-wrap:wrap;}
.s-profile-av{width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,.18);display:grid;place-items:center;font-size:1.5rem;font-weight:800;color:#fff;flex-shrink:0;backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);}
.s-profile-info h2{margin:0;font-size:1.35rem;font-weight:800;}
.s-profile-info p{margin:4px 0 0;opacity:.85;font-size:.88rem;}

/* ===== Responsive ===== */
@media (max-width:991px){
    .s-head{flex-direction:column;align-items:flex-start;}
}
@media (max-width:575px){
    .s-page{padding:12px 4px;}
    .s-card-head{padding:12px 14px;}
    .s-card-body{padding:14px;}
    .s-search{max-width:100%;}
    .s-table thead{display:none;}
    .s-table,.s-table tbody,.s-table tr,.s-table td{display:block;width:100%;}
    .s-table tr{padding:12px 14px;border-bottom:1px solid var(--s-border);}
    .s-table td{border:0;padding:6px 0;display:flex;justify-content:space-between;align-items:center;gap:10px;text-align:right;}
    .s-table td::before{content:attr(data-label);font-size:.68rem;text-transform:uppercase;letter-spacing:.08em;color:var(--s-muted);font-weight:700;text-align:left;}
    .s-table td:first-child::before,.s-table td.s-cell-main::before{content:"";}
    .s-cell-main{justify-content:flex-start!important;text-align:left!important;}
    .s-actions{justify-content:flex-end;}
}
</style>
