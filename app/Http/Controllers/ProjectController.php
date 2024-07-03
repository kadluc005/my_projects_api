<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function create(Request $request){
        //validation
        $request->validate([
            'name'=>'required',
            'duree'=>'required|integer',
            'description'=>'required'
        ]);

        $projet = new Project();
        $projet->name = $request->name;
        $projet->duree = $request->duree;
        $projet->description = $request->description;
        $projet->etudiant_id = Auth::user()->id;
        $projet->save();

        return response()->json([
            'statut'=> 1,
            'message'=>"Projet créé avec succès",
        ]);

    }

    public function delete($id){
        $etudiant_id = Auth::user()->id;
        if(Project::where(['id'=> $id, 'etudiant_id' => $etudiant_id])->exists()){

            $projet = Project::where(['id'=> $id, 'etudiant_id' => $etudiant_id])->first();
            $projet->delete();
            return response()->json([
                'statut'=> 1,
                'message'=>"Le projet a été supprimé avec succès",
            ]);
        }else{
            return response()->json([
                'statut'=> 0,
                'message'=>"Projet non trouvé",
            ], 404);
        }
    }

    public function list(){
        $etudiant_id = Auth::user()->id;
        $projets = Project::where('etudiant_id', $etudiant_id)->get();
        return response()->json([
            'statut'=> 1,
            'message'=>"Mes projets",
            'data' => $projets
        ]);
    }

    public function details($id){
        $etudiant_id = Auth::user()->id;
        if(Project::where(['id'=> $id, 'etudiant_id' => $etudiant_id])->exists()){

            $projet = Project::where(['id'=> $id, 'etudiant_id' => $etudiant_id])->get();
            return response()->json([
                'statut'=> 1,
                'message'=>"details du projet",
                'data' => $projet
            ]);
        }else{
            return response()->json([
                'statut'=> 0,
                'message'=>"Projet non trouvé",
            ], 404);
        }
    }

    public function update_project(Request $request, $id){
        $etudiant_id = Auth::user()->id;
        if(Project::where(['id'=> $id, 'etudiant_id' => $etudiant_id])->exists()){

            $projet = Project::where(['id'=> $id, 'etudiant_id' => $etudiant_id])->first();
            $projet->update([ 
                'name'=>$request->name, 
                'duree'=>$request->duree,
                'description'=>$request->description,
            ]);
            return response()->json([
                'statut'=> 1,
                'message'=>"Modifié avec succès",
                'data' => $projet
            ]);
        }else{
            return response()->json([
                'statut'=> 0,
                'message'=>"Projet non trouvé",
            ], 404);
        }
    }
}
