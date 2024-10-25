<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Role;
use App\Models\Service;
use App\Models\Produit;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Imports\UserSupImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role_id = $request->query('role_id');
        $service_id = $request->query('service_id');
        $search = $request->query('search');
        if ((!Auth::user()->is_admin) && isset($service_id) && (Auth::user()->service_id != $service_id)) {
            return back()->with('error', 'Accès non autorisé.');
        }
        $user = User::where('id', Auth::user()->id)->first();
        $select_service = Service::where('id', $service_id)->first();
        $select_role = Role::where('id', $role_id)->first();
        if($user->is_admin){
            $services = Service::where('remove', false)->get();
            $roles = Role::where('remove', false)
                    ->when($service_id, function ($query) use ($service_id) {
                        return $query->where('service_id', $service_id);
                    })->get(); 
            $agent_sup_id = Supervisor::select('supervisor_id')->distinct()->pluck('supervisor_id'); 
            $agent_sup = User::whereIn('id', $agent_sup_id)
                            ->where('remove', false)
                            ->orWhere('role_id', '<=', 5)
                            ->distinct()
                            ->get();
            
            $agents = User::where('remove', false)
                        ->when($service_id, function ($query) use ($service_id) {
                            return $query->where('service_id', $service_id);
                        })
                        ->when($role_id, function ($query) use ($role_id) {
                            return $query->where('role_id', $role_id);
                        })
                        ->when($search, function ($query) use ($search) {
                            return $query->where(function ($query) use ($search) {
                                $search = strtolower($search);
                                return $query->where(DB::raw('lower(nom)'), 'like', "%$search%")
                                    ->orWhere(DB::raw('lower(prenom)'), 'like', "%$search%")
                                    ->orWhere(DB::raw('lower(domicile)'), 'like', "%$search%");
                                    // ->orWhere(DB::raw('lower(equipements)'), 'like', "%$search%");
                            });
                        })
                        ->orderByDesc('id')->paginate(10);
        
            $agents->getCollection()->transform(function($query){
                $query->supervo_ids = Supervisor::where('user_id', $query->id)->pluck('supervisor_id');
                return $query;
            });
        }else{
            $services = Service::where('id', $user->service_id)->get();
            $roles = Role::where('remove', false)->where('service_id', $user->service_id)
                        ->when($service_id, function ($query) use ($service_id) {
                                return $query->where('service_id', $service_id);
                            })->get();
            $agent_sup_id = Supervisor::select('supervisor_id')->distinct()->pluck('supervisor_id');
            $agent_sup = User::whereIn('id', $agent_sup_id)
                            ->where('remove', false)
                            ->orwhere('role_id', '<=', $user->role_id)
                            ->distinct()
                            ->get();

            $subordinate_ids = Supervisor::where('supervisor_id', $user->id)->pluck('user_id');
            $agents = User::whereIn('id', $subordinate_ids)
                            ->where('remove', false)
                            ->when($service_id, function ($query) use ($service_id) {
                                return $query->where('service_id', $service_id);
                            })
                            ->when($role_id, function ($query) use ($role_id) {
                                return $query->where('role_id', $role_id);
                            })
                            ->when($search, function ($query) use ($search) {
                                return $query->where(function ($query) use ($search) {
                                    $search = strtolower($search);
                                    return $query->where(DB::raw('lower(nom)'), 'like', "%$search%")
                                        ->orWhere(DB::raw('lower(prenom)'), 'like', "%$search%")
                                        ->orWhere(DB::raw('lower(domicile)'), 'like', "%$search%");
                                        // ->orWhere(DB::raw('lower(equipements)'), 'like', "%$search%");
                                });
                            })
                        ->orderByDesc('id')->paginate(10);

            $agents->getCollection()->transform(function($query){
                $query->supervo_ids = Supervisor::where('user_id', $query->id)->pluck('supervisor_id');
                return $query;
            });
        }
        return view('user.index', compact(['user', 'services', 'roles', 'agents', 'agent_sup', 'select_service', 'select_role']));
    }
    
    public function userDeal(User $user) {
        $profile = $user;
        if (!Auth::user()->is_admin && Auth::user()->id != $profile->id) {
            $subordinates_id = Supervisor::where('supervisor_id', Auth::user()->id)->pluck('user_id');
                if(!in_array(Auth::user()->id, $subordinates_id->toArray()))
                    return back()->with('error', 'Accès non autorisé.');
        }
        if($user->is_amdin){
            $produits = Produit::where('remove', false)->get();
        }
        {
            $produits = Produit::where('service_id', $user->service->id)
                        ->where('remove', false)->get();
        }
        $user = User::where('id', Auth::user()->id)->first();
        $deals = Deal::where('remove', false)->where('user_id', $profile->id)->paginate(10);
        return view('user.deal', compact('profile', 'user', 'deals', 'produits'));
    }


    public function profile(User $user) {
        $profile = $user;
        if ((!Auth::user()->is_admin) && (Auth::user()->id != $profile->id)) {
            $subordinates_id = Supervisor::where('supervisor_id', Auth::user()->id)->pluck('user_id');
                if(!in_array(Auth::user()->id, $subordinates_id->toArray()))
                    return back()->with('error', 'Accès non autorisé.');
        }
        $user = User::where('id', Auth::user()->id)->first();
        $chiffre_affaire = $profile->chiffreAffaires();
        $subordinates_count = Supervisor::where('supervisor_id', $profile->id)->count();
        $subordinates_id = Supervisor::where('supervisor_id', $profile->id)->pluck('user_id');
        $total_user_service_id = User::where('remove', false)->where('service_id', $profile->service_id)->pluck('id');
        $total_deal = Deal::where('remove', false)->whereIn('user_id', $total_user_service_id)->count();
        // $total_contrat = Contrat::whereIn('user_id', $total_user_service_id)->count();
        $deal_encours = Deal::whereIn('user_id', $subordinates_id)->where('statut', 'en cours')->count();

        $pourcental_deal = isset($total_deal) ? ($profile->deals()->count() / $total_deal) * 100 : 0;

        $agent_sup_id = Supervisor::select('supervisor_id')->distinct()->pluck('supervisor_id');
            $agent_sup = User::whereIn('id', $agent_sup_id)
                            ->where('remove', false)
                            ->orwhere('role_id', '<=', $profile->role_id)
                            ->distinct()
                            ->get();
        return view('user.profile', compact('profile', 'user', 'chiffre_affaire', 'subordinates_count', 'pourcental_deal', 'deal_encours', 'agent_sup'));
    }

    public function showRoles() {
        $user = Auth::user();
        $roles = Role::all();
        
        if (request()->ajax()) {
            if(!$user->is_admin){
                $roles = Role::where('remove', false)->where('service_id', $user->service_id)->get();
            }
            else{
                $roles = Role::where('remove', false)->get();
            }
            return response()->json($roles); 
        }
        return view('role.index', compact('roles'));
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

    public function calculeCa(Request $request)
    {
        $datesearch = $request->query('datesearch');
        $user_id = $request->query('user_id');
        $sub = $request->query('sub');
        $objectif = $request->query('objectif');
        $user = User::where('id', $user_id)->first();
        if (request()->ajax()) {
            $subordinates_id = null;
            if($sub == 'true'){
                $subordinates_id = Supervisor::where('supervisor_id', $user->id)->pluck('user_id');
            }
            $ca = Deal::where('user_id', $user_id)
                            ->where('remove', false)
                            ->where('statut', 'à conclure')
                            ->when($datesearch, function ($query) use ($datesearch) {
                                return $query->where('date_conclusion', $datesearch);
                            })
                            ->when($subordinates_id, function ($query) use ($subordinates_id) {
                                return $query->whereIn('user_id', $subordinates_id);
                            })
                            ->sum('montant');

            return response()->json($ca); 
        }
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
            'nom' => 'required',
            'prenom' => 'required',
            'email'  => 'required', 
            'code_unique' => 'required', 
            'role_id' => 'required', 
            'telephone' => 'required', 
            'domicile' => 'required',
            // 'ifu' => 'required',
            // 'compte_bancaire' => 'required', 
            'service_id' => 'required', 
            // 'supervo_id' => 'required',
            'sexe' => 'required', 
            'mode_reglement' => 'required', 
            'date_naissance' => 'required',
            'lieu_naissance' => 'required', 
            // 'fixe', 
            'banque' => 'required', 
            'date_collaboration' => 'required',
        ]);

        // dd($request);
        $agent = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email, 
            'code_unique' => $request->code_unique, 
            'role_id' => $request->role_id, 
            'telephone' => $request->telephone, 
            'domicile' => $request->domicile,
            'ifu' => $request->ifu,
            'compte_bancaire' => $request->compte_bancaire, 
            'service_id' => $request->service_id, 
            'password' => Hash::make('12345678'),
            'sexe' => $request->sexe, 
            'mode_reglement' => $request->mode_reglement, 
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance, 
            // 'fixe', 
            'banque' => $request->banque, 
            'date_collaboration' => $request->date_collaboration,
        ]);

        if($request->supervo_id){
            foreach($request->supervo_id as $sup){
                Supervisor::create([
                    'supervisor_id' => $sup,
                    'user_id' => $agent->id,
                ]);
            }
        }

        flash()->success('Agent créé avec succès');

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
    public function update(Request $request, User $user)
    {
        $validation = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email'  => 'required', 
            // 'code_unique' => 'required', 
            'role_id' => 'required', 
            'telephone' => 'required', 
            'domicile' => 'required',
            // 'ifu' => 'required',
            // 'compte_bancaire' => 'required', 
            'service_id' => 'required', 
            // 'supervo_id' => 'required',
            'sexe' => 'required', 
            'mode_reglement' => 'required', 
            'date_naissance' => 'required',
            'lieu_naissance' => 'required', 
            // 'fixe', 
            'banque' => 'required', 
            'date_collaboration' => 'required',
        ]);

        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email, 
            // 'code_unique' => $request->code_unique, 
            'role_id' => $request->role_id, 
            'telephone' => $request->telephone, 
            'domicile' => $request->domicile,
            'ifu' => $request->ifu,
            'compte_bancaire' => $request->compte_bancaire, 
            'service_id' => $request->service_id, 
            'sexe' => $request->sexe, 
            'mode_reglement' => $request->mode_reglement, 
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance, 
            // 'fixe', 
            'banque' => $request->banque, 
            'date_collaboration' => $request->date_collaboration,
        ]);
        if($request->supervo_id){
            $supervos = $user->supervisors();
            foreach($supervos as $sup){
                $sup->delete();
            } 
            foreach($request->supervo_id as $sup){
                if(!$user->supervo_id($sup)){
                    Supervisor::create([
                        'supervisor_id' => $sup,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }

        flash()->success('Agent modifié avec succès');

        return back();
    }

    public function updatePassword(Request $request, User $user)
    {
        $validation = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if(!Hash::check($request->old_password, $user->password)){
            flash()->error('Ancien mot de passe incorrect.');
            return back();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        flash()->success('Mot de passe Agent modifié avec succès');

        return back();
    }

    public function updateProfile(Request $request, User $user)
    {
        $validation = $request->validate([
            'image' => 'required|image',
        ]);
        $image_url = time() . '-' . $request->image->getClientOriginalName();
        $path = $request->image->move(public_path('profile'), $image_url);
        $path = "profile/" . $image_url;

        $user->profile = $path;
        $user->save();

        flash()->success('L\'image profile de Agent modifié avec succès');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->remove = true;
        $user->email = $user->email . now();
        $user->save();

        flash()->success('Agent supprimer avec succès');

        return back();
    }

    public function blocked(User $user)
    {
        if($user->is_blocked){

            $user->is_blocked = false;
            $user->save();

            flash()->success('Agent débloquer avec succès');

            return back();
        }
        $user->is_blocked = true;
        $user->save();

        flash()->success('Agent bloquer avec succès');

        return back();
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function importAgent(Request $request){

        $validation = $request->validate([
            'fichier_excel' => 'required|file',
        ]);

        Excel::import(new UsersImport, $request->file('fichier_excel'));

        flash()->success('Fichier excel importé avec succès');

        return back();
    }

    public function importAgentSup(Request $request){

        $validation = $request->validate([
            'fichier_excel' => 'required|file',
        ]);

        Excel::import(new UserSupImport, $request->file('fichier_excel'));

        flash()->success('Fichier excel importé avec succès');

        return back();
    }

}
