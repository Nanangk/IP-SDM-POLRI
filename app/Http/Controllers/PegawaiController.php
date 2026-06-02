<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Requests\PegawaiRequest;
use Illuminate\Support\Facades\Storage;
use App\Imports\PegawaiImport;
use App\Exports\PegawaiExport;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $pangkat = $request->pangkat;
        $jabatan = $request->jabatan;
        $satuanKerja = $request->satuan_kerja;
        $statusNilai = $request->status_nilai;

        $promptSearch = $this->parsePromptSearch($search);

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
            ->when($search && !$promptSearch, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('nrp', 'like', '%' . $search . '%')
                        ->orWhere('pangkat', 'like', '%' . $search . '%')
                        ->orWhere('jabatan', 'like', '%' . $search . '%')
                        ->orWhere('satuan_kerja', 'like', '%' . $search . '%');
                });
            })
            ->when($promptSearch, function ($query) use ($promptSearch) {
                return $query->where(
                    $promptSearch['field'],
                    $promptSearch['operator'],
                    $promptSearch['value']
                );
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
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $listPangkat = Pegawai::select('pangkat')->distinct()->orderBy('pangkat')->pluck('pangkat');
        $listJabatan = Pegawai::select('jabatan')->distinct()->orderBy('jabatan')->pluck('jabatan');
        $listSatuanKerja = Pegawai::select('satuan_kerja')->distinct()->orderBy('satuan_kerja')->pluck('satuan_kerja');

        return view('pegawai.index', compact(
            'pegawai',
            'search',
            'pangkat',
            'jabatan',
            'satuanKerja',
            'statusNilai',
            'listPangkat',
            'listJabatan',
            'listSatuanKerja',
            'promptSearch'
        ));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(PegawaiRequest $request)
    {
        $data = $request->validated();

        $data['nilai_ip_personel'] = $this->hitungNilaiIpPersonel($data);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-pegawai', 'public');
        }

        Pegawai::create($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(PegawaiRequest $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $data = $request->validated();

        $data['nilai_ip_personel'] = $this->hitungNilaiIpPersonel($data);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $data['foto'] = $request->file('foto')->store('foto-pegawai', 'public');
        }

        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->foto) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
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

    public function importForm()
    {
        return view('pegawai.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file.required' => 'File Excel wajib diupload.',
            'file.mimes' => 'File harus berformat xlsx, xls, atau csv.',
            'file.max' => 'Ukuran file maksimal 2 MB.',
        ]);

        Excel::import(new PegawaiImport, $request->file('file'));

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diimport dari Excel.');
    }

    private function parsePromptSearch(?string $search): ?array
    {
        if (!$search) {
            return null;
        }

        $text = strtolower($search);

        $text = str_replace([
            'e-rohani',
            'erohani',
            'e rohani',
        ], 'rohani', $text);

        $text = str_replace([
            'e-mental',
            'emental',
            'e mental',
        ], 'emental', $text);

        $fields = [
            'kinerja semester 1' => 'kinerja_semester_1',
            'kinerja semester satu' => 'kinerja_semester_1',
            'kinerja s1' => 'kinerja_semester_1',

            'kinerja semester 2' => 'kinerja_semester_2',
            'kinerja semester dua' => 'kinerja_semester_2',
            'kinerja s2' => 'kinerja_semester_2',

            'disiplin' => 'disiplin',

            'rohani semester 1' => 'rohani_semester_1',
            'rohani semester satu' => 'rohani_semester_1',
            'rohani s1' => 'rohani_semester_1',

            'rohani semester 2' => 'rohani_semester_2',
            'rohani semester dua' => 'rohani_semester_2',
            'rohani s2' => 'rohani_semester_2',

            'emental semester 1' => 'emental_semester_1',
            'emental semester satu' => 'emental_semester_1',
            'emental s1' => 'emental_semester_1',

            'emental semester 2' => 'emental_semester_2',
            'emental semester dua' => 'emental_semester_2',
            'emental s2' => 'emental_semester_2',

            'kesehatan' => 'kesehatan',

            'jasmani semester 1' => 'jasmani_semester_1',
            'jasmani semester satu' => 'jasmani_semester_1',
            'jasmani s1' => 'jasmani_semester_1',

            'jasmani semester 2' => 'jasmani_semester_2',
            'jasmani semester dua' => 'jasmani_semester_2',
            'jasmani s2' => 'jasmani_semester_2',

            'akademik' => 'akademik',
            'nilai ip' => 'nilai_ip_personel',
            'ip personel' => 'nilai_ip_personel',
        ];

        $operator = '=';

        if (
            str_contains($text, 'di bawah') ||
            str_contains($text, 'dibawah') ||
            str_contains($text, 'kurang dari') ||
            str_contains($text, '<')
        ) {
            $operator = '<';
        } elseif (
            str_contains($text, 'di atas') ||
            str_contains($text, 'diatas') ||
            str_contains($text, 'lebih dari') ||
            str_contains($text, '>')
        ) {
            $operator = '>';
        } elseif (
            str_contains($text, 'minimal') ||
            str_contains($text, 'paling sedikit') ||
            str_contains($text, '>=')
        ) {
            $operator = '>=';
        } elseif (
            str_contains($text, 'maksimal') ||
            str_contains($text, 'paling banyak') ||
            str_contains($text, '<=')
        ) {
            $operator = '<=';
        }

        $selectedField = null;

        foreach ($fields as $keyword => $column) {
            if (str_contains($text, $keyword)) {
                $selectedField = $column;
                break;
            }
        }

        if (!$selectedField) {
            return null;
        }

        preg_match_all('/\d+(\.\d+)?/', $text, $matches);

        if (empty($matches[0])) {
            return null;
        }

        $value = end($matches[0]);

        return [
            'field' => $selectedField,
            'operator' => $operator,
            'value' => $value,
        ];
    }

    public function export(Request $request)
    {
        $filters = $request->only([
            'search',
            'pangkat',
            'jabatan',
            'satuan_kerja',
            'status_nilai',
        ]);

        return Excel::download(new PegawaiExport($filters), 'data-pegawai.xlsx');
    }
}
