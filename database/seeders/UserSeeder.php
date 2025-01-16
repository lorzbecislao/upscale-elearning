<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_user = new User(
            [
                'name' => 'Upscale Administrator',
                'email' => 'admin@upscale.com',
                'password' => Hash::make('123'),
                'email_verified_at' => Carbon::now(),
                'status' => 1,
                'user_type' => UserType::Admin()->value,
            ]
        );
        $admin_user->save();
    }
}
