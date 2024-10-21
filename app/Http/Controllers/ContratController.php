<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Produit;
use App\Models\Service;
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
        $produit_id = $request->query('produit_id');
        $service_id = $request->query('service_id');
        $search = $request->query('search');
        $date = $request->query('date');
        $user = User::where('id', Auth::user()->id)->first();
        $select_produit = Produit::where('id', $produit_id)->first();
        $select_service = Service::where('id', $service_id)->first();

        $services = Service::where('remove', false)->get();
        $produits = Produit::where('remove', false)->get();
       
        $contrats = Contrat::when($service_id, function ($query) use ($service_id) {
            return $query->where('service_id', $service_id);
            })->
            when($produit_id, function ($query) use ($produit_id) {
                return $query->where('produit_id', $produit_id);
                })->
            when($search, function ($query, $search) {
                return $query->where('Produit', 'LIKE', "%{$search}%")
                                ->orWhere('Police', 'LIKE', "%{$search}%")
                                ->orWhere('N_Quittance', 'LIKE', "%{$search}%");
            })->
            paginate(10);

        return view('contrat.index', compact(['user', 'contrats', 'produits', 'services', 'select_service', 'select_produit']));
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

        $deal = Deal::create([
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

        flash()->success('Deal créé avec succès');

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
    public function update(Request $request, Deal $deal)
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

        $deal->update([
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

        flash()->success('Deal modifié avec succès');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        $deal->remove = true;
        $deal->save();

        flash()->success('Deal supprimer avec succès');

        return back();
    }
}
