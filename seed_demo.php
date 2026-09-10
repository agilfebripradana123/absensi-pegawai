<?php
require __DIR__ . '/bootstrap/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Backend\Models\User;
use XSeven\Presensi\Models\Pegawai;
use Illuminate\Support\Facades\DB;

DB::table('xseven_presensi_presensi')->delete();
DB::table('xseven_presensi_pegawai')->delete();
DB::table('backend_users')->delete();

$mk = function ($fn, $ln, $email, $login, $pw) {
    $u = new User();
    $u->first_name = $fn;
    $u->last_name = $ln;
    $u->email = $email;
    $u->login = $login;
    $u->password = $pw;
    $u->password_confirmation = $pw;
    $u->is_activated = true;
    $u->save();
    return $u;
};

$admin = $mk('Admin', 'Presensi', 'admin@presensi.local', 'admin', 'admin123');
$admin->is_superuser = true;
$admin->save();
Pegawai::create(['user_id' => $admin->id, 'nama' => 'Admin Utama', 'jabatan' => 'Admin', 'departemen' => 'IT', 'status' => 1]);

$budi = $mk('Budi', 'Santoso', 'budi@presensi.local', 'budi', 'budi123');
Pegawai::create(['user_id' => $budi->id, 'nama' => 'Budi Santoso', 'jabatan' => 'Developer', 'departemen' => 'Engineering', 'status' => 1]);

$ani = $mk('Ani', 'Putri', 'ani@presensi.local', 'ani', 'ani123');
Pegawai::create(['user_id' => $ani->id, 'nama' => 'Ani Putri', 'jabatan' => 'Designer', 'departemen' => 'Design', 'status' => 1]);

echo "Seed OK: admin/admin123, budi/budi123, ani/ani123\n";
