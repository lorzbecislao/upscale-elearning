<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use App\Notifications\UserInviteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Str;

// or AdminController
class UserController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Users/Index', []);
    }

    public function getDataTable(Request $request)
    {
        $query = User::where('user_type', UserType::Admin()->value)
        ->where('deleted_at', null);
        // Apply search
        if ($request && $request->has('search')) {
            $query->where(function($query) use ($request) {
                $query->where('user_type', UserType::Admin()->value)
                      ->where(function($query) use ($request) {
                          $searchTerm = '%' . $request->input('search') . '%';
                          $query->where('name', 'like', $searchTerm)
                                ->orWhere('email', 'like', $searchTerm);
                      });
            });
        }

        if ($request && $request->has('sort_column') && $request->has('sort_direction')) {
            $query->orderBy($request->input('sort_column'), $request->input('sort_direction'));
        }


        $admins = $query->paginate(10);
        return $admins;
    }

    public function toggleStatus(User $user)
    {
        $user->toggleStatus();
        $header = 'User account set to inactive status';

        if ($user->status == 1) {
            $header = 'User account set to active status';
        }

        return redirect()->route('admin.users')->with([
            'success' => [
                'header' => $header,
                'message' => '',
            ]
        ]);
    }

    public function store(StoreAdminRequest $request)
    {
        DB::beginTransaction();

        $generated_password = Str::upper(Str::random(8));

        $admin_user = new User(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($generated_password),
                'status' => 1,
                'user_type' => UserType::Admin()->value,
            ]
        );
        $admin_user->save();

        if ($admin_user) {
            $admin_user->notify(new UserInviteNotification($admin_user, $generated_password));
        }


        DB::commit();

        return redirect()->route('admin.users')->with([
            'success' => [
                'header' => 'Admin account created successfully',
                'message' => 'An email has been sent to the provided email address',
            ]
        ]);
    }

    public function update($id, UpdateAdminRequest $request)
    {
        $data = $request->all();
        $user = User::find($id);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return redirect()->route('admin.users')->with([
            'success' => [
                'header' => 'Admin details updated successfully',
                'message' => '',
            ]
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.users')->with([
            'success' => [
                'header' => 'Admin account deleted successfully!',
                'message' => '',
            ]
        ]);
    }
}
