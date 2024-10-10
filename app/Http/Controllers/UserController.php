<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Service;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $user = User::where('id', Auth::user()->id)->first();
        if($user->is_admin){
            $agents = User::limit(5)->orderByDesc('id')->get();
            $services = Service::all();
            $roles = Role::all();
            $agent_sup_id = Supervisor::select('supervisor_id')->distinct()->pluck('supervisor_id'); 
            $agent_sup = User::whereIn('id', $agent_sup_id)
                            ->orWhere('role_id', '<=', 5)
                            ->distinct()
                            ->get();
            
            // dd($agent_sup);
        }else{
            $services = Service::where('id', $user->service_id)->get();
            $roles = Role::where('service_id', $user->service_id)->get();
            // $agent_sup = $user->supervisors();
            $agent_sup_id = Supervisor::select('supervisor_id')->distinct()->pluck('supervisor_id');
            $agent_sup = User::whereIn('id', $agent_sup_id)
                            ->orwhere('role_id', '<=', $user->role_id)
                            ->distinct()
                            ->get();
            $subordinate_ids = Supervisor::where('supervisor_id', $user->id)->pluck('user_id');
            $agents = User::whereIn('id', $subordinate_ids)
                ->limit(5)->orderByDesc('id')->get();
            $agents[0]->supervo_id($user->id);
            dd($agents[0]->supervo_id($user->id));
        }
        return view('user.index', compact(['user', 'services', 'roles', 'agents', 'agent_sup']));
    }
    
    public function userContrat(User $user) {
        
        return view('user.index', compact('roles'));
    }


    public function chiffre_affaire(User $user) {
        
        return view('user.index', compact('roles'));
    }

    public function showRoles() {
        $user = Auth::user();
        $roles = Role::all();
        
        if (request()->ajax()) {
            if($user->is_admin){
                $roles = Role::where('service_id', $user->service_id)->get();
            }
            else{
                $roles = Role::all();
            }
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
            'nom' => 'required',
            'prenom' => 'required',
            'email'  => 'required', 
            'code_unique' => 'required', 
            'role_id' => 'required', 
            'telephone' => 'required', 
            'domicile' => 'required',
            // 'ifu' => 'required',
            // 'compte_bancaire' => 'required', 
            'service_id' => 'required', 
            // 'supervo_id' => 'required',
            'sexe' => 'required', 
            'mode_reglement' => 'required', 
            'date_naissance' => 'required',
            'lieu_naissance' => 'required', 
            // 'fixe', 
            'banque' => 'required', 
            'date_collaboration' => 'required',
        ]);

        // dd($request);
        $agent = User::create([
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
            'password' => Hash::make('12345678'),
            'sexe' => $request->sexe, 
            'mode_reglement' => $request->mode_reglement, 
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance, 
            // 'fixe', 
            'banque' => $request->banque, 
            'date_collaboration' => $request->date_collaboration,
        ]);

        if($request->supervo_id){
            foreach($request->supervo_id as $sup){
                Supervisor::create([
                    'supervisor_id' => $sup,
                    'user_id' => $agent->id,
                ]);
            }
        }

        flash()->success('Agent créé avec succès');

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
    public function update(Request $request, User $user)
    {
        $validation = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email'  => 'required', 
            // 'code_unique' => 'required', 
            'role_id' => 'required', 
            'telephone' => 'required', 
            'domicile' => 'required',
            // 'ifu' => 'required',
            // 'compte_bancaire' => 'required', 
            'service_id' => 'required', 
            // 'supervo_id' => 'required',
            'sexe' => 'required', 
            'mode_reglement' => 'required', 
            'date_naissance' => 'required',
            'lieu_naissance' => 'required', 
            // 'fixe', 
            'banque' => 'required', 
            'date_collaboration' => 'required',
        ]);

        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email, 
            // 'code_unique' => $request->code_unique, 
            'role_id' => $request->role_id, 
            'telephone' => $request->telephone, 
            'domicile' => $request->domicile,
            'ifu' => $request->ifu,
            'compte_bancaire' => $request->compte_bancaire, 
            'service_id' => $request->service_id, 
            'sexe' => $request->sexe, 
            'mode_reglement' => $request->mode_reglement, 
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance, 
            // 'fixe', 
            'banque' => $request->banque, 
            'date_collaboration' => $request->date_collaboration,
        ]);
        if($request->supervo_id){
            $supervos = $user->supervisors();
            foreach($supervos as $sup){
                $sup->delete();
            } 
            foreach($request->supervo_id as $sup){
                if(!$user->supervo_id($sup)){
                    Supervisor::create([
                        'supervisor_id' => $sup,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }

        flash()->success('Agent modifier avec succès');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        flash()->success('Agent supprimer avec succès');

        return back();
    }

    public function blocked(User $user)
    {
        if($user->is_blocked){

            $user->is_blocked = false;
            $user->save();

            flash()->success('Agent débloquer avec succès');

            return back();
        }
        $user->is_blocked = true;
        $user->save();

        flash()->success('Agent bloquer avec succès');

        return back();
    }

}
