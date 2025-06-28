@extends('layouts.app')

@section('title', 'Kegiatan Saya')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Kegiatan Saya</h1>

        <!-- Kegiatan Table -->
        <div class="bg-white text-black rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-full">
                    <thead>
                        <tr class="bg-indigo-200 border-b">
                            <th class="p-4 text-center">Judul</th>
                            <th class="p-4">Kuota</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatans as $kegiatan)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-center">{{ $kegiatan->judul }}</td>
                                <td class="p-4">{{ $kegiatan->kuota }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($kegiatan->status === 'menunggu') bg-yellow-100 text-yellow-800
                                        @elseif($kegiatan->status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($kegiatan->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    @if($kegiatan->status !== 'approved')
                                        <button class="editKegiatanBtn text-indigo-600 hover:text-indigo-800 p-2 rounded-full hover:bg-indigo-50 transition-colors"
                                                data-kegiatan-id="{{ $kegiatan->kegiatan_id }}"
                                                data-judul="{{ $kegiatan->judul }}"
                                                data-deskripsi="{{ $kegiatan->deskripsi }}"
                                                data-kuota="{{ $kegiatan->kuota }}"
                                                data-status="{{ $kegiatan->status }}"
                                                title="Edit Kegiatan">
                                            <ion-icon name="create-outline" class="text-xl"></ion-icon>
                                        </button>
                                    @else
                                        <span class="text-gray-400 p-2 rounded-full" title="Kegiatan yang sudah approved tidak dapat diedit">
                                            <ion-icon name="lock-closed-outline" class="text-xl"></ion-icon>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada kegiatan yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Kegiatan Modal -->
        <div id="editKegiatanModal" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md text-black">
                <h2 class="text-2xl font-bold mb-4">Edit Kegiatan</h2>
                <form id="editKegiatanForm">
                    <input type="hidden" id="editKegiatanId" name="kegiatan_id">
                    <div class="mb-4">
                        <label for="editJudul" class="block text-sm font-medium">Judul</label>
                        <input type="text" id="editJudul" name="judul" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="editDeskripsi" class="block text-sm font-medium">Deskripsi</label>
                        <textarea id="editDeskripsi" name="deskripsi" rows="4" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="editKuota" class="block text-sm font-medium">Kuota</label>
                        <input type="number" id="editKuota" name="kuota" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required min="1" max="1000">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelEditBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection