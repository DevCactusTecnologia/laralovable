@php
    $user = Sentinel::getUser();
    $role = $user->roles[0]->slug;
    $currentUrl = url()->current();
    $isActive = function($routes) use ($currentUrl) {
        foreach ((array)$routes as $r) {
            if (str_contains($currentUrl, $r)) return 'active';
        }
        return '';
    };
@endphp

{{-- ========================================================
     Sidebar lateral estilo appsislac/dashboard
     Substitui o menu horizontal mantendo todos os links
     ======================================================== --}}
<style>
    :root { --sx-w: 260px; --sx-w-collapsed: 76px; }

    /* esconder o menu horizontal antigo */
    body .topnav { display: none !important; }

    /* sidebar */
    .sx-sidebar {
        position: fixed; top: 0; left: 0; bottom: 0;
        width: var(--sx-w);
        background: #ffffff;
        border-right: 1px solid #eef0f4;
        z-index: 1030;
        display: flex; flex-direction: column;
        font-family: 'Inter', system-ui, sans-serif;
        transition: width .25s ease;
        overflow: hidden;
    }
    .sx-sidebar .sx-brand {
        display: flex; align-items: center; gap: 12px;
        padding: 20px 20px 18px; border-bottom: 1px solid #f1f3f7;
    }
    .sx-sidebar .sx-brand-mark {
        width: 40px; height: 40px; border-radius: 12px;
        background: linear-gradient(135deg, #4f46e5, #8b5cf6);
        color: #fff; display: inline-flex; align-items: center; justify-content: center;
        font-size: 20px; box-shadow: 0 6px 14px rgba(79,70,229,.28);
        position: relative; flex-shrink: 0;
    }
    .sx-sidebar .sx-brand-mark::after {
        content: ""; position: absolute; top: -2px; right: -2px;
        width: 10px; height: 10px; border-radius: 50%;
        background: #10b981; border: 2px solid #fff;
    }
    .sx-sidebar .sx-brand-text { display: flex; flex-direction: column; line-height: 1.1; }
    .sx-sidebar .sx-brand-text strong { font-size: 15px; color: #0f172a; font-weight: 800; letter-spacing: -.01em; }
    .sx-sidebar .sx-brand-text span { font-size: 10.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: .12em; font-weight: 600; margin-top: 2px; }

    .sx-sidebar .sx-toggle {
        margin-left: auto; background: #f1f5f9; border: none;
        width: 28px; height: 28px; border-radius: 8px;
        color: #475569; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all .2s ease;
    }
    .sx-sidebar .sx-toggle:hover { background: #e2e8f0; color: #0f172a; }

    .sx-sidebar .sx-nav { flex: 1; overflow-y: auto; padding: 14px 12px 20px; }
    .sx-sidebar .sx-nav::-webkit-scrollbar { width: 6px; }
    .sx-sidebar .sx-nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 3px; }

    .sx-section {
        font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .12em;
        color: #94a3b8; padding: 14px 12px 8px;
    }
    .sx-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 12px; border-radius: 10px;
        color: #475569; font-size: 13.5px; font-weight: 500;
        text-decoration: none; transition: all .15s ease;
        position: relative; white-space: nowrap;
    }
    .sx-item i { font-size: 18px; color: #94a3b8; flex-shrink: 0; transition: color .15s ease; }
    .sx-item:hover { background: #f8fafc; color: #0f172a; text-decoration: none; }
    .sx-item:hover i { color: #4f46e5; }
    .sx-item.active {
        background: linear-gradient(90deg, #eef2ff, #f5f3ff);
        color: #4338ca; font-weight: 600;
    }
    .sx-item.active i { color: #4f46e5; }
    .sx-item.active::before {
        content: ""; position: absolute; left: 0; top: 8px; bottom: 8px;
        width: 3px; background: #4f46e5; border-radius: 0 3px 3px 0;
    }

    /* dropdown group */
    .sx-group > .sx-item .sx-caret { margin-left: auto; font-size: 14px; transition: transform .2s ease; }
    .sx-group.open > .sx-item .sx-caret { transform: rotate(90deg); }
    .sx-group .sx-sub {
        max-height: 0; overflow: hidden; transition: max-height .25s ease;
        margin: 2px 0 4px 36px; border-left: 1px solid #eef0f4; padding-left: 8px;
    }
    .sx-group.open .sx-sub { max-height: 500px; }
    .sx-sub .sx-item { padding: 7px 10px; font-size: 12.5px; color: #64748b; }
    .sx-sub .sx-item:hover { color: #4338ca; background: transparent; }
    .sx-sub .sx-item.active { background: transparent; color: #4338ca; font-weight: 600; }
    .sx-sub .sx-item.active::before { display: none; }

    .sx-sidebar .sx-foot {
        padding: 14px 16px; border-top: 1px solid #f1f3f7;
        font-size: 11.5px; color: #94a3b8; display: flex; align-items: center; gap: 8px;
    }
    .sx-sidebar .sx-foot .sx-dot { width: 7px; height: 7px; border-radius: 50%; background: #10b981; box-shadow: 0 0 0 4px rgba(16,185,129,.18); }

    /* ajusta conteúdo principal */
    body #layout-wrapper #page-topbar,
    body #layout-wrapper .main-content {
        margin-left: var(--sx-w) !important;
        transition: margin-left .25s ease;
    }
    body #layout-wrapper #page-topbar .navbar-brand-box { display: none !important; }

    /* colapsado (desktop) */
    body.sx-collapsed .sx-sidebar { width: var(--sx-w-collapsed); }
    body.sx-collapsed .sx-sidebar .sx-brand-text,
    body.sx-collapsed .sx-sidebar .sx-section,
    body.sx-collapsed .sx-sidebar .sx-item span,
    body.sx-collapsed .sx-sidebar .sx-caret,
    body.sx-collapsed .sx-sidebar .sx-sub,
    body.sx-collapsed .sx-sidebar .sx-foot span { display: none !important; }
    body.sx-collapsed .sx-sidebar .sx-item { justify-content: center; padding: 11px 0; }
    body.sx-collapsed #layout-wrapper #page-topbar,
    body.sx-collapsed #layout-wrapper .main-content { margin-left: var(--sx-w-collapsed) !important; }

    /* mobile */
    @media (max-width: 991px) {
        .sx-sidebar { transform: translateX(-100%); box-shadow: 0 30px 60px rgba(15,23,42,.25); }
        body.sx-open .sx-sidebar { transform: translateX(0); }
        body #layout-wrapper #page-topbar,
        body #layout-wrapper .main-content { margin-left: 0 !important; }
        body #layout-wrapper #page-topbar .navbar-brand-box { display: flex !important; }
        .sx-backdrop { display: none; position: fixed; inset: 0; background: rgba(15,23,42,.45); z-index: 1029; }
        body.sx-open .sx-backdrop { display: block; }
    }
</style>

<aside class="sx-sidebar">
    <div class="sx-brand">
        <span class="sx-brand-mark"><i class="bx bx-test-tube"></i></span>
        <div class="sx-brand-text">
            <strong>{{ config('app.name') }}</strong>
            <span>Sistema Laboratorial</span>
        </div>
        <button type="button" class="sx-toggle" onclick="document.body.classList.toggle('sx-collapsed')" title="Recolher">
            <i class="bx bx-chevrons-left"></i>
        </button>
    </div>

    <nav class="sx-nav">
        <div class="sx-section">Principal</div>
        <a href="{{ url('/') }}" class="sx-item {{ $currentUrl === url('/') ? 'active' : '' }}">
            <i class="bx bxs-dashboard"></i><span>Dashboard</span>
        </a>

        @if ($role == 'admin')
            <div class="sx-section">Cadastros</div>
            <a href="{{ route('doctors.index') }}" class="sx-item {{ $isActive('doctors') }}"><i class="bx bx-user-plus"></i><span>Médicos</span></a>
            <a href="{{ route('patients.index') }}" class="sx-item {{ $isActive('patients') }}"><i class="bx bxs-user-detail"></i><span>Pacientes</span></a>
            <a href="{{ route('receptionists.index') }}" class="sx-item {{ $isActive('receptionists') }}"><i class="bx bx-user-voice"></i><span>Recepcionistas</span></a>
            <a href="{{ route('biomedicals.index') }}" class="sx-item {{ $isActive('biomedicals') }}"><i class="bx bx-user-circle"></i><span>Analistas</span></a>

            <div class="sx-section">Operação</div>
            <div class="sx-group {{ $isActive('appointments') ? 'open' : '' }}">
                <a href="javascript:;" class="sx-item" onclick="this.parentElement.classList.toggle('open')">
                    <i class="bx bx-list-plus"></i><span>Atendimentos</span><i class="bx bx-chevron-right sx-caret"></i>
                </a>
                <div class="sx-sub">
                    <a href="{{ route('appointments.index') }}" class="sx-item">Lista de Atendimentos</a>
                    <a href="{{ route('appointments.create') }}" class="sx-item">Novo Atendimento</a>
                    <a href="{{ route('appointments.schedule.index') }}" class="sx-item">Ver Agenda</a>
                </div>
            </div>
            <div class="sx-group {{ $isActive('exams') || $isActive('categories') ? 'open' : '' }}">
                <a href="javascript:;" class="sx-item" onclick="this.parentElement.classList.toggle('open')">
                    <i class="bx bx-test-tube"></i><span>Exames</span><i class="bx bx-chevron-right sx-caret"></i>
                </a>
                <div class="sx-sub">
                    <a href="{{ route('exams.index') }}" class="sx-item">Lista de Exames</a>
                    <a href="{{ route('exams.create') }}" class="sx-item">Novo Exame</a>
                    <a href="{{ route('categories.index') }}" class="sx-item">Setores</a>
                </div>
            </div>
            <div class="sx-group {{ $isActive('routine') ? 'open' : '' }}">
                <a href="javascript:;" class="sx-item" onclick="this.parentElement.classList.toggle('open')">
                    <i class="bx bx-receipt"></i><span>Rotina</span><i class="bx bx-chevron-right sx-caret"></i>
                </a>
                <div class="sx-sub">
                    <a href="{{ route('routine.map.patient.index') }}" class="sx-item">Mapa por paciente</a>
                    <a href="{{ route('routine.map.biomedical.index') }}" class="sx-item">Mapa por analista</a>
                    <a href="{{ route('routine.appointment.by.day.index') }}" class="sx-item">Impressão geral</a>
                    <a href="{{ route('routine.production.by.biomedical.index') }}" class="sx-item">Produção do analista</a>
                    <a href="{{ route('routine.production.by.unity.index') }}" class="sx-item">Produção por unidade</a>
                    <a href="{{ route('routine.production.by.exam.index') }}" class="sx-item">Produção por exame</a>
                    <a href="{{ route('routine.traceability.index') }}" class="sx-item">Rastreabilidade</a>
                    <a href="{{ route('routine.tag.index') }}" class="sx-item">Impressão de etiquetas</a>
                    <a href="{{ route('routine.occurrence.index') }}" class="sx-item">Ocorrências</a>
                </div>
            </div>

        @elseif ($role == 'doctor')
            <div class="sx-section">Atendimento</div>
            <a href="{{ route('appointments.create') }}" class="sx-item"><i class="bx bx-calendar-plus"></i><span>Novo Atendimento</span></a>
            <a href="{{ route('appointments.index') }}" class="sx-item"><i class="bx bx-list-plus"></i><span>Lista de Atendimentos</span></a>

            <div class="sx-section">Pacientes</div>
            <a href="{{ route('patients.index') }}" class="sx-item"><i class="bx bxs-user-detail"></i><span>Lista de Pacientes</span></a>
            <a href="{{ route('patients.create') }}" class="sx-item"><i class="bx bx-user-plus"></i><span>Novo Paciente</span></a>

            <div class="sx-section">Documentos</div>
            <a href="{{ url('prescription') }}" class="sx-item"><i class="bx bx-notepad"></i><span>Prescrições</span></a>
            <a href="{{ route('prescription.create') }}" class="sx-item"><i class="bx bx-edit"></i><span>Nova Prescrição</span></a>
            <a href="{{ url('invoice') }}" class="sx-item"><i class="bx bx-receipt"></i><span>Faturas</span></a>
            <a href="{{ route('invoice.create') }}" class="sx-item"><i class="bx bx-plus-circle"></i><span>Nova Fatura</span></a>

        @elseif ($role == 'receptionist' || $role == 'biomedical')
            <div class="sx-section">Cadastros</div>
            <a href="{{ route('doctors.index') }}" class="sx-item {{ $isActive('doctors') }}"><i class="bx bx-user-plus"></i><span>Médicos</span></a>
            <a href="{{ route('patients.index') }}" class="sx-item {{ $isActive('patients') }}"><i class="bx bxs-user-detail"></i><span>Pacientes</span></a>

            <div class="sx-section">Operação</div>
            <a href="{{ route('appointments.index') }}" class="sx-item {{ $isActive('appointments') }}"><i class="bx bx-list-check"></i><span>Lista de Atendimentos</span></a>
            <a href="{{ route('appointments.create') }}" class="sx-item"><i class="bx bx-calendar-plus"></i><span>Novo Atendimento</span></a>

            <div class="sx-group {{ $isActive('routine') ? 'open' : '' }}">
                <a href="javascript:;" class="sx-item" onclick="this.parentElement.classList.toggle('open')">
                    <i class="bx bx-receipt"></i><span>Rotina</span><i class="bx bx-chevron-right sx-caret"></i>
                </a>
                <div class="sx-sub">
                    <a href="{{ route('routine.map.patient.index') }}" class="sx-item">Mapa por paciente</a>
                    <a href="{{ route('routine.map.biomedical.index') }}" class="sx-item">Mapa por analista</a>
                    @if($role == 'receptionist')
                        <a href="{{ route('routine.appointment.by.day.index') }}" class="sx-item">Impressão geral</a>
                    @endif
                    <a href="{{ route('routine.production.by.biomedical.index') }}" class="sx-item">Produção do analista</a>
                    @if($role == 'receptionist')
                        <a href="{{ route('routine.production.by.unity.index') }}" class="sx-item">Produção por unidade</a>
                    @endif
                    <a href="{{ route('routine.production.by.exam.index') }}" class="sx-item">Produção por exame</a>
                    <a href="{{ route('routine.traceability.index') }}" class="sx-item">Rastreabilidade</a>
                    <a href="{{ route('routine.tag.index') }}" class="sx-item">Impressão de etiquetas</a>
                    <a href="{{ route('routine.occurrence.index') }}" class="sx-item">Ocorrências</a>
                </div>
            </div>

        @elseif ($role == 'patient')
            <a href="{{ url('appointments/patient-appointment') }}" class="sx-item"><i class="bx bx-list-plus"></i><span>Meus Atendimentos</span></a>
        @endif
    </nav>

    <div class="sx-foot">
        <span class="sx-dot"></span><span>Sistema operacional</span>
    </div>
</aside>

<div class="sx-backdrop" onclick="document.body.classList.remove('sx-open')"></div>

<script>
    (function() {
        // mobile toggle: usa o botão de bars do topbar
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('[data-toggle="collapse"][data-target="#topnav-menu-content"]');
            if (btn) { e.preventDefault(); document.body.classList.toggle('sx-open'); }
        });
    })();
</script>
