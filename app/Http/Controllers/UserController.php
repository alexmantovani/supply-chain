<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $company = Auth::user()->activeCompany;
        $users = $company->users;
        $roles = \Spatie\Permission\Models\Role::all();
        $warehouses = $company->warehouses;

        return view('user.index', compact(['users', 'roles', 'company', 'warehouses']));
    }

    public function destroy(User $user)
    {
        dd($user);
        $user->delete();

        return to_route('admin.user.index');
    }
}
