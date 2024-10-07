<?php

namespace App\Http\Controllers;
use App\Models\User;
// use App\Models\Token;
// use App\Service\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\ResetCodePassword;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    //LOGIN
    public function login(){

        return view('auth.login');
    }

    public function check(Request $request){
        $validation = Validator::make($request->all(), [
            'code_unique' => 'required',
            'password' => 'required',
        ]);
        if ($validation->fails()){
            // Session::flash('danger', "Erreur dans le formulaire");
            $validation->validate($request, [
                'code_unique' => 'required',
                'password' => 'required',
            ]) ;
        }

        $credentials = $request->only('code_unique', 'password');
        // $credentials['role'] = 'admin';

        $exist = User::where('code_unique', $request->code_unique)->first();
        if(!$exist){
            flash()->error('Mauvais Code');
            return back();
        }
        if($exist){
            $valid_password = Hash::check($request->password, $exist->password);
            if(!$valid_password){
                flash()->error('Mauvais mot de passe');
                return back();
            }
        }
        if($exist->is_blocked){
            flash()->error('Votre compte a été bloqué');
            return back();
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Auth::login($user);
            return redirect()->route('home');
        }

        flash()->error('Mauvais Code ou mot de passe');
        return back();
    }
    
    public function forget(){

        return view('auth.forget');
    }

    public function reset(Request $request){
        // dd($request->t);
        $token = ResetCodePassword::where([
            'token' => $request->token,
            'email' => $request->email
        ])
        ->orderBy('id', 'desc')
        ->first();

        $created_date = new \DateTime($token->created_at);
        $expired_date = $created_date->add(new \DateInterval('PT15M'));
        $date = new \DateTime();

        if($date > $expired_date)
            dd('Error code expired');

        $user = User::where('email', $token->email)->first();

        return view('auth.reset',compact('user'));
    }

    public function update_pass(Request $request, $id){
        $request->validate([
            'password' => 'required|min:8|max:30',
            'confirm' => 'required|same:password|min:8|max:30',
        ]);
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('auth.login')->with('success', "Mot de passe modifier avec succès !");
    
    }

    public function logout(){

        Auth::logout();

        return redirect()->route('login');
    }

}

