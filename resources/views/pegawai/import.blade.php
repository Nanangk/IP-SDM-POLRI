@extends('layouts.app')

@section('title', 'Import Data Pegawai')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Import Data Pegawai</h2>
            <p class="text-gray-600">Upload file Excel untuk menginput banyak data pegawai sekaligus.</p>
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

        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
            <p class="font-semibold mb-2">Format header Excel:</p>
            <p class="text-sm">
                nama, nrp, pangkat, jabatan, satuan_kerja, kinerja_semester_1,
                kinerja_semester_2, disiplin, rohani_semester_1, rohani_semester_2,
                emental_semester_1, emental_semester_2, kesehatan, jasmani_semester_1,
                jasmani_semester_2, akademik
            </p>
        </div>

        <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">File Excel</label>
                <input type="file" name="file"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                <p class="text-sm text-gray-500 mt-1">Format: xlsx, xls, csv. Maksimal 2 MB.</p>
            </div>

            <div class="flex gap-2 pt-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Import Data
                </button>

                <a href="{{ route('pegawai.index') }}"
                    class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
