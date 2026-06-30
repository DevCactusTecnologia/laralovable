@extends('layouts.master-layouts')
@section('title') Criar Atendimento @endsection
@section('css')
    @include('partials.s-design-system')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ================================================================
           SISLAC — Design system local (escopo: .sislac-novo-atendimento)
           Inspirado no app appsislac.lovable.app /atendimentos/novo
           ================================================================ */
        .sislac-novo-atendimento {
            --s-bg: #f7f8fb;
            --s-surface: #ffffff;
            --s-surface-2: #f4f5f9;
            --s-border: #e6e8ef;
            --s-border-strong: #d9dce5;
            --s-text: #14162b;
            --s-text-muted: #6b7185;
            --s-primary: #4f46e5;     /* indigo 244 88% 60% */
            --s-primary-50: #eef0ff;
            --s-primary-600: #4338ca;
            --s-success: #2faa6f;
            --s-success-50: #e8f6ef;
            --s-danger: #e0394b;
            --s-warning: #f59e0b;
            --s-radius: 14px;
            --s-radius-sm: 10px;
            --s-shadow-sm: 0 1px 2px rgba(20,22,43,.04), 0 4px 12px -4px rgba(20,22,43,.06);
            --s-shadow-md: 0 2px 4px rgba(20,22,43,.05), 0 12px 28px -10px rgba(79,70,229,.14);

            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--s-text);
            background: var(--s-bg);
            padding: 8px 4px 32px;
        }

        .sislac-novo-atendimento * { letter-spacing: -0.005em; }

        /* Hero header */
        .sislac-hero {
            position: relative;
            background:
                radial-gradient(120% 140% at 100% 0%, rgba(167,139,250,.22), transparent 55%),
                linear-gradient(135deg, #4f46e5 0%, #6d5cf0 55%, #a78bfa 100%);
            color: #fff;
            border-radius: 22px;
            padding: 26px 28px;
            margin-bottom: 22px;
            box-shadow: 0 12px 30px -12px rgba(79,70,229,.45);
            overflow: hidden;
        }
        .sislac-hero::after {
            content: ""; position: absolute; inset: 0;
            background-image:
                radial-gradient(circle at 12% 110%, rgba(255,255,255,.10) 0 18%, transparent 19%),
                radial-gradient(circle at 92% -10%, rgba(255,255,255,.08) 0 22%, transparent 23%);
            pointer-events: none;
        }
        .sislac-hero .eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.22);
            padding: 5px 12px; border-radius: 999px;
            font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .08em;
        }
        .sislac-hero h1 {
            font-size: 26px; font-weight: 700; margin: 12px 0 4px; color: #fff;
        }
        .sislac-hero p { margin: 0; opacity: .85; font-size: 14px; }
        .sislac-hero .breadcrumb-mini {
            font-size: 12px; opacity: .85; margin-top: 10px;
        }
        .sislac-hero .breadcrumb-mini a { color: #fff; text-decoration: underline; opacity: .9; }

        /* Card / sections */
        .sislac-card {
            background: var(--s-surface);
            border: 1px solid var(--s-border);
            border-radius: var(--s-radius);
            box-shadow: var(--s-shadow-sm);
            padding: 22px 24px;
            margin-bottom: 18px;
        }
        .sislac-section-head {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 18px;
        }
        .sislac-section-head .icon {
            width: 38px; height: 38px; border-radius: 11px;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--s-primary-50); color: var(--s-primary);
            font-size: 18px;
        }
        .sislac-section-head .title {
            font-size: 15px; font-weight: 700; color: var(--s-text); line-height: 1.2;
        }
        .sislac-section-head .subtitle {
            font-size: 12px; color: var(--s-text-muted); margin-top: 2px;
        }

        /* Form controls */
        .sislac-novo-atendimento label.control-label,
        .sislac-novo-atendimento label.form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--s-text);
            margin-bottom: 6px;
            text-transform: none;
        }
        .sislac-novo-atendimento .form-control,
        .sislac-novo-atendimento .select2-container--default .select2-selection--single {
            border: 1px solid var(--s-border-strong) !important;
            border-radius: var(--s-radius-sm) !important;
            height: 42px;
            font-size: 14px;
            color: var(--s-text);
            background: #fff;
            box-shadow: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .sislac-novo-atendimento textarea.form-control { height: auto; min-height: 110px; }
        .sislac-novo-atendimento .form-control:focus,
        .sislac-novo-atendimento .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--s-primary) !important;
            box-shadow: 0 0 0 3px rgba(79,70,229,.15) !important;
        }
        .sislac-novo-atendimento .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px; padding-left: 12px; color: var(--s-text);
        }
        .sislac-novo-atendimento .select2-container--default .select2-selection--single .select2-selection__arrow { height: 40px; }
        .sislac-novo-atendimento .form-control.bg-light { background: var(--s-surface-2) !important; }
        .sislac-novo-atendimento .input-group-text {
            background: var(--s-surface-2);
            border: 1px solid var(--s-border-strong);
            border-left: 0;
            border-radius: 0 var(--s-radius-sm) var(--s-radius-sm) 0;
            color: var(--s-primary);
        }
        .sislac-novo-atendimento .input-group .form-control { border-radius: var(--s-radius-sm) 0 0 var(--s-radius-sm) !important; }

        /* Add buttons (lateral +) */
        .sislac-add-btn {
            height: 42px; width: 42px; border-radius: var(--s-radius-sm);
            background: var(--s-primary); color: #fff !important; border: 0;
            display: inline-flex; align-items: center; justify-content: center;
            box-shadow: 0 6px 14px -6px rgba(79,70,229,.55);
            transition: transform .15s, background .15s;
        }
        .sislac-add-btn:hover { background: var(--s-primary-600); transform: translateY(-1px); }
        .sislac-add-btn i { font-size: 20px; }

        /* Exames table */
        .sislac-exames-wrap { border: 1px solid var(--s-border); border-radius: var(--s-radius); overflow: hidden; background: #fff; }
        .sislac-exames-wrap table { margin: 0; }
        .sislac-exames-wrap thead th {
            background: var(--s-surface-2);
            color: var(--s-text-muted);
            font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
            border: 0 !important; border-bottom: 1px solid var(--s-border) !important;
            padding: 12px 14px;
        }
        .sislac-exames-wrap tbody td {
            border-color: var(--s-border) !important;
            padding: 12px 14px; vertical-align: middle; font-size: 13.5px;
        }
        .sislac-exames-wrap tfoot td {
            background: var(--s-surface-2);
            border-color: var(--s-border) !important;
            padding: 12px 14px;
        }
        .sislac-exames-wrap tbody tr:hover td { background: #fafbff; }

        /* Upload box */
        .sislac-upload {
            display: flex !important; align-items: center; justify-content: center;
            border: 1.5px dashed var(--s-border-strong) !important;
            background: var(--s-surface-2) !important;
            color: var(--s-primary) !important;
            border-radius: var(--s-radius-sm) !important;
            height: 42px; cursor: pointer;
            transition: border-color .15s, background .15s;
        }
        .sislac-upload:hover { border-color: var(--s-primary) !important; background: var(--s-primary-50) !important; }

        /* Action bar */
        .sislac-actions {
            display: flex; justify-content: space-between; align-items: center;
            gap: 12px; margin-top: 8px;
            padding: 18px 24px;
            background: var(--s-surface);
            border: 1px solid var(--s-border);
            border-radius: var(--s-radius);
            box-shadow: var(--s-shadow-sm);
        }
        .sislac-btn-ghost {
            display: inline-flex; align-items: center; gap: 6px;
            background: transparent; color: var(--s-text-muted) !important;
            border: 1px solid var(--s-border-strong);
            padding: 10px 18px; border-radius: var(--s-radius-sm);
            font-weight: 600; font-size: 13.5px;
            transition: background .15s, color .15s, border-color .15s;
        }
        .sislac-btn-ghost:hover { background: var(--s-surface-2); color: var(--s-text) !important; border-color: var(--s-border-strong); }
        .sislac-btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--s-primary); color: #fff !important;
            border: 0; padding: 11px 24px; border-radius: var(--s-radius-sm);
            font-weight: 600; font-size: 14px;
            box-shadow: 0 8px 20px -8px rgba(79,70,229,.55);
            transition: background .15s, transform .15s;
        }
        .sislac-btn-primary:hover { background: var(--s-primary-600); transform: translateY(-1px); color: #fff !important; }

        /* Alerts */
        .sislac-novo-atendimento .alert {
            border: 0; border-radius: var(--s-radius);
            padding: 14px 18px; font-size: 14px;
            box-shadow: var(--s-shadow-sm);
        }
        .sislac-novo-atendimento .alert-success { background: var(--s-success-50); color: #1f7a4d; }
        .sislac-novo-atendimento .alert-danger  { background: #fdecee; color: #a52232; }
        .sislac-novo-atendimento .alert-danger ul { padding-left: 18px; }

        @media (max-width: 768px) {
            .sislac-hero { padding: 22px 18px; border-radius: 18px; }
            .sislac-hero h1 { font-size: 20px; }
            .sislac-card { padding: 18px 16px; }
            .sislac-actions { flex-direction: column-reverse; align-items: stretch; }
            .sislac-actions .sislac-btn-primary, .sislac-actions .sislac-btn-ghost { justify-content: center; }
        }
    </style>
@endsection
@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@endsection

@section('content')
<div class="s-page">
    <div class="sislac-novo-atendimento">

        {{-- HERO --}}
        <div class="sislac-hero">
            <span class="eyebrow">
                <i class="bx bx-test-tube"></i> Novo Atendimento
            </span>
            <h1>Criar atendimento</h1>
            <p>Registre paciente, solicitante, exames e dados complementares em um só lugar.</p>
            <div class="breadcrumb-mini">
                <a href="{{ url('/') }}">Dashboard</a>
                <span style="opacity:.6;margin:0 6px;">/</span>
                <a href="{{ route('appointments.index') }}">Atendimentos</a>
                <span style="opacity:.6;margin:0 6px;">/</span>
                <span>Criar</span>
            </div>
        </div>

        @if (session()->has('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Atendimento <strong>registrado</strong> com sucesso! Deseja imprimir o comprovante?
                <a href="{{ route('appointments.print', session()->get('appointment_id')) }}" target="_blank"
                    class="sislac-btn-primary ml-2" style="padding:6px 14px;font-size:13px;"
                >
                    <i class="mdi mdi-printer-outline"></i> Imprimir
                </a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ session()->forget('status') }}
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <input type="hidden" data-js="baseUrl" value="{{ url('/') }}">
        <form action="{{ route('appointments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ─────────── PACIENTE & SOLICITANTE ─────────── --}}
            <div class="sislac-card">
                <div class="sislac-section-head">
                    <span class="icon"><i class="bx bx-user"></i></span>
                    <div>
                        <div class="title">Paciente e solicitante</div>
                        <div class="subtitle">Identifique o paciente e quem está solicitando o atendimento.</div>
                    </div>
                </div>

                {{-- PACIENTE --}}
                <div class="row">
                    <div class="col-md-11 form-group">
                        <input type="hidden" id="urlSearchPatient" value="{{ route('appointment.patient.search') }}">
                        <label class="control-label">Paciente <span class="text-danger">*</span></label>
                        <select class="form-control select2 @error('appointment_for') is-invalid @enderror"
                            name="appointment_for" id="searchPatient">
                        </select>
                        @error('appointment_for')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-1 form-group d-flex align-items-end">
                        <button type="button" class="sislac-add-btn w-100"
                            title="Adicionar novo paciente" data-toggle="modal" data-target="#create-patient">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>

                {{-- SOLICITANTE + CONVENIO --}}
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label class="control-label">Solicitante <span class="text-danger">*</span></label>
                        <select class="form-control select2 sel-doctor @error('appointment_with') is-invalid @enderror"
                            name="appointment_with" id="doctor">
                            <option selected disabled>Selecionar</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" @selected(old('appointment_with') == $doctor->id)>
                                    {{ $doctor->first_name }} {{ $doctor->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('appointment_with')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-1 form-group d-flex align-items-end">
                        <button type="button" class="sislac-add-btn w-100"
                            title="Adicionar novo solicitante" data-toggle="modal" data-target="#create-doctor">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="control-label">Convênio <span class="text-danger">*</span></label>
                        <select class="form-control" name="company_id" required>
                            <option value="">Selecione</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ $companies->count() === 1 ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- ─────────── AGENDAMENTO ─────────── --}}
            <div class="sislac-card">
                <div class="sislac-section-head">
                    <span class="icon"><i class="bx bx-calendar"></i></span>
                    <div>
                        <div class="title">Agendamento</div>
                        <div class="subtitle">Defina data e unidade de atendimento.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="control-label">Data do atendimento <span class="text-danger">*</span></label>
                        <div class="input-group datepickerdiv">
                            <input type="text"
                                class="form-control appointment-date @error('appointment_date') is-invalid @enderror"
                                name="appointment_date" id="datepicker" data-provide="datepicker"
                                data-date-format="dd/mm/yyyy" value="{{ old('appointment_date', date('d/m/Y')) }}"
                                data-date-autoclose="true" autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-calendar-month-outline"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="control-label">Unidade de atendimento <span class="text-danger">*</span></label>
                        <select class="form-control" name="unity_id" required>
                            <option value="">Selecione</option>
                            @foreach ($unitys as $unity)
                                <option value="{{ $unity->id }}">{{ $unity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- ─────────── EXAMES ─────────── --}}
            <div class="sislac-card">
                <div class="sislac-section-head">
                    <span class="icon"><i class="bx bx-test-tube"></i></span>
                    <div>
                        <div class="title">Exames</div>
                        <div class="subtitle">Adicione os exames solicitados para este atendimento.</div>
                    </div>
                </div>

                <div class="sislac-exames-wrap">
                    <table class="table table-centered table-sm mb-0">
                        <thead>
                            <tr>
                                <th style="width:60px;">Nº</th>
                                <th>Exame</th>
                                <th>Descrição</th>
                                <th>Analista</th>
                                <th>Data da coleta</th>
                            </tr>
                        </thead>
                        <tbody id="examContent">
                            @if (old('exam_ids'))
                                @foreach (old('exam_ids') as $index => $exam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ old('exam_names')[$index] }}</td>
                                        <td class="d-flex align-items-center">
                                            <div title="Remover exame" onclick="removeExam(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" viewBox="0 0 48 48"
                                                    fill="var(--s-danger)" style="cursor: pointer;">
                                                    <path d="M13.05 42q-1.2 0-2.1-.9-.9-.9-.9-2.1V10.5H8v-3h9.4V6h13.2v1.5H40v3h-2.05V39q0 1.2-.9 2.1-.9.9-2.1.9Zm5.3-7.3h3V14.75h-3Zm8.3 0h3V14.75h-3Z"/>
                                                </svg>
                                            </div>
                                            <span style="margin-left: 8px;">{{ old('exam_abbreviations')[$index] }}</span>
                                        </td>
                                        <td>
                                            <select class="form-control form-select" name="exam_biomedicals[]">
                                                <option value="">Selecione</option>
                                                @foreach ($biomedicals as $biomedical)
                                                    <option value="{{ $biomedical->id }}"
                                                        {{ old('exam_biomedicals')[$index] == $biomedical->id ? 'selected' : '' }}>
                                                        {{ $biomedical->first_name }} {{ $biomedical->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="exam_collected_at[]"
                                                value="{{ old('exam_collected_at')[$index] }}">
                                        </td>
                                        <input type="hidden" name="exam_ids[]" value="{{ $exam }}">
                                        <input type="hidden" name="exam_abbreviations[]" value="{{ old('exam_abbreviations')[$index] }}">
                                        <input type="hidden" name="exam_names[]" value="{{ old('exam_names')[$index] }}">
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td style="width: 18%">
                                    <input type="hidden" id="urlSearchExamAbbreviation"
                                        value="{{ route('exams.search.abbreviation') }}">
                                    <select class="form-control" id="searchExamAbbreviation"
                                        onchange="changeExamAbbreviation()"></select>
                                </td>
                                <td style="width: 35%">
                                    <input type="hidden" id="urlSearchExamName" value="{{ route('exams.search.name') }}">
                                    <select class="form-control" id="searchExamName" onchange="changeExamName()"></select>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- ─────────── COMPLEMENTARES ─────────── --}}
            <div class="sislac-card">
                <div class="sislac-section-head">
                    <span class="icon"><i class="bx bx-clipboard"></i></span>
                    <div>
                        <div class="title">Dados complementares</div>
                        <div class="subtitle">Prioridade, entrega, jejum e observações clínicas.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="control-label">Prioridade</label>
                                <select class="form-control" name="priority_id">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->value }}" @selected($loop->first)>{{ $priority->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="control-label">Data de entrega</label>
                                <input type="date" class="form-control" name="delivery_date"
                                    value="{{ old('delivery_date', $deliveredAt) }}" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="control-label">Jejum</label>
                                <select name="fast" class="form-control">
                                    <option value="yes" {{ old('fast', 'yes') == 'yes' ? 'selected' : '' }}>Sim</option>
                                    <option value="no" {{ old('fast') == 'no' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group" id="dum_group">
                                <label class="control-label" title="Data da Última Menstruação">DUM</label>
                                <input type="date" class="form-control" name="dum" value="{{ old('dum') }}" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="control-label">Nº da Guia</label>
                                <input type="text" class="form-control bg-light" value="Automático"
                                    title="O número da guia será gerado automaticamente conforme a unidade de atendimento"
                                    style="cursor: help;" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="control-label">Documentos</label>
                                <div class="sislac-upload" title="Realizar o carregamento de documentos"
                                    data-toggle="modal" data-target="#add-document">
                                    <i class="bx bxs-cloud-upload font-size-22 mr-2"></i>
                                    <span style="font-size:13px;font-weight:600;">Carregar arquivos</span>
                                </div>
                                @include('appointments.modal.document.create')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label">Observações, doenças e medicamentos</label>
                            <textarea class="form-control" name="observation" rows="6">{{ old('observation') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─────────── AÇÕES ─────────── --}}
            <div class="sislac-actions">
                <a href="{{ route('appointments.index') }}" class="sislac-btn-ghost">
                    <i class="bx bx-arrow-back"></i> Voltar
                </a>
                <button type="submit" id="createAttendance" class="sislac-btn-primary">
                    <i class="bx bx-check"></i> Salvar atendimento
                </button>
            </div>
        </form>

        @include('appointments.modal.patient.create')
        @include('appointments.modal.doctor.create')
    </div>
</div>
@endsection

@section('script')
    {{-- LIBS --}}
    <script src="{{ asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>

    {{-- PAGES --}}
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/appointments/search.js') }}"></script>
    <script src="{{ asset('assets/js/pages/appointments/people.js') }}"></script>
@endsection
