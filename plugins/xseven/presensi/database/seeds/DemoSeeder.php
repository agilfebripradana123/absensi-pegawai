<?php namespace XSeven\Presensi\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Backend\Models\User;
use XSeven\Presensi\Models\Pegawai;

class DemoSeeder extends Seeder
{
    public function run()
    {
        DB::table('xseven_presensi_presensi')->delete();
        DB::table('xseven_presensi_pegawai')->delete();
        DB::table('backend_users')->delete();

        $mkuser = function ($attrs) {
            $u = new User();
            $u->first_name = $attrs['first_name'];
            $u->last_name = $attrs['last_name'];
            $u->email = $attrs['email'];
            $u->login = $attrs['login'];
            $u->password = $attrs['password'];
            $u->password_confirmation = $attrs['password'];
            $u->is_activated = true;
            $u->save();
            return $u;
        };

        $adminUser = $mkuser([
            'first_name' => 'Admin',
            'last_name'  => 'Presensi',
            'email'      => 'admin@presensi.local',
            'login'      => 'admin',
            'password'   => 'admin123',
        ]);
        $adminUser->is_superuser = true;
        $adminUser->save();

        $pegawai1 = Pegawai::create([
            'user_id'    => $adminUser->id,
            'nama'       => 'Admin Utama',
            'jabatan'    => 'Admin',
            'departemen' => 'IT',
            'status'     => 1,
        ]);

        $user2 = $mkuser([
            'first_name' => 'Budi',
            'last_name'  => 'Santoso',
            'email'      => 'budi@presensi.local',
            'login'      => 'budi',
            'password'   => 'budi123',
        ]);
        Pegawai::create([
            'user_id'    => $user2->id,
            'nama'       => 'Budi Santoso',
            'jabatan'    => 'Developer',
            'departemen' => 'Engineering',
            'status'     => 1,
        ]);

        $user3 = $mkuser([
            'first_name' => 'Ani',
            'last_name'  => 'Putri',
            'email'      => 'ani@presensi.local',
            'login'      => 'ani',
            'password'   => 'ani123',
        ]);
        Pegawai::create([
            'user_id'    => $user3->id,
            'nama'       => 'Ani Putri',
            'jabatan'    => 'Designer',
            'departemen' => 'Design',
            'status'     => 1,
        ]);
    }
}
