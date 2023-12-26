<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Connectez-vous avec un utilisateur existant",
     *     tags={"Authentification"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @OA\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         required=true,
     *         description="Adresse e-mail de l'utilisateur",
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="formData",
     *         type="string",
     *         required=true,
     *         description="Mot de passe de l'utilisateur",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connecté avec succès",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="user", ref="#/definitions/User"),
     *             @OA\Property(
     *                 property="authorization",
     *                 type="object",
     *                 @OA\Property(property="token", type="string"),
     *                 @OA\Property(property="type", type="string", example="bearer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
       
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 200);
    }

    public function listecandidat()
    {
        $candidats = User::where('role_id', 2)->paginate(2);

        if ($candidats) {
            return response()->json([
                'users' => $candidats
            ], 200);
        } else {
            return response()->json([
                'message' => "aucun utilisateurs inscrit"
            ], 200);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Inscrivez un nouvel utilisateur",
     *     tags={"Authentification"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @OA\Par.ameter(
     *         name="name",
     *         in="formData",
     *         type="string",
     *         required=true,
     *         description="Nom de l'utilisateur",
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         required=true,
     *         description="Adresse e-mail de l'utilisateur",
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="formData",
     *         type="string",
     *         required=true,
     *         description="Mot de passe de l'utilisateur",
     *     ),
     *   @OA\Parameter(
     *         name="address",
     *         in="formData",
     *         type="string",
     *         required=true,
     *         description="Adresse postale de l'utilisateur",
     *     ),
     *   @OA\Parameter(
     *         name="telephone",
     *         in="formData",
     *         type="string",
     *         required=true,
     *         description="Numéro de téléphone de l'utilisateur",
     *     ),
     *   @OA\Parameter(
     *         name="role_id",
     *         in="formData",
     *         type="string",
     *         required=true,
     *         description="l'id du role de l'utilisateur",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur créé avec succès",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User created successfully"),
     *             @OA\Property(property="user", ref="#/definitions/User")
     *         )
     *     ),
     * )
     */
    public function register(RegisterUserRequest $request)
    {

        $donneeUtilisateurValider=$request->validated();
        //dd($donneeUtilisateurValider);
        $donneeUtilisateurValider['password']=Hash::make($donneeUtilisateurValider['password']);

        $user = User::create($donneeUtilisateurValider);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Déconnectez l'utilisateur actuellement authentifié",
     *     tags={"Authentification"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnecté avec succès",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     * )
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Actualisez le token d'authentification de l'utilisateur actuellement authentifié",
     *     tags={"Authentification"},
     *     requestBody={"$ref": "#/components/requestBodies/RefreshToken"},
     *     @OA\Response(
     *         response=200,
     *         description="Token actualisé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(
     *                 property="authorisation",
     *                 type="object",
     *                 @OA\Property(property="token", type="string"),
     *                 @OA\Property(property="type", type="string", example="bearer")
     *             )
     *         )
     *     )
     * )
     */
    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
