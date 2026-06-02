<?php

namespace App\Imports;

use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['nama']) || empty($row['nrp'])) {
                continue;
            }

            $data = [
                'nama' => $row['nama'],
                'nrp' => $row['nrp'],
                'pangkat' => $row['pangkat'] ?? null,
                'jabatan' => $row['jabatan'] ?? null,
                'satuan_kerja' => $row['satuan_kerja'] ?? null,

                'kinerja_semester_1' => $row['kinerja_semester_1'] ?? 0,
                'kinerja_semester_2' => $row['kinerja_semester_2'] ?? 0,
                'disiplin' => $row['disiplin'] ?? 0,

                'rohani_semester_1' => $row['rohani_semester_1'] ?? 0,
                'rohani_semester_2' => $row['rohani_semester_2'] ?? 0,

                'emental_semester_1' => $row['emental_semester_1'] ?? 0,
                'emental_semester_2' => $row['emental_semester_2'] ?? 0,

                'kesehatan' => $row['kesehatan'] ?? 0,

                'jasmani_semester_1' => $row['jasmani_semester_1'] ?? 0,
                'jasmani_semester_2' => $row['jasmani_semester_2'] ?? 0,

                'akademik' => $row['akademik'] ?? 0,
            ];

            $data['nilai_ip_personel'] = $this->hitungNilaiIpPersonel($data);

            Pegawai::updateOrCreate(
                ['nrp' => $data['nrp']],
                $data
            );
        }
    }

    private function hitungNilaiIpPersonel(array $data): float
    {
        $kinerja = (
            ($data['kinerja_semester_1'] ?? 0) +
            ($data['kinerja_semester_2'] ?? 0)
        ) / 2;

        $rohani = (
            ($data['rohani_semester_1'] ?? 0) +
            ($data['rohani_semester_2'] ?? 0)
        ) / 2;

        $emental = (
            ($data['emental_semester_1'] ?? 0) +
            ($data['emental_semester_2'] ?? 0)
        ) / 2;

        $jasmani = (
            ($data['jasmani_semester_1'] ?? 0) +
            ($data['jasmani_semester_2'] ?? 0)
        ) / 2;

        $nilaiIp =
            (0.30 * $kinerja) +
            (0.30 * ($data['disiplin'] ?? 0)) +
            (0.09 * $rohani) +
            (0.09 * $emental) +
            (0.08 * ($data['kesehatan'] ?? 0)) +
            (0.07 * $jasmani) +
            (0.07 * ($data['akademik'] ?? 0));

        return round($nilaiIp, 2);
    }
}
