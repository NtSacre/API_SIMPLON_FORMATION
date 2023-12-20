<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;

class RoleController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/role",
 *     summary="Récupérer la liste des rôles",
 *     produces={"application/json"},
 *     @OA\Response(
 *         response=200,
 *         description="Opération réussie",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="Roles", type="array", @OA\Items(ref="#/definitions/Role"))
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Erreur",
 *         @OA\Schema(ref="#/definitions/Error")
 *     )
 * )
 */
    public function index()
    {
        return response()->json([
            'staut'=>1,
            'Roles'=> Role::all(),
        ], 200);
    }

   

   /**
 * @OA\Post(
 *     path="/api/role",
 *     summary="Enregistrer un nouveau rôle",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="body",
 *         in="body",
 *         required=true,
 *         @OA\Schema(ref="#/definitions/StoreRoleRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Rôle enregistré avec succès",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Rôle enregistré avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Erreur",
 *         @OA\Schema(ref="#/definitions/Error")
 *     )
 * )
 */
    public function store(StoreRoleRequest $request)
    {
        $datavalidated=$request->validated();
        $role= Role::create($datavalidated);
        if($role){
            return response()->json([
             
                'message'=> 'Role enregistré avec succè',
            ], 201);
        }else{
            return response()->json([
                
                'message'=> 'Role non enregistré',
            ], 500);
        }
    }
/**
 * @OA\Get(
 *     path="/api/role/{role}",
 *     summary="Afficher les détails d'un rôle",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="role",
 *         in="path",
 *         required=true,
 *         type="integer",
 *         description="ID du rôle"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Opération réussie",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="role", type="object", ref="#/definitions/Role")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Rôle non trouvé",
 *         @OA\Schema(ref="#/definitions/Error")
 *     )
 * )
 */
    public function show(Role $role)
    {
        if($role->exists()){
            return response()->json([
               
                'role'=> $role,
            ], 200);
        }else{
            return response()->json([
               
                'message'=> 'role non trouvée',
            ],404);
        }
    }

   

  /**
 * @OA\Put(
 *     path="/api/role/{role}",
 *     summary="Modifier un rôle existant",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="role",
 *         in="path",
 *         required=true,
 *         type="integer",
 *         description="ID du rôle à modifier"
 *     ),
 *     @OA\Parameter(
 *         name="body",
 *         in="body",
 *         required=true,
 *         @OA\Schema(ref="#/definitions/UpdateRoleRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Rôle modifié avec succès",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Rôle modifié avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Erreur",
 *         @OA\Schema(ref="#/definitions/Error")
 *     )
 * )
 */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        if($role){
            
            $infoRoleValide=$request->validated();
        ;
        if($role->update($infoRoleValide)){
            return response()->json([
             
                'message'=> 'Role modifié',
            ], 200);
        }else{
            return response()->json([
              
                'message'=> 'Role non modifié',
            ], 500);
        }
    }
    }

    /**
 * @OA\Delete(
 *     path="/api/role/{role}",
 *     summary="Supprimer un rôle",
 *     produces={"application/json"},
 *     @OA\Parameter(
 *         name="role",
 *         in="path",
 *         required=true,
 *         type="integer",
 *         description="ID du rôle à supprimer"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Rôle supprimé avec succès",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Rôle supprimé avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Erreur",
 *         @OA\Schema(ref="#/definitions/Error")
 *     )
 * )
 */
    public function destroy(Role $role)
    {
        if($role){
           
            if($role->delete()){
                
                    return response()->json([
                       
                        'message'=> 'Role supprimée',
                    ], 200);
                }else{
                    return response()->json([
                      
                        'message'=> 'Role non supprimée',
                    ], 500);
                }
        }
    }
}
