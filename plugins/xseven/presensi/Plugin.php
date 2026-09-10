<?php namespace XSeven\Presensi;

use Backend\Facades\Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Presensi',
            'description' => 'Sistem presensi pegawai dengan kamera browser.',
            'author'      => 'XSeven',
            'icon'        => 'icon-clock',
            'homepage'    => 'https://xseven.id',
        ];
    }

    public function registerPermissions()
    {
        return [
            'xseven.presensi.manage_pegawai' => [
                'tab'   => 'Presensi',
                'label' => 'Kelola pegawai',
            ],
            'xseven.presensi.view_presensi' => [
                'tab'   => 'Presensi',
                'label' => 'Lihat presensi',
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'presensi' => [
                'label'       => 'Presensi',
                'url'         => Backend::url('xseven/presensi/dashboard'),
                'icon'        => 'icon-clock',
                'permissions' => ['xseven.presensi.*'],
                'order'       => 500,
                'sideMenu'    => [
                    'dashboard' => [
                        'label'       => 'Dashboard',
                        'icon'        => 'icon-dashboard',
                        'url'         => Backend::url('xseven/presensi/dashboard'),
                        'permissions' => ['xseven.presensi.view_presensi'],
                    ],
                    'pegawai' => [
                        'label'       => 'Data Pegawai',
                        'icon'        => 'icon-users',
                        'url'         => Backend::url('xseven/presensi/pegawai'),
                        'permissions' => ['xseven.presensi.manage_pegawai'],
                    ],
                    'presensi' => [
                        'label'       => 'Data Presensi',
                        'icon'        => 'icon-calendar-check',
                        'url'         => Backend::url('xseven/presensi/presensi'),
                        'permissions' => ['xseven.presensi.view_presensi'],
                    ],
                ],
            ],
        ];
    }


}
