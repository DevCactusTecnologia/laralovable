@extends('layouts.master-layouts')
@section('title') {{ __('Lista de Setores') }} @endsection
@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@endsection
@section('css') @include('partials.s-design-system') @endsection

@section('content')
<div class="s-page">
    <div class="s-head">
        <div class="s-head-title">
            <h1>Setores</h1>
            <p>Setores e categorias para classificação dos exames.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="s-btn s-btn-primary">
            <i class="bx bx-plus"></i> Novo Setor
        </a>
    </div>

    @if (session()->has('success'))
        <div class="s-alert success"><i class="bx bx-check-circle font-size-18"></i><span>{!! session()->get('success') !!}</span></div>
        {{ session()->forget('success') }}
    @endif

    <div class="s-card">
        <div class="s-card-head">
            <div class="s-card-head-left">
                <h2>Lista de Setores</h2>
                <span class="s-count">{{ $categories->count() }}</span>
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th style="width:160px;">Abreviação</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:120px;text-align:right;">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        @php
                            $statusName = $category->is_active?->getName();
                            $isActive = $statusName && (stripos($statusName,'ativo') !== false && stripos($statusName,'inativo') === false);
                        @endphp
                        <tr>
                            <td data-label="Nome" class="s-cell-main"><strong>{{ $category->name }}</strong></td>
                            <td data-label="Abreviação"><span class="s-tag indigo">{{ $category->abbreviation }}</span></td>
                            <td data-label="Status"><span class="s-status {{ $isActive ? 'on' : 'off' }}"><span class="s-dot"></span>{{ $statusName ?? '—' }}</span></td>
                            <td data-label="Ação" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="s-icon-btn edit" title="Atualizar"><i class="mdi mdi-square-edit-outline"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><div class="s-empty"><i class="bx bx-category"></i>Nenhum setor cadastrado.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="s-foot">
            <div class="s-foot-info"><strong>{{ $categories->count() }}</strong> registros encontrados</div>
        </div>
    </div>
</div>
@endsection
