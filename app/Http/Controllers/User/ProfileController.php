<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $profile = Profile::where('account_id', Session::get('account_id'))->first();

        return view("user.profile", [
            "profile" => $profile
        ]);
    }

    public function showProfileForm()
    {
        $profile = Profile::where('account_id', Session::get('account_id'))->first();

        if (empty($profile)) {
            return view("user.profile-form");
        }

        return view("user.edit-profile-form", [
            "profile" => $profile
        ]);
    }

    public function storeProfile(Request $req)
    {
        try {
            $validated = $req->validate(
                [
                    'furigana' => ['nullable', 'string', 'max:255'],
                    'nama_lengkap' => ['required', 'string', 'max:255'],
                    'tanggal_lahir' => ['nullable', 'date'],
                    'jenis_kelamin' => ['nullable', 'string', 'max:50'],
                    'status_pernikahan' => ['nullable', 'string', 'max:100'],
                    'kewarganegaraan' => ['nullable', 'string', 'max:100'],
                    'tempat_asal' => ['nullable', 'string', 'max:255'],
                    'alamat_sekarang' => ['nullable', 'string'],
                    'agama' => ['nullable', 'string', 'max:100'],
                    'hijab' => ['nullable', 'string', 'max:100'],
                    'salat' => ['nullable', 'string', 'max:100'],
                    'toleransi_babi' => ['nullable', 'string', 'max:100'],
                    'toleransi_alkohol' => ['nullable', 'string', 'max:100'],
                    'tanggal_masuk_jepang' => ['nullable', 'date'],
                    'status_izin_tinggal' => ['nullable', 'string', 'max:255'],
                    'masa_berlaku_kartu' => ['nullable', 'date'],
                    'tanggal_mulai_kerja' => ['nullable', 'date'],
                    'kemampuan_bahasa' => ['nullable', 'string'],
                    'ujian_keterampilan' => ['nullable', 'string'],
                    'kepemilikan_sim' => ['nullable', 'string', 'max:100'],
                ]
            );

            $validated['account_id'] = Session::get('account_id');

            Profile::create($validated);

            return response()->json(['message' => 'Profile created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
