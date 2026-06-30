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
    --s-bg:#f8fafc;
    --s-surface:#ffffff;
    --s-border:#e5e7eb;
    --s-text:#0f172a;
    --s-muted:#64748b;
    --s-success:#10b981;
    --s-warn:#f59e0b;
    --s-danger:#ef4444;
}
.s-page{background:var(--s-bg);min-height:calc(100vh - 70px);padding:18px 6px;}
.s-grad-text{background:linear-gradient(90deg,var(--s-primary),var(--s-secondary));-webkit-background-clip:text;background-clip:text;color:transparent;}
.s-hero{
    position:relative;border-radius:20px;overflow:hidden;
    background:linear-gradient(120deg,#4338ca 0%,#4f46e5 45%,#8b5cf6 100%);
    color:#fff;padding:22px 26px;margin-bottom:18px;
    box-shadow:0 10px 30px -12px rgba(79,70,229,.45);
}
.s-hero::before,.s-hero::after{content:"";position:absolute;border-radius:50%;filter:blur(40px);opacity:.35;}
.s-hero::before{width:240px;height:240px;background:#a78bfa;top:-80px;right:-60px;}
.s-hero::after{width:180px;height:180px;background:#22d3ee;bottom:-70px;left:30%;}
.s-hero .s-eyebrow{font-size:11px;letter-spacing:.18em;text-transform:uppercase;opacity:.85;font-weight:600;}
.s-hero h1{font-size:1.55rem;font-weight:800;margin:6px 0 4px;letter-spacing:-.01em;}
.s-hero p{margin:0;opacity:.85;font-size:.92rem;max-width:560px;}
.s-hero-actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;}
.s-btn{display:inline-flex;align-items:center;gap:8px;border:0;border-radius:12px;padding:9px 16px;font-weight:600;font-size:.875rem;cursor:pointer;transition:all .2s;text-decoration:none;}
.s-btn i{font-size:1.05rem;}
.s-btn-light{background:#fff;color:var(--s-accent);}
.s-btn-light:hover{transform:translateY(-1px);box-shadow:0 8px 20px -8px rgba(0,0,0,.25);color:var(--s-accent);}
.s-btn-glass{background:rgba(255,255,255,.15);color:#fff;backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);}
.s-btn-glass:hover{background:rgba(255,255,255,.22);color:#fff;}
.s-btn-primary{background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));color:#fff;}
.s-btn-primary:hover{transform:translateY(-1px);color:#fff;box-shadow:0 10px 24px -10px rgba(79,70,229,.6);}
.s-btn-ghost{background:#fff;color:var(--s-text);border:1px solid var(--s-border);}
.s-btn-ghost:hover{background:#f1f5f9;color:var(--s-text);}

.s-kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px;}
.s-kpi{background:var(--s-surface);border:1px solid var(--s-border);border-radius:16px;padding:14px 16px;position:relative;overflow:hidden;transition:.2s;}
.s-kpi:hover{transform:translateY(-2px);box-shadow:0 12px 30px -16px rgba(15,23,42,.18);}
.s-kpi .s-kpi-top{display:flex;justify-content:space-between;align-items:center;}
.s-kpi .s-kpi-label{font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--s-muted);font-weight:600;}
.s-kpi .s-kpi-icon{width:36px;height:36px;border-radius:11px;display:grid;place-items:center;font-size:1.1rem;color:#fff;}
.s-kpi .s-kpi-val{font-size:1.55rem;font-weight:800;color:var(--s-text);margin-top:6px;letter-spacing:-.01em;}
.s-kpi .s-kpi-sub{font-size:.74rem;color:var(--s-muted);margin-top:2px;}
.s-kpi.indigo .s-kpi-icon{background:linear-gradient(135deg,#6366f1,#8b5cf6);}
.s-kpi.green .s-kpi-icon{background:linear-gradient(135deg,#10b981,#22d3ee);}
.s-kpi.amber .s-kpi-icon{background:linear-gradient(135deg,#f59e0b,#fb923c);}
.s-kpi.pink .s-kpi-icon{background:linear-gradient(135deg,#ec4899,#8b5cf6);}

.s-panel{background:var(--s-surface);border:1px solid var(--s-border);border-radius:18px;overflow:hidden;}
.s-panel-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 20px;border-bottom:1px solid var(--s-border);flex-wrap:wrap;}
.s-panel-title{display:flex;align-items:center;gap:10px;}
.s-panel-title .s-dot{width:8px;height:8px;border-radius:50%;background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));}
.s-panel-title h2{font-size:1rem;font-weight:700;margin:0;color:var(--s-text);}
.s-panel-title small{color:var(--s-muted);font-size:.78rem;}

.s-search{position:relative;min-width:240px;flex:1;max-width:380px;}
.s-search input{
    width:100%;border:1px solid var(--s-border);background:#f8fafc;
    border-radius:12px;padding:9px 12px 9px 36px;font-size:.875rem;outline:none;
    transition:.2s;color:var(--s-text);
}
.s-search input:focus{border-color:var(--s-primary);background:#fff;box-shadow:0 0 0 3px rgba(79,70,229,.12);}
.s-search i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--s-muted);font-size:1rem;}

.s-table-wrap{overflow:auto;max-height:620px;}
.s-table{width:100%;border-collapse:separate;border-spacing:0;}
.s-table thead th{
    position:sticky;top:0;background:#f8fafc;z-index:1;
    font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;
    color:var(--s-muted);font-weight:700;padding:11px 14px;text-align:left;
    border-bottom:1px solid var(--s-border);
}
.s-table tbody td{padding:12px 14px;font-size:.88rem;color:var(--s-text);border-bottom:1px solid #f1f5f9;vertical-align:middle;}
.s-table tbody tr{transition:background .15s;}
.s-table tbody tr:hover{background:#fafbff;}
.s-table tbody tr:last-child td{border-bottom:0;}

.s-num{display:inline-grid;place-items:center;width:28px;height:28px;border-radius:8px;background:#eef2ff;color:var(--s-accent);font-weight:700;font-size:.75rem;}
.s-avatar{display:flex;align-items:center;gap:10px;min-width:0;}
.s-avatar .s-av{width:36px;height:36px;border-radius:10px;display:grid;place-items:center;color:#fff;font-weight:700;font-size:.82rem;flex-shrink:0;background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));}
.s-avatar .s-av-info{min-width:0;}
.s-avatar .s-name{font-weight:600;color:var(--s-text);line-height:1.2;}
.s-avatar .s-meta{font-size:.74rem;color:var(--s-muted);}

.s-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:999px;font-size:.72rem;font-weight:600;}
.s-chip.indigo{background:#eef2ff;color:#4338ca;}
.s-chip.green{background:#d1fae5;color:#047857;}
.s-chip.red{background:#fee2e2;color:#b91c1c;}
.s-chip.slate{background:#f1f5f9;color:#475569;}
.s-chip .s-cdot{width:6px;height:6px;border-radius:50%;background:currentColor;}

.s-actions{display:inline-flex;gap:6px;}
.s-icon-btn{
    width:32px;height:32px;display:grid;place-items:center;border-radius:9px;
    background:#f1f5f9;color:var(--s-muted);border:0;cursor:pointer;
    transition:.15s;text-decoration:none;font-size:.95rem;
}
.s-icon-btn:hover{background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));color:#fff;transform:translateY(-1px);}
.s-icon-btn.view:hover{background:linear-gradient(135deg,#0ea5e9,#22d3ee);}
.s-icon-btn.edit:hover{background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));}

.s-empty{padding:60px 20px;text-align:center;color:var(--s-muted);}
.s-empty i{font-size:3rem;color:#cbd5e1;display:block;margin-bottom:8px;}

.s-foot{padding:14px 20px;border-top:1px solid var(--s-border);display:flex;justify-content:flex-end;}
.s-foot .pagination{margin:0;}
.s-foot .page-item .page-link{border-radius:9px!important;margin:0 2px;border:1px solid var(--s-border);color:var(--s-text);font-size:.85rem;padding:6px 11px;}
.s-foot .page-item.active .page-link{background:linear-gradient(135deg,var(--s-primary),var(--s-secondary));border-color:transparent;color:#fff;}

.s-alert{border-radius:14px;border:0;padding:12px 16px;background:#d1fae5;color:#065f46;display:flex;align-items:center;gap:10px;margin-bottom:14px;}

@media (max-width: 991px){
    .s-kpis{grid-template-columns:repeat(2,1fr);}
    .s-hero h1{font-size:1.3rem;}
}
@media (max-width: 575px){
    .s-page{padding:10px 2px;}
    .s-hero{padding:18px;border-radius:16px;}
    .s-kpis{grid-template-columns:1fr 1fr;gap:10px;}
    .s-kpi .s-kpi-val{font-size:1.25rem;}
    .s-panel-head{padding:14px;}
    .s-search{max-width:100%;}
    .s-table thead{display:none;}
    .s-table,.s-table tbody,.s-table tr,.s-table td{display:block;width:100%;}
    .s-table tr{padding:12px;border-bottom:1px solid var(--s-border);}
    .s-table td{border:0;padding:5px 0;display:flex;justify-content:space-between;align-items:center;gap:10px;}
    .s-table td::before{content:attr(data-label);font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;color:var(--s-muted);font-weight:600;}
    .s-table td:first-child::before{content:"";}
    .s-actions{justify-content:flex-end;}
}
</style>
@endsection

@section('content')
<div class="s-page">
    <input type="hidden" data-js="base-url" value="{{ url('/') }}">

    {{-- HERO --}}
    <div class="s-hero">
        <div class="s-eyebrow">Equipe Clínica</div>
        <h1>Gestão de Médicos</h1>
        <p>Acompanhe, cadastre e gerencie todos os profissionais médicos vinculados ao laboratório com agilidade e segurança.</p>
        <div class="s-hero-actions">
            <a href="{{ route('doctors.create') }}" class="s-btn s-btn-light">
                <i class="bx bx-plus"></i> Novo Médico
            </a>
            <a href="{{ url('/') }}" class="s-btn s-btn-glass">
                <i class="bx bx-home-alt"></i> Dashboard
            </a>
        </div>
    </div>

    {{-- SUCCESS ALERT --}}
    @if (session()->has('success'))
        <div class="s-alert">
            <i class="bx bx-check-circle font-size-18"></i>
            <span>{!! session()->get('success') !!}</span>
        </div>
        {{ session()->forget('success') }}
    @endif

    {{-- KPIS --}}
    @php
        $totalDoctors = $doctors->total() ?? $doctors->count();
        $activeDoctors = collect($doctors->items() ?? $doctors)->filter(fn($d) => optional($d->doctor)->is_deleted && method_exists($d->doctor->is_deleted, 'value') ? $d->doctor->is_deleted->value == 0 : true)->count();
        $inactiveDoctors = max(0, $totalDoctors - $activeDoctors);
    @endphp
    <div class="s-kpis">
        <div class="s-kpi indigo">
            <div class="s-kpi-top">
                <span class="s-kpi-label">Total</span>
                <div class="s-kpi-icon"><i class="bx bx-user-pin"></i></div>
            </div>
            <div class="s-kpi-val">{{ $totalDoctors }}</div>
            <div class="s-kpi-sub">Médicos cadastrados</div>
        </div>
        <div class="s-kpi green">
            <div class="s-kpi-top">
                <span class="s-kpi-label">Ativos</span>
                <div class="s-kpi-icon"><i class="bx bx-check-shield"></i></div>
            </div>
            <div class="s-kpi-val">{{ $activeDoctors }}</div>
            <div class="s-kpi-sub">Em atividade</div>
        </div>
        <div class="s-kpi amber">
            <div class="s-kpi-top">
                <span class="s-kpi-label">Inativos</span>
                <div class="s-kpi-icon"><i class="bx bx-time-five"></i></div>
            </div>
            <div class="s-kpi-val">{{ $inactiveDoctors }}</div>
            <div class="s-kpi-sub">Sem atividade</div>
        </div>
        <div class="s-kpi pink">
            <div class="s-kpi-top">
                <span class="s-kpi-label">Página</span>
                <div class="s-kpi-icon"><i class="bx bx-list-ul"></i></div>
            </div>
            <div class="s-kpi-val">{{ $doctors->count() }}</div>
            <div class="s-kpi-sub">Itens exibidos</div>
        </div>
    </div>

    {{-- TABLE PANEL --}}
    <div class="s-panel">
        <div class="s-panel-head">
            <div class="s-panel-title">
                <span class="s-dot"></span>
                <div>
                    <h2>Lista de Médicos</h2>
                    <small>Resultados ordenados por cadastro</small>
                </div>
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
                        <th>UF</th>
                        <th>Nº Conselho</th>
                        <th>Status</th>
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
                        @endphp
                        <tr>
                            <td data-label="#"><span class="s-num">{{ $key + 1 + $limit * ($currentPage - 1) }}</span></td>
                            <td data-label="Médico">
                                <div class="s-avatar">
                                    <div class="s-av">{{ strtoupper($initials ?: 'M') }}</div>
                                    <div class="s-av-info">
                                        <div class="s-name">{{ $fullName ?: '—' }}</div>
                                        <div class="s-meta">{{ $item->email ?? 'sem e-mail' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Conselho">{{ $item->doctor?->council?->name ?? '—' }}</td>
                            <td data-label="UF"><span class="s-chip slate">{{ $item->doctor?->state?->name ?? '—' }}</span></td>
                            <td data-label="Nº Conselho">{{ $item->doctor?->counsil_number ?? '—' }}</td>
                            <td data-label="Status">
                                @php
                                    $statusName = $item->doctor?->is_deleted?->getName();
                                    $isActive = $statusName && stripos($statusName,'ativo') !== false && stripos($statusName,'inativo') === false;
                                @endphp
                                <span class="s-chip {{ $isActive ? 'green' : 'red' }}">
                                    <span class="s-cdot"></span>{{ $statusName ?? '—' }}
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
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/pages/doctors/index.js') }}"></script>
@endsection
