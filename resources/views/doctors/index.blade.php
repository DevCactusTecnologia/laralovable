@extends('layouts.master-layouts')
@section('title') Médicos @endsection
@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@endsection

@section('css')
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
}
.s-page{background:var(--s-bg);min-height:calc(100vh - 70px);padding:22px 8px;}
.s-head{
    display:flex;align-items:center;justify-content:space-between;gap:14px;
    flex-wrap:wrap;margin-bottom:18px;
}
.s-head-title h1{
    font-size:1.35rem;font-weight:800;margin:0;color:var(--s-text);letter-spacing:-.01em;
    display:flex;align-items:center;gap:10px;
}
.s-head-title h1::before{
    content:"";width:6px;height:24px;border-radius:4px;
    background:linear-gradient(180deg,var(--s-primary),var(--s-secondary));
}
.s-head-title p{margin:4px 0 0 16px;color:var(--s-muted);font-size:.85rem;}

.s-btn{
    display:inline-flex;align-items:center;gap:8px;border:0;border-radius:11px;
    padding:9px 16px;font-weight:600;font-size:.85rem;cursor:pointer;
    transition:all .2s;text-decoration:none;
}
.s-btn i{font-size:1.05rem;}
.s-btn-primary{
    background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));
    color:#fff;box-shadow:0 6px 18px -8px rgba(79,70,229,.55);
}
.s-btn-primary:hover{transform:translateY(-1px);color:#fff;box-shadow:0 10px 24px -10px rgba(79,70,229,.7);}

.s-alert{
    border-radius:12px;border:0;padding:11px 16px;background:#ecfdf5;color:#065f46;
    display:flex;align-items:center;gap:10px;margin-bottom:14px;font-size:.875rem;
    border:1px solid #a7f3d0;
}

.s-card{
    background:var(--s-surface);border:1px solid var(--s-border);border-radius:16px;
    overflow:hidden;box-shadow:0 1px 2px rgba(15,23,42,.03);
}
.s-card-head{
    display:flex;align-items:center;justify-content:space-between;gap:12px;
    padding:14px 18px;border-bottom:1px solid var(--s-border);flex-wrap:wrap;
}
.s-card-head-left{display:flex;align-items:center;gap:10px;}
.s-card-head-left h2{margin:0;font-size:.95rem;font-weight:700;color:var(--s-text);}
.s-count{
    background:#eef2ff;color:var(--s-accent);font-weight:700;font-size:.72rem;
    padding:3px 9px;border-radius:999px;
}

.s-search{position:relative;min-width:240px;flex:1;max-width:360px;}
.s-search input{
    width:100%;border:1px solid var(--s-border-strong);background:#fff;
    border-radius:11px;padding:9px 12px 9px 36px;font-size:.875rem;outline:none;
    transition:.2s;color:var(--s-text);
}
.s-search input:focus{border-color:var(--s-primary);box-shadow:0 0 0 3px rgba(79,70,229,.12);}
.s-search i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--s-muted);font-size:1rem;}

.s-table-wrap{overflow:auto;max-height:680px;}
.s-table{width:100%;border-collapse:separate;border-spacing:0;}
.s-table thead th{
    position:sticky;top:0;background:#fbfbfd;z-index:1;
    font-size:.68rem;letter-spacing:.1em;text-transform:uppercase;
    color:#94a3b8;font-weight:700;padding:12px 18px;text-align:left;
    border-bottom:1px solid var(--s-border);
}
.s-table tbody td{
    padding:14px 18px;font-size:.88rem;color:var(--s-text);
    border-bottom:1px solid #f3f4f8;vertical-align:middle;
}
.s-table tbody tr{transition:background .15s;}
.s-table tbody tr:hover{background:#fafbff;}
.s-table tbody tr:last-child td{border-bottom:0;}

.s-num{
    display:inline-grid;place-items:center;width:26px;height:26px;border-radius:8px;
    background:#f1f5f9;color:#64748b;font-weight:700;font-size:.72rem;
}
.s-avatar{display:flex;align-items:center;gap:11px;min-width:0;}
.s-av{
    width:38px;height:38px;border-radius:50%;display:grid;place-items:center;
    color:#fff;font-weight:700;font-size:.82rem;flex-shrink:0;
    background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));
    box-shadow:0 4px 10px -4px rgba(79,70,229,.5);
}
.s-av-info{min-width:0;}
.s-name{font-weight:600;color:var(--s-text);line-height:1.2;}
.s-meta{font-size:.74rem;color:var(--s-muted);margin-top:2px;}

.s-tag{
    display:inline-flex;align-items:center;gap:5px;padding:4px 10px;
    border-radius:8px;font-size:.74rem;font-weight:600;
    background:#f1f5f9;color:#475569;
}
.s-tag.outline{background:#fff;border:1px solid var(--s-border-strong);}

.s-status{
    display:inline-flex;align-items:center;gap:7px;padding:4px 10px;
    border-radius:999px;font-size:.74rem;font-weight:600;
}
.s-status .s-dot{width:7px;height:7px;border-radius:50%;}
.s-status.on{background:#ecfdf5;color:#047857;}
.s-status.on .s-dot{background:#10b981;box-shadow:0 0 0 3px rgba(16,185,129,.15);}
.s-status.off{background:#fef2f2;color:#b91c1c;}
.s-status.off .s-dot{background:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.15);}

.s-actions{display:inline-flex;gap:6px;}
.s-icon-btn{
    width:34px;height:34px;display:grid;place-items:center;border-radius:10px;
    background:#f8fafc;color:#64748b;border:1px solid var(--s-border);
    cursor:pointer;transition:.15s;text-decoration:none;font-size:1rem;
}
.s-icon-btn:hover{transform:translateY(-1px);}
.s-icon-btn.view:hover{background:#e0f2fe;color:#0369a1;border-color:#bae6fd;}
.s-icon-btn.edit:hover{background:#eef2ff;color:var(--s-accent);border-color:#c7d2fe;}

.s-empty{padding:60px 20px;text-align:center;color:var(--s-muted);}
.s-empty i{font-size:3rem;color:#cbd5e1;display:block;margin-bottom:8px;}

.s-foot{
    padding:14px 18px;border-top:1px solid var(--s-border);
    display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;
}
.s-foot-info{font-size:.8rem;color:var(--s-muted);}
.s-foot .pagination{margin:0;}
.s-foot .page-item .page-link{
    border-radius:9px!important;margin:0 2px;border:1px solid var(--s-border-strong);
    color:var(--s-text);font-size:.82rem;padding:6px 11px;background:#fff;
}
.s-foot .page-item.active .page-link{
    background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));
    border-color:transparent;color:#fff;
}
.s-foot .page-item.disabled .page-link{color:#cbd5e1;}

@media (max-width:991px){
    .s-head{flex-direction:column;align-items:flex-start;}
}
@media (max-width:575px){
    .s-page{padding:12px 4px;}
    .s-card-head{padding:12px 14px;}
    .s-search{max-width:100%;}
    .s-table thead{display:none;}
    .s-table,.s-table tbody,.s-table tr,.s-table td{display:block;width:100%;}
    .s-table tr{padding:12px 14px;border-bottom:1px solid var(--s-border);}
    .s-table td{border:0;padding:6px 0;display:flex;justify-content:space-between;align-items:center;gap:10px;}
    .s-table td::before{
        content:attr(data-label);font-size:.68rem;text-transform:uppercase;
        letter-spacing:.08em;color:var(--s-muted);font-weight:700;
    }
    .s-table td:first-child::before,
    .s-table td.s-cell-doctor::before{content:"";}
    .s-cell-doctor{justify-content:flex-start!important;}
    .s-actions{justify-content:flex-end;}
}
</style>
@endsection

@section('content')
<div class="s-page">
    <input type="hidden" data-js="base-url" value="{{ url('/') }}">

    {{-- HEADER --}}
    <div class="s-head">
        <div class="s-head-title">
            <h1>Médicos</h1>
            <p>Gerencie os profissionais médicos cadastrados no sistema.</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="s-btn s-btn-primary">
            <i class="bx bx-plus"></i> Novo Médico
        </a>
    </div>

    {{-- SUCCESS ALERT --}}
    @if (session()->has('success'))
        <div class="s-alert">
            <i class="bx bx-check-circle font-size-18"></i>
            <span>{!! session()->get('success') !!}</span>
        </div>
        {{ session()->forget('success') }}
    @endif

    {{-- TABLE CARD --}}
    <div class="s-card">
        <div class="s-card-head">
            <div class="s-card-head-left">
                <h2>Lista de Médicos</h2>
                <span class="s-count">{{ $doctors->total() ?? $doctors->count() }}</span>
            </div>
            <div class="s-search">
                <i class="bx bx-search"></i>
                @csrf
                <input type="search" id="searchDoctor" name="search_name"
                    placeholder="Pesquisar por nome, CPF ou CNS..." />
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Médico</th>
                        <th>Conselho</th>
                        <th style="width:80px;">UF</th>
                        <th style="width:140px;">Nº Conselho</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:120px;text-align:right;">Ações</th>
                    </tr>
                </thead>
                <tbody id="contentDoctor">
                    @php
                        $currentPage = $doctors->currentPage();
                        $limit = App\Helpers\Pagination::getLimit();
                    @endphp

                    @forelse ($doctors as $key => $item)
                        @php
                            $fullName = trim(($item->first_name ?? '').' '.($item->last_name ?? ''));
                            $initials = collect(explode(' ', $fullName))->filter()->take(2)->map(fn($p)=>mb_substr($p,0,1))->implode('');
                            $statusName = $item->doctor?->is_deleted?->getName();
                            $isActive = $statusName && stripos($statusName,'inativo') === false;
                        @endphp
                        <tr>
                            <td data-label="#"><span class="s-num">{{ $key + 1 + $limit * ($currentPage - 1) }}</span></td>
                            <td data-label="Médico" class="s-cell-doctor">
                                <div class="s-avatar">
                                    <div class="s-av">{{ strtoupper($initials ?: 'M') }}</div>
                                    <div class="s-av-info">
                                        <div class="s-name">{{ $fullName ?: '—' }}</div>
                                        <div class="s-meta">{{ $item->email ?? 'sem e-mail' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Conselho">{{ $item->doctor?->council?->name ?? '—' }}</td>
                            <td data-label="UF"><span class="s-tag outline">{{ $item->doctor?->state?->name ?? '—' }}</span></td>
                            <td data-label="Nº Conselho"><span class="s-tag">{{ $item->doctor?->counsil_number ?? '—' }}</span></td>
                            <td data-label="Status">
                                <span class="s-status {{ $isActive ? 'on' : 'off' }}">
                                    <span class="s-dot"></span>{{ $statusName ?? '—' }}
                                </span>
                            </td>
                            <td data-label="Ações" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ route('doctors.show', $item->id) }}" class="s-icon-btn view" title="Visualizar perfil">
                                        <i class="mdi mdi-eye-outline"></i>
                                    </a>
                                    <a href="{{ route('doctors.edit', $item->id) }}" class="s-icon-btn edit" title="Editar perfil">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="s-empty">
                                    <i class="bx bx-user-x"></i>
                                    Nenhum médico encontrado.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tbody id="loader" style="display:none;">
                    <tr>
                        <td colspan="7">
                            <div class="s-empty">
                                <span class="spinner-border spinner-border-sm mr-2 text-primary" role="status"></span>
                                Carregando...
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="s-foot" id="paginate">
            <div class="s-foot-info">
                Mostrando <strong>{{ $doctors->count() }}</strong> de <strong>{{ $doctors->total() ?? $doctors->count() }}</strong> médicos
            </div>
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/pages/doctors/index.js') }}"></script>
@endsection
