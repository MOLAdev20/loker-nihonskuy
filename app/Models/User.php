<?php

namespace App\Models;

use App\Models\User\UserEducationHistory;
use App\Models\User\UserInterviewAnswer;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ref_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getAdminUserList(?string $queryFilter = null, int $perPage = 10): LengthAwarePaginator
    {
        $users = static::query()
            ->leftJoin("user_profile", "users.id", "=", "user_profile.user_id")
            ->select("users.id", "users.email")
            ->selectRaw("COALESCE(user_profile.full_name, users.name) as displayName")
            ->selectRaw("CASE WHEN user_profile.user_id IS NULL THEN 0 ELSE 1 END as hasCompletedProfile")
            ->when($queryFilter, function ($query, $queryFilter) {
                $query->where(function ($searchQuery) use ($queryFilter) {
                    $searchQuery->where("user_profile.full_name", "like", "%{$queryFilter}%")
                        ->orWhere("users.name", "like", "%{$queryFilter}%");
                });
            })
            ->orderByDesc("users.id")
            ->paginate($perPage);

        return $users->withQueryString();
    }

    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfile::class, "user_id");
    }

    public function educationHistories(): HasMany
    {
        return $this->hasMany(UserEducationHistory::class, "user_id");
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class, "user_id");
    }

    public function userInterviewAnswer(): HasOne
    {
        return $this->hasOne(UserInterviewAnswer::class, "user_id");
    }
}
