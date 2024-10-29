<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;

//USE PARA LOS CONTROLADORES
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\PorcentajeEncuestasDay;
use App\Http\Controllers\AvisoPrivacidadController;

// Main Page Route
Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/encuesta', [VerticalForm::class, 'index'])->name('form-encuesta');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');



//controladores
Route::resource('encuestas', EncuestaController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('preguntas', PreguntaController::class);
Route::resource('respuestas', RespuestaController::class);

//RUTAS PARA ENCUESTA

Route::get('/encuesta', [EncuestaController::class, 'index'])
    ->name('nueva.encuesta');

Route::post('/encuesta/guardar', [EncuestaController::class, 'store'])
    ->name('encuesta.guardar');

Route::get('/encuestas', [EncuestaController::class, 'list'])
    ->name('encuestas.lista');

Route::delete('/encuesta/delete/{id}', [EncuestaController::class, 'delete'])
    ->name('encuesta.borrar');


//RUTAS PARA CATEGORIAS

Route::get('/categoria', [CategoriaController::class, 'index'])
    ->name('nueva.categoria');

Route::post('/categoria/guardar', [CategoriaController::class, 'store'])
    ->name('categoria.guardar');

Route::get('/categorias', [CategoriaController::class, 'list'])
    ->name('categorias.lista');

Route::delete('/categoria/delete/{id}', [CategoriaController::class, 'delete'])
    ->name('categoria.borrar');


//RUTAS PARA PREGUNTAS

Route::get('/pregunta', [PreguntaController::class, 'index'])
    ->name('nueva.pregunta');

Route::post('/pregunta/guardar', [PreguntaController::class, 'store'])
    ->name('pregunta.guardar');

Route::get('/preguntas', [PreguntaController::class, 'list'])
    ->name('preguntas.lista');

Route::delete('/pregunta/delete/{id}', [PreguntaController::class, 'delete'])
    ->name('pregunta.borrar');


//RUTAS PARA RESPUESTAS, SOLO VER

Route::get('/respuestas', [PreguntaController::class, 'list'])
    ->name('respuestas.lista');

//RUTA PARA VER LA ENCUESTA DESDE LA VISION DEL USUARIO 
Route::get('/encuestaUsuario', [RespuestaController::class, 'index'])
    ->name('encuesta.usuario');

Route::post('respuesta/guardar', [RespuestaController::class, 'storeResponse'])
    ->name('respuesta.guardar');

//RUTA PARA OBTENER PORCENTAJE DE ENCUESTAS
Route::get('/', [PorcentajeEncuestasDay::class, 'index'])
    ->name('porcentaje.dia');
    
    Route::get('/token', function (Request $request) {
        // Obtener el token CSRF desde la sesión
        $token = $request->session()->token(); 
    
        // También puedes usar la función csrf_token()
        $tokenAlternative = csrf_token(); 
    
        // Retornar el token como respuesta JSON (o simplemente retornarlo de otra forma)
        return response()->json(['csrf_token' => $token]);
    });

//RUTA DE AVISO DE PRIVACIDAD
Route::get('/aviso-privacidad', function () {
    return view('content.pages.avisoprivacidad');
});

//RUTA DE VISUALIZACION DE RESPPUESTAS
Route::get('/respuestas', [RespuestaController::class, 'list'])
    ->name('respuestas.lista');

    