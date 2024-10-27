<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Deal;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $products = Produit::where('remove', false)->with('deals')
                ->whereHas('deals', function($query) {
                    $query->where('statut', 'à conclure')
                        ->groupBy('produit_id')  // Group by produit_id
                        ->selectRaw('produit_id, SUM(montant) as total_montant')
                        ->orderByDesc('total_montant');  // Order by the summed montant
                })
                ->limit(3)
                ->get();
                
        $total = Deal::where('statut', 'à conclure')->count();
        // $total = $products->sum('contrats_count'); // Quantité totale des contrats à conclure

        $productPercentages = $products->map(function($product) use ($total) {
            $dealsCount = $product->deals->count(); // Nombre de contrats pour le produit
            return [
                'name' => $product->nom,
                'percentage' => $total ? ($dealsCount / $total) * 100 : 0
            ];
        });

        $agent_count = User::where('remove', false)->count();
        $agent_id = User::where('remove', false)->pluck('id');
        $chiffre_affaire = Deal::whereIn('user_id', $agent_id)
                            ->where('remove', false)
                            ->where('statut', 'à conclure')->sum('montant');
        $deal_count = Deal::whereIn('user_id', $agent_id)
                            ->where('remove', false)
                            ->where('statut', 'à conclure')->count();
        $deal_encours = Deal::whereIn('user_id', $agent_id)
                            ->where('statut', 'en cours')->sum('montant');
                            
        $chiffre_affaire_annuel = [];
        $chiffre_affaire_contrat_annuel = [];
        $month = [1, 2, 3, 4, 5, 6, 7, 8 , 9, 10, 11, 12];
        foreach($month as $i){
            $ca = Deal::whereIn('user_id', $agent_id)
                            ->where('remove', false)
                            ->where('statut', 'à conclure')
                            ->whereYear('created_at', date('Y'))
                            ->whereMonth('created_at', $i)
                            ->sum('montant');
            $ca_contrat = Contrat::whereYear('Date_Creation', date('Y'))
                            ->whereMonth('Date_Creation', $i)
                            ->sum('solde');
            array_push($chiffre_affaire_annuel, $ca);
            array_push($chiffre_affaire_contrat_annuel, $ca_contrat);
        }       
        return view('dashboard', compact(['user', 'productPercentages', 'chiffre_affaire', 'agent_count', 'deal_count', 'deal_encours', 'chiffre_affaire_annuel', 'chiffre_affaire_contrat_annuel']));
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
        //
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
    public function destroy(string $id)
    {
        //
    }

    public function voirActions(User $agent)
    {
        $currentAgent = User::where('id', Auth::user()->id)->first();

        if ($currentAgent->peutVoir($agent)) {
            // Afficher les actions de l'agent
        } else {
            abort(403, 'Accès refusé');
        }
    }
    
}
