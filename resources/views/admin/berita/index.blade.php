@section('title', content: 'Admin - Artikel')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Artikel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                    {{-- Tombol Tambah Data --}}
                    <div class="mb-4">
                        <a href="{{ route('admin.berita.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Tambah Artikel Baru') }}
                        </a>
                    </div>

                    {{-- Notifikasi Sukses --}}
                    @if (session('success'))
                        <div
                            class="mb-4 p-4 bg-green-100 dark:bg-green-800 border border-green-200 dark:border-green-600 text-green-700 dark:text-green-200 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel Artikel --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Foto</th>
                                    <th scope="col" class="px-6 py-3">Nama Artikel</th>
                                    <th scope="col" class="px-6 py-3">Jenis</th>
                                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($beritas as $berita)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">
                                            <img src="{{ Storage::url($berita->foto) }}"
                                                alt="{{ $berita->nama_berita }}" class="w-20 h-16 object-cover rounded">
                                        </td>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $berita->nama_berita }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $berita->jenis }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($berita->deskripsi), 50, '...') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($berita->tanggal)->isoFormat('D MMMM YYYY') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end items-center space-x-4">

                                                {{-- Tombol Lihat Detail dengan Modal --}}
                                                <div x-data="{ open: false }">
                                                    <button @click="open = true"
                                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Lihat</button>

                                                    <div x-show="open" @click.away="open = false"
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
                                                        style="display: none;">
                                                        <div
                                                            class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 max-w-2xl w-full mx-4">
                                                            <div
                                                                class="flex justify-between items-center border-b dark:border-gray-700 pb-3 mb-4">
                                                                <h3
                                                                    class="text-lg font-bold text-gray-900 dark:text-white">
                                                                    {{ $berita->nama_berita }}</h3>
                                                                <button @click="open = false"
                                                                    class="text-gray-500 hover:text-gray-700 dark:hover:text-white text-2xl">&times;</button>
                                                            </div>
                                                            <div class="space-y-4 text-left">
                                                                <img src="{{ Storage::url($berita->foto) }}"
                                                                    alt="{{ $berita->nama_berita }}"
                                                                    class="w-full h-64 object-cover rounded-md mb-4">
                                                                <p
                                                                    class="text-gray-600 dark:text-gray-300 whitespace-pre-wrap">
                                                                    {!! $berita->deskripsi !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="{{ route('admin.berita.edit', $berita) }}"
                                                    class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline">Edit</a>

                                                <div x-data="{ open: false }">
                                                    <button @click="open = true"
                                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>

                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div x-show="open" @click.away="open = false"
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                                        style="display: none;">
                                                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6">
                                                            <h3
                                                                class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                                                                Konfirmasi Hapus</h3>
                                                            <p class="text-gray-600 dark:text-gray-400 mb-6">Apakah Anda
                                                                yakin ingin menghapus berita
                                                                "{{ $berita->nama_berita }}"?</p>
                                                            <div class="flex justify-end space-x-4">
                                                                <button @click="open = false"
                                                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-md text-gray-800 dark:text-gray-200 hover:bg-gray-400">Batal</button>
                                                                <form
                                                                    action="{{ route('admin.berita.destroy', $berita) }}"
                                                                    method="POST" class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                            Artikel yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-4">
                        {{ $beritas->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
