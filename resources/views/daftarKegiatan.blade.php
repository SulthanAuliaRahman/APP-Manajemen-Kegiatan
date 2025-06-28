@extends('layouts.app')

@section('title', 'Daftar Kegiatan')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Daftar Kegiatan</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($kegiatans as $kegiatan)
                <div class="bg-white text-black rounded-lg shadow-lg overflow-hidden">
                    @if($kegiatan->gambar_kegiatan)
                        <div class="w-full h-32 overflow-hidden relative group">
                            <img src="{{ asset($kegiatan->gambar_kegiatan) }}" 
                                 alt="{{ $kegiatan->judul }}" 
                                 class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-70">
                            
                            <!-- Overlay for description - only appears on image hover -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <p class="text-white text-sm p-2 text-center">{{ $kegiatan->deskripsi }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Content section - not affected by image hover -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $kegiatan->judul }}</h3>
                        
                        @if(!$kegiatan->gambar_kegiatan)
                            <p class="text-sm text-gray-600 mb-2">{{ $kegiatan->deskripsi }}</p>
                        @endif
                        
                        <p class="text-sm text-gray-600 mb-3">
                            Peserta: {{ $kegiatan->getTotalPesertaAttribute() }}/{{ $kegiatan->kuota }}
                        </p>
                        
                        <!-- Button hanya muncul untuk mahasiswa yang sudah login -->
                        @if(session()->has('user_id') && session('role') === 'mahasiswa')
                            @php
                                $existingRegistration = \App\Models\UsersKegiatan::where('user_id', session('user_id'))
                                    ->where('kegiatan_id', $kegiatan->kegiatan_id)
                                    ->first();
                            @endphp
                            
                            @if($existingRegistration)
                                <button class="w-full bg-gray-400 text-white font-bold py-2 px-4 rounded text-sm cursor-not-allowed" disabled>
                                    Sudah Terdaftar
                                </button>
                            @elseif($kegiatan->isKuotaPenuh())
                                <button class="w-full bg-red-400 text-white font-bold py-2 px-4 rounded text-sm cursor-not-allowed" disabled>
                                    Kuota Penuh
                                </button>
                            @else
                                <form action="{{ route('kegiatan.register', $kegiatan->kegiatan_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded text-sm transition-colors duration-200">
                                        Ikuti Kegiatan
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection