<?php namespace XSeven\Presensi\Models;

use Model;

class Presensi extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    public $table = 'xseven_presensi_presensi';

    public $fillable = ['pegawai_id', 'tanggal', 'jam_masuk', 'foto_masuk', 'jam_pulang', 'foto_pulang', 'status'];

    public $rules = [
        'pegawai_id' => 'required|exists:xseven_presensi_pegawai,id',
        'tanggal'    => 'required|date',
    ];

    public $belongsTo = [
        'pegawai' => ['XSeven\Presensi\Models\Pegawai'],
    ];
}
