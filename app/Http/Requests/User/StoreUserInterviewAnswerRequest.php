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
            'work_history' => ['required', 'string'],
            'technical_skills' => ['required', 'string'],
            'comm_challenges' => ['required', 'string'],
            'leave_reason' => ['required', 'string'],
            'apply_reason' => ['required', 'string'],
            'career_prep' => ['required', 'string'],
            'personality_review' => ['required', 'string'],
            'problem_solving' => ['required', 'string'],
            'stay_motivation' => ['required', 'string'],
            'learning_goals' => ['required', 'string'],
            'japan_targets' => ['required', 'string'],
            'long_term_dream' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.'
        ];
    }

    public function attributes(): array
    {
        return [
            'work_history' => 'Pengalaman kerja sebelumnya di Jepang',
            'technical_skills' => 'Keterampilan atau skill teknis',
            'comm_challenges' => 'Situasi komunikasi yang paling menantang',
            'leave_reason' => 'Alasan mencari pekerjaan baru',
            'apply_reason' => 'Alasan tertarik pada bidang baru',
            'career_prep' => 'Proses atau persiapan untuk melamar bidang ini',
            'personality_review' => 'Gambaran kepribadian dari rekan kerja atau atasan',
            'problem_solving' => 'Cara mengatasi kendala berat atau tekanan',
            'stay_motivation' => 'Motivasi bertahan menyelesaikan kontrak kerja',
            'learning_goals' => 'Hal baru yang ingin dipelajari',
            'japan_targets' => 'Target atau goals selama bekerja di Jepang',
            'long_term_dream' => 'Impian jangka panjang setelah kembali ke Indonesia',
        ];
    }
}
