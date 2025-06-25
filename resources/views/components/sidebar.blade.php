<div class="w-64 bg-white text-black p-4 rounded-r-lg shadow-lg flex flex-col justify-between h-full">
    <div>
        <h2 class="text-2xl font-bold mb-6">MahasiswaPage Kegiatan</h2>
        <div class="mb-4">
            <h3 class="text-xl font-semibold">Mahasiswa</h3>
        </div>
    </div>
    <form action="/logout" method="POST" class="mb-4">
        @csrf
        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Log out</button>
    </form>
</div>