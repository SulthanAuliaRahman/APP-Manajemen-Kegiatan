<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sidebar extends Component
{
    public $user;
    public $menuItems;

    public function __construct()
    {
        // Ambil data user dari session
        $this->user = [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role')
        ];

        // Set menu items berdasarkan role
        $this->menuItems = $this->getMenuItems($this->user['role']);
    }

    private function getMenuItems($role)
    {
        $menus = [
            'mahasiswa' => [
                [
                    'title' => 'Daftar Kegiatan',
                    'route' => 'daftarKegiatan',
                    'icon' => 'calendar'
                ],
                [
                    'title' => 'Daftar User',
                    'route' => 'daftarUser',
                    'icon' => 'users'
                ]
            ],
            'admin' => [
                [
                    'title' => 'Daftar Kegiatan',
                    'route' => 'daftarKegiatan',
                    'icon' => 'calendar'
                ],
                [
                    'title' => 'Manage Kegiatan',
                    'route' => 'manageKegiatan',
                    'icon' => 'settings'
                ],
                [
                    'title' => 'Manage User',
                    'route' => 'manageUser',
                    'icon' => 'user-cog'
                ],
                [
                    'title' => 'Approve/Unapprove Kegiatan',
                    'route' => 'approveKegiatan',
                    'icon' => 'check-circle'
                ]
            ],
            'dosen' => [
                [
                    'title' => 'Daftar Kegiatan',
                    'route' => 'daftarKegiatan',
                    'icon' => 'calendar'
                ],
                [
                    'title' => 'Kelola Kegiatan',
                    'route' => 'kelolaKegiatan',
                    'icon' => 'edit'
                ],
                [
                    'title' => 'Laporan Mahasiswa',
                    'route' => 'laporanMahasiswa',
                    'icon' => 'file-text'
                ]
            ],
            'himpunan' => [
                [
                    'title' => 'Daftar Kegiatan',
                    'route' => 'daftarKegiatan',
                    'icon' => 'calendar'
                ],
                [
                    'title' => 'Buat Kegiatan',
                    'route' => 'buatKegiatan',
                    'icon' => 'plus-circle'
                ],
                [
                    'title' => 'Kegiatan Saya',
                    'route' => 'kegiatanSaya',
                    'icon' => 'list'
                ],
                [
                    'title' => 'Anggota Himpunan',
                    'route' => 'anggotaHimpunan',
                    'icon' => 'users'
                ]
            ]
        ];

        return $menus[$role] ?? $menus['mahasiswa'];
    }

    public function render()
    {
        return view('components.sidebar');
    }
}
