@extends('layouts.app')

@section('title', 'Penerimaan Kegiatan')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Penerimaan Kegiatan</h1>

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
                                    <form action="{{ route('admin.updateStatus', $kegiatan->kegiatan_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="Status" class="p-1 border rounded mr-2">
                                            <option value="approved">Approve</option>
                                            <option value="rejected">Reject</option>
                                        </select>
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection