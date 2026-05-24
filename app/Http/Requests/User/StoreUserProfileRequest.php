<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullName' => ['required', 'string', 'min:3', 'max:255'],
            'furiganaName' => ['required', 'string', 'min:3', 'max:255'],
            'birthDate' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'height' => ['required', 'integer', 'min:1'],
            'weight' => ['required', 'integer', 'min:1'],
            'maritalStatus' => ['required', 'in:single,married,divorce'],
            'nationality' => ['required', 'string', 'min:3', 'max:255'],
            'placeOfOrigin' => ['required', 'string', 'min:3', 'max:255'],
            'currentAddress' => ['required', 'string', 'min:3', 'max:255'],
            'religion' => ['required', 'in:islam,kristen,katolik,hindu,buddha'],
            'isWearingHijab' => ['required', 'string', 'min:3', 'max:255'],
            'prayerRequirement' => ['required', 'string', 'min:3', 'max:255'],
            'porkTolerance' => ['required', 'string', 'min:3', 'max:255'],
            'alcoholTolerance' => ['required', 'string', 'min:3', 'max:255'],
            'entryDate' => ['nullable', 'date'],
            'visaExpiryDate' => ['nullable', 'date'],
            'currentVisaType' => ['required', 'string', 'min:3', 'max:255'],
            'jlptLevel' => ['required', 'in:N1,N2,N3,N4,N5,none,other'],
            'hasDriverLicense' => ['required', 'string', 'min:3', 'max:255'],
            'workStartDate' => ['required', 'date'],
            'technicalExperience' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'integer' => ':attribute harus berupa angka.',
            'min.string' => ':attribute minimal :min karakter.',
            'min.numeric' => ':attribute minimal :min.',
            'max.string' => ':attribute maksimal :max karakter.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'in' => 'Pilihan :attribute tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'fullName' => 'Nama Lengkap',
            'furiganaName' => 'Furigana',
            'birthDate' => 'Tanggal Lahir',
            'gender' => 'Jenis Kelamin',
            'height' => 'Tinggi Badan',
            'weight' => 'Berat Badan',
            'maritalStatus' => 'Status Pernikahan',
            'nationality' => 'Kewarganegaraan',
            'placeOfOrigin' => 'Tempat Asal',
            'currentAddress' => 'Alamat Saat Ini',
            'religion' => 'Agama',
            'isWearingHijab' => 'Apakah Menggunakan Hijab',
            'prayerRequirement' => 'Kebutuhan Ibadah',
            'porkTolerance' => 'Toleransi Terhadap Daging Babi',
            'alcoholTolerance' => 'Toleransi Terhadap Alkohol',
            'entryDate' => 'Tanggal Masuk Jepang',
            'visaExpiryDate' => 'Masa Berlaku VISA',
            'currentVisaType' => 'Jenis Visa Saat Ini',
            'jlptLevel' => 'Level Kemampuan Bahasa Jepang (JLPT)',
            'hasDriverLicense' => 'Memiliki SIM',
            'workStartDate' => 'Tanggal Siap Mulai Kerja',
            'technicalExperience' => 'Detail Pengalaman Magang/Skill',
        ];
    }
}
