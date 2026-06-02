<?php

namespace App\Exports;

use App\Models\Pegawai;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PegawaiExport implements FromView
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $search = $this->filters['search'] ?? null;
        $pangkat = $this->filters['pangkat'] ?? null;
        $jabatan = $this->filters['jabatan'] ?? null;
        $satuanKerja = $this->filters['satuan_kerja'] ?? null;
        $statusNilai = $this->filters['status_nilai'] ?? null;

        $kolomPenilaian = [
            'kinerja_semester_1',
            'kinerja_semester_2',
            'disiplin',
            'rohani_semester_1',
            'rohani_semester_2',
            'emental_semester_1',
            'emental_semester_2',
            'kesehatan',
            'jasmani_semester_1',
            'jasmani_semester_2',
            'akademik',
        ];

        $pegawai = Pegawai::query()
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('nrp', 'like', '%' . $search . '%')
                        ->orWhere('pangkat', 'like', '%' . $search . '%')
                        ->orWhere('jabatan', 'like', '%' . $search . '%')
                        ->orWhere('satuan_kerja', 'like', '%' . $search . '%');
                });
            })
            ->when($pangkat, function ($query, $pangkat) {
                return $query->where('pangkat', $pangkat);
            })
            ->when($jabatan, function ($query, $jabatan) {
                return $query->where('jabatan', $jabatan);
            })
            ->when($satuanKerja, function ($query, $satuanKerja) {
                return $query->where('satuan_kerja', $satuanKerja);
            })
            ->when($statusNilai == 'belum_lengkap', function ($query) use ($kolomPenilaian) {
                return $query->where(function ($query) use ($kolomPenilaian) {
                    foreach ($kolomPenilaian as $kolom) {
                        $query->orWhereNull($kolom)
                            ->orWhere($kolom, 0);
                    }
                });
            })
            ->when($statusNilai == 'lengkap', function ($query) use ($kolomPenilaian) {
                foreach ($kolomPenilaian as $kolom) {
                    $query->whereNotNull($kolom)
                        ->where($kolom, '>', 0);
                }

                return $query;
            })
            ->orderBy('nama')
            ->get();

        return view('pegawai.export', compact('pegawai'));
    }
}
