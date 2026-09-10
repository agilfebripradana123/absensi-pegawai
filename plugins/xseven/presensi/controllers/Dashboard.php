<?php namespace XSeven\Presensi\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use XSeven\Presensi\Models\Pegawai;
use XSeven\Presensi\Models\Presensi;

class Dashboard extends Controller
{
    public $requiredPermissions = ['xseven.presensi.view_presensi'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('XSeven.Presensi', 'presensi', 'dashboard');
    }

    public function index()
    {
        $this->pageTitle = 'Dashboard Presensi';
        $this->vars['totalPegawai'] = Pegawai::count();
        $this->vars['aktifPegawai'] = Pegawai::where('status', 1)->count();
        $this->vars['presensiHariIni'] = Presensi::where('tanggal', date('Y-m-d'))->count();
        $this->vars['presensiTerbaru'] = Presensi::with('pegawai')->orderBy('created_at', 'desc')->limit(10)->get();
    }
}
