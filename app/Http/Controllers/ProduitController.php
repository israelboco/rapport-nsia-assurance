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
    public function index()
    {
        $user = Auth::user();

        if (request()->ajax()) {
            $produits = Produit::where('remove', false)->paginate(10);
            return response()->json($produits); 
        }
        
        $produits = Produit::paginate(10);
        return view('produit.index', compact(['user', 'produits']));
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
            'code_unique' => 'required',
            // 'description' => 'required',
        ]);

        if ($validation->fails()){
            $validation->validate($request, [
                'nom' => 'required',
                'code_unique' => 'required',
            ]);
        }

        $produit = Produit::create([
            'nom' => $request->nom,
            'code_unique' => $request->code_unique,
            'description' => $request->description,
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
            'code_unique' => 'required',
        ]);
        if ($validation->fails()){
            $validation->validate($request, [
                'nom' => 'required',
                'code_unique' => 'required',
            ]);
        }
        
        $produit->update([
            'nom' => $request->nom,
            'code_unique' => $request->code_unique,
            'description' => $request->description,
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
