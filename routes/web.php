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


  
/*--------------All Admin Routes List----------------------*/
Route::middleware(['auth', 'isAdmin'])->group(function () {
    
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/instructor/home', [App\Http\Controllers\HomeController::class, 'instructorHome'])->name('instructor.home');
    
    //courses routes
    Route::get('/admin/courses',[App\Http\Controllers\Main\CourseController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/courses', [App\Http\Controllers\Main\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [App\Http\Controllers\Main\CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [App\Http\Controllers\Main\CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [App\Http\Controllers\Main\CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'destroy'])->name('courses.destroy');
    //courses routes
   
    //materials routes
    Route::get('/admin/materials', [App\Http\Controllers\Admin\MaterialController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [App\Http\Controllers\Admin\MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [App\Http\Controllers\Admin\MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');
    //materials routes

    //Category routes
    Route::get('/categories/index', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create']);
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
    //Category routes

    //Topic routes
    Route::get('courses/{course}/topics', [App\Http\Controllers\Main\TopicController::class, 'index'])->name('topics.index');
    Route::get('courses/{course}/topics/create', [App\Http\Controllers\Main\TopicController::class,'create'])->name('topics.create');
    Route::post('courses/{course}/topics/store', [App\Http\Controllers\Main\TopicController::class,'store'])->name('topics.store');
    Route::get('courses/{course}/topics/{topic}/edit', [App\Http\Controllers\Main\TopicController::class,'edit'])->name('topics.edit');
    Route::put('courses/{course}/topics/{topic}/update', [App\Http\Controllers\Main\TopicController::class,'update'])->name('topics.update');
    Route::delete('courses/{course}/topics/{topic}/destroy', [App\Http\Controllers\Main\TopicController::class,'destroy'])->name('topics.destroy');
    Route::get('courses/{course}/topics/{topic}/add-materials', [App\Http\Controllers\Main\TopicController::class, 'createMaterials'])->name('topics.addMaterials');
    Route::post('courses/{course}/topics/{topic}/store-materials', [App\Http\Controllers\Main\TopicController::class, 'storeMaterials'])->name('topics.storeMaterials');
    //Topic routes

    //Quiz routes
    Route::get('quizzes/create/{course}/{topic}', [App\Http\Controllers\Quiz\QuizController::class, 'create'])->name('quizzes.create');
    Route::post('quizzes', [App\Http\Controllers\Quiz\QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}', [App\Http\Controllers\Quiz\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('quizzes/{quiz}/addQuestions', [App\Http\Controllers\Quiz\QuestionController::class, 'create'])->name('questions.create');
    Route::post('quizzes/{quiz}/storeQuestions', [App\Http\Controllers\Quiz\QuestionController::class, 'store'])->name('questions.store');
    Route::post('quizzes/{quiz}/finish', [App\Http\Controllers\Quiz\QuizController::class, 'finish'])->name('quizzes.finish');
    Route::get('/quizzes/result/{quizId}/{score}', [App\Http\Controllers\Quiz\QuizController::class, 'result'])->name('quizzes.result');
    //Quiz routes

    Route::prefix('admin')->group(function (){
       //Create user Routes
       Route::controller(App\Http\Controllers\Admin\UserController::class)->group(function(){
            Route::get('/users','index');
            Route::get('/users/create','create');
            Route::post('/users', 'store');
            Route::get('/users/{user_id}','edit');
            Route::put('users/{user_id}','update');
            Route::get('users/destroy/{user_id}','destroy');
            Route::get('/students','showStudents');
            Route::get('/instructors','showInstructors');

      });
    });
});
/*--------------All Admin Routes List----------------------*/

/*--------------All Instructor Routes List----------------------*/
Route::middleware(['auth', 'user-access:instructor'])->group(function () {

    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/instructor/home', [App\Http\Controllers\HomeController::class, 'instructorHome'])->name('instructor.home');
  
    //courses routes
    Route::get('/admin/courses',[App\Http\Controllers\Main\CourseController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/courses', [App\Http\Controllers\Main\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [App\Http\Controllers\Main\CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [App\Http\Controllers\Main\CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [App\Http\Controllers\Main\CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'destroy'])->name('courses.destroy');
    //courses routes

    //materials routes
    Route::get('/admin/materials', [App\Http\Controllers\Admin\MaterialController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [App\Http\Controllers\Admin\MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [App\Http\Controllers\Admin\MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');
    //materials routes

    //Category routes
    Route::get('/categories/index', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create']);
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
    //Category routes

    //Topic routes
    Route::get('courses/{course}/topics', [App\Http\Controllers\Main\TopicController::class, 'index'])->name('topics.index');
    Route::get('courses/{course}/topics/create', [App\Http\Controllers\Main\TopicController::class,'create'])->name('topics.create');
    Route::post('courses/{course}/topics/store', [App\Http\Controllers\Main\TopicController::class,'store'])->name('topics.store');
    Route::get('courses/{course}/topics/{topic}/edit', [App\Http\Controllers\Main\TopicController::class,'edit'])->name('topics.edit');
    Route::put('courses/{course}/topics/{topic}/update', [App\Http\Controllers\Main\TopicController::class,'update'])->name('topics.update');
    Route::delete('courses/{course}/topics/{topic}/destroy', [App\Http\Controllers\Main\TopicController::class,'destroy'])->name('topics.destroy');
    Route::get('courses/{course}/topics/{topic}/add-materials', [App\Http\Controllers\Main\TopicController::class, 'createMaterials'])->name('topics.addMaterials');
    Route::post('courses/{course}/topics/{topic}/store-materials', [App\Http\Controllers\Main\TopicController::class, 'storeMaterials'])->name('topics.storeMaterials');
    //Topic routes

    //Quiz routes
    Route::get('quizzes/create/{course}/{topic}', [App\Http\Controllers\Quiz\QuizController::class, 'create'])->name('quizzes.create');
    Route::post('quizzes', [App\Http\Controllers\Quiz\QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}', [App\Http\Controllers\Quiz\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('quizzes/{quiz}/addQuestions', [App\Http\Controllers\Quiz\QuestionController::class, 'create'])->name('questions.create');
    Route::post('quizzes/{quiz}/storeQuestions', [App\Http\Controllers\Quiz\QuestionController::class, 'store'])->name('questions.store');
    Route::post('quizzes/{quiz}/finish', [App\Http\Controllers\Quiz\QuizController::class, 'finish'])->name('quizzes.finish');
    Route::get('/quizzes/result/{quizId}/{score}', [App\Http\Controllers\Quiz\QuizController::class, 'result'])->name('quizzes.result');
    //Quiz routes

});
/*--------------All Instructor Routes List----------------------*/

/*--------------All Normal Users Routes List--------------*/

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/2fa-verify', [App\Http\Controllers\TwoFactorVerificationController::class, 'show'])->name('2fa.verify');
    Route::post('/2fa-verify', [App\Http\Controllers\TwoFactorVerificationController::class, 'verify']);
    
    // Add resources route
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');

    Route::get('/profile', [App\Http\Controllers\Profiles\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\Profiles\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\Profiles\ProfileController::class, 'update'])->name('profile.update');
