{{-- SISLAC Phase 1: Dark mode, busca global (Ctrl+K), confirm padronizado, empty states --}}
<style>
/* ===== Dark mode tokens (aplicados ao .s-page quando body.s-dark) ===== */
body.s-dark{background:#0b1020;color:#e5e7eb;}
body.s-dark .s-page{
    --s-bg:#0b1020; --s-surface:#111733; --s-soft:#0f1530;
    --s-border:#1f2745; --s-border-strong:#2a3358;
    --s-text:#e5e7eb; --s-muted:#94a3b8;
}
body.s-dark .s-page .card,
body.s-dark .s-page .s-card{background:var(--s-surface);border-color:var(--s-border);color:var(--s-text);}
body.s-dark .s-page .table{color:var(--s-text);}
body.s-dark .s-page .table thead th{background:#0f1530;color:#cbd5e1;border-color:var(--s-border);}
body.s-dark .s-page .table tbody tr{border-color:var(--s-border);}
body.s-dark .s-page .table tbody tr:hover{background:#172046;}
body.s-dark .s-page .form-control,
body.s-dark .s-page .form-select,
body.s-dark .s-page select,
body.s-dark .s-page input,
body.s-dark .s-page textarea{
    background:#0f1530!important;border-color:var(--s-border-strong)!important;color:var(--s-text)!important;
}
body.s-dark .s-page .s-btn-ghost{background:#172046;color:#e5e7eb;border-color:var(--s-border-strong);}
body.s-dark .s-page .s-icon-btn{background:#172046;border-color:var(--s-border-strong);color:#cbd5e1;}
body.s-dark .s-page .badge-light{background:#1f2745;color:#cbd5e1;}

/* ===== Empty state ===== */
.s-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 24px;text-align:center;color:var(--s-muted,#6b7280);}
.s-empty-icon{width:72px;height:72px;border-radius:50%;display:grid;place-items:center;
    background:linear-gradient(135deg,#eef2ff,#f5f3ff);color:#4f46e5;font-size:32px;margin-bottom:14px;}
body.s-dark .s-empty-icon{background:linear-gradient(135deg,#1f2745,#2a3358);color:#a5b4fc;}
.s-empty h3{font-size:1rem;font-weight:700;color:var(--s-text,#0f172a);margin:0 0 4px;}
.s-empty p{font-size:.85rem;margin:0 0 14px;max-width:340px;}

/* ===== Skeleton ===== */
.s-skel{display:inline-block;background:linear-gradient(90deg,#eef0f5 0%,#f7f8fb 50%,#eef0f5 100%);
    background-size:200% 100%;animation:sSkel 1.4s ease-in-out infinite;border-radius:8px;height:14px;width:100%;}
body.s-dark .s-skel{background:linear-gradient(90deg,#172046 0%,#1f2745 50%,#172046 100%);background-size:200% 100%;}
@keyframes sSkel{0%{background-position:200% 0;}100%{background-position:-200% 0;}}

/* ===== Busca global (Cmd/Ctrl+K) ===== */
.s-search-backdrop{position:fixed;inset:0;background:rgba(8,11,28,.55);backdrop-filter:blur(6px);z-index:1080;display:none;align-items:flex-start;justify-content:center;padding-top:10vh;}
.s-search-backdrop.show{display:flex;animation:sFade .18s ease;}
@keyframes sFade{from{opacity:0;}to{opacity:1;}}
.s-search-modal{width:min(640px,92vw);background:#fff;border-radius:18px;box-shadow:0 30px 80px -20px rgba(15,23,42,.45);overflow:hidden;animation:sPop .22s cubic-bezier(.2,.9,.3,1.2);}
body.s-dark .s-search-modal{background:#111733;color:#e5e7eb;}
@keyframes sPop{from{transform:translateY(-8px) scale(.97);opacity:0;}to{transform:none;opacity:1;}}
.s-search-input-wrap{display:flex;align-items:center;gap:10px;padding:14px 18px;border-bottom:1px solid #eceff5;}
body.s-dark .s-search-input-wrap{border-color:#1f2745;}
.s-search-input-wrap i{font-size:22px;color:#6b7280;}
.s-search-modal input{flex:1;border:0;outline:0;background:transparent;font-size:1rem;color:inherit;}
.s-search-results{max-height:50vh;overflow:auto;padding:8px;}
.s-search-results .s-sr-group{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;padding:10px 12px 4px;}
.s-search-results a{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;color:inherit;text-decoration:none;font-size:.9rem;}
.s-search-results a:hover,.s-search-results a.active{background:linear-gradient(135deg,#eef2ff,#f5f3ff);color:#4338ca;}
body.s-dark .s-search-results a:hover,body.s-dark .s-search-results a.active{background:#1f2745;color:#a5b4fc;}
.s-search-results a i{font-size:18px;}
.s-search-foot{display:flex;justify-content:space-between;gap:8px;padding:10px 18px;border-top:1px solid #eceff5;font-size:.72rem;color:#94a3b8;}
body.s-dark .s-search-foot{border-color:#1f2745;}
.s-search-foot kbd{background:#f1f5f9;border-radius:5px;padding:2px 6px;font-size:.7rem;color:#475569;}
body.s-dark .s-search-foot kbd{background:#1f2745;color:#cbd5e1;}

/* SweetAlert2 themed */
.swal2-popup.s-swal{border-radius:18px;padding:26px;font-family:inherit;}
.swal2-popup.s-swal .swal2-title{font-size:1.15rem;font-weight:700;color:#0f172a;}
.swal2-popup.s-swal .swal2-html-container{font-size:.9rem;color:#475569;}
.swal2-popup.s-swal .swal2-confirm{background:linear-gradient(135deg,#ef4444,#f97316)!important;border-radius:10px!important;font-weight:600;box-shadow:none!important;}
.swal2-popup.s-swal .swal2-cancel{background:#fff!important;color:#0f172a!important;border:1px solid #e2e6ef!important;border-radius:10px!important;font-weight:600;}
.swal2-popup.s-swal-info .swal2-confirm{background:linear-gradient(135deg,#4f46e5,#8b5cf6)!important;}
body.s-dark .swal2-popup.s-swal{background:#111733;color:#e5e7eb;}
body.s-dark .swal2-popup.s-swal .swal2-title{color:#e5e7eb;}
body.s-dark .swal2-popup.s-swal .swal2-html-container{color:#cbd5e1;}
body.s-dark .swal2-popup.s-swal .swal2-cancel{background:#172046!important;color:#e5e7eb!important;border-color:#2a3358!important;}

/* Botão dark toggle no header */
#s-dark-toggle i,#s-search-trigger i{font-size:1.25rem;}
</style>

{{-- Modal de busca global --}}
<div class="s-search-backdrop" id="s-search-backdrop" role="dialog" aria-modal="true" aria-label="Busca global">
  <div class="s-search-modal" onclick="event.stopPropagation()">
    <div class="s-search-input-wrap">
      <i class="mdi mdi-magnify"></i>
      <input id="s-search-input" type="text" placeholder="Buscar paciente, exame, médico, fatura, agendamento..." autocomplete="off"/>
      <kbd style="background:#f1f5f9;border-radius:5px;padding:2px 6px;font-size:.7rem;color:#475569;">ESC</kbd>
    </div>
    <div class="s-search-results" id="s-search-results">
      <div class="s-sr-group">Atalhos</div>
      <a href="{{ url('/') }}"><i class="mdi mdi-view-dashboard-outline"></i> Dashboard</a>
      <a href="{{ url('/patients') }}"><i class="mdi mdi-account-multiple-outline"></i> Pacientes</a>
      <a href="{{ url('/doctors') }}"><i class="mdi mdi-stethoscope"></i> Médicos</a>
      <a href="{{ url('/biomedicals') }}"><i class="mdi mdi-test-tube"></i> Biomédicos</a>
      <a href="{{ url('/receptionists') }}"><i class="mdi mdi-face-agent"></i> Recepcionistas</a>
      <a href="{{ url('/exams') }}"><i class="mdi mdi-flask-outline"></i> Exames</a>
      <a href="{{ url('/categories') }}"><i class="mdi mdi-tag-multiple-outline"></i> Categorias</a>
      <a href="{{ url('/appointments') }}"><i class="mdi mdi-calendar-month-outline"></i> Agendamentos</a>
      <a href="{{ url('/invoices') }}"><i class="mdi mdi-receipt-text-outline"></i> Faturas</a>
      <a href="{{ url('/prescriptions') }}"><i class="mdi mdi-file-document-edit-outline"></i> Prescrições</a>
      <a href="{{ url('/routine/occurrence') }}"><i class="mdi mdi-alert-circle-outline"></i> Ocorrências</a>
      <a href="{{ url('/routine/traceability') }}"><i class="mdi mdi-history"></i> Rastreabilidade</a>
    </div>
    <div class="s-search-foot">
      <span><kbd>↑</kbd> <kbd>↓</kbd> navegar &nbsp; <kbd>Enter</kbd> abrir</span>
      <span><kbd>Ctrl</kbd>+<kbd>K</kbd> para reabrir</span>
    </div>
  </div>
</div>

<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<script>
(function(){
  // ===== Dark mode =====
  const DARK_KEY='sislac-dark';
  function applyDark(on){
    document.body.classList.toggle('s-dark', on);
    try{
      const bDark=document.getElementById('bootstrap-dark'), bLight=document.getElementById('bootstrap-light');
      const aDark=document.getElementById('app-dark'), aLight=document.getElementById('app-light');
      if(bDark&&bLight){bDark.disabled=!on; bLight.disabled=on;}
      if(aDark&&aLight){aDark.disabled=!on; aLight.disabled=on;}
    }catch(e){}
    const btn=document.getElementById('s-dark-toggle');
    if(btn) btn.innerHTML = on ? '<i class="mdi mdi-white-balance-sunny"></i>' : '<i class="mdi mdi-weather-night"></i>';
    localStorage.setItem(DARK_KEY, on?'1':'0');
  }
  window.sToggleDark = ()=> applyDark(!document.body.classList.contains('s-dark'));
  document.addEventListener('DOMContentLoaded', ()=>{
    applyDark(localStorage.getItem(DARK_KEY)==='1');
  });

  // ===== Busca global (Ctrl/Cmd + K) =====
  const bd=document.getElementById('s-search-backdrop');
  const inp=document.getElementById('s-search-input');
  const res=document.getElementById('s-search-results');
  const items=()=> Array.from(res.querySelectorAll('a'));
  let idx=-1;
  function open(){ bd.classList.add('show'); setTimeout(()=>inp.focus(),50); }
  function close(){ bd.classList.remove('show'); inp.value=''; filter(''); idx=-1; }
  function filter(q){
    q=q.trim().toLowerCase();
    items().forEach(a=>{
      const m=!q || a.textContent.toLowerCase().includes(q);
      a.style.display=m?'flex':'none';
    });
    res.querySelectorAll('.s-sr-group').forEach(g=>g.style.display=q?'none':'block');
  }
  function move(d){
    const vis=items().filter(a=>a.style.display!=='none');
    if(!vis.length) return;
    idx=(idx+d+vis.length)%vis.length;
    vis.forEach((a,i)=>a.classList.toggle('active',i===idx));
    vis[idx].scrollIntoView({block:'nearest'});
  }
  window.sOpenSearch=open;
  document.addEventListener('keydown',e=>{
    if((e.ctrlKey||e.metaKey)&&e.key.toLowerCase()==='k'){e.preventDefault();open();return;}
    if(!bd.classList.contains('show'))return;
    if(e.key==='Escape')close();
    else if(e.key==='ArrowDown'){e.preventDefault();move(1);}
    else if(e.key==='ArrowUp'){e.preventDefault();move(-1);}
    else if(e.key==='Enter'){
      const vis=items().filter(a=>a.style.display!=='none');
      if(vis[idx]) vis[idx].click();
    }
  });
  bd && bd.addEventListener('click',e=>{ if(e.target===bd) close(); });
  inp && inp.addEventListener('input',e=>{ idx=-1; filter(e.target.value); });

  // ===== Confirmação padronizada (substitui confirm() e ações de exclusão) =====
  window.sConfirm = function(opts){
    opts=opts||{};
    return Swal.fire({
      title: opts.title || 'Tem certeza?',
      html: opts.text || 'Esta ação não pode ser desfeita.',
      icon: opts.icon || 'warning',
      showCancelButton: true,
      confirmButtonText: opts.confirm || 'Sim, confirmar',
      cancelButtonText: opts.cancel || 'Cancelar',
      reverseButtons: true,
      customClass:{ popup: 's-swal'+(opts.icon==='info'?' s-swal-info':'') },
      buttonsStyling: true,
    });
  };

  // Intercepta window.confirm para usar SweetAlert em formulários de exclusão
  // (mantém comportamento síncrono usando preventDefault + reenvio do form)
  document.addEventListener('submit', function(e){
    const f=e.target;
    const oc=f.getAttribute('onsubmit')||'';
    if(/confirm\s*\(/i.test(oc) && !f.dataset.sConfirmed){
      e.preventDefault();
      const msg=(oc.match(/confirm\(\s*['"`]([^'"`]+)/)||[])[1] || 'Tem certeza que deseja excluir este registro?';
      sConfirm({ title:'Confirmar ação', text: msg, confirm:'Sim, excluir' }).then(r=>{
        if(r.isConfirmed){ f.dataset.sConfirmed='1'; f.removeAttribute('onsubmit'); f.submit(); }
      });
    }
  }, true);

  document.addEventListener('click', function(e){
    const a=e.target.closest('a[onclick*="confirm("], button[onclick*="confirm("]');
    if(!a || a.dataset.sConfirmed) return;
    const oc=a.getAttribute('onclick')||'';
    e.preventDefault(); e.stopPropagation();
    const msg=(oc.match(/confirm\(\s*['"`]([^'"`]+)/)||[])[1] || 'Confirmar esta ação?';
    sConfirm({ title:'Confirmar ação', text: msg, confirm:'Sim, continuar' }).then(r=>{
      if(r.isConfirmed){
        a.dataset.sConfirmed='1'; a.removeAttribute('onclick');
        if(a.tagName==='A' && a.href){ window.location.href=a.href; }
        else { a.click(); }
      }
    });
  }, true);

  // ===== Empty states automáticos em tabelas vazias =====
  document.addEventListener('DOMContentLoaded', ()=>{
    document.querySelectorAll('.s-page table').forEach(t=>{
      const tb=t.querySelector('tbody'); if(!tb) return;
      const rows=tb.querySelectorAll('tr');
      const hasData = Array.from(rows).some(r=>r.children.length>1 || (r.children.length===1 && !r.children[0].hasAttribute('colspan')));
      if(rows.length===0 || (rows.length===1 && rows[0].querySelector('td[colspan]') && !rows[0].textContent.trim())){
        const cols=t.querySelectorAll('thead th').length || 1;
        tb.innerHTML=`<tr><td colspan="${cols}" style="padding:0;border:0;">
          <div class="s-empty">
            <div class="s-empty-icon"><i class="mdi mdi-inbox-outline"></i></div>
            <h3>Nenhum registro encontrado</h3>
            <p>Quando houver dados aqui, eles aparecerão automaticamente. Tente ajustar os filtros ou cadastrar um novo registro.</p>
          </div>
        </td></tr>`;
      }
    });
  });
})();
</script>
