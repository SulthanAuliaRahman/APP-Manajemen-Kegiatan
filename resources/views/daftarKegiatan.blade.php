@extends('layouts.app')

@section('title', 'Daftar Kegiatan')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Daftar Kegiatan</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($kegiatans as $kegiatan)
                <div class="bg-white text-black p-4 rounded-lg shadow-lg relative group">
                    <div class="w-full h-32 overflow-hidden rounded-t-lg {{ !$kegiatan->gambar_kegiatan ? 'hidden' : '' }}">
                        <img src="{{ $kegiatan->gambar_kegiatan ? asset($kegiatan->gambar_kegiatan) : asset('images/placeholder.jpg') }}" alt="{{ $kegiatan->judul }}" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-70">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <p class="text-white text-sm p-2">{{ $kegiatan->deskripsi }}</p>
                        </div>
                    </div>
                    <div class="p-2">
                        <h3 class="text-lg font-semibold">{{ $kegiatan->judul }}</h3>
                        <p class="text-sm text-gray-600">Peserta: {{ $kegiatan->getTotalPesertaAttribute() }}/{{ $kegiatan->kuota }}</p>
                        @if(session()->has('user_id') && session('role') === 'mahasiswa')
                            <form action="{{ route('kegiatan.register', $kegiatan->kegiatan_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="mt-2 bg-green-400 hover:bg-green-500 text-white font-bold py-1 px-2 rounded text-sm" {{ $kegiatan->isKuotaPenuh() ? 'disabled' : '' }}>{{ $kegiatan->isKuotaPenuh() ? 'Kuota Penuh' : 'Ikuti Kegiatan' }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection