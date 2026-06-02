@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold">IP SDM Personel</h2>
            <p class="text-gray-600">Detail Komponen IP SDM Personel.</p>
        </div>

        <div class="mb-6 flex items-center gap-4">
            @if ($pegawai->foto)
                <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai"
                    class="w-24 h-24 rounded-full object-cover border">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    Tidak ada
                </div>
            @endif

            <div>
                <h3 class="text-xl font-bold">{{ $pegawai->nama }}</h3>
                <p class="text-gray-600">{{ $pegawai->pangkat }} - {{ $pegawai->jabatan }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500">Nama</p>
                <p class="font-semibold">{{ $pegawai->nama }}</p>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500">NRP</p>
                <p class="font-semibold">{{ $pegawai->nrp }}</p>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500">Pangkat</p>
                <p class="font-semibold">{{ $pegawai->pangkat }}</p>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500">Jabatan</p>
                <p class="font-semibold">{{ $pegawai->jabatan }}</p>
            </div>

            <div class="border rounded-lg p-4 md:col-span-2">
                <p class="text-sm text-gray-500">Satuan Kerja</p>
                <p class="font-semibold">{{ $pegawai->satuan_kerja }}</p>
            </div>
        </div>

        <div class="mt-6 border-t pt-6">
            <h3 class="text-xl font-bold mb-4">Penilaian Personel</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Kinerja Semester 1</p>
                    <p class="font-semibold">{{ $pegawai->kinerja_semester_1 ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Kinerja Semester 2</p>
                    <p class="font-semibold">{{ $pegawai->kinerja_semester_2 ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Disiplin</p>
                    <p class="font-semibold">{{ $pegawai->disiplin ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Rohani Semester 1</p>
                    <p class="font-semibold">{{ $pegawai->rohani_semester_1 ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Rohani Semester 2</p>
                    <p class="font-semibold">{{ $pegawai->rohani_semester_2 ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">E-Mental Semester 1</p>
                    <p class="font-semibold">{{ $pegawai->emental_semester_1 ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">E-Mental Semester 2</p>
                    <p class="font-semibold">{{ $pegawai->emental_semester_2 ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Kesehatan</p>
                    <p class="font-semibold">{{ $pegawai->kesehatan ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Jasmani Semester 1</p>
                    <p class="font-semibold">{{ $pegawai->jasmani_semester_1 ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Jasmani Semester 2</p>
                    <p class="font-semibold">{{ $pegawai->jasmani_semester_2 ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Akademik</p>
                    <p class="font-semibold">{{ $pegawai->akademik ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4 bg-blue-50 border-blue-200">
                    <p class="text-sm text-gray-500">Nilai IP Personel</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $pegawai->nilai_ip_personel ?? '-' }}</p>
                </div>

                <div class="border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Kategori Nilai IP</p>

                    @if ($pegawai->kategori_ip == 'SANGAT BAIK')
                        <p class="mt-2">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-bold">
                                {{ $pegawai->kategori_ip }}
                            </span>
                        </p>
                    @elseif ($pegawai->kategori_ip == 'BAIK')
                        <p class="mt-2">
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-bold">
                                {{ $pegawai->kategori_ip }}
                            </span>
                        </p>
                    @elseif ($pegawai->kategori_ip == 'CUKUP')
                        <p class="mt-2">
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-bold">
                                {{ $pegawai->kategori_ip }}
                            </span>
                        </p>
                    @elseif ($pegawai->kategori_ip == 'KURANG')
                        <p class="mt-2">
                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-bold">
                                {{ $pegawai->kategori_ip }}
                            </span>
                        </p>
                    @else
                        <p class="mt-2">
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-bold">
                                {{ $pegawai->kategori_ip }}
                            </span>
                        </p>
                    @endif
                </div>
            </div>
</div>

        <div class="flex gap-2 mt-6">
            <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                Edit
            </a>

            <a href="{{ route('pegawai.index') }}"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </div>
@endsection
