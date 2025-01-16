<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $userData = $user ? $user->toArray() : null;

        // Load the student relationship if the user_type_id is 2
        if ($user && $user->user_type == 2) {
            $user->load('student');  // Eager load the student data
            $userData['student'] = $user->student;
        }

        if (($user && $user->user_type == 1) || ($user && $userData['student']['forum_status'] == 2)) {
            $userData['forum_full_access'] = true;
        } else {
            $userData['forum_full_access'] = false;
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $userData,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => function () {
                return [
                    'success' => Session::get('success'),
                    'error' => Session::get('error'),
                    'warning' => Session::get('warning'),
                    'info' => Session::get('info'),
                ];
            },
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object)[];
            },
        ]);
    }
}
