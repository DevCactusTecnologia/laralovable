<div class="s-page-header">
    <div>
        <h4>Olá, {{ $user->first_name }} 👋</h4>
        <div class="s-crumb">Visão geral · {{ config('app.name') }} Dashboard</div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 mb-4">
        <div class="s-card overflow-hidden">
            <div class="s-hero">
                <h5>Bem-vindo de volta!</h5>
                <p>{{ config('app.name') }} · Painel administrativo</p>
            </div>
            <div class="s-profile">
                <img src="@if ($user->profile_photo != ''){{ asset('storage/images/users/' . $user->profile_photo) }}@else{{ asset('assets/images/users/noImage.png') }}@endif" alt="">
                <div>
                    <p class="s-name">{{ $user->first_name }}</p>
                    <p class="s-role">Super Admin</p>
                </div>
            </div>
        </div>

        @if(isset($campaignCurrent))
        <div class="s-campaign">
            <img src="{{ asset($campaignCurrent->url_image) }}" alt="{{ $campaignCurrent->name }}">
        </div>
        @endif
    </div>

    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="s-card s-stat">
                    <div>
                        <p class="s-label">Total de Atendimentos</p>
                        <p class="s-value">{{ $total_appointment }}</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-copy-alt"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="s-card s-stat">
                    <div>
                        <p class="s-label">Exames este mês</p>
                        <p class="s-value">{{ $total_exam_month_current }}</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-calendar"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="s-card s-stat">
                    <div>
                        <p class="s-label">Total de Exames</p>
                        <p class="s-value">{{ $total_exams }}</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-test-tube"></i></span>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="s-card s-stat">
                    <div>
                        <p class="s-label">Atendimentos Hoje</p>
                        <p class="s-sub"><strong>{{ $today_appointment_total }}</strong> pacientes · <strong>{{ $today_appointment_exam_total }}</strong> exames</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-calendar-check"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="s-card s-stat">
                    <div>
                        <p class="s-label">Pendentes</p>
                        <p class="s-sub"><strong>{{ $pending_appointment_total }}</strong> pacientes · <strong>{{ $pending_appointment_exam_total }}</strong> exames</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="s-card s-stat">
                    <div>
                        <p class="s-label">Ocorrências</p>
                        <p class="s-sub"><strong>{{ $occurrences->pending ?: 0 }}</strong> pendentes · <strong>{{ $occurrences->resolved ?: 0 }}</strong> resolvidas</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-info-circle"></i></span>
                </div>
            </div>
        </div>

        <div class="s-card s-chart-card">
            <h4 class="s-section-title mb-3">Gráfico de atendimentos</h4>
            <div id="monthly_users" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
</div>
