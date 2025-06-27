@extends('layouts.app')

@section('title', 'Manage Kegiatan')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Manage Kegiatan</h1>

        <button id="createKegiatanBtn" class="mb-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors">
            Buat Kegiatan
        </button>

        <div class="bg-white text-black rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-full">
                    <thead>
                        <tr class="bg-indigo-200 border-b">
                            <th class="p-4 text-center w-20">Judul</th>
                            <th class="p-4">Created By</th>
                            <th class="p-4">Kuota</th>
                            <th class="p-4 text-center w-32">Status</th>
                            <th class="p-4 text-center w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatans as $kegiatan)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="p-4">{{ $kegiatan->Judul }}</td>
                                <td class="p-4">{{ $kegiatan->creator->name }}</td>
                                <td class="p-4">{{ $kegiatan->usersKegiatans->count() }}/{{ $kegiatan->Kuota }}</td>
                                <td class="p-4 text-center">{{ ucfirst($kegiatan->Status) }}</td>
                                <td class="p-4 text-center">
                                    @if($kegiatan->Status !== 'approved')
                                        <button class="editKegiatanBtn bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded mr-2" 
                                                data-kegiatan-id="{{ $kegiatan->kegiatan_id }}"
                                                data-judul="{{ $kegiatan->Judul }}"
                                                data-deskripsi="{{ $kegiatan->deskripsi }}"
                                                data-kuota="{{ $kegiatan->Kuota }}">Edit</button>
                                        <form action="{{ route('kegiatan.destroy', $kegiatan->kegiatan_id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="createKegiatanModal" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md text-black">
                <h2 class="text-2xl font-bold mb-4">Buat Kegiatan</h2>
                <form id="createKegiatanForm" action="{{ route('buatKegiatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="createJudul" class="block text-sm font-medium">Judul</label>
                        <input type="text" id="createJudul" name="Judul" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="createDeskripsi" class="block text-sm font-medium">Deskripsi</label>
                        <textarea id="createDeskripsi" name="deskripsi" class="w-full p-2 border rounded" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="createGambar" class="block text-sm font-medium">Gambar Kegiatan</label>
                        <input type="file" id="createGambar" name="gambar_kegiatan" class="w-full p-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label for="createKuota" class="block text-sm font-medium">Kuota</label>
                        <input type="number" id="createKuota" name="Kuota" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelCreateBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="editKegiatanModal" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md text-black">
                <h2 class="text-2xl font-bold mb-4">Edit Kegiatan</h2>
                <form id="editKegiatanForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editKegiatanId" name="kegiatan_id">
                    <div class="mb-4">
                        <label for="editJudul" class="block text-sm font-medium">Judul</label>
                        <input type="text" id="editJudul" name="Judul" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="editDeskripsi" class="block text-sm font-medium">Deskripsi</label>
                        <textarea id="editDeskripsi" name="deskripsi" class="w-full p-2 border rounded" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="editGambar" class="block text-sm font-medium">Gambar Kegiatan</label>
                        <input type="file" id="editGambar" name="gambar_kegiatan" class="w-full p-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label for="editKuota" class="block text-sm font-medium">Kuota</label>
                        <input type="number" id="editKuota" name="Kuota" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelEditBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/manageKegiatan.js') }}"></script>
    @endpush
@endsection