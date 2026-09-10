<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>XSeven Presensi</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f0f2f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
.card { background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); width: 100%; max-width: 400px; text-align: center; }
.card h1 { font-size: 1.5rem; margin-bottom: 0.25rem; }
.card .sub { color: #666; margin-bottom: 1.5rem; font-size: 0.9rem; }
.logo { display: block; margin: 0 auto 16px; height: 72px; width: auto; }
form { text-align: left; }
label { font-weight: 600; font-size: 0.85rem; display: block; margin-bottom: 4px; }
input[type=text], input[type=password] { width: 100%; padding: 10px 12px; border: 1px solid #d0d5dd; border-radius: 8px; font-size: 1rem; margin-bottom: 1rem; }
button.btn { width: 100%; padding: 12px; border: none; border-radius: 8px; background: #2563eb; color: #fff; font-size: 1rem; cursor: pointer; }
button.btn:hover { background: #1d4ed8; }
.error { background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem; }
</style>
</head>
<body>
 <div class="card">
    <img src="/plugins/xseven/presensi/assets/images/xp-logo.webp" alt="XSeven" class="logo">
    <h1>XSeven Presensi</h1>
    <p class="sub">Masuk dengan akun pegawai</p>
    @php $errs = session('errors'); @endphp
    @if ($errs && $errs->any())
        <div class="error">{{ $errs->first() }}</div>
    @endif
    <form method="POST" action="/presensi/login">
        {{ csrf_field() }}
        <label>Email / Username</label>
        <input type="text" name="login" required autofocus>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn">Masuk</button>
    </form>
</div>
</body>
</html>
