<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\Kegiatan;
use App\Models\UsersKegiatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $user = session()->has('user_id') ? [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role'),
        ] : [
            'name' => 'Guest',
            'email' => '',
            'role' => 'mahasiswa',
        ];

        $menuItems = MenuService::getMenuItems($user['role']);
        $kegiatans = Kegiatan::with('creator')
            ->where('status', 'approved')
            ->get();

        return view('daftarKegiatan', compact('user', 'menuItems', 'kegiatans'));
    }

    public function create()
    {
        $user = session()->has('user_id') ? [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role'),
            'user_id' => session('user_id'),
        ] : null;

        if (!$user) {
            Log::info('Unauthorized access to create method. User: Not logged in');
            abort(403, 'Unauthorized action.');
        }

        $menuItems = MenuService::getMenuItems($user['role']);
        return view('buatKegiatan', compact('user', 'menuItems'));
    }

    public function store(Request $request)
    {
        $user = session()->has('user_id') ? [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role'),
            'user_id' => session('user_id'),
        ] : null;

        if (!$user) {
            Log::info('Unauthorized access to store method. User: Not logged in');
            return redirect()->back()->with('error', 'Hanya himpunan yang dapat membuat kegiatan.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'gambar_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kuota' => 'required|integer|min:1|max:1000',
        ], [
            'judul.required' => 'Judul kegiatan wajib diisi.',
            'judul.max' => 'Judul kegiatan maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi kegiatan wajib diisi.',
            'deskripsi.max' => 'Deskripsi kegiatan maksimal 1000 karakter.',
            'gambar_kegiatan.image' => 'File harus berupa gambar.',
            'gambar_kegiatan.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'gambar_kegiatan.max' => 'Ukuran gambar maksimal 2MB.',
            'kuota.required' => 'Kuota peserta wajib diisi.',
            'kuota.integer' => 'Kuota harus berupa angka.',
            'kuota.min' => 'Kuota minimal 1 peserta.',
            'kuota.max' => 'Kuota maksimal 1000 peserta.',
        ]);

        try {
            $kegiatan = new Kegiatan();
            $kegiatan->kegiatan_id = Str::uuid();
            $kegiatan->judul = $request->judul;
            $kegiatan->deskripsi = $request->deskripsi;
            $kegiatan->kuota = $request->kuota;
            $kegiatan->status = 'menunggu';
            $kegiatan->created_by = $user['user_id'];

            if ($request->hasFile('gambar_kegiatan')) {
                $file = $request->file('gambar_kegiatan');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/kegiatan', $filename);
                $kegiatan->gambar_kegiatan = str_replace('public/', 'storage/', $path);
            }

            $kegiatan->save();

            return redirect()->route('kegiatanSaya')->with('success', 'Kegiatan berhasil dibuat dan menunggu persetujuan.');
        } catch (\Exception $e) {
            Log::error('Error creating kegiatan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal membuat kegiatan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function myActivities()
    {
        $user = session()->has('user_id') ? [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role'),
            'user_id' => session('user_id'),
        ] : null;

        if (!$user) {
            Log::info('Unauthorized access to myActivities method. User: Not logged in');
            abort(403, 'Unauthorized action.');
        }

        $menuItems = MenuService::getMenuItems($user['role']);
        $kegiatans = Kegiatan::where('created_by', $user['user_id'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kegiatanSaya', compact('user', 'menuItems', 'kegiatans'));
    }

    public function update(Request $request, $kegiatanId)
    {
        $user = session()->has('user_id') ? [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role'),
            'user_id' => session('user_id'),
        ] : null;

        if (!$user || $user['role'] !== 'himpunan') {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $kegiatan = Kegiatan::where('kegiatan_id', $kegiatanId)->where('created_by', $user['user_id'])->first();

        if (!$kegiatan) {
            return response()->json(['success' => false, 'message' => 'Kegiatan not found or not authorized.'], 404);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1|max:1000',
            'status' => 'required|in:menunggu,approved',
        ]);

        $kegiatan->update([
            'judul' => $request->judul,
            'kuota' => $request->kuota,
            'status' => $kegiatan->status === 'approved' ? 'approved' : $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Kegiatan updated successfully.']);
    }

    public function manageApprovals()
    {
        $user = session()->has('user_id') ? [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role'),
            'user_id' => session('user_id'),
        ] : null;

        if (!$user || !in_array($user['role'], ['dosen', 'admin'])) {
            Log::info('Unauthorized access to manageApprovals method. User: ' . ($user ? $user['email'] : 'Not logged in'));
            abort(403, 'Unauthorized action.');
        }

        $menuItems = MenuService::getMenuItems($user['role']);
        $kegiatans = Kegiatan::with('creator')->orderBy('created_at', 'desc')->get();

        return view('manageApprovals', compact('user', 'menuItems', 'kegiatans'));
    }

    public function approve(Request $request, $kegiatanId)
    {
        $user = session()->has('user_id') ? [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role'),
            'user_id' => session('user_id'),
        ] : null;

        if (!$user || !in_array($user['role'], ['dosen', 'admin'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $kegiatan = Kegiatan::find($kegiatanId);

        if (!$kegiatan) {
            return response()->json(['success' => false, 'message' => 'Kegiatan not found.'], 404);
        }

        $kegiatan->update(['status' => 'approved']);

        return response()->json(['success' => true, 'message' => 'Kegiatan approved successfully.']);
    }

    public function unapprove(Request $request, $kegiatanId)
    {
        $user = session()->has('user_id') ? [
            'name' => session('name'),
            'email' => session('email'),
            'role' => session('role'),
            'user_id' => session('user_id'),
        ] : null;

        if (!$user || !in_array($user['role'], ['dosen', 'admin'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $kegiatan = Kegiatan::find($kegiatanId);

        if (!$kegiatan) {
            return response()->json(['success' => false, 'message' => 'Kegiatan not found.'], 404);
        }

        $kegiatan->update(['status' => 'menunggu']);

        return response()->json(['success' => true, 'message' => 'Kegiatan unapproved successfully.']);
    }
}