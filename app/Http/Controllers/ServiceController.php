<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $services = Service::where('remove', false)->get();
        return view('service.index', compact(['user', 'services']));
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
        ]);
        if ($validation->fails()){
            $validation->validate($request, [
                'nom' => 'required',
            ]) ;
        }

        $service = Service::create([
            'nom' => $request->nom
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
    public function update(Request $request, Service $service)
    {
        $validation = Validator::make($request->all(), [
            'nom' => 'required',
        ]);

        if ($validation->fails()){
            $validation->validate($request, [
                'nom' => 'required',
            ]) ;
        }

        $service->nom = $request->nom;
        $service->save();

        flash()->success('Service modifié avec succès');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->remove = true;
        $service->save();

        flash()->success('Service supprimer avec succès');

        return back();
    }
}
