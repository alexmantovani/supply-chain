<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = \Spatie\Permission\Models\Role::all();

        $warehouse = Auth::user()->warehouse;

        return view('admin.users', compact(['users', 'roles', 'warehouse']));
    }
}
