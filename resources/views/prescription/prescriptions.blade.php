@extends('layouts.master-layouts')
@section('title') {{ __('Lista de Prescrições') }} @endsection
@section('css')
    @include('partials.s-design-system')
    <style>
        #pageloader{background:rgba(255,255,255,.8);display:none;height:100%;position:fixed;width:100%;z-index:9999;left:0;right:0;margin:auto;bottom:0;top:0;}
        #pageloader img{left:50%;margin-left:-32px;margin-top:-32px;position:absolute;top:50%;}
    </style>
@endsection
@section('body')
<body data-topbar="dark" data-layout="horizontal">
    <div id="pageloader"><img src="{{ URL::asset('assets/images/loader.gif') }}" alt="processing..." /></div>
@endsection

@section('content')
<div class="s-page">
    <div class="s-head">
        <div class="s-head-title">
            <h1>Prescrições</h1>
            <p>Prescrições médicas emitidas para os pacientes.</p>
        </div>
        @if ($role == 'doctor')
            <a href="{{ route('prescription.create') }}" class="s-btn s-btn-primary">
                <i class="bx bx-plus"></i> {{ __('Nova Prescrição') }}
            </a>
        @endif
    </div>

    @if (session()->has('success'))
        <div class="s-alert success"><i class="bx bx-check-circle font-size-18"></i><span>{!! session()->get('success') !!}</span></div>
        {{ session()->forget('success') }}
    @endif

    <div class="s-card">
        <div class="s-card-head">
            <div class="s-card-head-left">
                <h2>Lista de Prescrições</h2>
                <span class="s-count">{{ $prescriptions->total() ?? $prescriptions->count() }}</span>
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        @if ($role == 'doctor') <th>Paciente</th>
                        @elseif ($role == 'patient') <th>Médico</th>
                        @else <th>Paciente</th><th>Médico</th>
                        @endif
                        <th style="width:140px;">Data</th>
                        <th style="width:160px;">Horário</th>
                        <th style="width:160px;text-align:right;">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $per_page = session()->has('page_limit') ? session()->get('page_limit') : Config::get('app.page_limit');
                        $currentpage = $prescriptions->currentPage();
                    @endphp
                    @forelse ($prescriptions as $prescription)
                        <tr>
                            <td data-label="#"><span class="s-num">{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</span></td>
                            @if ($role == 'receptionist' || $role == 'biomedical')
                                <td data-label="Paciente" class="s-cell-main">{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</td>
                                <td data-label="Médico">{{ $prescription->doctor->first_name }} {{ $prescription->doctor->last_name }}</td>
                            @elseif ($role == 'doctor')
                                <td data-label="Paciente" class="s-cell-main">{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</td>
                            @elseif ($role == 'patient')
                                <td data-label="Médico" class="s-cell-main">{{ $prescription->doctor->first_name }} {{ $prescription->doctor->last_name }}</td>
                            @else
                                <td data-label="Paciente" class="s-cell-main">{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</td>
                                <td data-label="Médico">{{ $prescription->doctor->first_name }} {{ $prescription->doctor->last_name }}</td>
                            @endif
                            <td data-label="Data"><span class="s-tag">{{ $prescription->appointment->appointment_date }}</span></td>
                            <td data-label="Horário">{{ $prescription->appointment->timeSlot->from }} às {{ $prescription->appointment->timeSlot->to }}</td>
                            <td data-label="Opções" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ url('prescription/' . $prescription->id) }}" class="s-icon-btn view" title="Visualizar"><i class="mdi mdi-eye-outline"></i></a>
                                    @if ($role == 'doctor')
                                        <a href="{{ url('prescription/' . $prescription->id . '/edit') }}" class="s-icon-btn edit" title="Editar"><i class="mdi mdi-square-edit-outline"></i></a>
                                        <a href="javascript:void(0)" class="s-icon-btn del" id="delete-prescription" data-id="{{ $prescription->id }}" title="Excluir"><i class="mdi mdi-trash-can-outline"></i></a>
                                    @endif
                                    @if ($role != 'patient')
                                        <a href="javascript:void(0)" class="s-icon-btn mail send-mail" title="Enviar e-mail" data-id="{{ $prescription->id }}"><i class="mdi mdi-email-outline"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="s-empty"><i class="bx bx-file"></i>Nenhuma prescrição encontrada.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="s-foot">
            <div class="s-foot-info">Mostrando <strong>{{ $prescriptions->firstItem() ?? 0 }}</strong> a <strong>{{ $prescriptions->lastItem() ?? 0 }}</strong> de <strong>{{ $prescriptions->total() }}</strong></div>
            {{ $prescriptions->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
    <script>
        $(document).on('click', '#delete-prescription', function () {
            var id = $(this).data('id');
            if (confirm('Tem certeza que deseja excluir esta prescrição?')) {
                $.ajax({
                    type: "DELETE",
                    url: 'prescription/' + id,
                    data: { _token: '{{ csrf_token() }}' },
                    beforeSend: function () { $('#pageloader').show(); },
                    success: function (data) { toastr.success(data.message); location.reload(); },
                    error: function (response) { toastr.error(response.responseJSON.message); },
                    complete: function () { $('#pageloader').hide(); }
                });
            }
        });
        $('.send-mail').click(function () {
            var id = $(this).attr('data-id');
            if (confirm('Tem certeza de que deseja enviar e-mail?')) {
                $.ajax({
                    type: "get",
                    url: "prescription-email/" + id,
                    beforeSend: function () { $('#pageloader').show(); },
                    success: function (response) { toastr.success(response.message); },
                    error: function (response) { toastr.error(response.responseJSON.message); },
                    complete: function () { $('#pageloader').hide(); }
                });
            }
        });
    </script>
@endsection
