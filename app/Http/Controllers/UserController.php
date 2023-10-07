<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Warehouse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = \Spatie\Permission\Models\Role::all();

        $warehouse = Warehouse::find($_COOKIE['warehouse_id']);

        return view('admin.users', compact(['users', 'roles', 'warehouse']));
    }
}
