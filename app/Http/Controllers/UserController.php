<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return $user;
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());
        return $user;
    }

    public function destroy(User $user)
    {
        return response()->json(['error' => "Forbidden"], 403);
    }
}
