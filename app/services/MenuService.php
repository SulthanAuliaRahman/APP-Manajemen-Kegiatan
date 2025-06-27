<?php

namespace App\Services;

class MenuService
{
    public static function getMenuItems($role)
    {
        $menuItems = [
            'mahasiswa' => [
                ['title' => 'Daftar Kegiatan', 'route' => 'daftarKegiatan', 'icon' => 'calendar'],
            ],
            'admin' => [
                ['title' => 'Daftar Kegiatan', 'route' => 'daftarKegiatan', 'icon' => 'calendar'],
                ['title' => 'Manage User', 'route' => 'manageUser', 'icon' => 'user-cog'],
                ['title' => 'Approve/Unapprove Kegiatan', 'route' => 'approveKegiatan', 'icon' => 'check-circle'],
            ],
            'dosen' => [
                ['title' => 'Daftar Kegiatan', 'route' => 'daftarKegiatan', 'icon' => 'calendar'],
                ['title' => 'Approve Kegiatan', 'route' => 'approveKegiatan', 'icon' => 'check-circle'],
            ],
            'himpunan' => [
                ['title' => 'Daftar Kegiatan', 'route' => 'daftarKegiatan', 'icon' => 'calendar'],
                ['title' => 'Buat Kegiatan', 'route' => 'buatKegiatan', 'icon' => 'plus-circle'],
                ['title' => 'Kegiatan Saya', 'route' => 'kegiatanSaya', 'icon' => 'list'],
            ],
        ];

        return $menuItems[$role] ?? $menuItems['mahasiswa'];
    }
}