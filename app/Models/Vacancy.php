<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Vacancy extends Model
{
    protected $table = 'vacancies';

    protected $fillable = [
        'job_code',
        'title',
        'visa_type',
        'placement',
        'placement_branch',
        'job_type',
        'source',
        'salary',
        'whatsapp_number',
        'gender_requirement',
        'domicile_requirement',
        'qty',
        'benefit',
        'tags',
        'additional_information',
        'thumbnail_path',
        'expired_at',
        'status'
    ];

    // Assesor
    public function getDaysLeftAttribute()
    {
        $expired = Carbon::parse($this->expired_at)->startOfDay();
        return Carbon::today()->diffInDays($expired, false);
    }

    // Assesor
    public function getGenderAttribute()
    {
        return [
            'l' => 'Laki-laki',
            'p' => 'Perempuan',
            'a' => 'Laki-laki & Perempuan',
        ][$this->gender_requirement];
    }

    // Assesor
    public function getDomicileAttribute()
    {
        $domicileLabels = [
            'kokunai' => 'Khusus Jepang',
            'kokugai' => 'Bebas (Di Luar Jepang)',
            'kokunai-to-kokugai' => 'Domisili Bebas',
        ];

        return $domicileLabels[$this->domicile_requirement] ?? 'Tidak ditentukan';
    }

    // Assesor
    public function getBenefitAndFacilityAttribute()
    {
        return $this->benefit ? array_filter(explode('|', $this->benefit)) : [];
    }

    public function getTagListAttribute(): array
    {
        return $this->tags ? array_values(array_filter(explode('|', $this->tags))) : [];
    }

    // Assesor additional information
    public function getAdditionalInformationDeltaAttribute()
    {
        $additionalInformationRaw = $this->additional_information;
        $additionalInformationDelta = null;

        if (is_string($additionalInformationRaw)) {
            $decoded = json_decode($additionalInformationRaw, true);

            if (is_array($decoded) && isset($decoded['ops']) && is_array($decoded['ops'])) {
                $additionalInformationDelta = $decoded;
            }
        }

        return $additionalInformationDelta;
    }

    public function getSalaryRangeAttribute()
    {
        $salary = explode('-', $this->salary);

        $salaryRange = "¥" . number_format($salary[0]);
        if (!empty($salary[1])) {
            $salaryRange .= " - ¥" . number_format($salary[1]);
        }

        return $salaryRange;
    }

    public function scopeWithTag(Builder $query, string $tag): Builder
    {
        return $query->where(function (Builder $builder) use ($tag) {
            $builder->where('tags', $tag)
                ->orWhere('tags', 'like', $tag . '|%')
                ->orWhere('tags', 'like', '%|' . $tag . '|%')
                ->orWhere('tags', 'like', '%|' . $tag);
        });
    }
}
