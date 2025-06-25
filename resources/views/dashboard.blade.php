@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-4xl font-bold mb-6">Dash Board</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Activity Item 1 -->
            <div class="bg-white text-black p-4 rounded-lg shadow-lg">
                <img src="https://via.placeholder.com/200x150" alt="Activity" class="w-full h-32 object-cover rounded-t-lg">
                <div class="p-2">
                    <h3 class="text-lg font-semibold">Mencari Sampah</h3>
                    <p class="text-sm text-gray-600">peserta 32/150</p>
                    <button class="mt-2 bg-green-400 hover:bg-green-500 text-white font-bold py-1 px-2 rounded text-sm">Ikuti Kegiatan</button>
                </div>
            </div>

            <!-- Activity Item 2 -->
            <div class="bg-white text-black p-4 rounded-lg shadow-lg">
                <img src="https://via.placeholder.com/200x150" alt="Activity" class="w-full h-32 object-cover rounded-t-lg">
                <div class="p-2">
                    <h3 class="text-lg font-semibold">Kerjasma Menyampah</h3>
                    <p class="text-sm text-gray-600">peserta 32/150</p>
                    <button class="mt-2 bg-green-400 hover:bg-green-500 text-white font-bold py-1 px-2 rounded text-sm">Ikuti Kegiatan</button>
                </div>
            </div>

            <!-- Activity Item 3 -->
            <div class="bg-white text-black p-4 rounded-lg shadow-lg">
                <img src="https://via.placeholder.com/200x150" alt="Activity" class="w-full h-32 object-cover rounded-t-lg">
                <div class="p-2">
                    <h3 class="text-lg font-semibold">Example Activity</h3>
                    <p class="text-sm text-gray-600">peserta 32/150</p>
                    <button class="mt-2 bg-green-400 hover:bg-green-500 text-white font-bold py-1 px-2 rounded text-sm">Ikuti Kegiatan</button>
                </div>
            </div>
        </div>
    </div>
@endsection