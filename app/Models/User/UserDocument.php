<?php

namespace App\Models\User;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UserDocument extends Model
{
    use HasFactory;

    protected $table = 'user_document';

    protected $fillable = [
        'user_id',
        'file_type',
        'file',
    ];

    public static function fileTypes(): array
    {
        return [
            'ktp' => 'KTP',
            'kk' => 'KK',
            'akte_kelahiran' => 'Akte Kelahiran',
        ];
    }

    public static function fileTypeLabel(?string $type): string
    {
        return static::fileTypes()[$type] ?? ucfirst((string) $type);
    }

    public function getFileTypeLabelAttribute(): string
    {
        return static::fileTypeLabel($this->file_type);
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
