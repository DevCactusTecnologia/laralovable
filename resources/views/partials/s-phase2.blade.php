{{-- SISLAC Phase 2: Exportações padronizadas, notificações em tempo (quase) real, SLA mini-widget --}}
<style>
/* ===== Export toolbar ===== */
.s-export-bar{display:inline-flex;gap:6px;margin:0 0 10px;flex-wrap:wrap;}
.s-export-bar .s-exp{
    display:inline-flex;align-items:center;gap:6px;
    padding:6px 12px;border-radius:10px;border:1px solid #e5e7eb;
    background:#fff;color:#0f172a;font-size:12.5px;font-weight:600;
    cursor:pointer;transition:all .18s ease;
}
.s-export-bar .s-exp:hover{border-color:#4f46e5;color:#4f46e5;transform:translateY(-1px);}
.s-export-bar .s-exp i{font-size:16px;}
body.s-dark .s-export-bar .s-exp{background:#172046;border-color:#2a3358;color:#e5e7eb;}
body.s-dark .s-export-bar .s-exp:hover{border-color:#a5b4fc;color:#a5b4fc;}

/* ===== Realtime notification toast ===== */
.s-rt-toast{
    position:fixed;right:24px;bottom:24px;z-index:1090;
    max-width:360px;background:#fff;border-radius:14px;
    box-shadow:0 20px 50px -12px rgba(15,23,42,.35);
    border:1px solid #eceff5;padding:14px 16px;
    display:flex;gap:12px;align-items:flex-start;
    transform:translateY(20px);opacity:0;pointer-events:none;
    transition:all .35s cubic-bezier(.2,.9,.3,1.2);
}
.s-rt-toast.show{transform:none;opacity:1;pointer-events:auto;}
.s-rt-toast .s-rt-ic{
    width:38px;height:38px;border-radius:12px;flex:0 0 38px;
    background:linear-gradient(135deg,#eef2ff,#f5f3ff);color:#4f46e5;
    display:grid;place-items:center;font-size:20px;
}
.s-rt-toast strong{display:block;font-size:13px;color:#0f172a;}
.s-rt-toast small{font-size:11.5px;color:#64748b;}
body.s-dark .s-rt-toast{background:#111733;border-color:#1f2745;}
body.s-dark .s-rt-toast strong{color:#e5e7eb;}

/* ===== SLA mini widget ===== */
.s-sla-strip{
    display:flex;gap:10px;flex-wrap:wrap;
    padding:12px 14px;border-radius:14px;
    background:linear-gradient(135deg,#eef2ff 0%,#faf5ff 100%);
    border:1px solid #e0e7ff;margin-bottom:18px;
}
body.s-dark .s-sla-strip{background:linear-gradient(135deg,#172046,#1f1633);border-color:#2a3358;}
.s-sla-pill{
    display:inline-flex;align-items:center;gap:8px;
    padding:6px 12px;border-radius:999px;background:#fff;
    font-size:12px;font-weight:600;color:#0f172a;
    box-shadow:0 1px 2px rgba(15,23,42,.04);
}
body.s-dark .s-sla-pill{background:#0f1530;color:#e5e7eb;}
.s-sla-pill .s-dot{width:8px;height:8px;border-radius:50%;}
.s-sla-pill.ok .s-dot{background:#10b981;}
.s-sla-pill.warn .s-dot{background:#f59e0b;}
.s-sla-pill.crit .s-dot{background:#ef4444;}
.s-sla-pill.info .s-dot{background:#4f46e5;}
</style>

<script>
(function(){
'use strict';
document.addEventListener('DOMContentLoaded', function(){

    /* ============================================================
     *  1) EXPORTAÇÕES PADRONIZADAS (CSV, Excel, Imprimir)
     *  Anexa automaticamente em tabelas dentro de .s-page que não
     *  sejam DataTables (estes têm seus próprios botões).
     * ============================================================ */
    function tableToMatrix(table){
        const rows = [];
        table.querySelectorAll('tr').forEach(tr => {
            const cells = [];
            tr.querySelectorAll('th,td').forEach(td => {
                // Ignora colunas "Ações" se contiverem botões
                const isActions = td.querySelector('.s-icon-btn, .btn, button, a.btn');
                if (isActions && td.cellIndex === tr.cells.length - 1) {
                    cells.push('');
                    return;
                }
                cells.push((td.innerText || td.textContent || '').replace(/\s+/g,' ').trim());
            });
            if (cells.some(c => c.length)) rows.push(cells);
        });
        return rows;
    }
    function downloadFile(filename, content, mime){
        const blob = new Blob(["\ufeff" + content], {type: mime + ';charset=utf-8;'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = filename; document.body.appendChild(a);
        a.click(); a.remove(); setTimeout(() => URL.revokeObjectURL(url), 400);
    }
    function exportCSV(table, name){
        const sep = ';';
        const csv = tableToMatrix(table).map(r => r.map(c => '"' + c.replace(/"/g,'""') + '"').join(sep)).join('\n');
        downloadFile(name + '.csv', csv, 'text/csv');
    }
    function exportExcel(table, name){
        // .xls compatível: HTML reconhecido pelo Excel
        const html = '<html><head><meta charset="UTF-8"></head><body>' + table.outerHTML + '</body></html>';
        downloadFile(name + '.xls', html, 'application/vnd.ms-excel');
    }
    function printTable(table, title){
        const w = window.open('', '_blank', 'width=1000,height=700');
        if (!w) return;
        w.document.write(`<html><head><title>${title}</title>
            <style>
                body{font-family:-apple-system,Inter,system-ui,sans-serif;color:#0f172a;padding:20px;}
                h2{font-size:18px;margin:0 0 14px;color:#4f46e5;}
                table{width:100%;border-collapse:collapse;font-size:12px;}
                th,td{padding:8px 10px;border-bottom:1px solid #e5e7eb;text-align:left;}
                th{background:#f8fafc;font-weight:700;text-transform:uppercase;font-size:10.5px;letter-spacing:.05em;color:#64748b;}
                tr:nth-child(even) td{background:#fafbff;}
                @media print{body{padding:0;}}
            </style></head><body>
            <h2>${title}</h2>${table.outerHTML}
            <script>window.onload=function(){window.print();}<\/script>
            </body></html>`);
        w.document.close();
    }

    function attachExportBar(table){
        if (table.closest('.dataTables_wrapper')) return;        // pula DataTables
        if (table.dataset.sExportAttached) return;
        if (table.rows.length < 2) return;
        table.dataset.sExportAttached = '1';

        const name = (document.querySelector('h4.card-title, h4.mb-sm-0, .breadcrumb-item.active')?.innerText
                    || document.title || 'tabela').replace(/\s+/g,'_').toLowerCase().slice(0, 40);

        const bar = document.createElement('div');
        bar.className = 's-export-bar';
        bar.innerHTML = `
            <button type="button" class="s-exp" data-act="csv" title="Exportar CSV"><i class="mdi mdi-file-delimited-outline"></i>CSV</button>
            <button type="button" class="s-exp" data-act="xls" title="Exportar Excel"><i class="mdi mdi-microsoft-excel"></i>Excel</button>
            <button type="button" class="s-exp" data-act="print" title="Imprimir"><i class="mdi mdi-printer-outline"></i>Imprimir</button>
        `;
        // insere logo antes da tabela ou do wrapper responsivo
        const anchor = table.closest('.table-responsive') || table;
        anchor.parentNode.insertBefore(bar, anchor);

        bar.addEventListener('click', function(e){
            const btn = e.target.closest('.s-exp'); if (!btn) return;
            const act = btn.dataset.act;
            const title = document.title.split('|')[0].trim() || 'Relatório';
            if (act === 'csv') exportCSV(table, name);
            else if (act === 'xls') exportExcel(table, name);
            else if (act === 'print') printTable(table, title);
        });
    }
    document.querySelectorAll('.s-page table.table').forEach(attachExportBar);

    /* ============================================================
     *  2) NOTIFICAÇÕES EM (QUASE) TEMPO REAL via polling
     * ============================================================ */
    const countUrl = (document.querySelector('meta[name="base-url"]')?.content
                    || window.location.origin) + '/notification-count';
    let lastCount = null;

    function showRtToast(msg){
        let el = document.querySelector('.s-rt-toast');
        if (!el) {
            el = document.createElement('div');
            el.className = 's-rt-toast';
            el.innerHTML = `<div class="s-rt-ic"><i class="mdi mdi-bell-ring-outline"></i></div>
                <div><strong>Nova notificação</strong><small></small></div>`;
            document.body.appendChild(el);
        }
        el.querySelector('small').textContent = msg;
        el.classList.add('show');
        clearTimeout(el._t);
        el._t = setTimeout(() => el.classList.remove('show'), 5000);
        el.onclick = () => { window.location.href = '/notification-list'; };
    }

    async function pollNotifications(){
        try {
            const r = await fetch(countUrl, {headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}, credentials:'same-origin'});
            if (!r.ok) return;
            const data = await r.json().catch(() => null);
            const count = (data && (data.count ?? data.total ?? data.unread)) ?? 0;

            // atualiza badge no topbar se existir
            const badge = document.querySelector('.noti-icon .badge, #page-header-notifications-dropdown .badge');
            if (badge) {
                badge.textContent = count > 0 ? count : '';
                badge.style.display = count > 0 ? '' : 'none';
            }

            if (lastCount !== null && count > lastCount) {
                showRtToast((count - lastCount) + ' nova(s) atualização(ões) recebida(s).');
            }
            lastCount = count;
        } catch(_){ /* offline silencioso */ }
    }
    if (document.querySelector('.noti-icon, #page-header-notifications-dropdown')) {
        pollNotifications();
        setInterval(pollNotifications, 30000);
    }

    /* ============================================================
     *  3) SLA MINI WIDGET na dashboard
     *  Lê os cards do "Fluxo Operacional" e gera tira-resumo no topo.
     * ============================================================ */
    function buildSlaStrip(){
        const flow = document.querySelector('.sislac-dashboard');
        if (!flow || document.querySelector('.s-sla-strip')) return;

        // tenta extrair os 4 números do bloco de fluxo
        const blocks = flow.querySelectorAll('[data-flow], .s-flow-card, .s-card .s-stat');
        const nums = Array.from(flow.querySelectorAll('h3, .s-stat-value, .s-flow-value'))
                          .map(n => parseInt((n.textContent || '').replace(/\D/g,''), 10))
                          .filter(n => !isNaN(n));
        if (nums.length < 4) return;
        const [coletados, analise, disponiveis, liberados] = nums;
        const pend = analise + disponiveis;
        const slaPct = (coletados + liberados) > 0
            ? Math.round((liberados / (coletados + liberados)) * 100) : 0;

        const strip = document.createElement('div');
        strip.className = 's-sla-strip';
        strip.innerHTML = `
            <span class="s-sla-pill ${slaPct >= 80 ? 'ok' : slaPct >= 50 ? 'warn' : 'crit'}">
                <span class="s-dot"></span> SLA do dia: <b>${slaPct}%</b> liberados
            </span>
            <span class="s-sla-pill info"><span class="s-dot"></span> Em análise: <b>${analise||0}</b></span>
            <span class="s-sla-pill ${pend > 20 ? 'warn' : 'info'}"><span class="s-dot"></span> Pendências: <b>${pend||0}</b></span>
            <span class="s-sla-pill ok"><span class="s-dot"></span> Liberados hoje: <b>${liberados||0}</b></span>
        `;
        const header = flow.querySelector('.s-page-header');
        if (header && header.nextSibling) flow.insertBefore(strip, header.nextSibling);
        else flow.prepend(strip);
    }
    buildSlaStrip();

});
})();
</script>
