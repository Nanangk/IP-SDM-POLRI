@extends('layouts.app')

@section('title', 'IP SDM Polri')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Daftar Personel</h2>
                <p class="text-slate-500 mt-1">
                    Kelola data personel, penilaian personel, dan Nilai IP Personel.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pegawai.export', request()->query()) }}"
                    class="bg-slate-700 text-white px-4 py-2 rounded-lg hover:bg-slate-800 text-sm font-medium">
                    Export Excel
                </a>
                <a href="{{ route('pegawai.import.form') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm font-medium">
                    Import Excel
                </a>

                <a href="{{ route('pegawai.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                    + Tambah Pegawai
                </a>
            </div>
        </div>

       <form action="{{ route('pegawai.index') }}" method="GET"
            class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 mb-6">

            <div class="mb-4">
                <h3 class="font-semibold text-slate-900">Pencarian dan Filter</h3>
                <p class="text-sm text-slate-500">Cari berdasarkan nama, NRP, pangkat, jabatan, atau satuan kerja.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-7 gap-3">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder='Contoh: Nama, NRP atau carikan personel yang nilai erohani semester 1 nya 0'
                    class="border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 md:col-span-3">

                <select name="pangkat"
                    class="border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Pangkat</option>
                    @foreach ($listPangkat as $itemPangkat)
                        <option value="{{ $itemPangkat }}" {{ ($pangkat ?? '') == $itemPangkat ? 'selected' : '' }}>
                            {{ $itemPangkat }}
                        </option>
                    @endforeach
                </select>

                <select name="jabatan"
                    class="border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Jabatan</option>
                    @foreach ($listJabatan as $itemJabatan)
                        <option value="{{ $itemJabatan }}" {{ ($jabatan ?? '') == $itemJabatan ? 'selected' : '' }}>
                            {{ $itemJabatan }}
                        </option>
                    @endforeach
                </select>

                <select name="satuan_kerja"
                    class="border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Satker</option>
                    @foreach ($listSatuanKerja as $itemSatuanKerja)
                        <option value="{{ $itemSatuanKerja }}" {{ ($satuanKerja ?? '') == $itemSatuanKerja ? 'selected' : '' }}>
                            {{ $itemSatuanKerja }}
                        </option>
                    @endforeach
                </select>

                <select name="status_nilai"
                    class="border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Status Nilai</option>
                    <option value="lengkap" {{ ($statusNilai ?? '') == 'lengkap' ? 'selected' : '' }}>
                        Sudah Lengkap
                    </option>
                    <option value="belum_lengkap" {{ ($statusNilai ?? '') == 'belum_lengkap' ? 'selected' : '' }}>
                        Belum Lengkap
                    </option>
                </select>
            </div>

            <div class="flex gap-2 mt-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                    Terapkan Filter
                </button>

                <a href="{{ route('pegawai.index') }}"
                    class="bg-slate-200 text-slate-700 px-5 py-2 rounded-lg hover:bg-slate-300 text-sm font-medium">
                    Reset
                </a>
            </div>
        </form>

        @if (($statusNilai ?? '') == 'belum_lengkap')
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                Menampilkan personel yang masih memiliki nilai kosong atau 0.
                Ditemukan <strong>{{ $pegawai->total() }}</strong> personel.
            </div>
        @endif

        @if (($statusNilai ?? '') == 'lengkap')
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                Menampilkan personel yang seluruh komponen nilainya sudah terisi.
                Ditemukan <strong>{{ $pegawai->total() }}</strong> personel.
            </div>
        @endif

        @if (!empty($promptSearch))
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg text-sm">
                <div>
                    Sistem memahami pencarian:
                    <strong>{{ $promptSearch['field'] }}</strong>
                    {{ $promptSearch['operator'] }}
                    <strong>{{ $promptSearch['value'] }}</strong>
                </div>

                <div class="mt-1">
                    Ditemukan <strong>{{ $pegawai->total() }}</strong> personel.
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">No</th>
                        <th class="border px-4 py-2 text-left">Foto</th>
                        <th class="border px-4 py-2 text-left">Nama</th>
                        <th class="border px-4 py-2 text-left">NRP</th>
                        <th class="border px-4 py-2 text-left">Pangkat</th>
                        <th class="border px-4 py-2 text-left">Jabatan</th>
                        <th class="border px-4 py-2 text-left">Satuan Kerja</th>
                        <th class="border px-4 py-2 text-left">Kinerja Smtr 1</th>
                        <th class="border px-4 py-2 text-left">Kinerja Smtr 2</th>
                        <th class="border px-4 py-2 text-left">Disiplin</th>
                        <th class="border px-4 py-2 text-left">Rohani Smtr 1</th>
                        <th class="border px-4 py-2 text-left">Rohani Smtr 2</th>
                        <th class="border px-4 py-2 text-left">E-Mental Smtr 1</th>
                        <th class="border px-4 py-2 text-left">E-Mental Smtr 2</th>
                        <th class="border px-4 py-2 text-left">Kesehatan</th>
                        <th class="border px-4 py-2 text-left">Jasmani Smtr 1</th>
                        <th class="border px-4 py-2 text-left">Jasmani Smtr 2</th>
                        <th class="border px-4 py-2 text-left">Akademik</th>
                        <th class="border px-4 py-2 text-left">Nilai IP</th>
                        <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Kategori</th>
                        <th class="border px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawai as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $pegawai->firstItem() + $index }}</td>
                            <td class="border px-4 py-2">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Pegawai"
                                        class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <span class="text-gray-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $item->nama }}</td>
                            <td class="border px-4 py-2">{{ $item->nrp }}</td>
                            <td class="border px-4 py-2">{{ $item->pangkat }}</td>
                            <td class="border px-4 py-2">{{ $item->jabatan }}</td>
                            <td class="border px-4 py-2">{{ $item->satuan_kerja }}</td>
                            <td class="border px-4 py-2">{{ $item->kinerja_semester_1 ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->kinerja_semester_2 ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->disiplin ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->rohani_semester_1 ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->rohani_semester_2 ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->emental_semester_1 ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->emental_semester_2 ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->kesehatan ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->jasmani_semester_1 ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->jasmani_semester_2 ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $item->akademik ?? '-' }}</td>
                            <td class="border px-4 py-2 font-semibold">
                                {{ $item->nilai_ip_personel ?? '-' }}
                            </td>
                            <td class="px-4 py-3 border-b border-slate-100">
                                @if ($item->kategori_ip == 'SANGAT BAIK')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                        {{ $item->kategori_ip }}
                                    </span>
                                @elseif ($item->kategori_ip == 'BAIK')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                        {{ $item->kategori_ip }}
                                    </span>
                                @elseif ($item->kategori_ip == 'CUKUP')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                        {{ $item->kategori_ip }}
                                    </span>
                                @elseif ($item->kategori_ip == 'KURANG')
                                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                        {{ $item->kategori_ip }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                        {{ $item->kategori_ip }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('pegawai.show', $item->id) }}"
                                        title="Detail"
                                        class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('pegawai.edit', $item->id) }}"
                                        title="Edit"
                                        class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-yellow-50 text-yellow-700 hover:bg-yellow-100 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <button type="button"
                                        title="Hapus"
                                        onclick="openDeleteModal('{{ route('pegawai.destroy', $item->id) }}')"
                                        class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-50 text-red-700 hover:bg-red-100 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="19" class="border px-4 py-6 text-center text-gray-500">
                                Data personel tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $pegawai->links() }}
            </div>
        </div>

    </div>

    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-2">Konfirmasi Hapus</h3>

            <p class="text-gray-600 mb-6">
                Apakah Anda yakin ingin menghapus data personel ini? Data yang sudah dihapus tidak dapat dikembalikan.
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-2">
                    <button type="button"
                        onclick="closeDeleteModal()"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>

                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(actionUrl) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');

            form.action = actionUrl;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

@endsection
