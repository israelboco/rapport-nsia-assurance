<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $serviceId)
    {
        $user = Auth::user();
        $services = Service::all();

        if (request()->ajax()) {
            $roles = Role::where('service_id', $serviceId)->get();
            $roles->transform(function($query){
                $query->service = Service::where('id', $query->service_id)->first();
                return $query;
            });
            return response()->json($roles); 
        }
        
        $roles = Role::where('service_id', $serviceId)->get();
        return view('role.index', compact(['user', 'services', 'roles']));
    }

    public function showServices() {
        $services = Service::all();
        $selectedService = Service::find(session('selected_service_id'));
        if (request()->ajax()) {
            return response()->json($services); 
        }
        return view('role.index', compact('services', 'selectedService'));
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
            'niveau' => 'required',
            'service_id' => 'required',
        ]);

        if ($validation->fails()){
            if(!$request->service_id){
                flash()->warning('Selectionner le service');
            }
            $validation->validate($request, [
                'nom' => 'required',
                'niveau' => 'required',
                'service_id' => 'required',
            ]);
        }

        $niveau = $request->niveau;
        $exist = Role::where('niveau', $request->niveau)->first();
        if($exist){
            $actuel = Role::count();
            $exist->niveau = $actuel + 1;
            $exist->save();
        }
        $role = Role::create([
            'nom' => $request->nom,
            'niveau' => $niveau,
            'service_id' => $request->service_id
        ]);

        flash()->success('Role créé avec succès');

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
    public function update(Request $request, Role $role)
    {
        $validation = Validator::make($request->all(), [
            'nom' => 'required',
            'niveau' => 'required',
            'service_id' => 'required',
        ]);
        if ($validation->fails()){
            $validation->validate($request, [
                'nom' => 'required',
                'niveau' => 'required',
                'service_id' => 'required',
            ]);
        }


        $niveau = $request->niveau;
        $exist = Role::where('niveau', $request->niveau)->first();
        if($exist && $exist->id != $role->id){
            $exist->niveau = $role->niveau;
            $exist->save();
        }
        $role->update([
            'nom' => $request->nom,
            'niveau' => $niveau,
            'service_id' => $request->service_id
        ]);

        flash()->success('Role modifier avec succès');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        flash()->success('Role supprimer avec succès');

        return back();
    }
}
