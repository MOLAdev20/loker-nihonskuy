<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserInterviewAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workHistory' => ['required', 'string', 'min:10', 'max:5000'],
            'technicalSkills' => ['required', 'string', 'min:10', 'max:5000'],
            'commChallenges' => ['required', 'string', 'min:10', 'max:5000'],
            'leaveReason' => ['required', 'string', 'min:10', 'max:5000'],
            'applyReason' => ['required', 'string', 'min:10', 'max:5000'],
            'careerPrep' => ['required', 'string', 'min:10', 'max:5000'],
            'personalityReview' => ['required', 'string', 'min:10', 'max:5000'],
            'problemSolving' => ['required', 'string', 'min:10', 'max:5000'],
            'stayMotivation' => ['required', 'string', 'min:10', 'max:5000'],
            'learningGoals' => ['required', 'string', 'min:10', 'max:5000'],
            'japanTargets' => ['required', 'string', 'min:10', 'max:5000'],
            'longTermDream' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'min.string' => ':attribute minimal :min karakter.',
            'max.string' => ':attribute maksimal :max karakter.',
        ];
    }

    public function attributes(): array
    {
        return [
            'workHistory' => 'Pengalaman kerja sebelumnya di Jepang',
            'technicalSkills' => 'Keterampilan atau skill teknis',
            'commChallenges' => 'Situasi komunikasi yang paling menantang',
            'leaveReason' => 'Alasan mencari pekerjaan baru',
            'applyReason' => 'Alasan tertarik pada bidang baru',
            'careerPrep' => 'Proses atau persiapan untuk melamar bidang ini',
            'personalityReview' => 'Gambaran kepribadian dari rekan kerja atau atasan',
            'problemSolving' => 'Cara mengatasi kendala berat atau tekanan',
            'stayMotivation' => 'Motivasi bertahan menyelesaikan kontrak kerja',
            'learningGoals' => 'Hal baru yang ingin dipelajari',
            'japanTargets' => 'Target atau goals selama bekerja di Jepang',
            'longTermDream' => 'Impian jangka panjang setelah kembali ke Indonesia',
        ];
    }
}
