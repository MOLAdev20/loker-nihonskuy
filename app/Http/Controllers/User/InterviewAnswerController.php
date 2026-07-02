<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserInterviewAnswerRequest;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserInterviewAnswer;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use App\Support\FormWizardBuilder;

class InterviewAnswerController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $profile = UserProfile::where('user_id', $userId)->first();
        $educationHistoriesCount = UserEducationHistory::where('user_id', $userId)->count();
        $workExperiencesCount = WorkExperience::where('user_id', $userId)->count();

        if (! $profile) {
            return redirect()
                ->route('user.profile.form');
        }

        if ($educationHistoriesCount === 0) {
            return redirect()
                ->route('user.education-history');
        }

        if ($workExperiencesCount === 0) {
            return redirect()
                ->route('user.working-experience');
        }

        $interviewAnswer = UserInterviewAnswer::where('user_id', $userId)->first();
        $wizardSteps = FormWizardBuilder::buildSteps(
            'interview',
            true,
            true,
            true,
            (bool) $interviewAnswer
        );

        return view('user.interview-answer', [
            'profile' => $profile,
            'interviewAnswer' => $interviewAnswer,
            'wizardSteps' => $wizardSteps,
            'canGoNext' => (bool) $interviewAnswer,
        ]);
    }

    public function store(StoreUserInterviewAnswerRequest $request)
    {
        $userId = auth()->id();

        if (! UserProfile::where('user_id', $userId)->exists()) {
            return redirect()
                ->route('user.profile.form');
        }

        if (UserEducationHistory::where('user_id', $userId)->doesntExist()) {
            return redirect()
                ->route('user.education-history');
        }

        if (WorkExperience::where('user_id', $userId)->doesntExist()) {
            return redirect()
                ->route('user.working-experience');
        }

        $validatedData = $request->validated();

        UserInterviewAnswer::updateOrCreate(
            ['user_id' => $userId],
            $this->mapInterviewAnswerPayload($validatedData)
        );

        $interviewSummaryText = $this->buildInterviewSummaryText($validatedData);
        $interviewSummaryPrompt = 'これは企業に送信する外国人候補者の推薦文です。日本語的におかしい部分を修正してください';

        UserProfile::where('user_id', $userId)
            ->update([
                'jp_summary' => toJapan($interviewSummaryText, $interviewSummaryPrompt),
            ]);

        return redirect()
            ->route('users.confirm')
            ->with('status', 'Jawaban interview berhasil disimpan.');
    }

    private function mapInterviewAnswerPayload(array $validatedData): array
    {
        return [
            'work_history' => $validatedData['workHistory'],
            'technical_skills' => $validatedData['technicalSkills'],
            'comm_challenges' => $validatedData['commChallenges'],
            'leave_reason' => $validatedData['leaveReason'],
            'apply_reason' => $validatedData['applyReason'],
            'career_prep' => $validatedData['careerPrep'],
            'personality_review' => $validatedData['personalityReview'],
            'problem_solving' => $validatedData['problemSolving'],
            'stay_motivation' => $validatedData['stayMotivation'],
            'learning_goals' => $validatedData['learningGoals'],
            'japan_targets' => $validatedData['japanTargets'],
            'long_term_dream' => $validatedData['longTermDream'],
        ];
    }

    private function buildInterviewSummaryText(array $validatedData): string
    {
        $summaryItems = [
            'Pengalaman kerja sebelumnya di Jepang' => $validatedData['workHistory'],
            'Keterampilan atau skill teknis' => $validatedData['technicalSkills'],
            'Situasi komunikasi yang paling menantang' => $validatedData['commChallenges'],
            'Alasan mencari pekerjaan baru' => $validatedData['leaveReason'],
            'Alasan tertarik pada bidang baru' => $validatedData['applyReason'],
            'Proses atau persiapan untuk melamar bidang ini' => $validatedData['careerPrep'],
            'Gambaran kepribadian dari rekan kerja atau atasan' => $validatedData['personalityReview'],
            'Cara mengatasi kendala berat atau tekanan' => $validatedData['problemSolving'],
            'Motivasi bertahan menyelesaikan kontrak kerja' => $validatedData['stayMotivation'],
            'Hal baru yang ingin dipelajari' => $validatedData['learningGoals'],
            'Target atau goals selama bekerja di Jepang' => $validatedData['japanTargets'],
            'Impian jangka panjang setelah kembali ke Indonesia' => $validatedData['longTermDream'],
        ];

        return collect($summaryItems)
            ->map(function (string $answer, string $label): string {
                return $label . ': ' . trim($answer);
            })
            ->implode("\n\n");
    }
}
