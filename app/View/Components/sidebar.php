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
            'name' => session('name', 'Guest'),
            'email' => session('email', ''),
            'role' => session('role', 'mahasiswa')
        ];

        // Set menu items berdasarkan role
        $this->menuItems = $this->getMenuItems($this->user['role']);
    }

    private function getMenuItems($role)
    {
        $menus = [
            'Mahasiswa' => [
                [
                    'title' => 'Daftar Kegiatan',
                    'route' => 'daftarKegiatan',
                    'icon' => 'calendar'
                ]
            ],
            'Dosen' => [
                [
                    'title' => 'Daftar Kegiatan',
                    'route' => 'daftarKegiatan',
                    'icon' => 'calendar'
                ],
                [
                    'title' => 'Approve Kegiatan',
                    'route' => 'approveKegiatan',
                    'icon' => 'check-circle'
                ]
            ],
            'Himpunan' => [
                [
                    'title' => 'Daftar Kegiatan',
                    'route' => 'daftarKegiatan',
                    'icon' => 'calendar'
                ],
                [
                    'title' => 'Buat Kegiatan',
                    'route' => 'buatKegiatan',
                    'icon' => 'plus-circle'
                ]
            ],
            'Admin' => [
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
                    'title' => 'Approve Kegiatan',
                    'route' => 'approveKegiatan',
                    'icon' => 'check-circle'
                ],
                [
                    'title' => 'Buat User',
                    'route' => 'buatUser',
                    'icon' => 'user-cog'
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