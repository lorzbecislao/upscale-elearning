<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\College;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CollegeProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citcs = College::create([
            'initial' => 'CITCS',
            'name' => 'College of Information and Computer Studies'
        ]);

        $bsit = new Program();
        $bsit->initial = 'BSIT';
        $bsit->name = 'Bacher of Science in Information Technology';
        $bsit->save();

        $bscs = new Program();
        $bscs->initial = 'BSCS';
        $bscs->name = 'Bacher of Science in Computer Science';
        $bscs->save();

        $act = new Program();
        $act->initial = 'ACT';
        $act->name = 'Associate in Computer Technology';
        $act->save();
        
        $student_user = new User(
            [
                'name' => 'Upscale Student',
                'email' => 'student@upscale.com',
                'password' => Hash::make('123'),
                'email_verified_at' => Carbon::now(),
                'status' => 1,
                'user_type' => UserType::Student()->value,
            ]
        );
        $student_user->save();

        $data['user_id'] = $student_user->id;
        $data['full_name'] = $student_user->name;
        $data['first_name'] = 'Upscale';
        $data['last_name'] = 'Student';
        $data['email'] = 'student@upscale.com';
        $data['student_number'] = 15116014;
        $data['program_id'] = $bsit->id;
        // Create student
        Student::create($data);


        $student_user1 = new User(
            [
                'name' => 'Lance Gonzales',
                'email' => 'lance@upscale.com',
                'password' => Hash::make('123'),
                'email_verified_at' => Carbon::now(),
                'status' => 1,
                'user_type' => UserType::Student()->value,
            ]
        );
        $student_user1->save();

        $data['user_id'] = $student_user1->id;
        $data['full_name'] = $student_user1->name;
        $data['first_name'] = 'Lance';
        $data['last_name'] = 'Gonzales';
        $data['email'] = 'lance@upscale.com';
        $data['student_number'] = 12345678;
        $data['program_id'] = $bsit->id;
        // Create student
        Student::create($data);
    }
}
