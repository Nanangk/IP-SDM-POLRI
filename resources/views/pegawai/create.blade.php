@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Tambah Pegawai</h2>
            <p class="text-gray-600">Masukkan data pegawai baru.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-1 font-medium">NRP</label>
                <input type="text" name="nrp" value="{{ old('nrp') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-1 font-medium">Pangkat</label>
                <input type="text" name="pangkat" value="{{ old('pangkat') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-1 font-medium">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-1 font-medium">Satuan Kerja</label>
                <input type="text" name="satuan_kerja" value="{{ old('satuan_kerja') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div class="border-t pt-6 mt-6">
                <h3 class="text-xl font-bold mb-4">Penilaian Personel</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">Kinerja Semester 1</label>
                        <input type="number" step="0.01" min="0" max="100" name="kinerja_semester_1"
                            value="{{ old('kinerja_semester_1') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Kinerja Semester 2</label>
                        <input type="number" step="0.01" min="0" max="100" name="kinerja_semester_2"
                            value="{{ old('kinerja_semester_2') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Disiplin</label>
                        <input type="number" step="0.01" min="0" max="100" name="disiplin"
                            value="{{ old('disiplin') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Kesehatan</label>
                        <input type="number" step="0.01" min="0" max="100" name="kesehatan"
                            value="{{ old('kesehatan') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Rohani Semester 1</label>
                        <input type="number" step="0.01" min="0" max="100" name="rohani_semester_1"
                            value="{{ old('rohani_semester_1') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Rohani Semester 2</label>
                        <input type="number" step="0.01" min="0" max="100" name="rohani_semester_2"
                            value="{{ old('rohani_semester_2') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">E-Mental Semester 1</label>
                        <input type="number" step="0.01" min="0" max="100" name="emental_semester_1"
                            value="{{ old('emental_semester_1') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">E-Mental Semester 2</label>
                        <input type="number" step="0.01" min="0" max="100" name="emental_semester_2"
                            value="{{ old('emental_semester_2') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Jasmani Semester 1</label>
                        <input type="number" step="0.01" min="0" max="100" name="jasmani_semester_1"
                            value="{{ old('jasmani_semester_1') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Jasmani Semester 2</label>
                        <input type="number" step="0.01" min="0" max="100" name="jasmani_semester_2"
                            value="{{ old('jasmani_semester_2') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Akademik</label>
                        <input type="number" step="0.01" min="0" max="100" name="akademik"
                            value="{{ old('akademik') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <p class="text-sm text-gray-500 mt-3">
                    Nilai IP Personel akan dihitung otomatis oleh sistem setelah data disimpan.
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium">Foto</label>
                <input type="file" name="foto"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2 MB.</p>
            </div>

            <div class="flex gap-2 pt-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>

                <a href="{{ route('pegawai.index') }}"
                    class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
