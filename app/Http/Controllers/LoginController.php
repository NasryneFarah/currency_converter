<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    // je vais accéder aux servives d'authentification de Laravel via Auth façade

    public function login(Request $request)
    {
        
        // je demande à ma variable de réclamer seulement l'email et le password
        $credentials = $request->only('email','password');
        $msg= "welcome";
       

        // La méthode attempt sera utiliser pour gérer les tentatives d'authentification à partir du formulaire de connexion

        if (Auth::attempt($credentials)) {
            // si l'authentification est réussie

            $user = Auth::user();  //la variabe user représente l'utilisateur pour lequel je dois générer un jeton 

            return response()->json(['User' => $user,'message' => $msg], 200);
        } else {
            //si l'authentifiaction a échoué 
            return response()->json(['message' => 'La connexion a échouée'],401);
        }
 
    }
}
