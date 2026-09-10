<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide-static@latest/font/lucide.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<title>XSeven Presensi</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:linear-gradient(135deg,#f0f4ff 0%,#e8ecf4 50%,#f5f0ff 100%);min-height:100vh;display:flex;flex-direction:column}
.nav{background:linear-gradient(135deg,#1e3a5f 0%,#2563eb 100%);padding:16px 24px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 4px 20px rgba(37,99,235,.25)}
.nav strong{color:#fff;font-size:1.1rem;letter-spacing:.5px}
.nav a{color:rgba(255,255,255,.85);text-decoration:none;font-weight:500;font-size:.9rem;transition:color .2s}
.nav a:hover{color:#fff}
.menu{display:flex;justify-content:center;gap:8px;padding:12px 16px;background:transparent;flex-wrap:wrap}
.menu-link{display:inline-flex;align-items:center;gap:6px;padding:10px 24px;border-radius:30px;color:#475569;text-decoration:none;font-weight:600;font-size:.875rem;transition:all .2s;border:1.5px solid transparent}
.menu-link:hover{background:#eff6ff;color:#2563eb;border-color:#bfdbfe}
.menu-link.active{background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;border-color:#2563eb;box-shadow:0 4px 16px rgba(37,99,235,.3)}
.menu-link svg{width:16px;height:16px}
.container{max-width:960px;width:100%;margin:0 auto;padding:0 16px 32px}
.card{background:#fff;padding:28px;border-radius:20px;box-shadow:0 4px 32px rgba(0,0,0,.06),0 1px 4px rgba(0,0,0,.04);margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;transition:box-shadow .3s}
.card:hover{box-shadow:0 8px 40px rgba(0,0,0,.1),0 2px 8px rgba(0,0,0,.06)}
.card-table{display:block;padding:0;overflow:hidden}
.info-section{flex:1;display:flex;align-items:flex-start;gap:16px}
.avatar{width:56px;height:56px;border-radius:16px;background:transparent;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.25rem;flex-shrink:0;box-shadow:0 4px 12px rgba(37,99,235,.3)}
.info-content{flex:1}
.card h2{font-size:1.3rem;margin-bottom:4px;color:#1e293b;font-weight:700}
.card .info{color:#64748b;font-size:.875rem;margin-bottom:6px}
.action-section{flex-shrink:0;margin-left:24px}
.action-section .btn{width:auto;min-width:220px;margin-top:0}
.status-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;font-weight:600;font-size:.8rem;margin:10px 0}
.work-time{display:flex;gap:8px;flex-wrap:wrap;margin:8px 0}
.work-pill{display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:20px;font-weight:600;font-size:.8rem;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0}
.work-pill-masuk{border-color:#bfdbfe;color:#1e40af;background:#eff6ff}
.work-pill-pulang{border-color:#a7f3d0;color:#065f46;background:#ecfdf5}
.status-badge::before{content:'';width:8px;height:8px;border-radius:50%;flex-shrink:0}
.status-belum{background:#fef3c7;color:#92400e}.status-belum::before{background:#f59e0b}
.status-masuk{background:#dbeafe;color:#1e40af}.status-masuk::before{background:#3b82f6}
.status-selesai{background:#d1fae5;color:#065f46}.status-selesai::before{background:#10b981}
.btn{display:inline-block;padding:16px 32px;border:none;border-radius:14px;font-size:1rem;font-weight:700;cursor:pointer;color:#fff;text-align:center;letter-spacing:.5px;transition:all .2s;box-shadow:0 4px 16px rgba(0,0,0,.15)}
.btn:active{transform:scale(.96);box-shadow:0 2px 8px rgba(0,0,0,.15)}
.btn-masuk{background:linear-gradient(135deg,#2563eb,#3b82f6)}.btn-masuk:hover{box-shadow:0 6px 24px rgba(37,99,235,.4);transform:translateY(-1px)}
.btn-pulang{background:linear-gradient(135deg,#059669,#10b981);animation:pulse 2s infinite}.btn-pulang:hover{box-shadow:0 6px 24px rgba(5,150,105,.4);transform:translateY(-1px);animation:none !important}
.btn:disabled{background:#cbd5e1;cursor:not-allowed;box-shadow:none;transform:none}
.clock{font-size:2.5rem;font-weight:800;background:linear-gradient(135deg,#1e3a5f,#2563eb);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;text-align:center;margin:12px 0;font-variant-numeric:tabular-nums;letter-spacing:2px}
#cameraModal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(15,23,42,.8);backdrop-filter:blur(4px);z-index:1000;align-items:center;justify-content:center}
#cameraModal.active{display:flex}
.cam-box{background:#fff;border-radius:20px;padding:24px;max-width:500px;width:90%;text-align:center;box-shadow:0 24px 48px rgba(0,0,0,.2)}
.cam-box h3{font-size:1.1rem;color:#1e293b;margin-bottom:4px}
.cam-box video,.cam-box canvas,.cam-box img{width:100%;border-radius:12px;margin:12px 0}
.cam-box canvas{display:none}
.cam-btns{display:flex;gap:8px;margin-top:12px}
.cam-btns button{flex:1;padding:12px;border:none;border-radius:10px;font-weight:600;cursor:pointer;font-size:.9rem;transition:opacity .2s}
.cam-btns button:hover{opacity:.9}
.cam-btns .capture{background:#2563eb;color:#fff}
.cam-btns .confirm{background:#059669;color:#fff}
.cam-btns .cancel{background:#ef4444;color:#fff}
.cam-btns .retake{background:#f59e0b;color:#fff}
.msg{padding:14px 16px;border-radius:12px;margin-bottom:16px;font-size:.9rem;display:none;font-weight:500;border-left:4px solid transparent}
.msg.error{background:#fef2f2;color:#991b1b;display:block;border-left-color:#ef4444}
.msg.success{background:#f0fdf4;color:#065f46;display:block;border-left-color:#10b981}
.table-header{padding:20px 24px;border-bottom:1px solid #f1f5f9}
.table-header h3{font-size:1.05rem;color:#1e293b;font-weight:700}
table{width:100%;min-width:600px;border-collapse:collapse;font-size:.85rem}
th,td{padding:12px 16px;text-align:left;border-bottom:1px solid #f1f5f9}
th{background:#f8fafc;color:#475569;font-weight:600;font-size:.8rem;text-transform:uppercase;letter-spacing:.5px}
tbody tr{transition:background .15s}
tbody tr:hover{background:#f8fafc}
.thumb{border-radius:6px!important;box-shadow:0 2px 8px rgba(0,0,0,.1);transition:transform .2s}
.thumb:hover{transform:scale(1.15)}
.badge{display:inline-block;padding:4px 12px;border-radius:12px;font-size:.75rem;font-weight:600}
.badge-hadir{background:#d1fae5;color:#065f46}
.badge-terlambat{background:#fee2e2;color:#991b1b}
.modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(15,23,42,.9);backdrop-filter:blur(8px);z-index:1000;align-items:center;justify-content:center}
.modal.active{display:flex}
.modal img{max-width:90%;max-height:90%;border-radius:12px;box-shadow:0 24px 48px rgba(0,0,0,.3)}
@keyframes pulse{0%{box-shadow:0 6px 24px rgba(5,150,105,.4)}50%{box-shadow:0 6px 36px rgba(5,150,105,.7)}100%{box-shadow:0 6px 24px rgba(5,150,105,.4)}}
@media(max-width:768px){
  .card{flex-direction:column;align-items:center;text-align:center}
  .info-section{flex-direction:column;align-items:center;text-align:center;width:100%}
  .info-content{width:100%;text-align:center}
  .avatar{margin:0 auto}
  .card h2,.card .info,.clock{text-align:center}
  .work-time{justify-content:center}
  .action-section{margin-left:0;margin-top:16px;width:100%;text-align:center}
  .action-section .btn{width:100%;min-width:0;text-align:center}
  .card-table{text-align:left}
  .card-table .table-header h3{text-align:center}
}
@media(max-width:640px){
  .nav{padding:12px 16px}
  .menu-link{padding:8px 18px;font-size:.8rem}
  .clock{font-size:2rem}
}
@media(max-width:480px){
  .container{padding:0 12px}
  .card{padding:16px}
  .clock{font-size:1.8rem}
  .btn{padding:12px 20px;font-size:.9rem}
  .menu-link{padding:10px 16px;font-size:.85rem}
}
</style>
</head>
<body>
<div class="nav">
    <a href="/presensi/dashboard" style="display:flex;align-items:center;gap:10px;text-decoration:none"><img src="/plugins/xseven/presensi/assets/images/xp-logo.webp" alt="XSeven" style="height:32px;width:auto;border-radius:8px"><strong>XSeven Presensi</strong></a>
    <a href="/presensi/logout">Logout</a>
</div>
<div class="menu">
    <a href="/presensi/dashboard" class="menu-link {{ ($activePage ?? '') === 'dashboard' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Dashboard
    </a>
    <a href="/presensi/riwayat" class="menu-link {{ ($activePage ?? '') === 'riwayat' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Riwayat
    </a>
</div>