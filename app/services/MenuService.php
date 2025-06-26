<?php

namespace App\Services;

class MenuService
{
    public static function getMenuItems($role)
    {
        $menuItems = [
            'mahasiswa' => [
                ['title' => 'Daftar Kegiatan', 'route' => 'daftarKegiatan', 'icon' => 'calendar'],
                ['title' => 'Daftar User', 'route' => 'daftarUser', 'icon' => 'users'],
            ],
            'admin' => [
                ['title' => 'Daftar Kegiatan', 'route' => 'daftarKegiatan', 'icon' => 'calendar'],
                ['title' => 'Manage Kegiatan', 'route' => 'manageKegiatan', 'icon' => 'settings'],
                ['title' => 'Manage User', 'route' => 'manageUser', 'icon' => 'user-cog'],
                ['title' => 'Approve/Unapprove Kegiatan', 'route' => 'approveKegiatan', 'icon' => 'check-circle'],
            ],
            'dosen' => [
                ['title' => 'Daftar Kegiatan', 'route' => 'daftarKegiatan', 'icon' => 'calendar'],
                ['title' => 'Kelola Kegiatan', 'route' => 'kelolaKegiatan', 'icon' => 'edit'],
                ['title' => 'Laporan Mahasiswa', 'route' => 'laporanMahasiswa', 'icon' => 'file-text'],
            ],
            'himpunan' => [
                ['title' => 'Daftar Kegiatan', 'route' => 'daftarKegiatan', 'icon' => 'calendar'],
                ['title' => 'Buat Kegiatan', 'route' => 'buatKegiatan', 'icon' => 'plus-circle'],
                ['title' => 'Kegiatan Saya', 'route' => 'kegiatanSaya', 'icon' => 'list'],
                ['title' => 'Anggota Himpunan', 'route' => 'anggotaHimpunan', 'icon' => 'users'],
            ],
        ];

        return $menuItems[$role] ?? $menuItems['mahasiswa'];
    }
}