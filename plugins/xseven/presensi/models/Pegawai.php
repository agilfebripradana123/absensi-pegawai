<?php namespace XSeven\Presensi\Models;

use Model;

class Pegawai extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    public $table = 'xseven_presensi_pegawai';

    public $fillable = ['user_id', 'nama', 'jabatan', 'departemen', 'status'];

    public $rules = [
        'nama' => 'required|string|max:255',
    ];

    public $belongsTo = [
        'user' => ['Backend\Models\User'],
    ];

    public $hasMany = [
        'presensis' => ['XSeven\Presensi\Models\Presensi'],
    ];

    public function getStatusOptions()
    {
        return [1 => 'Aktif', 0 => 'Tidak Aktif'];
    }
}
