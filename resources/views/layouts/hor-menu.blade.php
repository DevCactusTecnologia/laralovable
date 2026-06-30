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
    $profilePhoto = $user->profile_photo
        ? URL::asset('storage/images/users/' . $user->profile_photo)
        : URL::asset('assets/images/users/noImage.png');
    $profileRoute = $role === 'admin' ? url('profile-edit') : url('profile-view');
@endphp

{{-- ========================================================
     Sidebar lateral única — substitui menu superior e direito
     ======================================================== --}}
<style>
    :root { --sx-w: 264px; --sx-w-collapsed: 76px; }

    /* esconder topbar e menu horizontal antigos */
    body #page-topbar,
    body .topnav,
    body .right-bar,
    body .rightbar-overlay { display: none !important; }

    /* sidebar */
    .sx-sidebar {
        position: fixed; top: 0; left: 0; bottom: 0;
        width: var(--sx-w);
        background: var(--s-surface, #ffffff);
        border-right: 1px solid var(--s-border, #e8ecf1);
        z-index: 1030;
        display: flex; flex-direction: column;
        font-family: 'Manrope', system-ui, sans-serif;
        transition: width .25s ease;
    }
    body.s-dark .sx-sidebar { background: #111733; border-right-color: #1f2745; }

    .sx-sidebar .sx-brand {
        display: flex; align-items: center; gap: 12px;
        padding: 18px 18px 16px; border-bottom: 1px solid var(--s-border, #f1f3f7);
    }
    .sx-sidebar .sx-brand-mark {
        width: 40px; height: 40px; border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6, #0ea5e9);
        color: #fff; display: inline-flex; align-items: center; justify-content: center;
        font-size: 20px; box-shadow: 0 6px 14px rgba(59,130,246,.28);
        position: relative; flex-shrink: 0;
    }
    .sx-sidebar .sx-brand-mark::after {
        content: ""; position: absolute; top: -2px; right: -2px;
        width: 10px; height: 10px; border-radius: 50%;
        background: #10b981; border: 2px solid var(--s-surface,#fff);
    }
    .sx-sidebar .sx-brand-text { display: flex; flex-direction: column; line-height: 1.1; min-width:0; }
    .sx-sidebar .sx-brand-text strong { font-family:'Sora',sans-serif; font-size: 15px; color: var(--s-text,#0f172a); font-weight: 700; letter-spacing: -.01em; }
    .sx-sidebar .sx-brand-text span { font-size: 10.5px; color: var(--s-muted,#94a3b8); text-transform: uppercase; letter-spacing: .12em; font-weight: 600; margin-top: 2px; }

    .sx-sidebar .sx-toggle {
        margin-left: auto; background: var(--s-soft,#f1f5f9); border: none;
        width: 28px; height: 28px; border-radius: 8px;
        color: var(--s-text-2,#475569); cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all .2s ease; flex-shrink:0;
    }
    .sx-sidebar .sx-toggle:hover { background: #e2e8f0; color: #0f172a; }

    /* Tool row — search, dark mode, fullscreen, notif */
    .sx-tools {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 6px; padding: 12px 14px; border-bottom: 1px solid var(--s-border,#f1f3f7);
    }
    .sx-tool {
        position: relative;
        height: 38px; border-radius: 10px; border: 1px solid var(--s-border,#e8ecf1);
        background: var(--s-soft,#f8fafc); color: var(--s-text-2,#475569);
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .15s ease; font-size: 17px;
    }
    .sx-tool:hover { background: var(--s-primary-50,#eff6ff); color: var(--s-primary,#3b82f6); border-color: var(--s-primary,#3b82f6); }
    .sx-tool .sx-badge {
        position: absolute; top: -4px; right: -4px;
        background: #ef4444; color: #fff; font-size: 9.5px; font-weight: 700;
        min-width: 16px; height: 16px; border-radius: 999px;
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0 4px; border: 2px solid var(--s-surface,#fff);
    }
    body.s-dark .sx-tool { background:#172046; border-color:#2a3358; color:#cbd5e1; }

    .sx-sidebar .sx-nav { flex: 1; overflow-y: auto; padding: 10px 12px 16px; }
    .sx-sidebar .sx-nav::-webkit-scrollbar { width: 6px; }
    .sx-sidebar .sx-nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 3px; }

    .sx-section {
        font-family:'Sora',sans-serif;
        font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .12em;
        color: var(--s-muted,#94a3b8); padding: 14px 12px 8px;
    }
    .sx-item {
        display: flex; align-items: center; gap: 12px;
        padding: 9px 12px; border-radius: 10px;
        color: var(--s-text-2,#475569); font-size: 13px; font-weight: 500;
        text-decoration: none; transition: all .15s ease;
        position: relative; white-space: nowrap;
    }
    .sx-item i { font-size: 18px; color: var(--s-muted,#94a3b8); flex-shrink: 0; transition: color .15s ease; }
    .sx-item:hover { background: var(--s-soft,#f8fafc); color: var(--s-text,#0f172a); text-decoration: none; }
    .sx-item:hover i { color: var(--s-primary,#3b82f6); }
    .sx-item.active {
        background: var(--s-primary-50,#eff6ff);
        color: var(--s-primary-2,#2563eb); font-weight: 600;
    }
    .sx-item.active i { color: var(--s-primary,#3b82f6); }
    .sx-item.active::before {
        content: ""; position: absolute; left: 0; top: 8px; bottom: 8px;
        width: 3px; background: var(--s-primary,#3b82f6); border-radius: 0 3px 3px 0;
    }
    body.s-dark .sx-item:hover { background:#172046; color:#e5e7eb; }
    body.s-dark .sx-item.active { background:#172046; }

    /* dropdown group */
    .sx-group > .sx-item .sx-caret { margin-left: auto; font-size: 14px; transition: transform .2s ease; }
    .sx-group.open > .sx-item .sx-caret { transform: rotate(90deg); }
    .sx-group .sx-sub {
        max-height: 0; overflow: hidden; transition: max-height .25s ease;
        margin: 2px 0 4px 36px; border-left: 1px solid var(--s-border,#eef0f4); padding-left: 8px;
    }
    .sx-group.open .sx-sub { max-height: 600px; }
    .sx-sub .sx-item { padding: 7px 10px; font-size: 12.5px; color: var(--s-muted,#64748b); }
    .sx-sub .sx-item:hover { color: var(--s-primary-2,#2563eb); background: transparent; }
    .sx-sub .sx-item.active { background: transparent; color: var(--s-primary-2,#2563eb); font-weight: 600; }
    .sx-sub .sx-item.active::before { display: none; }

    /* user footer */
    .sx-user {
        position: relative;
        padding: 12px 14px; border-top: 1px solid var(--s-border,#f1f3f7);
        display: flex; align-items: center; gap: 10px;
    }
    .sx-user img { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; flex-shrink:0; border:2px solid var(--s-border,#e8ecf1); }
    .sx-user-info { flex: 1; min-width:0; }
    .sx-user-info strong { display:block; font-family:'Sora',sans-serif; font-size: 13px; color: var(--s-text,#0f172a); font-weight: 700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .sx-user-info span { display:block; font-size: 11px; color: var(--s-muted,#94a3b8); text-transform: capitalize; }
    .sx-user .sx-user-menu-btn {
        background: var(--s-soft,#f1f5f9); border: 0; width: 32px; height: 32px; border-radius: 8px;
        color: var(--s-text-2,#475569); cursor: pointer; display:inline-flex;align-items:center;justify-content:center;
        transition: all .15s ease; flex-shrink:0;
    }
    .sx-user .sx-user-menu-btn:hover { background:#e2e8f0; color:#0f172a; }
    body.s-dark .sx-user .sx-user-menu-btn { background:#172046; color:#cbd5e1; }

    .sx-user-pop {
        position: absolute; bottom: calc(100% + 4px); left: 12px; right: 12px;
        background: var(--s-surface,#fff); border: 1px solid var(--s-border,#e8ecf1);
        border-radius: 12px; box-shadow: 0 20px 40px -16px rgba(15,23,42,.18);
        padding: 6px; opacity: 0; transform: translateY(6px); pointer-events: none;
        transition: all .18s ease; z-index: 50;
    }
    .sx-user.open .sx-user-pop { opacity: 1; transform: none; pointer-events: auto; }
    .sx-user-pop a, .sx-user-pop button {
        display:flex; align-items:center; gap:10px; width:100%;
        padding: 9px 12px; border-radius: 8px; font-size: 13px;
        color: var(--s-text-2,#475569); background: transparent; border:0; text-align:left;
        text-decoration:none; transition: all .12s ease; cursor: pointer; font-family:'Manrope',sans-serif;
    }
    .sx-user-pop a:hover, .sx-user-pop button:hover { background: var(--s-primary-50,#eff6ff); color: var(--s-primary,#3b82f6); }
    .sx-user-pop .sx-pop-divider { height:1px; background: var(--s-border,#eef0f4); margin: 4px 6px; }
    .sx-user-pop button.danger:hover { background:#fef2f2; color:#dc2626; }
    body.s-dark .sx-user-pop { background:#111733; border-color:#1f2745; }

    /* notifications pop */
    .sx-notif-pop {
        position: absolute; bottom: 60px; left: 14px; right: 14px;
        background: var(--s-surface,#fff); border: 1px solid var(--s-border,#e8ecf1);
        border-radius: 12px; box-shadow: 0 20px 40px -16px rgba(15,23,42,.18);
        opacity: 0; transform: translateY(6px); pointer-events: none;
        transition: all .18s ease; z-index: 60; overflow:hidden; max-height:60vh; display:flex; flex-direction:column;
    }
    .sx-notif-pop.open { opacity:1; transform:none; pointer-events:auto; }
    .sx-notif-pop .sx-notif-head { padding:12px 14px; border-bottom:1px solid var(--s-border,#eef0f4); font-family:'Sora',sans-serif; font-weight:700; font-size:13px; color:var(--s-text,#0f172a); display:flex; justify-content:space-between; align-items:center; }
    .sx-notif-pop .sx-notif-head a { font-size:11.5px; color:var(--s-primary,#3b82f6); text-decoration:none; font-weight:600; }
    .sx-notif-pop .sx-notif-list { overflow-y:auto; flex:1; }
    .sx-notif-pop .sx-notif-list a { display:flex; gap:10px; padding:10px 14px; border-bottom:1px solid var(--s-border,#eef0f4); color:var(--s-text-2,#475569); text-decoration:none; font-size:12.5px; transition:background .12s ease; }
    .sx-notif-pop .sx-notif-list a:hover { background:var(--s-soft,#f8fafc); }
    .sx-notif-pop .sx-notif-empty { padding:24px; text-align:center; color:var(--s-muted,#94a3b8); font-size:12.5px; }
    body.s-dark .sx-notif-pop { background:#111733; border-color:#1f2745; }

    /* ajusta conteúdo principal */
    body #layout-wrapper .main-content {
        margin-left: var(--sx-w) !important;
        transition: margin-left .25s ease;
    }

    /* colapsado (desktop) */
    body.sx-collapsed .sx-sidebar { width: var(--sx-w-collapsed); }
    body.sx-collapsed .sx-sidebar .sx-brand-text,
    body.sx-collapsed .sx-sidebar .sx-section,
    body.sx-collapsed .sx-sidebar .sx-item span,
    body.sx-collapsed .sx-sidebar .sx-caret,
    body.sx-collapsed .sx-sidebar .sx-sub,
    body.sx-collapsed .sx-sidebar .sx-user-info,
    body.sx-collapsed .sx-sidebar .sx-user .sx-user-menu-btn,
    body.sx-collapsed .sx-sidebar .sx-tools { display: none !important; }
    body.sx-collapsed .sx-sidebar .sx-item { justify-content: center; padding: 11px 0; }
    body.sx-collapsed .sx-sidebar .sx-user { justify-content:center; }
    body.sx-collapsed #layout-wrapper .main-content { margin-left: var(--sx-w-collapsed) !important; }

    /* Botão flutuante para abrir no mobile (substitui topbar) */
    .sx-mobile-trigger {
        display: none; position: fixed; top: 14px; left: 14px; z-index: 1031;
        width: 42px; height: 42px; border-radius: 12px; border: 1px solid var(--s-border,#e8ecf1);
        background: var(--s-surface,#fff); color: var(--s-text,#0f172a); align-items:center; justify-content:center;
        box-shadow: 0 4px 12px rgba(15,23,42,.08); cursor:pointer; font-size: 22px;
    }

    /* mobile */
    @media (max-width: 991px) {
        .sx-sidebar { transform: translateX(-100%); box-shadow: 0 30px 60px rgba(15,23,42,.25); }
        body.sx-open .sx-sidebar { transform: translateX(0); }
        body #layout-wrapper .main-content { margin-left: 0 !important; padding-top: 64px; }
        .sx-backdrop { display: none; position: fixed; inset: 0; background: rgba(15,23,42,.45); z-index: 1029; }
        body.sx-open .sx-backdrop { display: block; }
        .sx-mobile-trigger { display: inline-flex; }
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

    {{-- ferramentas migradas do topbar --}}
    <div class="sx-tools">
        <button type="button" class="sx-tool" onclick="sOpenSearch && sOpenSearch()" title="Busca global (Ctrl+K)" aria-label="Busca global">
            <i class="mdi mdi-magnify"></i>
        </button>
        <button type="button" class="sx-tool" id="s-dark-toggle" onclick="sToggleDark && sToggleDark()" title="Alternar tema" aria-label="Alternar tema">
            <i class="mdi mdi-weather-night"></i>
        </button>
        <button type="button" class="sx-tool" onclick="(document.fullscreenElement?document.exitFullscreen():document.documentElement.requestFullscreen())" title="Tela cheia" aria-label="Tela cheia">
            <i class="mdi mdi-fullscreen"></i>
        </button>
        <button type="button" class="sx-tool noti-icon" id="page-header-notifications-dropdown" onclick="document.getElementById('sx-notif-pop').classList.toggle('open');event.stopPropagation();" title="Notificações" aria-label="Notificações">
            <i class="mdi mdi-bell-outline"></i>
            @if($Cnotification_count && $Cnotification_count->count() > 0)
                <span class="sx-badge badge">{{ $Cnotification_count->count() }}</span>
            @endif
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

    {{-- popover de notificações --}}
    <div class="sx-notif-pop" id="sx-notif-pop">
        <div class="sx-notif-head">
            Notificações
            <a href="{{ url('/notification-list') }}">Ver tudo</a>
        </div>
        <div class="sx-notif-list">
            @forelse ($Cnotification_count as $item)
                <a href="/notification/{{ $item->id }}">
                    <img src="{{ $profilePhoto }}" style="width:32px;height:32px;border-radius:50%;flex-shrink:0;">
                    <div style="min-width:0;">
                        <strong style="display:block;color:var(--s-text,#0f172a);font-size:12.5px;">{{ $item->user->first_name .' '.$item->user->last_name }}</strong>
                        <span style="display:block;font-size:11.5px;color:var(--s-muted,#94a3b8);">{{ $item->title }}</span>
                        <span style="font-size:10.5px;color:var(--s-muted,#94a3b8);"><i class="mdi mdi-clock-time-four-outline"></i> {{ $item->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="sx-notif-empty"><i class="mdi mdi-bell-off-outline" style="font-size:28px;display:block;margin-bottom:6px;"></i>Sem notificações</div>
            @endforelse
        </div>
    </div>

    {{-- usuário --}}
    <div class="sx-user" id="sx-user">
        <img src="{{ $profilePhoto }}" alt="{{ $user->first_name }}">
        <div class="sx-user-info">
            <strong>{{ $user->first_name }}</strong>
            <span>{{ $role }}</span>
        </div>
        <button type="button" class="sx-user-menu-btn" onclick="document.getElementById('sx-user').classList.toggle('open');event.stopPropagation();" aria-label="Menu do usuário">
            <i class="mdi mdi-dots-vertical"></i>
        </button>
        <div class="sx-user-pop">
            <a href="{{ $profileRoute }}"><i class="mdi mdi-account-outline"></i> {{ $role === 'admin' ? 'Alterar perfil' : 'Perfil' }}</a>
            <a href="{{ url('change-password') }}"><i class="mdi mdi-lock-outline"></i> Alterar senha</a>
            <div class="sx-pop-divider"></div>
            <button type="button" class="danger" onclick="document.getElementById('sx-logout-form').submit();">
                <i class="mdi mdi-logout"></i> Sair
            </button>
            <form id="sx-logout-form" action="{{ url('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>
    </div>
</aside>

<button type="button" class="sx-mobile-trigger" onclick="document.body.classList.toggle('sx-open')" aria-label="Abrir menu">
    <i class="mdi mdi-menu"></i>
</button>
<div class="sx-backdrop" onclick="document.body.classList.remove('sx-open')"></div>

<script>
    (function() {
        // fecha popovers ao clicar fora
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#sx-user')) document.getElementById('sx-user')?.classList.remove('open');
            if (!e.target.closest('#sx-notif-pop') && !e.target.closest('#page-header-notifications-dropdown'))
                document.getElementById('sx-notif-pop')?.classList.remove('open');
        });
    })();
</script>
