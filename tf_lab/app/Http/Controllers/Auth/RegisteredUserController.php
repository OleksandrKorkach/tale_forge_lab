<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\book\BookList;
use App\Models\user\User;
use App\Models\user\UserRoles;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole(UserRoles::ROLE_USER);


        event(new Registered($user));

        Auth::login($user);

        BookList::create([
            'name' => 'readlist',
            'description' => 'readlist',
            'type' => 'readlist',
            'user_id' => $user->id,
        ]);

        BookList::create([
            'name' => 'favorite',
            'description' => 'favorite',
            'type' => 'favorite',
            'user_id' => $user->id,
        ]);

        return redirect(route('main', absolute: false));
    }
}
