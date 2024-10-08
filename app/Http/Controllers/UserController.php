<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $date = today(); // Date du jour    
        // $ca = $agent->chiffreAffairesDuJour($date);
        $user = Auth::user();
        $services = Service::all();
        $roles = Role::all();
        $agents = User::limit(5)->orderByDesc('id')->get();

        if($user->is_admin){
            $agents = User::limit(5)->orderByDesc('id')->get();
        }
        return view('user.index', compact(['user', 'services', 'roles', 'agents']));
    }
    
    public function userContrat(User $user) {
        
        return view('user.index', compact('roles'));
    }


    public function chiffre_affaire(User $user) {
        
        return view('user.index', compact('roles'));
    }

    public function showRoles() {
        $roles = Role::all();
        if (request()->ajax()) {
            return response()->json($roles); 
        }
        return view('role.index', compact('roles'));
    }

    public function voirToutesActions()
    {
        $agentPrincipal = User::where('id', Auth::user()->id)->first();
        $subordinates = $agentPrincipal->tousLesSubordonnés()->get();

        // Récupérer les actions (contrats) de tous les subordonnés
        $actions = collect();

        foreach ($subordinates as $subordinate) {
            $actions = $actions->merge($subordinate->contrats);
        }

        return view('actions.index', compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email, 
            'code_unique' => $request->code_unique, 
            'role_id' => $request->role_id, 
            'telephone' => $request->telephone, 
            'domicile' => $request->domicile,
            'ifu' => $request->ifu,
            'compte_bancaire' => $request->compte_bancaire, 
            'service_id' => $request->service_id, 
            'supervisor_id' => $request->supervisor_id,
        ]);

        $service = Service::create([
            'nom' => $request->nom,
            'prenom' => $request->nom,
            'email'  => $request->nom, 
            'code_unique' => $request->nom, 
            'role_id' => $request->nom, 
            'telephone' => $request->nom, 
            'domicile' => $request->nom,
            // 'ifu',
            // 'compte_bancaire', 
            'service_id' => $request->nom, 
            // 'supervisor_id' => 'required'
        ]);

        flash()->success('Service créé avec succès');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function blocked(User $user)
    {
        //
    }

}
