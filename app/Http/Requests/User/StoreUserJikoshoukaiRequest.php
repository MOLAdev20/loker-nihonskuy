<?php

namespace App\Http\Requests\User;

use App\Models\User\UserProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreUserJikoshoukaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jikoshoukai' => ['nullable', 'url', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'jikoshoukai.url' => 'Link YouTube harus berupa URL yang valid.',
            'jikoshoukai.max' => 'Link YouTube maksimal 2048 karakter.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $link = $this->input('jikoshoukai');

            if (! filled($link) || $validator->errors()->has('jikoshoukai')) {
                return;
            }

            if (! UserProfile::extractYoutubeVideoId($link)) {
                $validator->errors()->add('jikoshoukai', 'Link harus mengarah ke video YouTube yang valid.');
            }
        });
    }
}
