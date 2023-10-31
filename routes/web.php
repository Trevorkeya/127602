<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*--------------All Normal Users Routes List--------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Add resources route
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');

});
  
/*--------------All Admin Routes List----------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
   
    Route::prefix('admin')->group(function (){
       //Create user Routes
       Route::controller(App\Http\Controllers\Admin\UserController::class)->group(function(){
            Route::get('/users','index');
            Route::get('/users/create','create');
            Route::post('/users', 'store');
            Route::get('/users/{user_id}','edit');
            Route::put('users/{user_id}','update');
            Route::get('users/destroy/{user_id}','destroy');
      });
    });
    // Add resources route
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [App\Http\Controllers\Admin\MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [App\Http\Controllers\Admin\MaterialController::class, 'destroy'])->name('materials.destroy');
});
  
/*--------------All Instructor Routes List----------------------*/
Route::middleware(['auth', 'user-access:instructor'])->group(function () {
  
    Route::get('/instructor/home', [App\Http\Controllers\HomeController::class, 'instructorHome'])->name('instructor.home');

    // Add resources route
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [App\Http\Controllers\Admin\MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [App\Http\Controllers\Admin\MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');


});


Route::get('/2fa-verify', [App\Http\Controllers\TwoFactorVerificationController::class, 'show'])->name('2fa.verify');
Route::post('/2fa-verify', [App\Http\Controllers\TwoFactorVerificationController::class, 'verify']);
