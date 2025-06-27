@extends('layouts.app')

@section('title', 'Buat Kegiatan')

@section('content')
    <div class="p-6 bg-indigo-900 min-h-screen">
        <h1 class="text-4xl font-bold mb-6 text-white">Buat Kegiatan</h1>

        <div class="bg-white text-black rounded-lg shadow-lg p-6 max-w-4xl">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('buatKegiatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Judul Kegiatan -->
                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="judul" 
                        name="judul" 
                        value="{{ old('judul') }}" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('judul') border-red-500 @enderror" 
                        required
                        maxlength="255"
                        placeholder="Masukkan judul kegiatan..."
                    >
                    @error('judul')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="deskripsi" 
                        name="deskripsi" 
                        rows="5"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror" 
                        required
                        maxlength="1000"
                        placeholder="Masukkan deskripsi kegiatan..."
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    <div class="text-sm text-gray-500 mt-1">
                        <span id="char-count">0</span>/1000 karakter
                    </div>
                </div>

                <!-- Gambar Kegiatan -->
                <div>
                    <label for="gambar_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Kegiatan
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="gambar_kegiatan" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500">
                                    <span>Upload gambar</span>
                                    <input 
                                        id="gambar_kegiatan" 
                                        name="gambar_kegiatan" 
                                        type="file" 
                                        class="sr-only @error('gambar_kegiatan') border-red-500 @enderror"
                                        accept="image/jpeg,image/png,image/jpg,image/gif"
                                        onchange="previewImage(this)"
                                    >
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                        </div>
                    </div>
                    @error('gambar_kegiatan')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    
                    <!-- Preview Gambar -->
                    <div id="image-preview" class="mt-4 hidden">
                        <img id="preview-img" src="" alt="Preview" class="h-48 w-full object-cover rounded-lg">
                        <button type="button" onclick="removeImage()" class="mt-2 text-red-600 hover:text-red-800 text-sm">
                            Hapus gambar
                        </button>
                    </div>
                </div>

                <!-- Kuota -->
                <div>
                    <label for="kuota" class="block text-sm font-medium text-gray-700 mb-2">
                        Kuota Peserta <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="kuota" 
                        name="kuota" 
                        value="{{ old('kuota') }}" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kuota') border-red-500 @enderror" 
                        required 
                        min="1" 
                        max="1000"
                        placeholder="Masukkan jumlah kuota peserta..."
                    >
                    @error('kuota')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    <div class="text-sm text-gray-500 mt-1">
                        Minimal 1 peserta, maksimal 1000 peserta
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('kegiatanSaya') }}" 
                       class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors font-medium">
                        Buat Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Character count untuk deskripsi
        document.getElementById('deskripsi').addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('char-count').textContent = charCount;
            
            if (charCount > 1000) {
                document.getElementById('char-count').style.color = 'red';
            } else {
                document.getElementById('char-count').style.color = '#6b7280';
            }
        });

        // Preview gambar
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Hapus gambar
        function removeImage() {
            document.getElementById('gambar_kegiatan').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        }
    </script>
@endsection