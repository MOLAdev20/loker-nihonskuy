<?php

namespace App\Http\Requests\User;

use App\Models\User\UserCertificate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreUserCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'certificate_type' => ['required', 'string', 'in:' . implode(',', array_keys(UserCertificate::certificateTypes()))],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'file' => ':attribute harus berupa file yang valid.',
            'mimes' => ':attribute harus berformat PDF, JPG, JPEG, atau PNG.',
            'max.file' => ':attribute maksimal :max KB.',
            'in' => 'Pilihan :attribute tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'certificate_type' => 'Jenis Sertifikat',
            'file' => 'File Sertifikat',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $certificateType = $this->input('certificate_type');

            if (! $certificateType || $validator->errors()->has('certificate_type')) {
                return;
            }

            $exists = UserCertificate::query()
                ->where('user_id', auth()->id())
                ->where('certificate_type', $certificateType)
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'certificate_type',
                    'sertifikat ' . UserCertificate::certificateTypeLabel($certificateType) . ' sudah ada. Hapus terlebih dahulu untuk menggantinya'
                );
            }
        });
    }
}
