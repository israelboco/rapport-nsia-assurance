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
            Session::flash('danger', "Erreur dans le formulaire");
            $validation->validate($request, [
                'code_unique' => 'required',
                'password' => 'required',
            ]) ;
        }

        $credentials = $request->only('code_unique', 'password');
        // $credentials['role'] = 'admin';

        $exist = User::where('code_unique',$request->code_unique)->first();
        if(!$exist)
            return back()->with(['danger' => 'Mauvais Code ou mot de passe' ]);
        if(!$exist->is_blocked)
            return back()->with(['danger' => 'Votre compte a été bloqué']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Auth::login($user);
            
            return redirect()->route('dashboard');
        }

        return back()->with(['danger' => 'Mauvais Pseudo ou mot de passe' ]);
    }
    
    public function forget(){

        return view('auth.forget');
    }

    public function exist(Request $request, MailService $mailer){
        $request->validate([
            'email' => 'required',
        ]);
            
        $user = User::where(['email' => $request->email])->first();

        if($user){
            $token = new ResetCodePassword(); 
            $token->code = bin2hex(random_bytes(8));
            $token->email = $user->id;
            $token->created_at = new \DateTime("+1 day");
            $token->save();
            
            $url = asset(route('auth.reset')."?t=".$token->token."&u=".$user->email);

            //sendin email with reactivation email
            $mailer->passwordMail($url, $user->email);

            Session::put('forget_email', $user->email);

            return redirect()->route('auth.link-sended');
        }else
            return back()->with('fail','Cette adresse mail non valide');
    }

    public function linkSended(){
        return view('auth.resend',[
            'email' => Session::pull('forget_email')
        ]);
    }

    public function reset(Request $request){
        // dd($request->t);
        $token = ResetCodePassword::where([
            'token' => $request->t,
            'email' => $request->u
        ])
        ->orderBy('id', 'desc')
        ->first();

        $created_date = new \DateTime($token->created_at);
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

        return redirect()->route('auth.login');
    }

}

