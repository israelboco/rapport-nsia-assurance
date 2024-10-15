<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Produit;
use App\Models\Role;
use App\Models\Service;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role_id = $request->query('role_id');
        $service_id = $request->query('service_id');
        if ((!Auth::user()->is_admin) && isset($service_id) && (Auth::user()->service_id != $service_id)) {
            return back()->with('error', 'Accès non autorisé.');
        }
        $statut = $request->query('statut');
        $date = $request->query('date');
        $user = User::where('id', Auth::user()->id)->first();
        $select_service = Service::where('id', $service_id)->first();
        $select_role = Role::where('id', $role_id)->first();
        if($user->is_admin){
            $services = Service::where('remove', false)->get();
            $roles = Role::when($service_id, function ($query) use ($service_id) {
                return $query->where('service_id', $service_id);
            })->where('remove', false)->get(); 
            $produits = Produit::where('remove', false)->get();
            $agent_ids = User::where('remove', false)
                ->when($service_id, function ($query) use ($service_id) {
                return $query->where('service_id', $service_id);
                })
                ->when($role_id, function ($query) use ($role_id) {
                    return $query->where('role_id', $role_id);
                })
                ->when($date, function ($query) use ($date) {
                    return $query->where('created_at', $date);
                })
                ->pluck('id');
            
        }else{
            $services = Service::where('id', $user->service_id)->get();
            $roles = Role::where('service_id', $user->service_id)
                        ->where('remove', false)
                        ->when($service_id, function ($query) use ($service_id) {
                            return $query->where('service_id', $service_id);
                        })->get();
            $produits = Produit::where('service_id', $user->service_id)->get();
            $subordinate_ids = Supervisor::where('supervisor_id', $user->id)->pluck('user_id');
            $agent_ids = User::whereIn('id', $subordinate_ids)
                            ->where('remove', false)
                            ->when($service_id, function ($query) use ($service_id) {
                            return $query->where('service_id', $service_id);
                            })
                            ->when($role_id, function ($query) use ($role_id) {
                                return $query->where('role_id', $role_id);
                            })
                            ->when($date, function ($query) use ($date) {
                                return $query->where('created_at', $date);
                            })
                            ->pluck('id');
        }

        $contrats = Contrat::where('remove', false)->whereIn('user_id', $agent_ids)->paginate(10);

        return view('contrat.index', compact(['user', 'contrats', 'produits', 'services', 'roles', 'select_service', 'select_role', 'statut', 'date']));
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
            // 'user_id' => 'required',
            // 'nature' => 'required',
            'produit_id' => 'required',
            'montant'  => 'required',
            'prospect_nom' => 'required',
            'prospect_prenom'  => 'required',
            'prospect_telephone' => 'required',
            'prospect_email' => 'required',
            'lieu_signature' => 'required',
            'statut' => 'required',
            // 'date_conclusion' => 'required',
        ]);

        $contrat = Contrat::create([
            'user_id' => Auth::user()->id,
            'nature' => $request->nature,
            'produit_id' => $request->produit_id,
            'montant' => $request->montant,
            'prospect_nom' => $request->prospect_nom,
            'prospect_prenom' => $request->prospect_prenom,
            'prospect_telephone' => $request->prospect_telephone,
            'prospect_email' => $request->prospect_email,
            'lieu_signature' => $request->lieu_signature,
            'statut' => $request->statut,
            'date_conclusion' => $request->date_conclusion,
        ]);

        flash()->success('Contrat créé avec succès');

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
    public function update(Request $request, Contrat $contrat)
    {
        $validation = $request->validate([
            // 'user_id' => 'required',
            // 'nature' => 'required',
            'produit_id' => 'required',
            'montant'  => 'required',
            'prospect_nom' => 'required',
            'prospect_prenom'  => 'required',
            'prospect_telephone' => 'required',
            'prospect_email' => 'required',
            'lieu_signature' => 'required',
            'statut' => 'required',
        ]);

        $contrat->update([
            'user_id' => Auth::user()->id,
            'nature' => $request->nature,
            'produit_id' => $request->produit_id,
            'montant' => $request->montant,
            'prospect_nom' => $request->prospect_nom,
            'prospect_prenom' => $request->prospect_prenom,
            'prospect_telephone' => $request->prospect_telephone,
            'prospect_email' => $request->prospect_email,
            'lieu_signature' => $request->lieu_signature,
            'statut' => $request->statut,
            'date_conclusion' => $request->date_conclusion,
        ]);

        flash()->success('Contrat modifié avec succès');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contrat $contrat)
    {
        $contrat->remove = true;
        $contrat->save();

        flash()->success('Contrat supprimer avec succès');

        return back();
    }
}
