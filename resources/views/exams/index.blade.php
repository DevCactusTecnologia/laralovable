@extends('layouts.master-layouts')
@section('title') {{ __('Lista de Exames') }} @endsection
@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@endsection
@section('css') @include('partials.s-design-system') @endsection

@section('content')
<div class="s-page">
    <div class="s-head">
        <div class="s-head-title">
            <h1>Exames</h1>
            <p>Catálogo de exames laboratoriais disponíveis.</p>
        </div>
        <a href="{{ route('exams.create') }}" class="s-btn s-btn-primary">
            <i class="bx bx-plus"></i> Novo Exame
        </a>
    </div>

    @if (session()->has('success'))
        <div class="s-alert success"><i class="bx bx-check-circle font-size-18"></i><span>{!! session()->get('success') !!}</span></div>
        {{ session()->forget('success') }}
    @endif

    <div class="s-card">
        <div class="s-card-head">
            <div class="s-card-head-left">
                <h2>Lista de Exames</h2>
                <span class="s-count">{{ $exams->total() ?? $exams->count() }}</span>
            </div>
            <div class="s-search">
                <i class="bx bx-search"></i>
                @csrf
                <input type="text" id="searchExam" placeholder="Pesquisar pelo nome ou abreviação..." />
                <input type="hidden" id="urlSearch" value="{{ route('exams.search.all') }}">
            </div>
        </div>

        <div class="s-table-wrap">
            <table class="s-table">
                <thead>
                    <tr>
                        <th>Nome do Exame</th>
                        <th style="width:110px;">Abrev.</th>
                        <th style="width:140px;">Categoria</th>
                        <th style="width:90px;">Prazo</th>
                        <th style="width:110px;">Destino</th>
                        <th style="width:110px;">G. Rótulos</th>
                        <th style="width:100px;">Qtd. Etiq.</th>
                        <th style="width:80px;">Kit</th>
                        <th style="width:120px;">Status</th>
                        <th style="width:80px;text-align:right;">Ação</th>
                    </tr>
                </thead>
                <tbody id="contentExam">
                    @forelse ($exams as $exam)
                        @php
                            $statusName = $exam->is_active?->getName();
                            $isActive = $statusName && (stripos($statusName,'ativo') !== false && stripos($statusName,'inativo') === false);
                        @endphp
                        <tr>
                            <td data-label="Nome" class="s-cell-main"><strong>{{ $exam->name }}</strong></td>
                            <td data-label="Abrev."><span class="s-tag indigo">{{ $exam->abbreviation }}</span></td>
                            <td data-label="Categoria">{{ $exam->category }}</td>
                            <td data-label="Prazo">{{ $exam->deadline }}</td>
                            <td data-label="Destino"><span class="s-tag">{{ $exam->destiny }}</span></td>
                            <td data-label="G. Rótulos">{{ $exam->label_group }}</td>
                            <td data-label="Qtd. Etiq.">{{ $exam->quantity_label }}</td>
                            <td data-label="Kit">{{ $exam->exam_kit }}</td>
                            <td data-label="Status"><span class="s-status {{ $isActive ? 'on' : 'off' }}"><span class="s-dot"></span>{{ $statusName ?? '—' }}</span></td>
                            <td data-label="Ação" style="text-align:right;">
                                <div class="s-actions">
                                    <a href="{{ route('exams.edit', $exam->id) }}" class="s-icon-btn edit" title="Atualizar"><i class="mdi mdi-square-edit-outline"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10"><div class="s-empty"><i class="bx bx-test-tube"></i>Nenhum exame encontrado.</div></td></tr>
                    @endforelse
                </tbody>
                <tbody id="loader" style="display:none;">
                    <tr><td colspan="10"><div class="s-empty"><span class="spinner-border spinner-border-sm mr-2 text-primary"></span>Carregando...</div></td></tr>
                </tbody>
            </table>
        </div>

        <div class="s-foot" id="paginate">
            <div class="s-foot-info">Total: <strong>{{ $exams->total() ?? $exams->count() }}</strong> exames</div>
            {{ $exams->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/pages/exams/search.js') }}"></script>
@endsection
