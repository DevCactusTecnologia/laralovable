@extends('layouts.master-layouts')
@section('title') {{ __('Lista de Recepcionistas') }} @endsection
@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@endsection
@section('css') @include('partials.s-design-system') @endsection

@section('content')
<div class="s-page">
    <div class="s-head">
        <div class="s-head-title">
            <h1>Recepcionistas</h1>
            <p>Gerencie os recepcionistas vinculados ao sistema.</p>
        </div>
        @if ($role == 'admin')
            <a href="{{ route('receptionists.create') }}" class="s-btn s-btn-primary">
                <i class="bx bx-plus"></i> Novo Recepcionista
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
                <h2>Lista de Recepcionistas</h2>
                <span class="s-count">{{ $receptionists->total() ?? $receptionists->count() }}</span>
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Recepcionista</th>
                        <th style="width:160px;">Contato</th>
                        <th>E-mail</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:120px;text-align:right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @php $currentPage = $receptionists->currentPage(); @endphp
                    @forelse ($receptionists as $receptionist)
                        @php
                            $fullName = trim(($receptionist->first_name ?? '').' '.($receptionist->last_name ?? ''));
                            $initials = collect(explode(' ', $fullName))->filter()->take(2)->map(fn($p)=>mb_substr($p,0,1))->implode('');
                            $statusName = $receptionist->receptionist?->is_deleted?->getName();
                            $isActive = $statusName && stripos($statusName,'inativo') === false;
                        @endphp
                        <tr>
                            <td data-label="#"><span class="s-num">{{ $loop->index + 1 + $limit * ($currentPage - 1) }}</span></td>
                            <td data-label="Recepcionista" class="s-cell-main">
                                <div class="s-avatar">
                                    <div class="s-av">{{ strtoupper($initials ?: 'R') }}</div>
                                    <div class="s-av-info">
                                        <a href="{{ route('receptionists.show', $receptionist->id) }}" class="s-name">{{ $fullName ?: '—' }}</a>
                                        <div class="s-meta">Recepção</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Contato"><span class="s-tag">{{ $receptionist->mobile ?? '—' }}</span></td>
                            <td data-label="E-mail">{{ $receptionist->email ?? '—' }}</td>
                            <td data-label="Status"><span class="s-status {{ $isActive ? 'on' : 'off' }}"><span class="s-dot"></span>{{ $statusName ?? '—' }}</span></td>
                            <td data-label="Ações" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ route('receptionists.show', $receptionist->id) }}" class="s-icon-btn view" title="Visualizar"><i class="mdi mdi-eye-outline"></i></a>
                                    @if ($role == 'admin')
                                        <a href="{{ route('receptionists.edit', $receptionist->id) }}" class="s-icon-btn edit" title="Editar"><i class="mdi mdi-pencil-outline"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="s-empty"><i class="bx bx-user-x"></i>Nenhum recepcionista encontrado.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="s-foot">
            <div class="s-foot-info">Mostrando <strong>{{ $receptionists->firstItem() ?? 0 }}</strong> a <strong>{{ $receptionists->lastItem() ?? 0 }}</strong> de <strong>{{ $receptionists->total() }}</strong> entradas</div>
            {{ $receptionists->links() }}
        </div>
    </div>
</div>
@endsection
