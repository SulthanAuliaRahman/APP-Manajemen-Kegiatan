@extends('layouts.app')

@section('title', 'Manage Approvals')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Manage Approvals</h1>

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
                                    @if($kegiatan->status === 'menunggu')
                                        <button class="approveBtn text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-50 transition-colors"
                                                data-kegiatan-id="{{ $kegiatan->kegiatan_id }}"
                                                title="Approve Kegiatan">
                                            <ion-icon name="checkmark-outline" class="text-xl"></ion-icon>
                                        </button>
                                    @elseif($kegiatan->status === 'approved')
                                        <button class="unapproveBtn text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition-colors"
                                                data-kegiatan-id="{{ $kegiatan->kegiatan_id }}"
                                                title="Unapprove Kegiatan">
                                            <ion-icon name="close-outline" class="text-xl"></ion-icon>
                                        </button>
                                    @else
                                        <span class="text-gray-500">No actions available</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada kegiatan untuk ditinjau.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const approveButtons = document.querySelectorAll('.approveBtn');
                const unapproveButtons = document.querySelectorAll('.unapproveBtn');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                approveButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const kegiatanId = this.getAttribute('data-kegiatan-id');
                        if (confirm('Apakah Anda yakin ingin menyetujui kegiatan ini?')) {
                            fetch(`/kegiatan/approve/${kegiatanId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    });
                });

                unapproveButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const kegiatanId = this.getAttribute('data-kegiatan-id');
                        if (confirm('Apakah Anda yakin ingin membatalkan persetujuan kegiatan ini?')) {
                            fetch(`/kegiatan/unapprove/${kegiatanId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection