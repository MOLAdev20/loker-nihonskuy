<?php

namespace App\Http\Controllers\Admin\UserManagement\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserInterviewAnswerRequest;
use App\Models\User;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserInterviewAnswer;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use App\Support\AdminUserFormWizardBuilder;

class InterviewController extends Controller
{
    // Method untuk menampilkan form pertanyaan interview
    public function index(int $id)
    {
        // Dapatkan data kandidatnya, sekaligus pengecekan
        $user = User::query()->findOrFail($id);

        // Dapatkan data pertanyaan interview
        $interviewAnswer = UserInterviewAnswer::query()->where(['user_id' => $id])->get();

        return view("admin.user.form.interview", [
            'user' => $user,
            'interviewAnswer' => $interviewAnswer
        ]);
    }

    // Method untuk menyimpan data pertanyaan interview
    public function store(StoreUserInterviewAnswerRequest $request, int $id)
    {
        $validatedRequest = $request->validated();

        // Dapatkan data kandidatnya, sekaligus pengecekan
        $user = User::query()->findOrFail($id);

        UserInterviewAnswer::updateOrCreate(
            ["user_id" => $user->id],
            $validatedRequest
        );

        return redirect()->refresh()->with("success-msg", "");
    }
}
