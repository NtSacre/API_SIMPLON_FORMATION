<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFormationRequest;
use App\Http\Requests\UpdateFormationRequest;

class FormationController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/formation",
 *     summary="Récupérer la liste des formations de l'utilisateur",
 *     produces={"application/json"},
 *     @OA\Response(
 *         response=200,
 *         description="Opération réussie",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="formations", type="array", @OA\Items(ref="#/definitions/Formation"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Aucune formation enregistrée",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Aucune formation enregistrée")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Non autorisé")
 *         )
 *     )
 * )
 */
    public function index()
    {
        $formation = Formation::where('user_id', Auth::user()->id)->paginate(1);
        if($formation){
            return response()->json([
                'formations' => $formation,
            ], 200);
        }else{
            return response()->json([
               
                'message' =>'Aucun formation enregistré',
            ], 201);
        }
    }

   
    /**
 * @OA\Post(
 *     path="/api/formation",
 *     summary="Enregistrer une nouvelle formation",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="formation",
 *         in="body",
 *         required=true,
 *         @OA\Schema(ref="#/definitions/Formation")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Opération réussie",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="La formation a été enregistrée avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="La formation n'a pas été enregistrée")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Non autorisé")
 *         )
 *     )
 * )
 */
    public function store(StoreFormationRequest $request)
    {
        try {
      
            $donneeFormationValide = $request->validated();
          
            $donneeFormationValide['user_id']=Auth::user()->id;
            
            $Formation = new Formation($donneeFormationValide);
    
            if ($Formation->save()) {
                return response()->json([
                    
                    "message" => "la Formation à été enregistrer avec succès"
                ], 201);
            } else {
                return response()->json([
                  
                    "message" => "le Formation n'a pas été enregistrer"
                ], 500);
            }
           } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "messageErreur" => $th,
            ]);
           }
    }

   /**
 * @OA\Get(
 *     path="/api/formation/{formation}",
 *     summary="Récupérer les détails d'une formation",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="formation",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="ID de la formation"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Opération réussie",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="formation", type="object", ref="#/definitions/Formation")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Formation non trouvée",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Erreur, formation non trouvée")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Non autorisé")
 *         )
 *     )
 * )
 */
    public function show(Formation $formation)
    {
        if($formation){
            return response()->json([
                
                'formation' => $formation,
            ], 200);
        }else{
            return response()->json([
                
                'message' => "Erreur formation non trouvé",
            ], 404); 
        }
    }

 

  /**
 * @OA\Put(
 *     path="/api/formation/{formation}",
 *     summary="Modifier les détails d'une formation",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="formation",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="ID de la formation"
 *     ),
 *     @OA\Parameter(
 *         name="formation",
 *         in="body",
 *         required=true,
 *         @OA\Schema(ref="#/definitions/Formation")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Opération réussie",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="La formation a été modifiée avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="La formation n'a pas été modifiée")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Non autorisé")
 *         )
 *     )
 * )
 */
    public function update(UpdateFormationRequest $request, Formation $formation)
    {
        try {
      
            $donneeFormationValide = $request->validated();
          
            $donneeFormationValide['user_id']=Auth::user()->id;
            
          
    
            if ($formation->update($donneeFormationValide)) {
                return response()->json([
                    
                    "message" => "la Formation à été modifié avec succès"
                ], 201);
            } else {
                return response()->json([
                  
                    "message" => "le Formation n'a pas été modifié"
                ], 500);
            }
           } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "messageErreur" => $th,
            ]);
           }
    }

    /**
 * @OA\Delete(
 *     path="/api/formation/{formation}",
 *     summary="Supprimer une formation",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="formation",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="ID de la formation"
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Opération réussie",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="La formation a été supprimée avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Formation non trouvée",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="La formation n'a pas été supprimée")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Non autorisé")
 *         )
 *     )
 * )
 */
    public function destroy(Formation $formation)
    {
        if($formation){
            if($formation->delete()){
                return response()->json([
                   
                    "message" => "la formation à été supprimer avec succès"
                ], 201);
            } else {
                return response()->json([
                   
                    "message" => "la formation n'a pas été supprimer"
                ],404);
            }
        }
    }
}
