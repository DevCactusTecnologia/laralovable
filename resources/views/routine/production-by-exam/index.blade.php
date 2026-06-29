@extends('layouts.master-layouts')
@section('title') Produção por exame @endsection

@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('title') Produção por exame @endslot
        @slot('li_1') Dashboard @endslot
        @slot('li_2') Produção por exame @endslot
    @endcomponent

    <div class="row"> 

        <div class="col-xl-12">
            <input type="hidden" value="{{ url('/') }}" data-base-url>
            <div class="alert alert-warning" style="display: none" data-alert></div>

            <div class="card p-3 mb-3">
                <form action="{{ route('routine.production.by.exam.search.all') }}" method="POST" data-form-production-exam>
                    @csrf
                    <div class="d-md-flex">
                        <div class="col-md-3 mb-4">
                            <label class="form-label">Data inicial</label>
                            <input type="date" class="form-control" data-started-at>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label">Data final</label>
                            <input type="date" class="form-control" data-finished-at>
                        </div>
                        <div class="col-md-2 mb-4">
                            <label class="form-label invisible">.</label>
                            <button type="submit" class="btn btn-primary form-control" data-submit-production-exam>
                                <i class="fa fa-search"></i>
                                <span class="ml-2">Buscar</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div data-container style="display: none;">
                    <div data-content></div>
                    <a href="" class="btn btn-dark mx-3 mt-3 d-none" target="_blank" data-print-production-exam>
                        Gerar relatório
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/js/pages/routine/production-by-exam.js') }}?version=160320252122"></script>
@endsection
