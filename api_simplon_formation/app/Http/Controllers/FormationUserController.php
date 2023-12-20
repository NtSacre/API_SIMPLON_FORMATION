<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Formation_user;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFormation_userRequest;
use App\Http\Requests\UpdateFormation_userRequest;

class FormationUserController extends Controller
{
   /**
 * @OA\Get(
 *     path="/toutesformations",
 *     summary="Lister toutes les formations non terminées",
 *     produces={"application/json"},
 *     @OA\Response(
 *         response=200,
 *         description="Liste des formations",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="formations", type="array", @OA\Items(ref="#/definitions/Formation")),
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Aucune formation enregistrée pour l'instant",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     )
 * )
 */
    public function toutesFormations()
    {
        $formation = Formation::where('status', 'pas_terminer')->paginate(1);
        if($formation){
            return response()->json([
                'formations' => $formation,
            ], 200);
        }else{
            return response()->json([
               
                'message' =>'Aucun formation enregistré pour l\'instant ',
            ], 201);
        }
    }

/**
 * @OA\Get(
 *     path="/Candidature/accepter",
 *     summary="Lister les candidatures acceptées",
 *     produces={"application/json"},
 *     @OA\Response(
 *         response=200,
 *         description="Liste des candidatures acceptées",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="formations", type="array", @OA\Items(ref="#/definitions/Formation_user")),
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Aucune candidature enregistrée",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     )
 * )
 */
    public function  listeCandidatAccepter()
    {
        $formation = Formation_user::where('status', 'accepter')->paginate(1);
        if($formation){
            return response()->json([
                'formations' => $formation,
            ], 200);
        }else{
            return response()->json([
               
                'message' =>'Aucun Candidature enregistrée',
            ], 201);
        }
    }

  /**
 * @OA\Get(
 *     path="/Candidature/refuser",
 *     summary="Lister les candidatures refusées",
 *     produces={"application/json"},
 *     @OA\Response(
 *         response=200,
 *         description="Liste des candidatures refusées",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="formations", type="array", @OA\Items(ref="#/definitions/Formation_user")),
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Aucune candidature refusée",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     )
 * )
 */
    public function  listeCandidatRefuser()
    {
        $formation = Formation_user::where('status', 'refuser')->paginate(1);
        if($formation){
            return response()->json([
                'formations' => $formation,
            ], 200);
        }else{
            return response()->json([
               
                'message' =>'Aucun Candidature refuser',
            ], 201);
        }
    }



   
/**
 * @OA\Post(
 *     path="/candidater-formations/{formation}",
 *     summary="Candidater à une formation",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="formation",
 *         in="path",
 *         required=true,
 *         type="integer",
 *         description="ID de la formation à candidater",
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Candidature réussie",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de la candidature",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     )
 * )
 */
    public function store(Formation $formation)
    {
        if($formation){
            $formationCandidater= Formation_user::create([
                'user_id' => Auth::user()->id,
                'formation_id' => $formation->id,
            ]);
            if($formationCandidater){
                
                return response()->json([
                    'message' => 'votre requette à été pris en compte'
                ], 201);
            }
        }else{
            return response()->json(
                [
                    'message' => "Oups veuiller recommencer"
                ],500);
        }
    }

 /**
 * @OA\Put(
 *     path="/refuserCandidature/{formation_user}",
 *     summary="Refuser une candidature",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="formation_user",
 *         in="path",
 *         required=true,
 *         type="integer",
 *         description="ID de la candidature à refuser",
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Candidature refusée avec succès",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors du refus de la candidature",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     )
 * )
 */
    public function refuseCandidat( Formation_user $formation_user)
    {
       
        if($formation_user){
            $formation_user->status="refuser";
            if($formation_user->update()){
                
                return response()->json([
                    'message' => 'Candidature rejetée avec succès'
                ], 201);
            }
        }else{
            return response()->json(
                [
                    'message' => "Oups veuiller recommencer"
                ],500);
        
        }
    }
    /**
 * @OA\Put(
 *     path="/accepterCandidature/{formation_user}",
 *     summary="Accepter une candidature",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="formation_user",
 *         in="path",
 *         required=true,
 *         type="integer",
 *         description="ID de la candidature à accepter",
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Candidature acceptée avec succès",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de l'acceptation de la candidature",
 *         @OA\Schema(
 *             type="object",
 *             properties={
 *                 @OA\Property(property="message", type="string"),
 *             }
 *         )
 *     )
 * )
 */
    public function accepteCandidat( Formation_user $formation_user)
    {
        if($formation_user){
            $formation_user->status="accepter";
            if($formation_user->update()){
                
                return response()->json([
                    'message' => 'Candidature accepter avec succès'
                ], 201);
            }
        }else{
            return response()->json(
                [
                    'message' => "Oups veuiller recommencer"
                ],500);
        
        }
    }

   
}
