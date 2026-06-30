@extends('layouts.master-layouts')
@section('title') {{ __('Lista de Faturas') }} @endsection
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
            <h1>Faturas</h1>
            <p>Gerencie as faturas dos atendimentos.</p>
        </div>
        @if ($role != 'patient')
            <a href="{{ route('invoice.create') }}" class="s-btn s-btn-primary">
                <i class="bx bx-plus"></i> {{ __('Nova Fatura') }}
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
                <h2>Lista de Faturas</h2>
                <span class="s-count">{{ $invoices->total() ?? $invoices->count() }}</span>
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        @if ($role != 'patient')<th>Paciente</th>@endif
                        <th style="width:140px;">Data</th>
                        <th style="width:160px;">Horário</th>
                        <th style="width:140px;">Status</th>
                        <th style="width:160px;text-align:right;">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $per_page = session()->has('page_limit') ? session()->get('page_limit') : Config::get('app.page_limit');
                        $currentpage = $invoices->currentPage();
                    @endphp
                    @forelse ($invoices as $invoice)
                        @php
                            $status = strtolower($invoice->payment_status ?? '');
                            $statusCls = in_array($status,['paid','pago']) ? 'on' : (in_array($status,['pending','pendente']) ? 'pending' : 'off');
                        @endphp
                        <tr>
                            <td data-label="#"><span class="s-num">{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</span></td>
                            @if ($role != 'patient')
                                @php
                                    $fullName = trim(($invoice->user->first_name ?? '').' '.($invoice->user->last_name ?? ''));
                                    $initials = collect(explode(' ', $fullName))->filter()->take(2)->map(fn($p)=>mb_substr($p,0,1))->implode('');
                                @endphp
                                <td data-label="Paciente" class="s-cell-main">
                                    <div class="s-avatar">
                                        <div class="s-av">{{ strtoupper($initials ?: 'P') }}</div>
                                        <div class="s-av-info"><div class="s-name">{{ $fullName ?: '—' }}</div></div>
                                    </div>
                                </td>
                            @endif
                            <td data-label="Data"><span class="s-tag">{{ $invoice->appointment->appointment_date }}</span></td>
                            <td data-label="Horário">{{ $invoice->appointment->timeSlot->from }} às {{ $invoice->appointment->timeSlot->to }}</td>
                            <td data-label="Status"><span class="s-status {{ $statusCls }}"><span class="s-dot"></span>{{ $invoice->payment_status }}</span></td>
                            <td data-label="Opções" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ url('invoice/' . $invoice->id) }}" class="s-icon-btn view" title="Visualizar"><i class="mdi mdi-eye-outline"></i></a>
                                    <a href="{{ url('invoice/' . $invoice->id . '/edit') }}" class="s-icon-btn edit" title="Editar"><i class="mdi mdi-pencil-outline"></i></a>
                                    @if ($role != 'patient')
                                        <a href="javascript:void(0)" class="s-icon-btn mail send-mail" title="Enviar e-mail" data-id="{{ $invoice->id }}"><i class="mdi mdi-email-outline"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ $role != 'patient' ? 6 : 5 }}"><div class="s-empty"><i class="bx bx-receipt"></i>Nenhuma fatura encontrada.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="s-foot">
            <div class="s-foot-info">Mostrando <strong>{{ $invoices->firstItem() ?? 0 }}</strong> a <strong>{{ $invoices->lastItem() ?? 0 }}</strong> de <strong>{{ $invoices->total() }}</strong></div>
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
    <script>
        $('.send-mail').click(function () {
            var id = $(this).attr('data-id');
            if (confirm('Tem certeza de que deseja enviar e-mail?')) {
                $.ajax({
                    type: "get",
                    url: "invoice-email/" + id,
                    beforeSend: function () { $('#pageloader').show(); },
                    success: function (response) { toastr.success(response.message); },
                    error: function (response) { toastr.error(response.responseJSON.message); },
                    complete: function () { $('#pageloader').hide(); }
                });
            }
        });
    </script>
@endsection
