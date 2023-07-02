<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = \Spatie\Permission\Models\Role::all();

        return view('user.index', compact(['users', 'roles']));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('admin.user.index');
    }
}
