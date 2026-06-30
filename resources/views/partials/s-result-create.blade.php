{{-- SISLAC — restyle visual da página INSERIR RESULTADO conforme referência --}}
<style>
/* ========= Escopo ========= */
body.s-result-page { background: #f8fafc; }
body.s-result-page .s-page { background: transparent; }

/* esconder breadcrumb antigo e botão Voltar grande */
body.s-result-page .s-page > .page-title-box,
body.s-result-page .s-page .row:first-of-type .btn-primary[href*="appointments"] { display: none !important; }

/* link Voltar slim */
.sr-back {
    display: inline-flex; align-items: center; gap: 8px;
    color: #475569; font-family: 'Sora', sans-serif; font-weight: 600; font-size: 13.5px;
    text-decoration: none; margin: 4px 0 18px; padding: 6px 4px;
    transition: color .15s ease;
}
.sr-back:hover { color: #3b82f6; text-decoration: none; }
.sr-back i { font-size: 18px; }

/* ========= Layout principal ========= */
body.s-result-page .s-page .card { background: #fff; border: 1px solid #e8ecf1; border-radius: 16px; box-shadow: 0 1px 2px rgba(15,23,42,.03); padding: 0; }
body.s-result-page .s-page .card.p-2 { padding: 0 !important; }

/* esconde o cabeçalho cinza antigo (vamos reconstruir via JS) */
body.s-result-page .s-page .card > .d-md-flex:first-of-type { display: none !important; }
body.s-result-page .s-page .card > .d-md-flex.mt-3.border-top { margin: 0 !important; border-top: 0 !important; gap: 18px; padding: 0; }

/* duas colunas: lista exames | conteúdo */
body.s-result-page .s-page .card > .d-md-flex.mt-3 > .col-2 {
    flex: 0 0 300px; max-width: 300px; padding: 16px;
    background: #fff; border: 1px solid #e8ecf1; border-radius: 16px;
    margin: 0; align-self: flex-start;
}
body.s-result-page .s-page .card > .d-md-flex.mt-3 > .col-10 { flex: 1; padding: 0; max-width: none; }

/* ========= Coluna esquerda — Progresso + lista de exames ========= */
.sr-progress { padding: 6px 4px 14px; border-bottom: 1px solid #f1f3f7; margin-bottom: 14px; }
.sr-progress-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-family:'Sora',sans-serif; }
.sr-progress-head .lbl { font-size:11px; font-weight:700; letter-spacing:.12em; color:#94a3b8; text-transform:uppercase; }
.sr-progress-head .val { font-size:12.5px; font-weight:700; color:#0f172a; }
.sr-progress-bar { height:6px; background:#eef2f6; border-radius:999px; overflow:hidden; }
.sr-progress-bar > div { height:100%; background:linear-gradient(90deg,#6366f1,#3b82f6); border-radius:999px; transition: width .35s ease; }

.sr-search { position:relative; margin-bottom:12px; }
.sr-search input { width:100%; padding:9px 12px 9px 36px; border-radius:12px; border:1px solid #e8ecf1; background:#f8fafc; font-size:13px; color:#0f172a; outline:none; transition:all .15s ease; }
.sr-search input:focus { border-color:#3b82f6; background:#fff; box-shadow:0 0 0 4px rgba(59,130,246,.1); }
.sr-search i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:16px; }

.sr-tabs { display:flex; gap:4px; padding:4px; background:#f1f5f9; border-radius:999px; margin-bottom:14px; }
.sr-tabs button { flex:1; border:0; background:transparent; padding:6px 10px; border-radius:999px; font-family:'Sora',sans-serif; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#64748b; cursor:pointer; transition:all .15s ease; }
.sr-tabs button.active { background:linear-gradient(135deg,#4f46e5,#6366f1); color:#fff; box-shadow:0 2px 8px rgba(79,70,229,.3); }

/* cada exame na lista vira um card */
body.s-result-page .list-group { display:flex; flex-direction:column; gap:10px; }
body.s-result-page .list-group .list-group-item {
    display:block !important; padding:12px 14px !important;
    border-radius:12px !important; border:1px solid #e8ecf1 !important;
    background:#fff !important; transition:all .2s ease;
    position: relative;
}
body.s-result-page .list-group .list-group-item:hover { border-color:#c7d2fe !important; transform:translateY(-1px); box-shadow:0 4px 12px -4px rgba(15,23,42,.08); }
body.s-result-page .list-group .list-group-item.active {
    background:#eef2ff !important; border-color:#c7d2fe !important; color:#1e1b4b !important;
}
/* dentro do item: linha superior abrev + badge */
body.s-result-page .list-group .list-group-item .col-3,
body.s-result-page .list-group .list-group-item .col-4 { padding:0; flex:none; width:auto; max-width:none; }
body.s-result-page .list-group .list-group-item .col-5 {
    padding:0 !important; font-family:'Sora',sans-serif; font-weight:700; font-size:11px;
    letter-spacing:.08em; color:#4338ca; text-transform:uppercase; flex:1;
}
body.s-result-page .list-group .list-group-item .col-3 { order:2; margin-left:auto; }
body.s-result-page .list-group .list-group-item .col-4 { display:none !important; }
body.s-result-page .list-group .list-group-item i.mdi-check-circle-outline,
body.s-result-page .list-group .list-group-item i.mdi-information-slab-circle-outline,
body.s-result-page .list-group .list-group-item i.mdi-close-circle-outline {
    font-size:0 !important; /* esconde só o ícone e mostramos badge via ::after */
}
body.s-result-page .list-group .list-group-item .col-3 span {
    display:inline-flex; align-items:center; padding:3px 10px; border-radius:999px;
    font-family:'Sora',sans-serif; font-size:10.5px; font-weight:700; letter-spacing:.04em;
}
body.s-result-page .list-group .list-group-item .col-3 span[style*="33c38e"] { background:#dcfce7; color:#166534; }
body.s-result-page .list-group .list-group-item .col-3 span[style*="33c38e"]::after { content:"Digitado"; }
body.s-result-page .list-group .list-group-item .col-3 span[style*="efc681"] { background:#fef3c7; color:#92400e; }
body.s-result-page .list-group .list-group-item .col-3 span[style*="efc681"]::after { content:"Pendente"; }
body.s-result-page .list-group .list-group-item .col-3 span[style*="ff0000"] { background:#fee2e2; color:#991b1b; }
body.s-result-page .list-group .list-group-item .col-3 span[style*="ff0000"]::after { content:"Cancelado"; }

/* botão Imprimir exame embutido na lista quando ativo (via JS) */
.sr-print-inline {
    display:flex; align-items:center; justify-content:center; gap:8px;
    width:100%; padding:9px 12px; margin-top:10px;
    background:linear-gradient(135deg,#4f46e5,#6366f1); color:#fff !important;
    border:0; border-radius:10px;
    font-family:'Sora',sans-serif; font-weight:600; font-size:12.5px;
    cursor:pointer; transition:all .15s ease; text-decoration:none;
    box-shadow:0 4px 12px -2px rgba(79,70,229,.4);
}
.sr-print-inline:hover { transform:translateY(-1px); box-shadow:0 6px 16px -2px rgba(79,70,229,.5); color:#fff !important; text-decoration:none; }

/* ========= Coluna direita — Header do paciente ========= */
.sr-patient-card {
    background:#fff; border:1px solid #e8ecf1; border-radius:16px;
    padding:22px 24px; margin-bottom:18px;
    box-shadow:0 1px 2px rgba(15,23,42,.03);
}
.sr-patient-top { display:flex; justify-content:space-between; align-items:flex-start; gap:14px; margin-bottom:14px; flex-wrap:wrap; }
.sr-jejum { display:inline-flex; align-items:center; gap:8px; padding:6px 14px; border-radius:999px; background:#fef3c7; color:#92400e; font-size:12px; font-weight:600; font-family:'Sora',sans-serif; }
.sr-jejum::before { content:""; width:6px; height:6px; border-radius:50%; background:#f59e0b; }
.sr-final { display:inline-flex; align-items:center; gap:8px; padding:5px 14px; border-radius:999px; background:#dcfce7; color:#166534; font-size:12px; font-weight:700; font-family:'Sora',sans-serif; }

.sr-patient-body { display:flex; gap:16px; align-items:center; margin-bottom:18px; }
.sr-avatar {
    width:54px; height:54px; border-radius:50%; flex-shrink:0;
    background:#eef2ff; color:#4338ca;
    display:flex; align-items:center; justify-content:center;
    font-family:'Sora',sans-serif; font-weight:700; font-size:18px; letter-spacing:.02em;
}
.sr-patient-info h2 { font-family:'Sora',sans-serif; font-weight:700; font-size:18px; color:#0f172a; margin:0 0 6px; letter-spacing:-.01em; text-transform:uppercase; }
.sr-meta { display:flex; gap:16px; flex-wrap:wrap; font-size:12.5px; color:#64748b; align-items:center; }
.sr-meta span { display:inline-flex; align-items:center; gap:6px; }
.sr-meta i { color:#94a3b8; font-size:15px; }

.sr-actions { display:flex; gap:8px; flex-wrap:wrap; padding-top:14px; border-top:1px solid #f1f3f7; }
.sr-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:12px; font-family:'Sora',sans-serif; font-weight:600; font-size:13px; border:1px solid transparent; cursor:pointer; transition:all .18s ease; text-decoration:none; }
.sr-btn i { font-size:17px; }
.sr-btn-whats { background:linear-gradient(135deg,#10b981,#059669); color:#fff; box-shadow:0 4px 12px -2px rgba(16,185,129,.4); }
.sr-btn-whats:hover { color:#fff; transform:translateY(-1px); box-shadow:0 6px 16px -2px rgba(16,185,129,.5); text-decoration:none; }
.sr-btn-more { background:#fff; border-color:#e8ecf1; color:#475569; }
.sr-btn-more:hover { border-color:#3b82f6; color:#3b82f6; text-decoration:none; }
.sr-btn-print { background:linear-gradient(135deg,#4f46e5,#6366f1); color:#fff; box-shadow:0 4px 12px -2px rgba(79,70,229,.4); margin-left:auto; }
.sr-btn-print:hover { color:#fff; transform:translateY(-1px); box-shadow:0 6px 16px -2px rgba(79,70,229,.5); text-decoration:none; }

/* ========= Card do exame (conteúdo) ========= */
body.s-result-page .tab-pane > form { background:#fff; border:1px solid #e8ecf1; border-radius:16px; padding:24px 26px; box-shadow:0 1px 2px rgba(15,23,42,.03); }

/* título antigo do exame (faixa cinza) → título grande */
body.s-result-page .tab-pane > form > div[style*="eff2f7"] {
    background:transparent !important; padding:0 !important; margin:0 0 14px !important;
    border-bottom:1px solid #f1f3f7; padding-bottom:14px !important;
}
body.s-result-page .tab-pane > form > div[style*="eff2f7"] strong {
    font-family:'Sora',sans-serif; font-size:18px; font-weight:700; color:#0f172a;
    letter-spacing:-.01em; text-transform:uppercase;
}

/* inputs alinhados ao design system */
body.s-result-page .tab-pane .form-control {
    border-radius:10px; border:1px solid #e8ecf1; padding:9px 12px;
    background:#f8fafc; font-size:13.5px; transition:all .15s ease;
}
body.s-result-page .tab-pane .form-control:focus {
    border-color:#3b82f6; background:#fff; box-shadow:0 0 0 4px rgba(59,130,246,.1);
}
body.s-result-page .tab-pane label { font-family:'Sora',sans-serif; font-weight:600; font-size:12px; color:#475569; letter-spacing:.02em; text-transform:uppercase; }

/* botão Salvar */
body.s-result-page .tab-pane button[type="submit"] {
    background:linear-gradient(135deg,#4f46e5,#6366f1) !important; color:#fff !important;
    border:0; padding:10px 22px; border-radius:12px;
    font-family:'Sora',sans-serif; font-weight:600; font-size:13px;
    box-shadow:0 4px 12px -2px rgba(79,70,229,.4); transition:all .18s ease;
}
body.s-result-page .tab-pane button[type="submit"]:hover { transform:translateY(-1px); box-shadow:0 6px 16px -2px rgba(79,70,229,.5); }

/* mobile */
@media (max-width: 991px) {
    body.s-result-page .s-page .card > .d-md-flex.mt-3 { flex-direction:column; gap:14px; }
    body.s-result-page .s-page .card > .d-md-flex.mt-3 > .col-2 { flex:none; max-width:none; width:100%; }
}
</style>

<script>
(function(){
'use strict';
document.addEventListener('DOMContentLoaded', function(){
    document.body.classList.add('s-result-page');

    var page = document.querySelector('.s-page');
    if (!page) return;

    // ---- 1. Link "Voltar para resultados" no topo ----
    var back = document.createElement('a');
    back.href = @json(route('appointments.index'));
    back.className = 'sr-back';
    back.innerHTML = '<i class="mdi mdi-arrow-left"></i> Voltar para resultados';
    page.insertBefore(back, page.firstChild);

    // ---- 2. Header do paciente reconstruído ----
    @php
        $srPatient = isset($patient) ? $patient : \App\Models\Patient::firstWhere('user_id', $appointment->patient->id);
        $srData = [
            'name'     => $appointment->patient->first_name,
            'social'   => $appointment->patient->patient->patient_social_name ?? null,
            'gender'   => $srPatient && $srPatient->gender === 'Female' ? 'Feminino' : 'Masculino',
            'birth'    => $srPatient && $srPatient->date_of_birth ? \Carbon\Carbon::parse($srPatient->date_of_birth)->format('d/m/Y') : '',
            'age'      => $srPatient ? $srPatient->ageExtended($appointment->appointment_date) : '',
            'protocol' => 'ATD-' . str_pad($appointment->id, 10, '0', STR_PAD_LEFT),
            'finished' => $appointment->status == '1',
        ];
    @endphp
    var data = {!! json_encode($srData) !!};

    var initials = data.name.split(' ').slice(0,2).map(function(p){ return p[0]; }).join('').toUpperCase();

    var contentCol = document.querySelector('.s-page .card > .d-md-flex.mt-3 > .col-10');
    if (contentCol) {
        var header = document.createElement('div');
        header.className = 'sr-patient-card';
        header.innerHTML = ''
            + '<div class="sr-patient-top">'
            +    '<span class="sr-jejum">Jejum: Não informado</span>'
            +    (data.finished ? '<span class="sr-final">Finalizado</span>' : '')
            + '</div>'
            + '<div class="sr-patient-body">'
            +    '<div class="sr-avatar">' + initials + '</div>'
            +    '<div class="sr-patient-info">'
            +       '<h2>' + data.name + (data.social ? ' (' + data.social + ')' : '') + '</h2>'
            +       '<div class="sr-meta">'
            +          '<span><i class="mdi mdi-account-outline"></i>' + data.gender + '</span>'
            +          (data.birth ? '<span><i class="mdi mdi-calendar-blank-outline"></i>' + data.birth + '</span>' : '')
            +          '<span>' + data.age + '</span>'
            +          '<span><i class="mdi mdi-pound"></i>' + data.protocol + '</span>'
            +       '</div>'
            +    '</div>'
            + '</div>'
            + '<div class="sr-actions">'
            +    '<a href="#" class="sr-btn sr-btn-whats"><i class="mdi mdi-whatsapp"></i> Enviar WhatsApp</a>'
            +    '<a href="#" class="sr-btn sr-btn-more"><i class="mdi mdi-dots-horizontal"></i> Mais ações</a>'
            +    '<a href="' + @json(route('appointments.result.print', $appointment->id)) + '" target="_blank" class="sr-btn sr-btn-print"><i class="mdi mdi-printer-outline"></i> Imprimir todos</a>'
            + '</div>';
        contentCol.insertBefore(header, contentCol.firstChild);
    }

    // ---- 3. Coluna esquerda: progresso, busca, tabs ----
    var leftCol = document.querySelector('.s-page .card > .d-md-flex.mt-3 > .col-2');
    if (leftCol) {
        var items = leftCol.querySelectorAll('.list-group-item');
        var total = items.length;
        var done = leftCol.querySelectorAll('.list-group-item span[style*="33c38e"]').length;
        var pct = total ? Math.round((done/total)*100) : 0;

        var prog = document.createElement('div');
        prog.className = 'sr-progress';
        prog.innerHTML = ''
            + '<div class="sr-progress-head"><span class="lbl">Progresso</span><span class="val">' + done + '/' + total + ' · ' + pct + '%</span></div>'
            + '<div class="sr-progress-bar"><div style="width:' + pct + '%"></div></div>';

        var search = document.createElement('div');
        search.className = 'sr-search';
        search.innerHTML = '<i class="mdi mdi-magnify"></i><input type="text" placeholder="Buscar exame" id="sr-search-input">';

        var tabs = document.createElement('div');
        tabs.className = 'sr-tabs';
        tabs.innerHTML = ''
            + '<button class="active" data-filter="all">Todos ' + total + '</button>'
            + '<button data-filter="done">Liber. ' + done + '</button>';

        var listGroup = leftCol.querySelector('.list-group');
        leftCol.insertBefore(prog, listGroup);
        leftCol.insertBefore(search, listGroup);
        leftCol.insertBefore(tabs, listGroup);

        // busca
        document.getElementById('sr-search-input').addEventListener('input', function(e){
            var q = e.target.value.toLowerCase();
            items.forEach(function(it){
                it.style.display = it.textContent.toLowerCase().indexOf(q) >= 0 ? '' : 'none';
            });
        });

        // tabs filtro
        tabs.querySelectorAll('button').forEach(function(b){
            b.addEventListener('click', function(){
                tabs.querySelectorAll('button').forEach(function(x){ x.classList.remove('active'); });
                b.classList.add('active');
                var filter = b.dataset.filter;
                items.forEach(function(it){
                    if (filter === 'all') it.style.display = '';
                    else it.style.display = it.querySelector('span[style*="33c38e"]') ? '' : 'none';
                });
            });
        });

        // botão "Imprimir exame" injetado no item ativo
        function syncPrintButton(){
            leftCol.querySelectorAll('.sr-print-inline').forEach(function(b){ b.remove(); });
            var active = leftCol.querySelector('.list-group-item.active');
            if (!active) return;
            var examId = active.id.replace('list-','').replace('-list','');
            var url = @json(url('/')) + '/appointments/' + @json($appointment->id) + '/exams/' + examId + '/result';
            var btn = document.createElement('a');
            btn.className = 'sr-print-inline';
            btn.target = '_blank';
            btn.href = url;
            btn.innerHTML = '<i class="mdi mdi-printer-outline"></i> Imprimir exame';
            active.appendChild(btn);
        }
        syncPrintButton();
        items.forEach(function(it){ it.addEventListener('click', function(){ setTimeout(syncPrintButton, 50); }); });
    }
});
})();
</script>
