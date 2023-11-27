<?php

use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;

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
Route::get('/course/create', function () {
    return view('Courses.Create');
});
Route::get('/materials/create', function (){
    return view ('Materials.Create');
});
Auth::routes();

/*--------------All Normal Users Routes List--------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/2fa-verify', [App\Http\Controllers\TwoFactorVerificationController::class, 'show'])->name('2fa.verify');
    Route::post('/2fa-verify', [App\Http\Controllers\TwoFactorVerificationController::class, 'verify']);
    
    // materials section
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');

    // Profile Section
    Route::get('/profile', [App\Http\Controllers\Profiles\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\Profiles\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\Profiles\ProfileController::class, 'update'])->name('profile.update');

    //course section
    Route::post('/courses/{courseId}/enroll', [App\Http\Controllers\Main\EnrollmentController::class, 'enroll'])->name('enroll');
    Route::get('courses/{course}/topics', [App\Http\Controllers\Main\TopicController::class, 'index'])->name('topics.index');
    Route::get('/courses', [App\Http\Controllers\Main\CourseController::class, 'index'])->name('courses.index');
    Route::get('/mycourses', [App\Http\Controllers\Main\MyCoursesController::class, 'index'])->name('mycourses.index');
    Route::get('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'show'])->name('courses.show')->middleware('enroll.check');
    Route::get('/quizzes/{quiz}/max-attempts-reached', [App\Http\Controllers\Quiz\QuizController::class, 'maxAttemptsReached'])->name('quizzes.maxAttemptsReached');


    //Quiz section
    Route::get('quizzes/{quiz}', [App\Http\Controllers\Quiz\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/start-attempt', [App\Http\Controllers\Quiz\QuizController::class, 'startAttempt'])->name('quizzes.startAttempt');
    Route::post('quizzes/{quiz}/finish', [App\Http\Controllers\Quiz\QuizController::class, 'finish'])->name('quizzes.finish');
    Route::get('/quizzes/result/{quizId}/{score}', [App\Http\Controllers\Quiz\QuizController::class, 'result'])->name('quizzes.result');
    Route::get('/quizzes/{quiz}/max-attempts-reached', [App\Http\Controllers\Quiz\QuizController::class, 'maxAttemptsReached'])->name('quizzes.maxAttemptsReached');
    Route::get('/quizzes/user-results/{courseId}', [App\Http\Controllers\Quiz\QuizController::class, 'userResults'])->name('quizzes.userResults');

});
/*--------------All Normal Users Routes List--------------*/


  
/*--------------All Admin Routes List----------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/instructor/home', [App\Http\Controllers\HomeController::class, 'instructorHome'])->name('instructor.home');
    
   //courses routes
    Route::get('/admin/courses',[App\Http\Controllers\Main\CourseController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/courses', [App\Http\Controllers\Main\CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [App\Http\Controllers\Main\CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [App\Http\Controllers\Main\CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('/mycourses', [App\Http\Controllers\Main\MyCoursesController::class, 'index'])->name('mycourses.index');
    Route::get('/courses/{course}/topics/table', [App\Http\Controllers\Main\CourseController::class, 'showTopics'])->name('courses.showTopics');
    Route::patch('/courses/{course}/toggle-status', [App\Http\Controllers\Main\CourseController::class, 'toggleStatus'])->name('courses.toggle-status');
    

   //courses routes
   
   //materials routes
    Route::get('/admin/materials', [App\Http\Controllers\Admin\MaterialController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');
    Route::post('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [App\Http\Controllers\Admin\MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');
    Route::get('/materials/search', [App\Http\Controllers\Main\TopicController::class, 'search'])->name('materials.search');
   //materials routes

   //Category routes
    Route::get('/categories/index', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create']);
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');

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
    Route::get('topics/view-pdf/{materialId}', [App\Http\Controllers\Main\TopicController::class,'viewPDF'])->name('topics.view-pdf');
    Route::get('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'show'])->name('courses.show')->middleware('enroll.check');
   //Topic routes

   //Quiz routes
    Route::get('quizzes/create/{course}/{topic}', [App\Http\Controllers\Quiz\QuizController::class, 'create'])->name('quizzes.create');
    Route::post('quizzes', [App\Http\Controllers\Quiz\QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}', [App\Http\Controllers\Quiz\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('quizzes/{quiz}/addQuestions', [App\Http\Controllers\Quiz\QuestionController::class, 'create'])->name('questions.create');
    Route::post('quizzes/{quiz}/storeQuestions', [App\Http\Controllers\Quiz\QuestionController::class, 'store'])->name('questions.store');
    Route::post('quizzes/{quiz}/finish', [App\Http\Controllers\Quiz\QuizController::class, 'finish'])->name('quizzes.finish');
    Route::get('/quizzes/result/{quizId}/{score}', [App\Http\Controllers\Quiz\QuizController::class, 'result'])->name('quizzes.result');
    Route::get('/quizzes/{quiz}/max-attempts-reached', [App\Http\Controllers\Quiz\QuizController::class, 'maxAttemptsReached'])->name('quizzes.maxAttemptsReached');
    Route::get('/quizzes/user-results/{courseId}', [App\Http\Controllers\Quiz\QuizController::class, 'userResults'])->name('quizzes.userResults');
    Route::get('quiz/course-results', [App\Http\Controllers\Quiz\QuizController::class, 'courseResults'])->name('quizzes.courseResults');
   //Quiz routes

   // Profile Section
    Route::get('/profile', [App\Http\Controllers\Profiles\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\Profiles\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\Profiles\ProfileController::class, 'update'])->name('profile.update');
   // Profile Section

    Route::prefix('admin')->group(function (){
       //Create user Routes
       Route::controller(App\Http\Controllers\Admin\UserController::class)->group(function(){
            Route::get('/users','index');
            Route::get('/users/create','create');
            Route::post('/users', 'store');
            Route::get('/users/{user_id}','edit')->name('user.edit');
            Route::put('users/{user_id}','update');
            Route::get('users/destroy/{user_id}','destroy')->name('user.delete');
            Route::get('/students','showStudents');
            Route::get('/instructors','showInstructors');
            Route::get('/administrators', 'showAdmins');

      });
    });
});
/*--------------All Admin Routes List----------------------*/

/*--------------All Instructor Routes List----------------------*/
Route::middleware(['auth', 'user-access:instructor'])->group(function(){

    Route::get('/instructor/home', [App\Http\Controllers\HomeController::class, 'instructorHome'])->name('instructor.home');
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
  
    //courses routes
    Route::get('/admin/courses',[App\Http\Controllers\Main\CourseController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/courses', [App\Http\Controllers\Main\CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [App\Http\Controllers\Main\CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [App\Http\Controllers\Main\CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('/mycourses', [App\Http\Controllers\Main\MyCoursesController::class, 'index'])->name('mycourses.index');
    Route::patch('/courses/{course}/toggle-status', [App\Http\Controllers\Main\CourseController::class, 'toggleStatus'])->name('courses.toggle-status');
    Route::get('/courses/{course}/topics', [App\Http\Controllers\Main\CourseController::class, 'showTopics'])->name('courses.showTopics');

    //courses routes

    //materials routes
    Route::get('/admin/materials', [App\Http\Controllers\Admin\MaterialController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');
    Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [App\Http\Controllers\Admin\MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [App\Http\Controllers\Admin\MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::get('materials/{file}', [App\Http\Controllers\Admin\MaterialController::class, 'download'])->name('materials.download');
    Route::get('/materials/search', [App\Http\Controllers\Main\TopicController::class, 'search'])->name('materials.search');
    //materials routes

    //Category routes
    Route::get('/categories/index', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create']);
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
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
    Route::get('topics/view-pdf/{materialId}', [App\Http\Controllers\Main\TopicController::class,'viewPDF'])->name('topics.view-pdf');

    Route::get('/courses/{course}', [App\Http\Controllers\Main\CourseController::class, 'show'])->name('courses.show')->middleware('enroll.check');

    //Topic routes

    //Quiz routes
    Route::get('quizzes/create/{course}/{topic}', [App\Http\Controllers\Quiz\QuizController::class, 'create'])->name('quizzes.create');
    Route::post('quizzes', [App\Http\Controllers\Quiz\QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}', [App\Http\Controllers\Quiz\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('quizzes/{quiz}/addQuestions', [App\Http\Controllers\Quiz\QuestionController::class, 'create'])->name('questions.create');
    Route::post('quizzes/{quiz}/storeQuestions', [App\Http\Controllers\Quiz\QuestionController::class, 'store'])->name('questions.store');
    Route::post('quizzes/{quiz}/finish', [App\Http\Controllers\Quiz\QuizController::class, 'finish'])->name('quizzes.finish');
    Route::get('/quizzes/result/{quizId}/{score}', [App\Http\Controllers\Quiz\QuizController::class, 'result'])->name('quizzes.result');
    Route::get('/quizzes/{quiz}/max-attempts-reached', [App\Http\Controllers\Quiz\QuizController::class, 'maxAttemptsReached'])->name('quizzes.maxAttemptsReached');
    Route::get('/quizzes/user-results/{courseId}', [App\Http\Controllers\Quiz\QuizController::class, 'userResults'])->name('quizzes.userResults');
    Route::get('quiz/course-results', [App\Http\Controllers\Quiz\QuizController::class, 'courseResults'])->name('quizzes.courseResults');
    //Quiz routes

    // Profile Section
    Route::get('/profile', [App\Http\Controllers\Profiles\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\Profiles\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\Profiles\ProfileController::class, 'update'])->name('profile.update');
});
/*--------------All Instructor Routes List----------------------*/

Route::get('/chatbot', [App\Http\Controllers\ChatbotController::class, 'index']);
Route::post('/chatbot/ask', [App\Http\Controllers\ChatbotController::class, 'ask']);

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submitForm'])->name('contact.submit');
