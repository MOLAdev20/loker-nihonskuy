<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create("id_ID");
        $hashedPassword = Hash::make("Admin@1234");
        $timestamp = now();
        $users = [];

        foreach (range(1, 50) as $index) {
            $fullName = $faker->name();
            $emailPrefix = Str::slug($fullName, ".");

            if ($emailPrefix === "") {
                $emailPrefix = "user";
            }

            $users[] = [
                "name" => $fullName,
                "email" => "{$emailPrefix}.{$index}@example.com",
                "email_verified_at" => $timestamp,
                "password" => $hashedPassword,
                "remember_token" => Str::random(10),
                "created_at" => $timestamp,
                "updated_at" => $timestamp,
            ];
        }

        User::insert($users);
    }
}
