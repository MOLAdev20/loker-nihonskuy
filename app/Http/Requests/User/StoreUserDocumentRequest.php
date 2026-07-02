<?php

namespace App\Http\Requests\User;

use App\Models\User\UserDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreUserDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_type' => ['required', 'string', 'in:ktp,kk,akte_kelahiran'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'file' => ':attribute harus berupa file yang valid.',
            'mimes' => ':attribute harus berformat PDF.',
            'max.file' => ':attribute maksimal :max KB.',
            'in' => 'Pilihan :attribute tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'file_type' => 'Jenis Dokumen',
            'file' => 'File Dokumen',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $fileType = $this->input('file_type');

            if (! $fileType || $validator->errors()->has('file_type')) {
                return;
            }

            $exists = UserDocument::query()
                ->where('user_id', auth()->id())
                ->where('file_type', $fileType)
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'file_type',
                    'Dokumen ' . UserDocument::fileTypeLabel($fileType) . ' sudah ada. Hapus terlebih dahulu untuk menggantinya'
                );
            }
        });
    }
}
