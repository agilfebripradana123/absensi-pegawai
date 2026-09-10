<?php namespace XSeven\Presensi\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Illuminate\Support\Facades\Response;
use XSeven\Presensi\Models\Presensi as PresensiModel;

class Presensi extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
    ];

    public $listConfig = 'config_list.yaml';
    public $requiredPermissions = ['xseven.presensi.view_presensi'];
    protected $publicActions = ['viewPhoto'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('XSeven.Presensi', 'presensi', 'presensi');
    }

    public function viewPhoto()
    {
        $id = input('id');
        $type = input('type');
        $record = PresensiModel::findOrFail($id);
        $field = $type === 'pulang' ? 'foto_pulang' : 'foto_masuk';
        $path = storage_path('app/' . $record->$field);

        if (!$record->$field || !file_exists($path)) {
            return Response::make('Foto tidak ditemukan', 404);
        }

        $mime = mime_content_type($path) ?: 'image/jpeg';
        return Response::file($path, ['Content-Type' => $mime]);
    }
}
