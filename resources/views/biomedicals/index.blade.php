@extends('layouts.master-layouts')
@section('title') Lista de Analistas @endsection
@section('body') <body data-topbar="dark" data-layout="horizontal"> @endsection
@section('css') @include('partials.s-design-system') @endsection

@section('content')
<div class="s-page">
    <div class="s-head">
        <div class="s-head-title">
            <h1>Analistas Biomédicos</h1>
            <p>Gerencie os analistas biomédicos do laboratório.</p>
        </div>
        @if ($role == 'admin')
            <a href="{{ route('biomedicals.create') }}" class="s-btn s-btn-primary">
                <i class="bx bx-plus"></i> Novo Analista
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
                <h2>Lista de Analistas</h2>
                <span class="s-count">{{ count($biomedicals) }}</span>
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Analista</th>
                        <th style="width:160px;">Contato</th>
                        <th>E-mail</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:120px;text-align:right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($biomedicals as $biomedical)
                        @php
                            $fullName = trim(($biomedical->first_name ?? '').' '.($biomedical->last_name ?? ''));
                            $initials = collect(explode(' ', $fullName))->filter()->take(2)->map(fn($p)=>mb_substr($p,0,1))->implode('');
                            $statusName = $biomedical->biomedical?->is_deleted?->getName();
                            $isActive = $statusName && stripos($statusName,'inativo') === false;
                        @endphp
                        <tr>
                            <td data-label="#"><span class="s-num">{{ $loop->iteration }}</span></td>
                            <td data-label="Analista" class="s-cell-main">
                                <div class="s-avatar">
                                    <div class="s-av">{{ strtoupper($initials ?: 'A') }}</div>
                                    <div class="s-av-info">
                                        <a href="{{ route('biomedicals.show', $biomedical->id) }}" class="s-name">{{ $fullName ?: '—' }}</a>
                                        <div class="s-meta">Biomédico</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Contato"><span class="s-tag">{{ $biomedical->mobile ?? '—' }}</span></td>
                            <td data-label="E-mail">{{ $biomedical->email ?? '—' }}</td>
                            <td data-label="Status"><span class="s-status {{ $isActive ? 'on' : 'off' }}"><span class="s-dot"></span>{{ $statusName ?? '—' }}</span></td>
                            <td data-label="Ações" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ route('biomedicals.show', $biomedical->id) }}" class="s-icon-btn view" title="Visualizar"><i class="mdi mdi-eye-outline"></i></a>
                                    @if ($role == 'admin')
                                        <a href="{{ route('biomedicals.edit', $biomedical->id) }}" class="s-icon-btn edit" title="Editar"><i class="mdi mdi-pencil-outline"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="s-empty"><i class="bx bx-user-x"></i>Nenhum analista encontrado.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
