@section('title', content: 'Admin - Artikel')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Artikel Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                    {{-- Menampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600 dark:text-red-400">
                                {{ __('Whoops! Something went wrong.') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Nama Artikel -->
                            <div>
                                <x-label for="nama_berita" value="{{ __('Nama Artikel') }}" />
                                <x-input id="nama_berita" class="block mt-1 w-full" type="text" name="nama_berita"
                                    :value="old('nama_berita')" required autofocus placeholder="Masukkan Nama Artikel" />
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <x-label for="tanggal" value="{{ __('Tanggal') }}" />
                                <x-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="old('tanggal')" required placeholder="Masukkan Tanggal" />
                            </div>

                            <!-- Jenis -->
                            <div>
                                <x-label for="jenis" value="{{ __('Jenis Artikel') }}" />
                                <select name="jenis" id="jenis"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option disabled selected>Pilih Jenis Artikel</option>
                                    <option value="Berita Desa"
                                        {{ old('jenis', $berita->jenis ?? '') == 'Berita Desa' ? 'selected' : '' }}>
                                        Berita Desa</option>
                                    <option value="Pengumuman Desa"
                                        {{ old('jenis', $berita->jenis ?? '') == 'Pengumuman Desa' ? 'selected' : '' }}>
                                        Pengumuman Desa</option>
                                    <option value="Pembangunan Desa"
                                        {{ old('jenis', $berita->jenis ?? '') == 'Pembangunan Desa' ? 'selected' : '' }}>
                                        Pembangunan Desa</option>
                                    <option value="Kegiatan Desa"
                                        {{ old('jenis', $berita->jenis ?? '') == 'Kegiatan Desa' ? 'selected' : '' }}>
                                        Kegiatan Desa</option>
                                </select>
                            </div>

                            <!-- Deskripsi CKEditor 5 -->
                            <div>
                                <x-label for="deskripsi" value="{{ __('Deskripsi') }}" />
                                <textarea id="deskripsi" name="deskripsi" rows="10" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi') }}</textarea>
                            </div>

                            <!-- Masukkan Foto -->
                            <div>
                                <x-label for="foto" value="{{ __('Masukkan Foto (Maks 2MB)') }}" />
                                <input id="foto"
                                    class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                    type="file" name="foto" required>
                                <img id="preview-foto" class="mt-4 h-40 object-cover rounded-md" style="display: none;">
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('admin.berita.index') }}"
                                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white underline mr-4">
                                    Batal
                                </a>
                                <x-button>
                                    {{ __('Simpan Artikel') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Flatpickr -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!-- CKEditor 5 -->
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                flatpickr("#tanggal", {
                    dateFormat: "Y-m-d",
                    allowInput: true
                });

                ClassicEditor
                    .create(document.querySelector('#deskripsi'))
                    .catch(error => console.error(error));

                const fotoInput = document.getElementById('foto');
                const previewFoto = document.getElementById('preview-foto');

                if (fotoInput) {
                    fotoInput.addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function (evt) {
                                previewFoto.src = evt.target.result;
                                previewFoto.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        } else {
                            previewFoto.style.display = 'none';
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
