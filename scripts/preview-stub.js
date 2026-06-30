#!/usr/bin/env node
/**
 * Lovable sandbox dev-server stub.
 * The real app is Laravel (PHP) and runs on Hostinger.
 * This stub only exists so the sandbox health-check on port 8080 succeeds.
 * It accepts --port <n> (passed by the harness), serves a friendly status page,
 * and exposes /public/* assets if present.
 */
const http = require('http');
const fs = require('fs');
const path = require('path');

const args = process.argv.slice(2);
let port = 8080;
for (let i = 0; i < args.length; i++) {
    if ((args[i] === '--port' || args[i] === '-p') && args[i + 1]) {
        port = parseInt(args[i + 1], 10) || 8080;
    } else if (args[i].startsWith('--port=')) {
        port = parseInt(args[i].split('=')[1], 10) || 8080;
    }
}

const PUBLIC_DIR = path.join(__dirname, '..', 'public');
const MIME = {
    '.html':'text/html; charset=utf-8','.css':'text/css; charset=utf-8',
    '.js':'application/javascript; charset=utf-8','.json':'application/json',
    '.png':'image/png','.jpg':'image/jpeg','.jpeg':'image/jpeg','.gif':'image/gif',
    '.svg':'image/svg+xml','.ico':'image/x-icon','.woff':'font/woff','.woff2':'font/woff2',
    '.ttf':'font/ttf','.eot':'application/vnd.ms-fontobject','.map':'application/json',
};

const STATUS_HTML = `<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><title>SISLAC — Preview</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;background:linear-gradient(135deg,#4338ca,#4f46e5 45%,#8b5cf6);min-height:100vh;display:grid;place-items:center;color:#fff;padding:24px}
.card{max-width:560px;background:rgba(255,255,255,.1);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.2);border-radius:24px;padding:40px;text-align:center;box-shadow:0 30px 60px -20px rgba(0,0,0,.4)}
.logo{width:64px;height:64px;border-radius:18px;background:rgba(255,255,255,.18);display:grid;place-items:center;margin:0 auto 20px;font-size:28px;font-weight:800}
h1{font-size:1.6rem;font-weight:800;margin-bottom:10px;letter-spacing:-.01em}
p{opacity:.85;line-height:1.6;font-size:.95rem;margin-bottom:8px}
.tag{display:inline-block;margin-top:16px;padding:6px 14px;background:rgba(255,255,255,.15);border-radius:999px;font-size:.78rem;font-weight:600;letter-spacing:.05em}
code{background:rgba(0,0,0,.25);padding:2px 8px;border-radius:6px;font-size:.85em}
</style></head>
<body><div class="card">
<div class="logo">S</div>
<h1>Sistema Laboratorial</h1>
<p>Este é um projeto <strong>Laravel (PHP)</strong>. O preview real roda no Hostinger.</p>
<p>O sandbox da Lovable usa este stub apenas para validação de porta. Os arquivos Blade em <code>resources/views</code> são editados normalmente.</p>
<span class="tag">PREVIEW SANDBOX OK</span>
</div></body></html>`;

const server = http.createServer((req, res) => {
    try {
        const url = decodeURIComponent((req.url || '/').split('?')[0]);
        if (url === '/' || url === '/index.html') {
            res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
            return res.end(STATUS_HTML);
        }
        if (url === '/health' || url === '/healthz') {
            res.writeHead(200, { 'Content-Type': 'text/plain' });
            return res.end('ok');
        }
        // Serve from /public if file exists
        const safe = path.normalize(url).replace(/^([\/\\])+/, '');
        const filePath = path.join(PUBLIC_DIR, safe);
        if (filePath.startsWith(PUBLIC_DIR) && fs.existsSync(filePath) && fs.statSync(filePath).isFile()) {
            const ext = path.extname(filePath).toLowerCase();
            res.writeHead(200, { 'Content-Type': MIME[ext] || 'application/octet-stream' });
            return fs.createReadStream(filePath).pipe(res);
        }
        res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
        res.end(STATUS_HTML);
    } catch (e) {
        res.writeHead(500, { 'Content-Type': 'text/plain' });
        res.end('error: ' + e.message);
    }
});

server.listen(port, '0.0.0.0', () => {
    console.log(`[sislac-preview-stub] listening on http://0.0.0.0:${port}`);
});

['SIGINT','SIGTERM'].forEach(s => process.on(s, () => { server.close(()=>process.exit(0)); }));
