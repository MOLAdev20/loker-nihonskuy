<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserWorkExperienceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fieldOfWork' => ['required', 'string', 'min:3', 'max:255'],
            'companyName' => ['required', 'string', 'min:3', 'max:255'],
            'location' => ['required', 'string'],
            'dateOfJoin' => ['required', 'date'],
            'dateOfResign' => ['nullable', 'date', 'after_or_equal:dateOfJoin'],
            'employmentStatus' => ['required', 'in:permanent,contract,fullTime,partTime,freelance'],
            'visaType' => ['nullable', 'in:tokuteiGinou,gijinkoku,magang'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'min.string' => ':attribute minimal :min karakter.',
            'max.string' => ':attribute maksimal :max karakter.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'in' => 'Pilihan :attribute tidak valid.',
            'after_or_equal' => ':attribute tidak boleh lebih awal dari :date.',
        ];
    }

    public function attributes(): array
    {
        return [
            'fieldOfWork' => 'Bidang Pekerjaan',
            'companyName' => 'Nama Perusahaan',
            'location' => 'Lokasi Kerja/Perusahaan',
            'dateOfJoin' => 'Tanggal Bergabung',
            'dateOfResign' => 'Tanggal Resign/Berhenti',
            'employmentStatus' => 'Status Kepegawaian',
            'visaType' => 'Jenis Visa',
        ];
    }
}
