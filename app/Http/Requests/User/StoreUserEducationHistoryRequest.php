<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User\UserEducationHistory;

class StoreUserEducationHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $educationLevelOptions = array_keys(UserEducationHistory::educationLevelOptions());
        $educationLocationOptions = array_keys(UserEducationHistory::eduLocationOptions());
        $educationStatusOptions = array_keys(UserEducationHistory::eduStatusOptions());

        return [
            'education' => ['required', 'in:' . implode(',', $educationLevelOptions)],
            'institution' => ['required', 'string', 'min:3', 'max:255'],
            'location' => ['required', 'in:' . implode(',', $educationLocationOptions)],
            'dateOfEntry' => ['required', 'date'],
            'dateOfGraduation' => ['nullable', 'date', 'after_or_equal:dateOfEntry'],
            'dateOfDroppedOut' => ['nullable', 'date', 'after_or_equal:dateOfEntry'],
            'status' => ['required', 'in:' . implode(',', $educationStatusOptions)],
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
            'education' => 'Jenjang Pendidikan',
            'institution' => 'Nama Institusi/Sekolah/Perguruan',
            'location' => 'Lokasi Institusi/Sekolah/Perguruan',
            'dateOfEntry' => 'Tanggal Masuk',
            'dateOfGraduation' => 'Tanggal Lulus',
            'dateOfDroppedOut' => 'Tanggal Berhenti/Putus Sekolah',
            'status' => 'Status',
        ];
    }
}
