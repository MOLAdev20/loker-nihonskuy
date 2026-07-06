<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');
            DB::statement('ALTER TABLE user_profile RENAME TO user_profile_old');

            Schema::create('user_profile', function (Blueprint $table) {
                $table->id()->comment('ID data profile user');
                $table->foreignId('user_id')->constrained('users')->comment('Relasi ke tabel users');
                $table->string('profile_picture', 255)->nullable()->comment('Foto Profile atau Pas Foto (氏名)');
                $table->string('full_name', 255)->comment('Nama lengkap (氏名)');
                $table->string('furigana_name', 255)->comment('Nama lengkap dalam bahasa Jepang (フリガナ)');
                $table->date('birth_date')->comment('Tanggal lahir (生年月日)');
                $table->enum('gender', ['male', 'female'])->comment('Jenis kelamin (性別)');
                $table->integer('height')->unsigned()->comment('Tinggi badan');
                $table->integer('weight')->unsigned()->comment('berat badan');
                $table->enum('marital_status', ['single', 'married', 'divorce'])->comment('Status pernikahan (婚姻)');
                $table->string('nationality', 255)->comment('Kewarganegaraan (国籍)');
                $table->string('place_of_origin', 255)->comment('Tempat asal (出身地)');
                $table->text('current_address')->comment('Alamat sekarang (現住所)');
                $table->string('religion', 50)->comment('Agama (宗教)');
                $table->string('is_wearing_hijab', 255)->comment('Pakai hijab atau tidak (ヒジャブ)');
                $table->text('prayer_requirement')->comment('Kebutuhan waktu ibadah (お祈り)');
                $table->text('pork_tolerance')->comment('Skala toleransi babi');
                $table->text('alcohol_tolerance')->comment('Skala toleransi alkohol (飲酒への許容度)');
                $table->date('entry_date')->nullable()->comment('Tanggal masuk Jepang (入国日)');
                $table->date('visa_expiry_date')->nullable()->comment('Masa berlaku visa (在留カードの期限)');
                $table->string('current_visa_type', 255)->comment('Jenis visa saat ini (現在の在留資格)');
                $table->enum('jlpt_level', ['N1', 'N2', 'N3', 'N4', 'N5', 'none'])->comment('Level bahasa Jepang (日本語能力)');
                $table->string('has_driver_license', 255)->comment('Punya SIM atau tidak (運転免許有無)');
                $table->string('work_start_date', 255)->comment('Kapan siap mulai kerja (就労開始可能日)');
                $table->text('technical_experience')->comment('Detail pengalaman magang/skill (技能実習経験)');
                $table->timestamp('created_at')->useCurrent()->comment('Record data dibuat');
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('Record data diupdate');
                $table->text('summary')->nullable()->comment('Ringkasan profil');
                $table->text('reason_for_leaving')->nullable()->comment('Alasan pindah kerja');
                $table->text('additional_info')->nullable()->comment('Informasi tambahan');
                $table->text('jp_summary')->nullable()->comment('Ringkasan profil bahasa Jepang');
                $table->text('jp_reason_for_leaving')->nullable()->comment('Alasan pindah kerja bahasa Jepang');
                $table->text('jp_additional_info')->nullable()->comment('Informasi tambahan bahasa Jepang');
                $table->string('jikoshoukai')->nullable()->comment('Link video jikoshoukai');
            });

            DB::statement(
                'INSERT INTO user_profile (
                    id, user_id, profile_picture, full_name, furigana_name, birth_date, gender, height, weight,
                    marital_status, nationality, place_of_origin, current_address, religion, is_wearing_hijab,
                    prayer_requirement, pork_tolerance, alcohol_tolerance, entry_date, visa_expiry_date,
                    current_visa_type, jlpt_level, has_driver_license, work_start_date, technical_experience,
                    created_at, updated_at, summary, reason_for_leaving, additional_info, jp_summary,
                    jp_reason_for_leaving, jp_additional_info, jikoshoukai
                )
                SELECT
                    id, user_id, profile_picture, full_name, furigana_name, birth_date, gender, height, weight,
                    marital_status, nationality, place_of_origin, current_address, religion, is_wearing_hijab,
                    prayer_requirement, pork_tolerance, alcohol_tolerance, entry_date, visa_expiry_date,
                    current_visa_type, jlpt_level, has_driver_license, work_start_date, technical_experience,
                    created_at, updated_at, summary, reason_for_leaving, additional_info, jp_summary,
                    jp_reason_for_leaving, jp_additional_info, jikoshoukai
                FROM user_profile_old'
            );

            DB::statement('DROP TABLE user_profile_old');
            DB::statement('PRAGMA foreign_keys=ON');

            return;
        }

        DB::statement("ALTER TABLE user_profile MODIFY work_start_date VARCHAR(255) NOT NULL COMMENT 'Kapan siap mulai kerja (就労開始可能日)'");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');
            DB::statement('ALTER TABLE user_profile RENAME TO user_profile_old');

            Schema::create('user_profile', function (Blueprint $table) {
                $table->id()->comment('ID data profile user');
                $table->foreignId('user_id')->constrained('users')->comment('Relasi ke tabel users');
                $table->string('profile_picture', 255)->nullable()->comment('Foto Profile atau Pas Foto (氏名)');
                $table->string('full_name', 255)->comment('Nama lengkap (氏名)');
                $table->string('furigana_name', 255)->comment('Nama lengkap dalam bahasa Jepang (フリガナ)');
                $table->date('birth_date')->comment('Tanggal lahir (生年月日)');
                $table->enum('gender', ['male', 'female'])->comment('Jenis kelamin (性別)');
                $table->integer('height')->unsigned()->comment('Tinggi badan');
                $table->integer('weight')->unsigned()->comment('berat badan');
                $table->enum('marital_status', ['single', 'married', 'divorce'])->comment('Status pernikahan (婚姻)');
                $table->string('nationality', 255)->comment('Kewarganegaraan (国籍)');
                $table->string('place_of_origin', 255)->comment('Tempat asal (出身地)');
                $table->text('current_address')->comment('Alamat sekarang (現住所)');
                $table->string('religion', 50)->comment('Agama (宗教)');
                $table->string('is_wearing_hijab', 255)->comment('Pakai hijab atau tidak (ヒジャブ)');
                $table->text('prayer_requirement')->comment('Kebutuhan waktu ibadah (お祈り)');
                $table->text('pork_tolerance')->comment('Skala toleransi babi');
                $table->text('alcohol_tolerance')->comment('Skala toleransi alkohol (飲酒への許容度)');
                $table->date('entry_date')->nullable()->comment('Tanggal masuk Jepang (入国日)');
                $table->date('visa_expiry_date')->nullable()->comment('Masa berlaku visa (在留カードの期限)');
                $table->string('current_visa_type', 255)->comment('Jenis visa saat ini (現在の在留資格)');
                $table->enum('jlpt_level', ['N1', 'N2', 'N3', 'N4', 'N5', 'none'])->comment('Level bahasa Jepang (日本語能力)');
                $table->string('has_driver_license', 255)->comment('Punya SIM atau tidak (運転免許有無)');
                $table->date('work_start_date')->comment('Kapan siap mulai kerja (就労開始可能日)');
                $table->text('technical_experience')->comment('Detail pengalaman magang/skill (技能実習経験)');
                $table->timestamp('created_at')->useCurrent()->comment('Record data dibuat');
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('Record data diupdate');
                $table->text('summary')->nullable()->comment('Ringkasan profil');
                $table->text('reason_for_leaving')->nullable()->comment('Alasan pindah kerja');
                $table->text('additional_info')->nullable()->comment('Informasi tambahan');
                $table->text('jp_summary')->nullable()->comment('Ringkasan profil bahasa Jepang');
                $table->text('jp_reason_for_leaving')->nullable()->comment('Alasan pindah kerja bahasa Jepang');
                $table->text('jp_additional_info')->nullable()->comment('Informasi tambahan bahasa Jepang');
                $table->string('jikoshoukai')->nullable()->comment('Link video jikoshoukai');
            });

            DB::statement(
                'INSERT INTO user_profile (
                    id, user_id, profile_picture, full_name, furigana_name, birth_date, gender, height, weight,
                    marital_status, nationality, place_of_origin, current_address, religion, is_wearing_hijab,
                    prayer_requirement, pork_tolerance, alcohol_tolerance, entry_date, visa_expiry_date,
                    current_visa_type, jlpt_level, has_driver_license, work_start_date, technical_experience,
                    created_at, updated_at, summary, reason_for_leaving, additional_info, jp_summary,
                    jp_reason_for_leaving, jp_additional_info, jikoshoukai
                )
                SELECT
                    id, user_id, profile_picture, full_name, furigana_name, birth_date, gender, height, weight,
                    marital_status, nationality, place_of_origin, current_address, religion, is_wearing_hijab,
                    prayer_requirement, pork_tolerance, alcohol_tolerance, entry_date, visa_expiry_date,
                    current_visa_type, jlpt_level, has_driver_license, work_start_date, technical_experience,
                    created_at, updated_at, summary, reason_for_leaving, additional_info, jp_summary,
                    jp_reason_for_leaving, jp_additional_info, jikoshoukai
                FROM user_profile_old'
            );

            DB::statement('DROP TABLE user_profile_old');
            DB::statement('PRAGMA foreign_keys=ON');

            return;
        }

        DB::statement("ALTER TABLE user_profile MODIFY work_start_date DATE NOT NULL COMMENT 'Kapan siap mulai kerja (就労開始可能日)'");
    }
};
