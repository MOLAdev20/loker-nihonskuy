<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Check referral code availability via AJAX.
     */
    public function checkReferalCode(Request $request): JsonResponse
    {
        $request->validate([
            'ref_code' => ['nullable', 'string', 'max:12'],
        ]);

        $refCode = $this->normalizeReferalCode($request->query('ref_code'));

        if ($refCode === null) {
            return response()->json([
                'valid' => false,
                'message' => 'Silakan masukkan kode referal terlebih dahulu.',
            ]);
        }

        $isValid = $this->isValidReferalCode($refCode);

        return response()->json([
            'valid' => $isValid,
            'message' => $isValid
                ? 'Kode referal tersedia dan dapat digunakan.'
                : 'Kode referal tidak tersedia. Mohon periksa kembali kode yang dimasukkan.',
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed:confirm-pwd', Rules\Password::defaults()],
            'ref_code' => [
                'nullable',
                'string',
                'max:12',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ($value === null || $value === '') {
                        return;
                    }

                    if (! $this->isValidReferalCode((string) $value)) {
                        $fail('Kode referal tidak tersedia. Mohon periksa kembali kode yang dimasukkan.');
                    }
                },
            ],
        ], [
            'fullname.required' => "Nama lengkap wajib diisi",
            'fullname.max' => "Nama lengkap terlalu panjang",
            'email.required' => "Email wajib diisi",
            'email.max' => "Email terlalu panjang",
            'email.unique' => "Email sudah terdaftar",
            'password.required' => "Password wajib diisi",
            'password.confirmed' => "Password tidak cocok",
            'ref_code.max' => "Kode referal maksimal 12 karakter",
        ]);

        $user = User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ref_code' => $this->normalizeReferalCode($request->ref_code),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home')->with('status', 'Registrasi berhasil.');
    }

    private function isValidReferalCode(string $refCode): bool
    {
        return in_array($this->normalizeReferalCode($refCode), $this->getReferalCodes(), true);
    }

    /**
     * @return array<int, string>
     */
    private function getReferalCodes(): array
    {
        $filePath = public_path('referal.json');

        if (! File::exists($filePath)) {
            return [];
        }

        $content = json_decode(File::get($filePath), true);

        if (! is_array($content) || ! isset($content['ref']) || ! is_array($content['ref'])) {
            return [];
        }

        $codes = [];

        foreach ($content['ref'] as $code) {
            $normalizedCode = $this->normalizeReferalCode(is_string($code) ? $code : null);

            if ($normalizedCode !== null) {
                $codes[] = $normalizedCode;
            }
        }

        return array_values(array_unique($codes));
    }

    private function normalizeReferalCode(?string $refCode): ?string
    {
        if ($refCode === null) {
            return null;
        }

        $normalizedCode = strtoupper(trim($refCode));

        return $normalizedCode === '' ? null : $normalizedCode;
    }
}
