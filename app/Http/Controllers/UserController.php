<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = today(); // Date du jour    
        // $ca = $agent->chiffreAffairesDuJour($date);
    
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
}
