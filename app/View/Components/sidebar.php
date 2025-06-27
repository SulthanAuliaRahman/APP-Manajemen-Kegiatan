<?php

namespace App\View\Components;

use App\Services\MenuService;
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
        $this->menuItems = MenuService::getMenuItems($this->user['role']);
    }


    public function render()
    {
        return view('components.sidebar');
    }
}