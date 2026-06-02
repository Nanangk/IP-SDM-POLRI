<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nrp',
        'pangkat',
        'jabatan',
        'satuan_kerja',
        'foto',

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
        'nilai_ip_personel',
    ];

    public function getKategoriIpAttribute()
    {
        $nilai = $this->nilai_ip_personel;

        if ($nilai === null) {
            return '-';
        }

        if ($nilai > 90 && $nilai <= 100) {
            return 'SANGAT BAIK';
        }

        if ($nilai > 80 && $nilai <= 90) {
            return 'BAIK';
        }

        if ($nilai > 70 && $nilai <= 80) {
            return 'CUKUP';
        }

        if ($nilai >= 61 && $nilai <= 70) {
            return 'KURANG';
        }

        return 'SANGAT KURANG';
    }
}
