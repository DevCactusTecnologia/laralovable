@extends('layouts.master-layouts')
@section('title') {{ __('Lista de Pacientes') }} @endsection
@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@endsection
@section('css') @include('partials.s-design-system') @endsection

@section('content')
<div class="s-page">
    <input type="hidden" data-js="base-url" value="{{ url('/') }}">

    <div class="s-head">
        <div class="s-head-title">
            <h1>Pacientes</h1>
            <p>Gerencie os pacientes cadastrados no laboratório.</p>
        </div>
        <a href="{{ route('patients.create') }}" class="s-btn s-btn-primary">
            <i class="bx bx-plus"></i> Novo Paciente
        </a>
    </div>

    @if (session()->has('success'))
        <div class="s-alert success"><i class="bx bx-check-circle font-size-18"></i><span>{!! session()->get('success') !!}</span></div>
        {{ session()->forget('success') }}
    @endif

    <div class="s-card">
        <div class="s-card-head">
            <div class="s-card-head-left">
                <h2>Lista de Pacientes</h2>
                <span class="s-count">{{ $patients->total() ?? $patients->count() }}</span>
            </div>
            <div class="s-search">
                <i class="bx bx-search"></i>
                @csrf
                <input type="text" id="searchPatient" name="search_name" placeholder="Pesquisar por nome, CPF ou CNS..." />
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Paciente</th>
                        <th style="width:160px;">CPF</th>
                        <th style="width:180px;">CNS</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:120px;text-align:right;">Ações</th>
                    </tr>
                </thead>
                <tbody id="contentPatient">
                    @php $currentpage = $patients->currentPage(); @endphp
                    @forelse ($patients as $item)
                        @php
                            $fullName = trim(($item->first_name ?? '').' '.($item->last_name ?? ''));
                            $initials = collect(explode(' ', $fullName))->filter()->take(2)->map(fn($p)=>mb_substr($p,0,1))->implode('');
                            $statusName = $item->patient?->is_deleted?->getName();
                            $isActive = $statusName && stripos($statusName,'inativo') === false;
                        @endphp
                        <tr>
                            <td data-label="#"><span class="s-num">{{ $loop->index + 1 + $limit * ($currentpage - 1) }}</span></td>
                            <td data-label="Paciente" class="s-cell-main">
                                <div class="s-avatar">
                                    <div class="s-av">{{ strtoupper($initials ?: 'P') }}</div>
                                    <div class="s-av-info">
                                        <a href="{{ route('patients.show', $item->id) }}" class="s-name">{{ $fullName ?: '—' }}</a>
                                        <div class="s-meta">{{ $item->email ?? 'sem e-mail' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="CPF"><span class="s-tag">{{ $item->patient->cpf_masked ?? '—' }}</span></td>
                            <td data-label="CNS"><span class="s-tag outline">{{ $item->patient->cns_masked ?? '—' }}</span></td>
                            <td data-label="Status"><span class="s-status {{ $isActive ? 'on' : 'off' }}"><span class="s-dot"></span>{{ $statusName ?? '—' }}</span></td>
                            <td data-label="Ações" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ route('patients.show', $item->id) }}" class="s-icon-btn view" title="Visualizar"><i class="mdi mdi-eye-outline"></i></a>
                                    <a href="{{ route('patients.edit', $item->id) }}" class="s-icon-btn edit" title="Editar"><i class="mdi mdi-pencil-outline"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="s-empty"><i class="bx bx-user-x"></i>Nenhum paciente encontrado.</div></td></tr>
                    @endforelse
                </tbody>
                <tbody id="loader" style="display:none;">
                    <tr><td colspan="6"><div class="s-empty"><span class="spinner-border spinner-border-sm mr-2 text-primary"></span>Carregando...</div></td></tr>
                </tbody>
            </table>
        </div>

        <div class="s-foot" id="paginate">
            <div class="s-foot-info">Mostrando <strong>{{ $patients->count() }}</strong> de <strong>{{ $patients->total() ?? $patients->count() }}</strong> pacientes</div>
            {{ $patients->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/pages/patients/search.js') }}"></script>
@endsection
