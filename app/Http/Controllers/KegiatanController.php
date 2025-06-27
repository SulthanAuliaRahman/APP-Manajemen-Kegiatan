<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MenuService;
    
class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::check() ? [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'role' => Auth::user()->role,
        ] : [
            'name' => 'Guest',
            'email' => '',
            'role' => 'mahasiswa',
        ];

        $menuItems = MenuService::getMenuItems($user['role']);

        $kegiatan = [
            [
                'title' => 'Mencari Sampah',
                'image' => 'https://via.placeholder.com/200x150',
                'participants' => '32/150',
            ],
            [
                'title' => 'Kerjasma Menyampah',
                'image' => 'https://via.placeholder.com/200x150',
                'participants' => '32/150',
            ],
            [
                'title' => 'Example Activity',
                'image' => 'https://via.placeholder.com/200x150',
                'participants' => '32/150',
            ],
        ];

        return view('daftarKegiatan', compact('user', 'menuItems', 'kegiatan'));
    }
}
