<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;

class DashboardController extends Controller
{
    public function index()
    {
        $namaAplikasi = 'IP SDM POLRI';
        //$namaUser = auth()->user()->name ?? 'Admin';

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

        $totalPersonel = Pegawai::count();

        $rataRataIp = Pegawai::whereNotNull('nilai_ip_personel')
            ->avg('nilai_ip_personel');

        $nilaiIpTertinggi = Pegawai::whereNotNull('nilai_ip_personel')
            ->max('nilai_ip_personel');

        $nilaiIpTerendah = Pegawai::whereNotNull('nilai_ip_personel')
            ->min('nilai_ip_personel');

        $topPersonel = Pegawai::whereNotNull('nilai_ip_personel')
            ->orderByDesc('nilai_ip_personel')
            ->take(5)
            ->get();

        $personelIpRendah = Pegawai::whereNotNull('nilai_ip_personel')
            ->where('nilai_ip_personel', '<', 60)
            ->orderBy('nilai_ip_personel')
            ->take(5)
            ->get();

        $querySudahMengisi = Pegawai::query();

        foreach ($kolomPenilaian as $kolom) {
            $querySudahMengisi->whereNotNull($kolom)
                ->where($kolom, '>', 0);
        }

        $jumlahSudahMengisiNilai = $querySudahMengisi->count();

        $jumlahBelumMengisiNilai = Pegawai::where(function ($query) use ($kolomPenilaian) {
            foreach ($kolomPenilaian as $kolom) {
                $query->orWhereNull($kolom)
                    ->orWhere($kolom, 0);
            }
        })->count();

        $personelBelumMengisiNilai = Pegawai::where(function ($query) use ($kolomPenilaian) {
            foreach ($kolomPenilaian as $kolom) {
                $query->orWhereNull($kolom)
                    ->orWhere($kolom, 0);
            }
        })
            ->orderBy('nama')
            ->take(10)
            ->get();

        $jumlahSangatBaik = Pegawai::where('nilai_ip_personel', '>', 90)
            ->where('nilai_ip_personel', '<=', 100)
            ->count();

        $jumlahBaik = Pegawai::where('nilai_ip_personel', '>', 80)
            ->where('nilai_ip_personel', '<=', 90)
            ->count();

        $jumlahCukup = Pegawai::where('nilai_ip_personel', '>', 70)
            ->where('nilai_ip_personel', '<=', 80)
            ->count();

        $jumlahKurang = Pegawai::where('nilai_ip_personel', '>=', 61)
            ->where('nilai_ip_personel', '<=', 70)
            ->count();

        $jumlahSangatKurang = Pegawai::where('nilai_ip_personel', '<=', 60)
            ->count();

        return view('dashboard', compact(
            'namaAplikasi',
            //'namaUser',
            'totalPersonel',
            'rataRataIp',
            'nilaiIpTertinggi',
            'nilaiIpTerendah',
            'topPersonel',
            'personelIpRendah',
            'jumlahSudahMengisiNilai',
            'jumlahBelumMengisiNilai',
            'personelBelumMengisiNilai',
            'jumlahSangatBaik',
            'jumlahBaik',
            'jumlahCukup',
            'jumlahKurang',
            'jumlahSangatKurang'
        ));
    }
}
