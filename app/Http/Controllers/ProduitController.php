<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $serviceId)
    {
        $user = Auth::user();
        $services = Service::where('remove', false)->get();

        if (request()->ajax()) {
            $produits = Produit::where('remove', false)->where('service_id', $serviceId)->get();
            $produits->transform(function($query){
                $query->service = Service::where('id', $query->service_id)->first();
                return $query;
            });
            return response()->json($produits); 
        }
        
        $produits = Produit::where('service_id', $serviceId)->get();
        return view('produit.index', compact(['user', 'services', 'produits']));
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
        $validation = Validator::make($request->all(), [
            'nom' => 'required',
            'service_id' => 'required',
        ]);

        if ($validation->fails()){
            if(!$request->service_id){
                flash()->warning('Selectionner le service');
            }
            $validation->validate($request, [
                'nom' => 'required',
                'service_id' => 'required',
            ]);
        }

        $produit = Produit::create([
            'nom' => $request->nom,
            'service_id' => $request->service_id
        ]);

        flash()->success('Produit créé avec succès');

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
    public function update(Request $request, Produit $produit)
    {
        $validation = Validator::make($request->all(), [
            'nom' => 'required',
            'service_id' => 'required',
        ]);
        if ($validation->fails()){
            $validation->validate($request, [
                'nom' => 'required',
                'service_id' => 'required',
            ]);
        }
        
        $produit->update([
            'nom' => $request->nom,
            'service_id' => $request->service_id
        ]);

        flash()->success('Produit modifié avec succès');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $produit->remove = true;
        $produit->save();

        flash()->success('Produit supprimer avec succès');

        return back();
    }
}
