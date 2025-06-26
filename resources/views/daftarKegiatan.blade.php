@extends('layouts.app')

@section('title', 'Daftar Kegiatan')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Dash Board</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($kegiatans as $kegiatan)
                <div class="bg-white text-black p-4 rounded-lg shadow-lg">
                    <img src="{{ $kegiatan['image'] }}" alt="{{ $kegiatan['title'] }}" class="w-full h-32 object-cover rounded-t-lg">
                    <div class="p-2">
                        <h3 class="text-lg font-semibold">{{ $kegiatan['title'] }}</h3>
                        <p class="text-sm text-gray-600">peserta {{ $kegiatan['participants'] }}</p>
                        <button class="mt-2 bg-green-400 hover:bg-green-500 text-white font-bold py-1 px-2 rounded text-sm">Ikuti Kegiatan</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection