<div class="s-page-header">
    <div>
        <span class="s-badge">Análises clínicas · Painel do biomédico</span>
        <h4>Olá, <span class="s-grad">{{ $user->first_name }}</span> 👋</h4>
        <div class="s-crumb">Bem-vindo ao {{ config('app.name') }} — amostras, validações e laudos em um só lugar.</div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 mb-4">
        <div class="s-card overflow-hidden">
            <div class="s-hero">
                <h5>Bem-vindo de volta!</h5>
                <p>{{ config('app.name') }} · Análises clínicas</p>
            </div>
            <div class="s-profile">
                <img src="@if ($user->profile_photo != null){{ asset('storage/images/users/' . $user->profile_photo) }}@else{{ asset('assets/images/users/noImage.png') }}@endif" alt="">
                <div>
                    <p class="s-name">{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="s-role">Analista</p>
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
                        <p class="s-label">Atendimentos Hoje</p>
                        <p class="s-value">{{ $today_appointment_total }}</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-calendar-check"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="s-card s-stat">
                    <div>
                        <p class="s-label">Pendentes</p>
                        <p class="s-value">{{ $pending_appointment_total }}</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="s-card s-stat">
                    <div>
                        <p class="s-label">Agendados</p>
                        <p class="s-value">{{ $upcoming_appointment_total }}</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-purchase-tag-alt"></i></span>
                </div>
            </div>
        </div>

        <div class="s-card" style="padding: 24px;">
            <div class="s-page-header" style="margin-bottom: 18px;">
                <h4 class="s-section-title">Atendimentos de hoje</h4>
                <a href="{{ route('appointments.index') }}" class="s-btn-primary">
                    Ver todos os atendimentos
                </a>
            </div>

            <div class="table-responsive">
                <table class="s-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $per_page = 20;
                            $currentpage = $appointments->currentPage();
                        @endphp
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td class="text-center" style="color: var(--s-muted); font-weight: 600;">{{ $loop->iteration + $per_page * ($currentpage - 1) }}</td>
                                <td>
                                    <a href="{{ route('patients.show', $appointment->patient_id) }}" style="font-weight: 600; color: var(--s-ink);">
                                        {{ $appointment->patient_name }}
                                    </a>
                                </td>
                                <td>{{ $appointment->doctor_name }}</td>
                                <td style="color: var(--s-muted);">{{ date('d/m/Y H:i', strtotime($appointment->created_at)) }}</td>
                                <td>
                                    @if ($appointment->status == '0')
                                        <span class="s-pill s-pill-warn">Pendente</span>
                                    @elseif($appointment->status == '1')
                                        <span class="s-pill s-pill-ok">Finalizado</span>
                                    @else
                                        <span class="s-pill s-pill-bad">Cancelado</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($appointment->status == '1')
                                        <a href="{{ route('appointments.result.pdf', $appointment->protocol) }}"
                                            style="color: #10b981;" title="Imprimir resultado" target="_blank">
                                            <i class="mdi mdi-printer-outline font-size-20 align-middle"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3" id="paginate">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>
