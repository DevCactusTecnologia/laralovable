@extends('layouts.master-without-nav')
@section('title') Entrar @endsection
@section('body') <body style="background: var(--slc-bg);"> @endsection

@section('content')
    <div class="slc-auth-shell">
        <div class="row g-0">
            {{-- HERO ESQUERDO --}}
            <div class="col-lg-6 d-none d-lg-flex">
                <div class="slc-auth-hero w-100">
                    <div>
                        <span class="slc-eyebrow">Mais laudos liberados, menos retrabalho</span>
                        <h1>Gestão completa para <em>laboratórios clínicos</em></h1>
                        <p class="slc-lead">
                            Do atendimento ao resultado, tudo em um único sistema seguro e
                            escalável. Coleta rastreada, análises validadas, financeiro integrado.
                        </p>
                        <ul class="slc-bullets">
                            <li>Reduz retrabalho e recoletas</li>
                            <li>Laudos liberados em minutos</li>
                            <li>Rastreabilidade ponta a ponta</li>
                        </ul>
                    </div>
                    <div class="slc-foot">© {{ date('Y') }} SISLAC · Todos os direitos reservados</div>
                </div>
            </div>

            {{-- FORM DIREITO --}}
            <div class="col-lg-6">
                <div class="slc-auth-panel">
                    <div class="slc-logo">
                        <span class="slc-mark">⚗</span> SISLAC
                    </div>

                    <h2>Bem vindo de volta 👋</h2>
                    <p class="slc-sub">Hoje é um dia novo. Entre para começar a gerenciar seu trabalho.</p>

                    <form method="POST" action="{{ url('login') }}">
                        @csrf

                        {{-- ALERTAS --}}
                        @if ($msg = Session::get('error'))
                            <div class="alert alert-danger" style="border-radius: var(--slc-radius-sm); border:none; background:#fee2e2; color:#991b1b;">
                                <span>{{ $msg }}</span>
                            </div>
                        @endif
                        @if ($msg = Session::get('success'))
                            <div class="alert alert-success" style="border-radius: var(--slc-radius-sm); border:none; background:#d1fae5; color:#065f46;">
                                <span>{{ $msg }}</span>
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="email">Usuário</label>
                            <input name="email" type="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="Digite seu e-mail" autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="pass">Senha</label>
                            <input type="password" name="password" id="pass"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Digite sua senha">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Entrar →
                        </button>
                    </form>

                    <div class="slc-foot d-lg-none">© {{ date('Y') }} SISLAC</div>
                </div>
            </div>
        </div>
    </div>
@endsection
