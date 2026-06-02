@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-slate-900">Dashboard</h2>
        <p class="text-slate-500 mt-1">
            Ringkasan data personel dan Nilai IP Personel.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-5 mb-6">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
            <p class="text-sm text-slate-500">Total Personel</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalPersonel }}</p>
        </div>

        <a href="{{ route('pegawai.index', ['status_nilai' => 'lengkap']) }}"
            class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 hover:shadow-md hover:border-green-300 transition">
            <p class="text-sm text-slate-500">Sudah Mengisi Nilai</p>
            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ $jumlahSudahMengisiNilai }}
            </p>
            <p class="text-xs text-slate-400 mt-2">Klik untuk melihat data</p>
        </a>

        <a href="{{ route('pegawai.index', ['status_nilai' => 'belum_lengkap']) }}"
            class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 hover:shadow-md hover:border-red-300 transition">
            <p class="text-sm text-slate-500">Belum Mengisi Nilai</p>
            <p class="text-3xl font-bold text-red-600 mt-2">
                {{ $jumlahBelumMengisiNilai }}
            </p>
            <p class="text-xs text-slate-400 mt-2">Klik untuk melihat data</p>
        </a>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
            <p class="text-sm text-slate-500">Rata-rata Nilai IP</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">
                {{ number_format($rataRataIp ?? 0, 2) }}
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
            <p class="text-sm text-slate-500">Nilai IP Tertinggi</p>
            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ number_format($nilaiIpTertinggi ?? 0, 2) }}
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
            <p class="text-sm text-slate-500">Nilai IP Terendah</p>
            <p class="text-3xl font-bold text-red-600 mt-2">
                {{ number_format($nilaiIpTerendah ?? 0, 2) }}
            </p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-6">
        <div class="mb-4">
            <h3 class="font-semibold text-slate-900">Kategori Nilai IP Personel</h3>
            <p class="text-sm text-slate-500">Rekap jumlah personel berdasarkan kategori nilai.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="rounded-xl bg-green-50 border border-green-100 p-4">
                <p class="text-sm text-green-700 font-medium">Sangat Baik</p>
                <p class="text-2xl font-bold text-green-700 mt-1">{{ $jumlahSangatBaik }}</p>
                <p class="text-xs text-green-600 mt-1">&gt;90 - 100</p>
            </div>

            <div class="rounded-xl bg-blue-50 border border-blue-100 p-4">
                <p class="text-sm text-blue-700 font-medium">Baik</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $jumlahBaik }}</p>
                <p class="text-xs text-blue-600 mt-1">&gt;80 - 90</p>
            </div>

            <div class="rounded-xl bg-yellow-50 border border-yellow-100 p-4">
                <p class="text-sm text-yellow-700 font-medium">Cukup</p>
                <p class="text-2xl font-bold text-yellow-700 mt-1">{{ $jumlahCukup }}</p>
                <p class="text-xs text-yellow-600 mt-1">&gt;70 - 80</p>
            </div>

            <div class="rounded-xl bg-orange-50 border border-orange-100 p-4">
                <p class="text-sm text-orange-700 font-medium">Kurang</p>
                <p class="text-2xl font-bold text-orange-700 mt-1">{{ $jumlahKurang }}</p>
                <p class="text-xs text-orange-600 mt-1">61 - 70</p>
            </div>

            <div class="rounded-xl bg-red-50 border border-red-100 p-4">
                <p class="text-sm text-red-700 font-medium">Sangat Kurang</p>
                <p class="text-2xl font-bold text-red-700 mt-1">{{ $jumlahSangatKurang }}</p>
                <p class="text-xs text-red-600 mt-1">60 ke bawah</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">Top 5 Nilai IP Tertinggi</h3>
                <p class="text-sm text-slate-500">Personel dengan nilai IP terbaik.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">No</th>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Pangkat</th>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Satker</th>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Nilai IP</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($topPersonel as $index => $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 border-b border-slate-100">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 border-b border-slate-100 font-medium">
                                    {{ $item->nama }}
                                </td>
                                <td class="px-4 py-3 border-b border-slate-100">{{ $item->pangkat }}</td>
                                <td class="px-4 py-3 border-b border-slate-100">{{ $item->satuan_kerja }}</td>
                                <td class="px-4 py-3 border-b border-slate-100 font-bold text-green-600">
                                    {{ number_format($item->nilai_ip_personel ?? 0, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada data penilaian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">Personel Nilai IP Rendah</h3>
                <p class="text-sm text-slate-500">Personel dengan Nilai IP di bawah 60.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">No</th>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Pangkat</th>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Satker</th>
                            <th class="px-4 py-3 text-left font-semibold border-b border-slate-200">Nilai IP</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($personelIpRendah as $index => $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 border-b border-slate-100">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 border-b border-slate-100 font-medium">
                                    {{ $item->nama }}
                                </td>
                                <td class="px-4 py-3 border-b border-slate-100">{{ $item->pangkat }}</td>
                                <td class="px-4 py-3 border-b border-slate-100">{{ $item->satuan_kerja }}</td>
                                <td class="px-4 py-3 border-b border-slate-100 font-bold text-red-600">
                                    {{ number_format($item->nilai_ip_personel ?? 0, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-slate-500">
                                    Tidak ada personel dengan Nilai IP di bawah 60.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
