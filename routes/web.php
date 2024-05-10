<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});
Route::get('/register', function () {return view('auth.register');});
Route::get('/login',function () {return view('auth.login');});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function (){
    Route::get('/home', [ProjectController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/projects', function () {return view('home');});
    Route::post('/create', [ProjectController::class, 'create']);

    Route::get("/projects/{id}", [ProjectController::class, 'show']);
    Route::post("/projects/add-member/{id}", [ProjectController::class, 'addMember']);
    Route::post("/projects/remove-member/{id}", [ProjectController::class, 'removeMember']);

    Route::post("/tasks/add/{id}", [TaskController::class, 'addTask']);
    Route::post("/tasks/remove/{id}/{task}", [TaskController::class, 'removeTask']);

    Route::post("/tasks/submit/{task}", [TaskController::class, 'submit']);

    Route::get("/documents/approve/{document}", [DocumentController::class, 'approve']);
    Route::get("/documents/disapprove/{document}", [DocumentController::class, 'disapprove']);

    Route::post("/profile", [ProfileController::class, 'update']);
    Route::get("/profile", [ProfileController::class, 'index']);
    Route::get("/profile/{user}", [ProfileController::class, 'show']);

    Route::get("/mark/{notification}", [ProfileController::class, 'mark']);
    Route::delete('/delete/{project}', [ProjectController::class, 'delete']);

    Route::get('/staff', [StaffController::class, 'index']);
    Route::get('/archive', [ProjectController::class, 'archive']);
    Route::get("/archive-projects/{id}", [ProjectController::class, 'archiveShow']);
});
