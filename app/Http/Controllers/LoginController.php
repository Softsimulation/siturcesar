<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin(){
        return view('Login');
    }
    public function postAutenticacion(Request $request){
        if($request->userName == null || $request->password == null || $request->userName == '' || $request->password == '' ){
            return redirect()->intended('login/login')->with('message', 'Credenciales no válidas');
        }
        $user = User::where('email',$request->userName)->first();
        //return $user->password;
        if($user != null){
            if(\Hash::check($request->password,$user->password)){
            
                Auth::login($user);
                if(Auth::user()->hasRole("Admin")){
                    return redirect()->intended('usuario/listadousuarios'); 
                }else if(Auth::user()->hasRole("Promocion")){
                    return redirect()->intended('noticias/listadonoticias'); 
                }else if(Auth::user()->hasRole("Estadistico")){
                    return redirect()->intended('ofertaempleo/listadoproveedores'); 
                }else{
                    return redirect()->intended('/');
                }
                     
            }
             
            return redirect()->intended('login/login')->with('message', 'Credenciales no válidas');
        }else{
            return redirect()->intended('login/login')->with('message', 'Credenciales no válidas');
        }
        
    }
    public function getCerrarsesion(){
        Auth::logout();
        return redirect()->intended('/');
    
    }
}
