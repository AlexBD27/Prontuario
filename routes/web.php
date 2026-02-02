<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocTypeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\GiroTypeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupTypeController;
use App\Http\Controllers\PDFGeneratorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProntuarioController;
use App\Http\Controllers\PublicTypeController;
use App\Http\Controllers\ReportEmailController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\SubgroupController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckJefatura;
use App\Http\Middleware\CheckUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard-admin', [DashboardController::class, 'admin'])
->middleware(['auth', 'verified', CheckAdmin::class])->name('dashboard.admin');

Route::get('/dashboard-user', [DashboardController::class, 'user'])
->middleware(['auth', 'verified', CheckUser::class])->name('dashboard.user');

// Código Qr
Route::get('/prontuario/{id}/view', [ProntuarioController::class, 'viewProntuarioPdf'])->name('prontuario.view');


Route::middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/area', [AreaController::class, 'index'])->name('area');
    Route::get('/area/create', [AreaController::class, 'create'])->name('area.create');
    Route::post('/area', [AreaController::class, 'store'])->name('area.store');
    Route::get('/area/edit/{id}', [AreaController::class, 'edit'])->name('area.edit');
    Route::put('/area/{id}', [AreaController::class, 'update'])->name('area.update');
    Route::delete('/area/{id}', [AreaController::class, 'destroy'])->name('area.destroy');

    Route::get('areas/{id}/groups', [AreaController::class, 'groups'])->name('area.groups');

    Route::get('/group', [GroupController::class, 'index'])->name('group');
    Route::get('/group/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/group', [GroupController::class, 'store'])->name('group.store');
    Route::get('/group/edit/{id}', [GroupController::class, 'edit'])->name('group.edit');
    Route::put('/group/{id}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('/group/{id}', [GroupController::class, 'destroy'])->name('group.destroy');

    Route::get('/subgroup', [SubgroupController::class, 'index'])->name('subgroup');
    Route::get('/subgroup/create', [SubgroupController::class, 'create'])->name('subgroup.create');
    Route::post('/subgroup', [SubgroupController::class, 'store'])->name('subgroup.store');
    Route::get('/subgroup/edit/{id}', [SubgroupController::class, 'edit'])->name('subgroup.edit');
    Route::put('/subgroup/{id}', [SubgroupController::class, 'update'])->name('subgroup.update');
    Route::delete('/subgroup/{id}', [SubgroupController::class, 'destroy'])->name('subgroup.destroy');

    Route::get('/doctype', [DocTypeController::class,'index'])->name('doctype');
    Route::get( '/doctype/create', [DocTypeController::class,'create'])->name('doctype.create');
    Route::post('/doctype', [DocTypeController::class,'store'])->name('doctype.store');
    Route::get('/doctype/edit/{id}', [DocTypeController::class,'edit'])->name('doctype.edit');
    Route::put('/doctype/{id}', [DocTypeController::class, 'update'])->name('doctype.update');
    Route::delete('/doctype/{id}', [DocTypeController::class, 'destroy'])->name('doctype.destroy');

    Route::get('/grouptype', [GroupTypeController::class,'index'])->name('grouptype');
    Route::get( '/grouptype/create', [GroupTypeController::class,'create'])->name('grouptype.create');
    Route::post('/grouptype', [GroupTypeController::class,'store'])->name('grouptype.store');
    Route::post('/grouptype-assign', [GroupTypeController::class,'assignGroupType'])->name('grouptype.assign');
    Route::delete('/grouptype-unassign', [GroupTypeController::class,'unassignGroupType'])->name('grouptype.unassign');
    Route::get('/grouptype/edit/{id}', [GroupTypeController::class,'edit'])->name('grouptype.edit');
    Route::put('/grouptype/{id}', [GroupTypeController::class, 'update'])->name('grouptype.update');
    Route::delete('/grouptype/{id}', [GroupTypeController::class, 'destroy'])->name('grouptype.destroy');

    Route::get('/girotype', [GiroTypeController::class,'index'])->name('girotype');
    Route::get( '/girotype/create', [GiroTypeController::class,'create'])->name('girotype.create');
    Route::post('/girotype', [GiroTypeController::class,'store'])->name('girotype.store');
    Route::get('/girotype/edit/{id}', [GiroTypeController::class,'edit'])->name('girotype.edit');
    Route::put('/girotype/{id}', [GiroTypeController::class, 'update'])->name('girotype.update');
    Route::delete('/girotype/{id}', [GiroTypeController::class, 'destroy'])->name('girotype.destroy');

    Route::get('/entity', [EntityController::class,'index'])->name('entity');
    Route::get( '/entity/create', [EntityController::class,'create'])->name('entity.create');
    Route::post('/entity', [EntityController::class,'store'])->name('entity.store');
    Route::get('/entity/edit/{id}', [EntityController::class,'edit'])->name('entity.edit');
    Route::put('/entity/{id}', [EntityController::class, 'update'])->name('entity.update');
    Route::delete('/entity/{id}', [EntityController::class, 'destroy'])->name('entity.destroy');

    Route::get('/publictype', [PublicTypeController::class,'index'])->name('publictype');
    Route::get( '/publictype/create', [PublicTypeController::class,'create'])->name('publictype.create');
    Route::post('/publictype', [PublicTypeController::class,'store'])->name('publictype.store');
    Route::get('/publictype/edit/{id}', [PublicTypeController::class,'edit'])->name('publictype.edit');
    Route::put('/publictype/{id}', [PublicTypeController::class, 'update'])->name('publictype.update');
    Route::delete('/publictype/{id}', [PublicTypeController::class, 'destroy'])->name('publictype.destroy');

    Route::get('/prontuario/edit/{id}', [ProntuarioController::class,'edit'])->name('prontuario.edit');
    Route::put('/prontuario/{id}', [ProntuarioController::class, 'update'])->name('prontuario.update');
    Route::get('/prontuario/ask-reset', [ProntuarioController::class,'askReset'])->name('prontuario.ask');
    Route::post('/prontuario/reset', [ProntuarioController::class,'reset'])->name('prontuario.reset');

    Route::get('/user', [UserController::class,'index'])->name('user');
    Route::get( '/user/create', [UserController::class,'create'])->name('user.create');
    Route::post('/user', [UserController::class,'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class,'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/prontuario/clean-all', [ProntuarioController::class,'cleanAll'])->name('prontuario.clean');
    Route::post('/prontuario/reset-all', [ProntuarioController::class,'resetAll'])->name('prontuario.resetAll');

    Route::post('/reports/{report}/send-email', [ReportEmailController::class, 'send'])
    ->name('reports.send.email');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/prontuario/index/{slug}', [ProntuarioController::class,'index'])->name('prontuario');
    Route::get( '/prontuario/create', [ProntuarioController::class,'create'])->name('prontuario.create');
    Route::get( '/prontuario/create/{slug}', [ProntuarioController::class,'createByType'])->name('prontuario.create.bytype');
    Route::post('/prontuario', [ProntuarioController::class,'store'])->name('prontuario.store');
    Route::get('/prontuario/{slug}/{id}', [ProntuarioController::class,'show'])->name('prontuario.showOne');

    Route::put('/prontuario/{id}/upload', [ProntuarioController::class, 'uploadFile'])->name('prontuario.uploadFile');
    Route::delete('/prontuario/{id}/delete-file', [ProntuarioController::class, 'deleteFile'])->name('prontuario.deleteFile');


    Route::get('/prontuario/show/{slug}/{id}', [ProntuarioController::class, 'showByType'])->name('prontuario.show');
    Route::delete('/prontuario/{id}', [ProntuarioController::class, 'destroy'])->name('prontuario.destroy');
    Route::get('/prontuario/initial-numbers', [ProntuarioController::class,'initialNumbers'])->name('prontuario.initial.numbers');
    Route::post('/prontuario/initial-numbers/store', [ProntuarioController::class, 'storeInitialNumber'])->name('prontuario.initial.store');

    Route::get('/report', [PDFGeneratorController::class, 'index'])->name('report');
    Route::get('/report-user/{id}', [PDFGeneratorController::class, 'generateByWorker'])->name('report.user');
    Route::get('/report-admin', [PDFGeneratorController::class, 'generateAdminReports'])->name('report.admin');
    Route::get('/export-excel', [PDFGeneratorController::class, 'exportByAdmin'])->name('export.admin');
    Route::get('/export-excel/{id}', [PDFGeneratorController::class, 'exportByWorker'])->name('export.user');  
});

Route::middleware(['auth', CheckJefatura::class])->group(function () {
    Route::get('/documentos/firmados', [SignatureController::class, 'signed'])->name('firma.signed');
    Route::get('/documentos/por-firmar', [SignatureController::class, 'unsigned'])->name('firma.unsigned');
    Route::get('/firma-documento/{slug}/{id}/{from}', [SignatureController::class,'show'])->name('firma.show');
    Route::put('/firmar-documento/{id}', [SignatureController::class, 'store'])->name('firma.store');
    Route::delete('/firma-documento/{id}/delete', [SignatureController::class, 'delete'])->name('firma.delete');
});


require __DIR__.'/auth.php';
