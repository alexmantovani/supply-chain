<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInviteRequest;
use App\Http\Requests\UpdateInviteRequest;
use App\Mail\InviteCreated;
use App\Models\Invite;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company = Auth::user()->activeCompany;
        $warehouses = $company->warehouses;
        $roles = \Spatie\Permission\Models\Role::all();

        return view('invite.create', compact('warehouses', 'company', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInviteRequest $request)
    {
        // L'email può non essere unica perchè l'utente che invito potrebbe già
        // essere iscritto ed appartenere ad altre compagnie
        $request->validate([
            'warehouse_id' => ['required', 'integer', 'min:1'],
            'company_id' => ['required', 'integer', 'min:1'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ]);

// TODO: Verifico che la mail non sia già presente tra gli utenti


        do {
            $token = Str::uuid()->toString();
        } while (Invite::where('token', $token)->first());

        //create a new invite record
        $invite = Invite::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'token' => $token,
            'roles' => implode(",", $request->get('roles')),
            'company_id' => $request->get('company_id'),
            'warehouse_id' => $request->get('warehouse_id'),
        ]);

        // send the email
        Mail::to($request->get('email'))->send(new InviteCreated($invite));

        return to_route('user.index');

        // return redirect()->back()->with('status', $request->get('email') .' invited.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invite $invite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invite $invite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInviteRequest $request, Invite $invite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invite $invite)
    {
        //
    }

    public function accept(Invite $invite)
    {
        // Vado alla pagina di registrazione (semplificata)
        return view('invite.register', compact('invite'));
    }

    public function completed(Request $request, Invite $invite)
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $invite->name,
            'email' => $invite->email,
            'password' => Hash::make($data['password']),
        ]);

        // Lo asssocio alla compagnia e al magazzino
        $user->companies()->attach(
            $invite->company_id,
            [
                'is_active' => true,
                'roles' => $invite->roles,
                'warehouse_id' => $invite->warehouse_id,
            ]
        );

        // Faccio il login
        $userdata = array(
            'email' => $invite->email,
            'password' => $data['password'],
        );
        Auth::attempt($userdata); // attempt to do the login

        // Tolgo l'invito
        $invite->delete();

        // TODO: Mando una mail a chi ha fatto l'invito per dire che il nuovo utente ha accettato l'invito

        return to_route('warehouse.show', $invite->warehouse_id);
    }
}
