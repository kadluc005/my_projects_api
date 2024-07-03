<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    public function register(Request $request){

        //validation
        $request -> validate([
            'name'=> 'required',
            'email'=>'required|email|unique:etudiants',
            'password'=>'required|confirmed'
        ]);

        $etudiant = new Etudiant();
        $etudiant->name = $request->name;
        $etudiant->email = $request->email;
        $etudiant->password = Hash::make($request->password);
        $etudiant->phone = isset($request->phone) ? $request->phone :'';
        $etudiant->save();

        return response()->json([
            'statut'=> 1,
            'message'=> 'Etudiant créé avec succès'
        ], 201);
    }

    public function login(Request $request){
        //validation
        $request -> validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        //vérifier si l'étudiant existe
        $etudiant = Etudiant::where('email', '=', $request->email)->first();

        if($etudiant){
            
            if(Hash::check($request->password, $etudiant->password)){
                //créer un token
                $token = $etudiant->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'statut'=> 1,
                    'message'=>"Connexion réussie",
                    'access_token' => $token
                ], 200);

            }else{
                return response()->json([
                    'statut'=> 0,
                    'message'=>"Mot de passe incorrect"
                ]);
            }

        }else{
            return response()->json([
                'statut'=> 0,
                'message'=>"l'étudiant n'existe pas"
            ], 404);
        }
    }
    public function logout(Request $request){
        Auth::user()->tokens()->delete();
        return response()->json([
            'statut'=> 1,
            'message'=>"Vous êtes déconnecté",
        ]);
    }
    public function profile(Request $request){
        return response()->json([
            'statut'=> 1,
            'message'=>"Connexion réussie",
            'data' => Auth::user()
        ]);
    }
}
