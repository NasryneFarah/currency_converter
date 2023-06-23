<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    // je vais accéder aux servives d'authentification de Laravel via Auth façade

    public function login(Request $request)
    {
        $user =  new User();
        $user->name = 'edouard';
        $user->email = "test@gmail.com";
        $user->password = Hash::make("test");
        $user->id_role = 1;
        $user->save();
        
        if (Auth::login($user)) {

            $user = Auth::user();  //la variabe user représente l'utilisateur pour lequel je dois générer un jeton 
            return response()->json(['User' => $user], 200);
        } else {
            //si l'authentifiaction a échoué 
            return response()->json(['message' => 'La connexion a échouée'],401);
        }
     
        // //je m'assure que mes champs email et password son valide
        // $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ]);

        // // ma variable  va récupérer que les infos de ces deux champs dans le formulaire
        // $credentials = $request->only('email','password');
      
        // // La méthode attempt sera utiliser pour gérer les tentatives d'authentification à partir du formulaire de connexion

        // if (Auth::attempt($credentials)) {
        //     // si l'authentification est réussie

        //     $user = Auth::user();  //la variabe user représente l'utilisateur pour lequel je dois générer un jeton 

        //     return response()->json(['User' => $user], 200);
        // } else {
        //     //si l'authentifiaction a échoué 
        //     return response()->json(['message' => 'La connexion a échouée'],401);
        // }
 
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->id_role
        ]);

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur déconnecté'
        ]);
    }
}
