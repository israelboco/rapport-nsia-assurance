<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
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

        $products = Produit::with('contrats')
                ->whereHas('contrats', function($query) {
                    $query->where('statut', 'à conclure')
                        ->groupBy('produit_id')  // Group by produit_id
                        ->selectRaw('produit_id, SUM(montant) as total_montant')
                        ->orderByDesc('total_montant');  // Order by the summed montant
                })
                ->limit(3)
                ->get();
        // dd($products);
        $total = Contrat::where('statut', 'à conclure')->count();
        // $total = $products->sum('contrats_count'); // Quantité totale des contrats à conclure

        $productPercentages = $products->map(function($product) use ($total) {
            $contractsCount = $product->contrats->count(); // Nombre de contrats pour le produit
            return [
                'name' => $product->nom,
                'percentage' => $total ? ($contractsCount / $total) * 100 : 0
            ];
        });

        $agent_count = User::count();
        $agent_id = User::pluck('id');
        $chiffre_affaire = Contrat::whereIn('user_id', $agent_id)
                            ->where('statut', 'à conclure')->sum('montant');
        $contrat_count = Contrat::whereIn('user_id', $agent_id)
                            ->where('statut', 'à conclure')->count();
        $contrat_encours = Contrat::whereIn('user_id', $agent_id)
                            ->where('statut', 'en cours')->sum('montant');
                            
        $chiffre_affaire_annuel = [];
        $month = [1, 2, 3, 4, 5, 6, 7, 8 , 9, 10, 11, 12];
        foreach($month as $i){
            $ca = Contrat::whereIn('user_id', $agent_id)
                            ->where('statut', 'à conclure')
                            ->whereYear('created_at', date('Y'))
                            ->whereMonth('created_at', $i)
                            ->sum('montant');
            array_push($chiffre_affaire_annuel, $ca);
        }       
        // dd($chiffre_affaire_annuel);
        return view('dashboard', compact(['user', 'productPercentages', 'chiffre_affaire', 'agent_count', 'contrat_count', 'contrat_encours', 'chiffre_affaire_annuel']));
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
