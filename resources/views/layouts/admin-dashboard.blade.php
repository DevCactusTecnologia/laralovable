<div class="s-page-header">
    <div>
        <span class="s-badge">Visão geral · Painel administrativo</span>
        <h4>Olá, <span class="s-grad">{{ $user->first_name }}</span> 👋</h4>
        <div class="s-crumb">Visão geral operacional, financeira e de produtividade.</div>
    </div>
    <a href="{{ route('appointments.index') }}" class="s-btn-dark">
        <i class="bx bx-crown"></i> Ver atendimentos
    </a>
</div>

{{-- ===== Banner hero ===== --}}
<div class="s-banner mb-4">
    <div class="s-banner-content">
        <span class="s-banner-chip">✦ HOJE</span>
        <h3>Acompanhe seus atendimentos em tempo real</h3>
        <p>{{ $today_appointment_total }} atendimentos hoje · {{ $today_appointment_exam_total }} exames solicitados.</p>
        <div class="s-banner-actions">
            <a href="{{ route('appointments.index') }}" class="s-btn-dark">
                Ver atendimentos <i class="bx bx-right-top-arrow-circle"></i>
            </a>
            <a href="{{ route('appointments.create') }}" class="s-btn-glass">
                <i class="bx bx-receipt"></i> Novo atendimento
            </a>
        </div>
    </div>
    <div class="s-banner-art" aria-hidden="true"></div>
</div>

{{-- ===== Stat cards ===== --}}
<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="s-card s-stat-2">
            <p class="s-label">Atendimentos hoje</p>
            <h2 class="s-big">{{ $today_appointment_total }}</h2>
            <p class="s-sub"><strong>{{ $today_appointment_exam_total }}</strong> exames vinculados</p>
            <div class="s-stat-art s-art-donut"></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="s-card s-stat-2">
            <p class="s-label">Exames este mês</p>
            <h2 class="s-big">{{ $total_exam_month_current }}</h2>
            <p class="s-sub">acumulado do mês corrente</p>
            <div class="s-stat-art s-art-grid"></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="s-card s-stat-2">
            <p class="s-label">Total de atendimentos</p>
            <h2 class="s-big">{{ $total_appointment }}</h2>
            <p class="s-sub">histórico completo</p>
            <div class="s-stat-art s-art-line"></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="s-card s-stat-2">
            <p class="s-label">Total de exames</p>
            <h2 class="s-big">{{ $total_exams }}</h2>
            <p class="s-sub">solicitados e processados</p>
            <div class="s-stat-art s-art-bars"></div>
        </div>
    </div>
</div>

{{-- ===== Fluxo operacional + Pacientes ===== --}}
<div class="row g-3 mb-4">
    <div class="col-xl-8">
        <div class="s-card s-panel">
            <div class="s-panel-head">
                <div>
                    <h4 class="s-section-title">Fluxo operacional</h4>
                    <p class="s-panel-sub">Acompanhe sua rotina laboratorial</p>
                </div>
            </div>
            <div class="s-flow">
                <div class="s-flow-row">
                    <span class="s-flow-ic"><i class="bx bx-test-tube"></i></span>
                    <div class="s-flow-text">Coletas realizadas</div>
                    <span class="s-pill s-pill-ok">Concluído</span>
                    <span class="s-flow-val">{{ $today_appointment_exam_total }}</span>
                </div>
                <div class="s-flow-row">
                    <span class="s-flow-ic s-flow-ic-warn"><i class="bx bx-loader-circle"></i></span>
                    <div class="s-flow-text">Análises em andamento</div>
                    <span class="s-pill s-pill-warn">Em processo</span>
                    <span class="s-flow-val">{{ $pending_appointment_exam_total }}</span>
                </div>
                <div class="s-flow-row">
                    <span class="s-flow-ic"><i class="bx bx-file"></i></span>
                    <div class="s-flow-text">Resultados disponíveis</div>
                    <span class="s-pill s-pill-soft">Aguardando</span>
                    <span class="s-flow-val">{{ $pending_appointment_total }}</span>
                </div>
                <div class="s-flow-row">
                    <span class="s-flow-ic s-flow-ic-dark"><i class="bx bx-check-circle"></i></span>
                    <div class="s-flow-text">Liberados hoje</div>
                    <span class="s-pill s-pill-ok">Concluído</span>
                    <span class="s-flow-val">{{ max($today_appointment_total - $pending_appointment_total, 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="s-card s-panel h-100">
            <div class="s-panel-head">
                <div>
                    <h4 class="s-section-title">Ocorrências</h4>
                    <p class="s-panel-sub">Status atual de pendências</p>
                </div>
                <a href="javascript:void(0)" class="s-link">Ver todas →</a>
            </div>
            <div class="s-kpi-block">
                <p class="s-label">Pendentes</p>
                <h2 class="s-big">{{ $occurrences->pending ?: 0 }}</h2>
            </div>
            <div class="s-kpi-line">
                <span><i class="bx bx-info-circle"></i> Resolvidas</span>
                <strong>{{ $occurrences->resolved ?: 0 }}</strong>
            </div>
            <div class="s-kpi-line">
                <span><i class="bx bx-time-five"></i> Pendentes hoje</span>
                <strong class="s-pos">{{ $pending_appointment_total }}</strong>
            </div>
        </div>
    </div>
</div>

{{-- ===== Chart + Produtividade ===== --}}
<div class="row g-3">
    <div class="col-xl-8">
        <div class="s-card s-panel">
            <div class="s-panel-head">
                <div>
                    <h4 class="s-section-title">Gráfico de atendimentos</h4>
                    <p class="s-panel-sub">Atendimentos × Exames no ano</p>
                </div>
            </div>
            <div id="monthly_users" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="s-card s-panel h-100">
            <div class="s-panel-head">
                <div>
                    <h4 class="s-section-title">Produtividade</h4>
                    <p class="s-panel-sub">Indicadores do período</p>
                </div>
            </div>
            <div class="s-kpi-block">
                <p class="s-label">Exames realizados</p>
                <h2 class="s-big">{{ $total_exam_month_current }}</h2>
            </div>
            <div class="s-kpi-line"><span>Atendimentos totais</span><strong>{{ $total_appointment }}</strong></div>
            <div class="s-kpi-line"><span>Pendentes</span><strong>{{ $pending_appointment_total }}</strong></div>
            <div class="s-kpi-line"><span>Ocorrências</span><strong>{{ ($occurrences->pending ?: 0) + ($occurrences->resolved ?: 0) }}</strong></div>
        </div>

        @if(isset($campaignCurrent))
        <div class="s-campaign">
            <img src="{{ asset($campaignCurrent->url_image) }}" alt="{{ $campaignCurrent->name }}">
        </div>
        @endif
    </div>
</div>
