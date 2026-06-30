<div class="s-page-header">
    <div>
        <span class="s-badge">Recepção · Atendimentos de hoje</span>
        <h4>Olá, <span class="s-grad">{{ $user->first_name }}</span> 👋</h4>
        <div class="s-crumb">Bem-vindo ao {{ config('app.name') }} — do agendamento ao laudo, em um só lugar.</div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 mb-4">
        <div class="s-card overflow-hidden">
            <div class="s-hero">
                <h5>Bem-vindo de volta!</h5>
                <p>{{ config('app.name') }} · Recepção</p>
            </div>
            <div class="s-profile">
                <img src="@if ($user->profile_photo != null){{ asset('storage/images/users/' . $user->profile_photo) }}@else{{ asset('assets/images/users/noImage.png') }}@endif" alt="">
                <div>
                    <p class="s-name">{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="s-role">Recepcionista</p>
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
                        <p class="s-sub"><strong>{{ $occurrences->pending }}</strong> pendentes · <strong>{{ $occurrences->resolved }}</strong> resolvidas</p>
                    </div>
                    <span class="s-icon"><i class="bx bx-info-circle"></i></span>
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
                            <th class="text-center">Nº</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ação</th>
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
                                    @if($appointment->patient_name_social)
                                        <div style="font-weight: 600;">{{ $appointment->patient_name_social }}</div>
                                        <div style="font-size: 12px; color: var(--s-muted);">{{ $appointment->patient_name }}</div>
                                    @else
                                        <div style="font-weight: 600;">{{ $appointment->patient_name }}</div>
                                    @endif
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
                                    {!! App\Enums\Appointment\PriorityEnum::tryFrom($appointment->priority_id)?->getIcon() !!}
                                </td>
                                <td>
                                    <a href="{{ route('appointments.edit', $appointment->protocol) }}"
                                        class="s-btn-primary" style="padding: 6px 10px; font-size: 12px;" title="Ver atendimento">
                                        <i class="mdi mdi-eye-plus-outline align-middle"></i>
                                    </a>
                                    @if ($appointment->status == '1')
                                        <a href="{{ route('appointments.result.pdf', $appointment->protocol) }}"
                                            style="color: #10b981; margin-left: 6px;" title="Imprimir resultado" target="_blank">
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
