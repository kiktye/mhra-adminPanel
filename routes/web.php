<?php

use App\Http\Controllers\{
    AgendaController,
    BlogController,
    CommentController,
    ConferenceController,
    EmployeeController,
    EventController,
    GeneralInfoController,
    RegisteredUserController,
    RoleController,
    SessionController,
    SpeakerController,
    UserController
};


use App\Http\Middleware\admin;
use App\Models\Agenda;
use App\Models\Speaker;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

// User Blog Routes
Route::middleware('auth')->prefix('user/blogs')->name('blogs.')->group(function () {
    Route::get('/', [BlogController::class, 'userIndex'])->name('userIndex');
    Route::get('{blog}', [BlogController::class, 'userShow'])->name('userShow');
});

// User Blog Routes
Route::middleware('auth')->prefix('user/employees')->name('employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'userIndex'])->name('userIndex');
    Route::get('{employee}', [EmployeeController::class, 'userShow'])->name('userShow');
});

// User Event Routes
Route::middleware('auth')->prefix('user/events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'userIndex'])->name('userIndex');
    Route::get('{event}', [EventController::class, 'userShow'])->name('userShow');
});

// User Conference Routes
Route::middleware('auth')->prefix('user/conferences')->name('conferences.')->group(function () {
    Route::get('/', [ConferenceController::class, 'userIndex'])->name('userIndex');
    Route::get('{conference}', [ConferenceController::class, 'userShow'])->name('userShow');
});


// User Comment -> Like Routes
Route::prefix('comments')->name('comments.')->group(function () {
    Route::post('blogs/{blog}', [CommentController::class, 'store'])->name('store');
    Route::post('{comment}/like', [CommentController::class, 'like'])->name('like');
    Route::post('{comment}/reply', [CommentController::class, 'reply'])->name('reply');
});


// Blog Like and Comment Routes
Route::post('blogs/{blog}/like', [BlogController::class, 'like'])->name('blogs.like');
Route::post('blogs/{blog}/comment', [BlogController::class, 'addComment'])->name('blogs.comment');

// User Recommendation Routes
Route::post('/user/{user}/send-recommendation', [UserController::class, 'sendRecommendation'])->name('user.sendRecommendation');

// Admin Panel Routes
Route::middleware([Admin::class])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // User Management Routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('{user}', [UserController::class, 'show'])->name('show');

        // Update Blog Contents 
        Route::patch('{user}/update-image', [UserController::class, 'updateImage'])->name('update.image');
        Route::patch('{user}/update-credentials', [UserController::class, 'updateCredentials'])->name('update.credentials');
        Route::patch('{user}/update-info', [UserController::class, 'updateInfo'])->name('update.info');
        Route::patch('{user}/update-bio', [UserController::class, 'updateBio'])->name('update.bio');

        // Delete Blog Contents 
        Route::delete('{user}/delete-image', [UserController::class, 'deleteImage'])->name('delete.image');
        Route::delete('{user}/delete-cv', [UserController::class, 'deleteCV'])->name('delete.cv');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
        // Restrict & Restore
        Route::put('{user}/restore', [UserController::class, 'restore'])->name('restore');
        Route::put('{user}/restrict', [UserController::class, 'restrict'])->name('restrict');
    });

    // Employee Management Routes
    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('{employee}', [EmployeeController::class, 'show'])->name('show');

        // Update Employee Contents 
        Route::patch('{employee}/update-image', [EmployeeController::class, 'updateImage'])->name('update.image');
        Route::patch('{employee}/update-info', [EmployeeController::class, 'updateInfo'])->name('update.info');
        Route::patch('{employee}/update-description', [EmployeeController::class, 'updateDescription'])->name('update.description');
        Route::patch('{employee}/update-role', [EmployeeController::class, 'updateRole'])->name('update.role');

        // Delete Employee Contents
        Route::delete('{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::delete('{employee}/delete-image', [EmployeeController::class, 'deleteImage'])->name('delete.image');
        Route::delete('{employee}/delete-section/{descriptionIndex}', [EmployeeController::class, 'deleteSection'])->name('delete.section');
    });

    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

    Route::delete('{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('{comment}/restore', [CommentController::class, 'restore'])->name('comments.restore');

    // Blog Management Routes
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('{blog}', [BlogController::class, 'show'])->name('show');

        // Update Blog Contents 
        Route::patch('{blog}/update-image', [BlogController::class, 'updateImage'])->name('update.image');
        Route::patch('{blog}/update-info', [BlogController::class, 'updateInfo'])->name('update.info');
        Route::patch('{blog}/update-sections', [BlogController::class, 'updateSections'])->name('update.sections');
        Route::patch('{blog}/feature', [BlogController::class, 'featured'])->name('feature');


        // Delete Blog Contents 
        Route::delete('{blog}/delete-image', [BlogController::class, 'deleteImage'])->name('delete.image');
        Route::delete('{blog}', [BlogController::class, 'destroy'])->name('destroy');
        Route::delete('{blog}/delete-section/{sectionIndex}', [BlogController::class, 'deleteSection'])->name('delete.section');
    });

    // Event Management Routs
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('{event}', [EventController::class, 'show'])->name('show');

        // Update Event Contents
        Route::patch('{event}/update-image', [EventController::class, 'updateImage'])->name('update.image');
        Route::patch('{event}/update-info', [EventController::class, 'updateInfo'])->name('update.info');
        Route::patch('{event}/update-main', [EventController::class, 'updateMain'])->name('update.mainInfo');
        Route::patch('{event}/update-content', [EventController::class, 'updateContent'])->name('update.content');
        Route::patch('{event}/update-prices', [EventController::class, 'updatePrices'])->name('update.prices');
        Route::patch('{event}/feature', [EventController::class, 'featured'])->name('feature');

        // Delete Event Contents
        Route::delete('{event}/delete-image', [EventController::class, 'deleteImage'])->name('delete.image');
        Route::delete('{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::delete('{event}/delete-section/{sectionIndex}', [EventController::class, 'deleteSection'])->name('delete.section');
    });

    // Conference Management Routes
    Route::prefix('conferences')->name('conferences.')->group(function () {
        Route::get('/', [ConferenceController::class, 'index'])->name('index');
        Route::get('create', [ConferenceController::class, 'create'])->name('create');
        Route::post('/', [ConferenceController::class, 'store'])->name('store');
        Route::get('{conference}', [ConferenceController::class, 'show'])->name('show');

        // Update Conference Contents
        Route::patch('{conference}/update-image', [ConferenceController::class, 'updateImage'])->name('update.image');
        Route::patch('{conference}/update-info', [ConferenceController::class, 'updateInfo'])->name('update.info');
        Route::patch('{conference}/update-main', [ConferenceController::class, 'updateMain'])->name('update.mainInfo');
        Route::patch('{conference}/update-prices', [ConferenceController::class, 'updatePrices'])->name('update.prices');
        Route::patch('{conference}/update-status', [ConferenceController::class, 'updateStatus'])->name('update.status');

        // Delete Conference Contents
        Route::delete('{conference}/delete-image', [ConferenceController::class, 'deleteImage'])->name('delete.image');
        Route::delete('{conference}', [ConferenceController::class, 'destroy'])->name('destroy');
    });

    // Agenda Management Routes
    Route::prefix('agendas')->name('agendas.')->group(function () {
        Route::get('/', [AgendaController::class, 'index'])->name('index');
        Route::get('create', [AgendaController::class, 'create'])->name('create');
        Route::post('/', [AgendaController::class, 'store'])->name('store');
        Route::patch('/{agenda}', [AgendaController::class, 'update'])->name('update');

        // Delete Agenda Contents
        Route::delete('{agenda}/delete', [AgendaController::class, 'destroy'])->name('destroy');
    });

    // Speaker Management Routes
    Route::prefix('speakers')->name('speakers.')->group(function () {
        Route::get('/', [SpeakerController::class, 'index'])->name('index');
        Route::get('create', [SpeakerController::class, 'create'])->name('create');
        Route::post('/', [SpeakerController::class, 'store'])->name('store');
        Route::get('{speaker}', [SpeakerController::class, 'show'])->name('show');

        // Update Speaker Contents
        Route::patch('{speaker}/update', [SpeakerController::class, 'update'])->name('update');
        Route::patch('{speaker}/update-image', [SpeakerController::class, 'updateImage'])->name('update.image');
        Route::patch('{speaker}/update-credentials', [SpeakerController::class, 'updateCredentials'])->name('update.credentials');
        Route::patch('{speaker}/update-links', [SpeakerController::class, 'updateLinks'])->name('update.links');


        // Delete Speaker Contents
        Route::delete('{speaker}/delete', [SpeakerController::class, 'destroy'])->name('destroy');
        Route::delete('{speaker}/delete-image', [SpeakerController::class, 'deleteImage'])->name('delete.image');
        Route::patch('{speaker}/remove-from-event', [SpeakerController::class, 'removeFromEvent'])->name('remove.from.event');
        Route::patch('{speaker}/remove-from-conference', [SpeakerController::class, 'removeFromConference'])->name('remove.from.conference');
    });

    // Homepage Management Routes
    Route::prefix('generalInfo')->name('generalInfo.')->group(function () {
        Route::get('/', [GeneralInfoController::class, 'show'])->name('show');
        Route::patch('/{generalInfo}/update-image', [GeneralInfoController::class, 'updateImage'])->name('update.image');
        Route::patch('/{generalInfo}/update-info', [GeneralInfoController::class, 'updateInfo'])->name('update.info');
        Route::patch('/{generalInfo}/update-links', [GeneralInfoController::class, 'updateLinks'])->name('update.links');

        // Delete Image
        Route::delete('{generalInfo}/delete-image', [GeneralInfoController::class, 'deleteImage'])->name('delete.image');
    });
});
