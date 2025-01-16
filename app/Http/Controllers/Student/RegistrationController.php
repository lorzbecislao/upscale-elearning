<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
   public function signup(Request $request): RedirectResponse
   {
       $request->validate([
           'first_name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'student_number' => 'required|integer|digits:8',
           'program' => 'required|exists:programs,id',
           'email' => 'required|string|email|max:255|unique:'.User::class,
           'password' => ['required', 'confirmed', Rules\Password::defaults()],
       ]);

       $name = $request->first_name . ' ' . $request->last_name;

       $user = User::create([
           'name' => $name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'email_verified_at' => Carbon::now(),
           'user_type' => $request->user_type,
       ]);

       $data = $request->all();
       $data['user_id'] = $user->id;
       $data['full_name'] = $name;
       $data['program_id'] = $data['program'];

       // Create student
       Student::create($data);

       Auth::login($user);

       return redirect(route('dashboard'));
   }
}
