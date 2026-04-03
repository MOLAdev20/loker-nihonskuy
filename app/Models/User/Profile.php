<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "profile";
    protected $fillable = [
        'account_id',
        'furigana',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_pernikahan',
        'kewarganegaraan',
        'tempat_asal',
        'alamat_sekarang',
        'agama',
        'hijab',
        'salat',
        'toleransi_babi',
        'toleransi_alkohol',
        'tanggal_masuk_jepang',
        'status_izin_tinggal',
        'masa_berlaku_kartu',
        'tanggal_mulai_kerja',
        'kemampuan_bahasa',
        'ujian_keterampilan',
        'kepemilikan_sim',
    ];

    protected function casts(): array
    {
        return [
            "tanggal_lahir" => "date",
            "tanggal_masuk_jepang" => "date",
            "masa_berlaku_kartu" => "date",
            "tanggal_mulai_kerja" => "date",
        ];
    }
}
