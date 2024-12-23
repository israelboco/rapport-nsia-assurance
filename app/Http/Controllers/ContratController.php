<?php

namespace App\Http\Controllers;

use App\Exports\ContratsExport;
use App\Models\Contrat;
use App\Models\Produit;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\ContratsImport;
use Maatwebsite\Excel\Facades\Excel;

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
                return $query->where('produit_code', 'LIKE', "%{$search}%")
                                ->orWhere('Police', 'LIKE', "%{$search}%")
                                ->orWhere('N_Quittance', 'LIKE', "%{$search}%");
            })->
            paginate(10);

        return view('contrat.index', compact(['user', 'contrats', 'produits', 'services', 'select_service', 'select_produit']));
    }


    public function detail(Request $request, Contrat $contrat)
    {
        $user = User::where('id', Auth::user()->id)->first();
    
        return view('contrat.detail', compact(['user', 'contrat']));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function info_holding(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $startDate = $request->input('startDate', now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('endDate', now()->endOfWeek()->format('Y-m-d'));
        // $data1 = Service::whereBetween('date', [$startDate, $endDate])->get();
        $services = Service::all();
        // $data2 = Prime::whereBetween('date_creation', [$startDate, $endDate])->get();
        $data2 = ['',''];
        $data3 = ['',''];
        // $data3 = Encaissement::whereBetween('date_creation', [$startDate, $endDate])->get();

        return view('contrat.info_holding', compact(['user', 'services', 'data2', 'data3', 'startDate', 'endDate']));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function prime_unique(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $startDate = $request->input('startDate', now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('endDate', now()->endOfWeek()->format('Y-m-d'));
        // $data1 = Service::whereBetween('date', [$startDate, $endDate])->get();
        $services = Service::all();
        // $data2 = Prime::whereBetween('date_creation', [$startDate, $endDate])->get();
        $data2 = ['',''];
        $data3 = ['',''];
        // $data3 = Encaissement::whereBetween('date_creation', [$startDate, $endDate])->get();

        return view('contrat.prime_unique', compact(['user', 'services', 'data2', 'data3', 'startDate', 'endDate']));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function cafv1(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $startDate = $request->input('startDate', now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('endDate', now()->endOfWeek()->format('Y-m-d'));
        // $data1 = Service::whereBetween('date', [$startDate, $endDate])->get();
        $services = Service::all();
        // $data2 = Prime::whereBetween('date_creation', [$startDate, $endDate])->get();
        $data2 = ['',''];
        $data3 = ['',''];
        // $data3 = Encaissement::whereBetween('date_creation', [$startDate, $endDate])->get();

        return view('contrat.ca_fv1', compact(['user', 'services', 'data2', 'data3', 'startDate', 'endDate']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function nbrs_contrat_fv(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $startDate = $request->input('startDate', now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('endDate', now()->endOfWeek()->format('Y-m-d'));
        // $data1 = Service::whereBetween('date', [$startDate, $endDate])->get();
        $services = Service::all();
        // $data2 = Prime::whereBetween('date_creation', [$startDate, $endDate])->get();
        $data2 = ['',''];
        $data3 = ['',''];
        // $data3 = Encaissement::whereBetween('date_creation', [$startDate, $endDate])->get();

        return view('contrat.nbr_contrat_fv1', compact(['user', 'services', 'data2', 'data3', 'startDate', 'endDate']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function qualite(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $startDate = $request->input('startDate', now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('endDate', now()->endOfWeek()->format('Y-m-d'));
        // $data1 = Service::whereBetween('date', [$startDate, $endDate])->get();
        $services = Service::all();
        // $data2 = Prime::whereBetween('date_creation', [$startDate, $endDate])->get();
        $data2 = ['',''];
        $data3 = ['',''];
        // $data3 = Encaissement::whereBetween('date_creation', [$startDate, $endDate])->get();

        return view('contrat.qualite', compact(['user', 'services', 'data2', 'data3', 'startDate', 'endDate']));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function impayes(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $startDate = $request->input('startDate', now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('endDate', now()->endOfWeek()->format('Y-m-d'));
        // $data1 = Service::whereBetween('date', [$startDate, $endDate])->get();
        $services = Service::all();
        // $data2 = Prime::whereBetween('date_creation', [$startDate, $endDate])->get();
        $data2 = ['',''];
        $data3 = ['',''];
        // $data3 = Encaissement::whereBetween('date_creation', [$startDate, $endDate])->get();

        return view('contrat.impayes', compact(['user', 'services', 'data2', 'data3', 'startDate', 'endDate']));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function performance(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $startDate = $request->input('startDate', now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('endDate', now()->endOfWeek()->format('Y-m-d'));
        // $data1 = Service::whereBetween('date', [$startDate, $endDate])->get();
        $services = Service::all();
        // $data2 = Prime::whereBetween('date_creation', [$startDate, $endDate])->get();
        $data2 = ['',''];
        $data3 = ['',''];
        // $data3 = Encaissement::whereBetween('date_creation', [$startDate, $endDate])->get();

        return view('contrat.performance', compact(['user', 'services', 'data2', 'data3', 'startDate', 'endDate']));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function suivi_detailles(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $startDate = $request->input('startDate', now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->input('endDate', now()->endOfWeek()->format('Y-m-d'));
        // $data1 = Service::whereBetween('date', [$startDate, $endDate])->get();
        $services = Service::all();
        // $data2 = Prime::whereBetween('date_creation', [$startDate, $endDate])->get();
        $data2 = ['',''];
        $data3 = ['',''];
        // $data3 = Encaissement::whereBetween('date_creation', [$startDate, $endDate])->get();

        return view('contrat.suivi_detailles', compact(['user', 'services', 'data2', 'data3', 'startDate', 'endDate']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
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
    public function update(Request $request)
    {
        
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

    public function import(Request $request){

        $validation = $request->validate([
            'fichier_excel' => 'required|file',
        ]);

        Excel::import(new ContratsImport, $request->file('fichier_excel'));

        flash()->success('Fichier excel importé avec succès');

        return back();
    }

    public function export() 
    {
        return Excel::download(new ContratsExport, 'contrats.xlsx');

        // flash()->success('Fichier excel exporté avec succès');

        // return back();
    }
}
