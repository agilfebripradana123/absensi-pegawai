<?php namespace XSeven\Presensi\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use XSeven\Presensi\Models\Pegawai as PegawaiModel;
use Backend\Models\User;
use Hash;

class Pegawai extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $requiredPermissions = ['xseven.presensi.manage_pegawai'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('XSeven.Presensi', 'presensi', 'pegawai');
    }

    public function onToggleStatus()
    {
        $id = post('id');
        $pegawai = PegawaiModel::findOrFail($id);
        $pegawai->status = $pegawai->status ? 0 : 1;
        $pegawai->save();
        return $this->listRefresh();
    }

    public function formBeforeSave($model)
    {
        $data = post('Pegawai');
        if (!empty($data['password'])) {
            $user = new User();
            $user->email = $data['email'] ?? $model->user->email ?? strtolower(str_replace(' ', '', $data['nama'])) . '@presensi.local';
            $user->login = $data['username'] ?? strtolower(str_replace(' ', '', $data['nama']));
            $user->password = $data['password'];
            $user->password_confirmation = $data['password'];
            $user->first_name = $data['nama'];
            $user->is_activated = true;
            $user->save();
            $model->user_id = $user->id;
        }
    }
}
