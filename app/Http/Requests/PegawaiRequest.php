<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pegawaiId = $this->route('pegawai');

        return [
            'nama' => 'required',
            'nrp' => 'required|min:8|unique:pegawais,nrp,' . $pegawaiId,
            'pangkat' => 'required',
            'jabatan' => 'required',
            'satuan_kerja' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'kinerja_semester_1' => 'nullable|numeric|min:0|max:100',
            'kinerja_semester_2' => 'nullable|numeric|min:0|max:100',
            'disiplin' => 'nullable|numeric|min:0|max:100',
            'rohani_semester_1' => 'nullable|numeric|min:0|max:100',
            'rohani_semester_2' => 'nullable|numeric|min:0|max:100',
            'emental_semester_1' => 'nullable|numeric|min:0|max:100',
            'emental_semester_2' => 'nullable|numeric|min:0|max:100',
            'kesehatan' => 'nullable|numeric|min:0|max:100',
            'jasmani_semester_1' => 'nullable|numeric|min:0|max:100',
            'jasmani_semester_2' => 'nullable|numeric|min:0|max:100',
            'akademik' => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nrp.required' => 'NRP wajib diisi.',
            'nrp.min' => 'NRP minimal 8 karakter.',
            'nrp.unique' => 'NRP sudah terdaftar.',
            'pangkat.required' => 'Pangkat wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'satuan_kerja.required' => 'Satuan kerja wajib diisi.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',

            '*.numeric' => 'Nilai harus berupa angka.',
            '*.min' => 'Nilai minimal 0.',
            '*.max' => 'Nilai maksimal 100.',
        ];
    }
}
