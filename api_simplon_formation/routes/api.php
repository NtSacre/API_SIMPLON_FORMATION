<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\FormationUserController;
use App\Models\Formation_user;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// route pour les utilisateurs ci dessous
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
// route pour l'admin: ci dessous ce trouve la oute pour le role et la formation
Route::middleware('auth:api','admin')->group(function(){
    Route::apiResource('/role', RoleController::class);
    Route::apiResource('/formation', FormationController::class);
    Route::put('/refuserCandidature/{formation_user}', [FormationUserController::class, 'refuseCandidat']);
    Route::put('/accepterCandidature/{formation_user}', [FormationUserController::class, 'accepteCandidat']);
    Route::get('/Candidature/accepter', [FormationUserController::class, 'listeCandidatAccepter']);
    Route::get('/Candidature/refuser', [FormationUserController::class, 'listeCandidatRefuser']);
});
// ce qui s'affiche lorsqu'on est pas connecter et qu'on essaye d'acceder à une route protégée
Route::get('/login', function(){
    return response()->json([
        'error' => 'Unauthenticated', 
    ], 401);
})->name('login');

// route pour l'admin et les candidats

Route::get('/toutesformations', [FormationUserController::class, 'toutesFormations']);
Route::middleware('auth:api','candidat')->group(function(){

    Route::post('/candidater-formations/{formation}', [FormationUserController::class, 'store']);
    Route::get('/voirformation/{formation}', [FormationController::class, 'show']);

});


