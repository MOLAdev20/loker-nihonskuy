<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $queryFilter = trim((string) $request->query("q", ""));

        return view("admin.user.users", [
            "users" => User::getAdminUserList($queryFilter !== "" ? $queryFilter : null),
            "queryFilter" => $queryFilter,
        ]);
    }

    public function showAccountDetail(int $id)
    {
        $user = User::query()
            ->with([
                "userProfile",
                "educationHistories" => fn ($query) => $query->orderByDesc("date_of_entry")->orderByDesc("id"),
                "workExperiences" => fn ($query) => $query->orderByDesc("date_of_join")->orderByDesc("id"),
            ])
            ->findOrFail($id);

        return view("admin.user.detail", [
            "user" => $user,
        ]);
    }
}
