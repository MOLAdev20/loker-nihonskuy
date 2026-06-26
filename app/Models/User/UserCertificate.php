<?php

namespace App\Models\User;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UserCertificate extends Model
{
    use HasFactory;

    protected $table = 'user_certificate';

    protected $fillable = [
        'user_id',
        'certificate_type',
        'file',
    ];

    public static function certificateTypes(): array
    {
        return [
            'n5' => 'N5',
            'n4' => 'N4',
            'n3' => 'N3',
            'n2' => 'N2',
            'n1' => 'N1',
            'ssw_pengolahan_makanan' => 'SSW Pengolahan Makanan',
            'ssw_pertanian' => 'SSW Pertanian',
            'ssw_kaigo_perawat_lansia' => 'SSW Kaigo/Perawat Lansia',
        ];
    }

    public static function certificateTypeLabel(?string $type): string
    {
        return static::certificateTypes()[$type] ?? ucfirst((string) $type);
    }

    public function getCertificateTypeLabelAttribute(): string
    {
        return static::certificateTypeLabel($this->certificate_type);
    }

    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
