@extends('layouts.master-layouts')
@section('title') Médicos @endsection
@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@endsection
@section('css') @include('partials.s-design-system') @endsection

@section('content')
<div class="s-page">
    <input type="hidden" data-js="base-url" value="{{ url('/') }}">

    <div class="s-head">
        <div class="s-head-title">
            <h1>Médicos</h1>
            <p>Gerencie os profissionais médicos cadastrados no sistema.</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="s-btn s-btn-primary">
            <i class="bx bx-plus"></i> Novo Médico
        </a>
    </div>

    @if (session()->has('success'))
        <div class="s-alert success"><i class="bx bx-check-circle font-size-18"></i><span>{!! session()->get('success') !!}</span></div>
        {{ session()->forget('success') }}
    @endif

    <div class="s-card">
        <div class="s-card-head">
            <div class="s-card-head-left">
                <h2>Lista de Médicos</h2>
                <span class="s-count">{{ $doctors->total() ?? $doctors->count() }}</span>
            </div>
            <div class="s-search">
                <i class="bx bx-search"></i>
                @csrf
                <input type="search" id="searchDoctor" name="search_name" placeholder="Pesquisar por nome, CPF ou CNS..." />
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Médico</th>
                        <th>Conselho</th>
                        <th style="width:80px;">UF</th>
                        <th style="width:140px;">Nº Conselho</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:120px;text-align:right;">Ações</th>
                    </tr>
                </thead>
                <tbody id="contentDoctor">
                    @php $currentPage = $doctors->currentPage(); $limit = App\Helpers\Pagination::getLimit(); @endphp
                    @forelse ($doctors as $key => $item)
                        @php
                            $fullName = trim(($item->first_name ?? '').' '.($item->last_name ?? ''));
                            $initials = collect(explode(' ', $fullName))->filter()->take(2)->map(fn($p)=>mb_substr($p,0,1))->implode('');
                            $statusName = $item->doctor?->is_deleted?->getName();
                            $isActive = $statusName && stripos($statusName,'inativo') === false;
                        @endphp
                        <tr>
                            <td data-label="#"><span class="s-num">{{ $key + 1 + $limit * ($currentPage - 1) }}</span></td>
                            <td data-label="Médico" class="s-cell-main">
                                <div class="s-avatar">
                                    <div class="s-av">{{ strtoupper($initials ?: 'M') }}</div>
                                    <div class="s-av-info">
                                        <div class="s-name">{{ $fullName ?: '—' }}</div>
                                        <div class="s-meta">{{ $item->email ?? 'sem e-mail' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Conselho">{{ $item->doctor?->council?->name ?? '—' }}</td>
                            <td data-label="UF"><span class="s-tag outline">{{ $item->doctor?->state?->name ?? '—' }}</span></td>
                            <td data-label="Nº Conselho"><span class="s-tag">{{ $item->doctor?->counsil_number ?? '—' }}</span></td>
                            <td data-label="Status">
                                <span class="s-status {{ $isActive ? 'on' : 'off' }}"><span class="s-dot"></span>{{ $statusName ?? '—' }}</span>
                            </td>
                            <td data-label="Ações" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ route('doctors.show', $item->id) }}" class="s-icon-btn view" title="Visualizar"><i class="mdi mdi-eye-outline"></i></a>
                                    <a href="{{ route('doctors.edit', $item->id) }}" class="s-icon-btn edit" title="Editar"><i class="mdi mdi-pencil-outline"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="s-empty"><i class="bx bx-user-x"></i>Nenhum médico encontrado.</div></td></tr>
                    @endforelse
                </tbody>
                <tbody id="loader" style="display:none;">
                    <tr><td colspan="7"><div class="s-empty"><span class="spinner-border spinner-border-sm mr-2 text-primary"></span>Carregando...</div></td></tr>
                </tbody>
            </table>
        </div>

        <div class="s-foot" id="paginate">
            <div class="s-foot-info">Mostrando <strong>{{ $doctors->count() }}</strong> de <strong>{{ $doctors->total() ?? $doctors->count() }}</strong> médicos</div>
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/pages/doctors/index.js') }}"></script>
@endsection
