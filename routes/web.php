<?php

use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForumsController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\TopicsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('signup', [Student\RegistrationController::class, 'signup'])->name('signup');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student
Route::middleware(['auth:sanctum', 'web.student'])->group(function () {
    Route::get('dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');

    // StudentCourses
    Route::get('my-courses', [Student\StudentCourseController::class, 'index'])->name('studentCourses');
    Route::get('my-courses/{slug}', [Student\StudentCourseController::class, 'show'])->name('studentCourses.show');

    // Forums
    Route::get('forums', [Student\ForumsController::class, 'index'])->name('forums');
    Route::post('forums', [Student\ForumsController::class, 'store'])->name('forums.store');
    Route::get('forums/{forum}', [Student\ForumsController::class, 'show'])->name('forums.show');
    Route::post('forums/{forum}', [Student\ForumsController::class, 'update'])->name('forums.update');
    Route::post('forums/close/{forum}', [Student\ForumsController::class, 'close'])->name('forums.close');
    Route::post('forums/delete/{forum}', [Student\ForumsController::class, 'delete'])->name('forums.delete');
    Route::post('forums/like/{forum}', [Student\ForumsController::class, 'like'])->name('forums.like');
    Route::post('forums/comment/{forum}', [Student\ForumsController::class, 'comment'])->name('forums.comment');
    Route::post('forums/comment/reply/{comment}', [Student\ForumsController::class, 'commentReply'])->name('forums.commentReply');

    // Browse / All Courses
    Route::get('explore-courses', [Student\CourseController::class, 'index'])->name('courses');
    Route::get('courses/{slug}', [Student\CourseController::class, 'show'])->name('courses.show');
    Route::post('courses/{course}/start', [Student\CourseController::class, 'start'])->name('courses.start');

    // Topics
    Route::get('topics/{slug}', [Student\TopicsController::class, 'show'])->name('topics.show');
    Route::post('topics/{studentCourse}/{topic}/mark-as-complete', [Student\TopicsController::class, 'markAsComplete'])->name('topics.markAsComplete');

    // Assessments
    Route::get('topics/assessment/{assessment}', [Student\AssessmentController::class, 'show'])->name('assessment.show');
    Route::post('topics/assessment/{assessment}/start', [Student\AssessmentController::class, 'startAssessment'])->name('assessment.start');
    Route::get('topics/assessment/{assessment}/{question}/show', [Student\AssessmentController::class, 'showQuestion'])->name('assessment.showQuestion');
    Route::get('topics/assessment/{id}/result', [Student\AssessmentController::class, 'result'])->name('assessment.result');
    Route::post('topics/assessment/{id}/next', [Student\AssessmentController::class, 'nextQuestion'])->name('assessment.next');
    Route::get('topics/assessment/{id}/practical', [Student\AssessmentController::class, 'showPractical'])->name('assessment.showPractical');
    Route::post('topics/assessment/{id}/practical/mark-as-complete', [Student\AssessmentController::class, 'markPracticalCompleted'])->name('topics.markPracticalCompleted');

    // DataTables
    Route::get('datatables/courses', [Student\CourseController::class, 'getDataTable'])->name('datatable.courses');
    Route::get('topics/data-table', [Student\TopicsController::class, 'getDataTable'])->name('datatable.topics');

});

Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum', 'web.admin'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/get-user-count', [DashboardController::class, 'getUserCount'])->name('dashboard.getUserCount');
    Route::get('dashboard/get-students-count', [DashboardController::class, 'getStudentsCount'])->name('dashboard.getStudentsCount');

    // Users
    Route::get('users/administrators', [UserController::class, 'index'])->name('users');
    Route::get('users/administrators/data-table', [UserController::class, 'getDataTable'])->name('datatable.admins');
    Route::patch('users/administrators/toggle-status/{user}', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('users/administrators/store', [UserController::class, 'store'])->name('users.store');
    Route::post('users/administrators/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('users/administrators/delete/{id}', [UserController::class, 'delete'])->name('users.delete');


    // Students
    Route::get('users/students', [StudentController::class, 'index'])->name('students');
    Route::get('users/students/data-table', [StudentController::class, 'getDataTable'])->name('datatable.students');
    Route::post('users/students/delete/{id}', [StudentController::class, 'delete'])->name('students.delete');
    Route::post('users/students/update-forum-status/{id}', [StudentController::class, 'updateForumStatus'])->name('students.update-forum-status');
    Route::patch('users/students/toggle-status/{student}', [StudentController::class, 'toggleStatus'])->name('students.toggleStatus');
    Route::post('users/students/update/{id}', [StudentController::class, 'update'])->name('students.update');

    // StudentCourses
    Route::get('courses', [CourseController::class, 'index'])->name('courses');
    Route::get('courses/{slug}/overview', [CourseController::class, 'show'])->name('courses.show');
    Route::get('courses/data-table', [CourseController::class, 'getDataTable'])->name('datatable.courses');
    Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
    Route::post('courses/delete/{id}', [CourseController::class, 'delete'])->name('courses.delete');
    Route::patch('courses/toggle-status/{course}', [CourseController::class, 'toggleStatus'])->name('courses.toggleStatus');
    Route::post('courses/update/{id}', [CourseController::class, 'update'])->name('courses.update');

    // Topics
    Route::post('topics', [TopicsController::class, 'store'])->name('topics.store');
    Route::post('topics/update/{topic}', [TopicsController::class, 'update'])->name('topics.update');
    Route::get('topics/data-table', [TopicsController::class, 'getDataTable'])->name('datatable.topics');
    Route::get('topics/{slug}/edit', [TopicsController::class, 'edit'])->name('topics.edit');
    Route::patch('topics/toggle-status/{topic}', [TopicsController::class, 'toggleStatus'])->name('topics.toggleStatus');
    Route::post('topics/delete/{id}', [TopicsController::class, 'delete'])->name('topics.delete');

    // Reports
    Route::get('reports', [ReportsController::class, 'index'])->name('reports');
    Route::post('reports/{type}', [ReportsController::class, 'export'])->name('reports.export');

    // Forums
    Route::get('forums', [ForumsController::class, 'index'])->name('forums');
    Route::post('forums', [ForumsController::class, 'store'])->name('forums.store');
    Route::get('forums/{forum}', [ForumsController::class, 'show'])->name('forums.show');
    Route::post('forums/{forum}', [ForumsController::class, 'update'])->name('forums.update');
    Route::post('forums/close/{forum}', [ForumsController::class, 'close'])->name('forums.close');
    Route::post('forums/delete/{forum}', [ForumsController::class, 'delete'])->name('forums.delete');
    Route::post('forums/like/{forum}', [ForumsController::class, 'like'])->name('forums.like');
    Route::post('forums/comment/{forum}', [ForumsController::class, 'comment'])->name('forums.comment');
    Route::post('forums/comment/reply/{comment}', [ForumsController::class, 'commentReply'])->name('forums.commentReply');

    // Assessments
    Route::get('assessments', [AssessmentController::class, 'index'])->name('assessments');
    Route::post('assessments', [AssessmentController::class, 'store'])->name('assessments.store');
    Route::get('assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');
    Route::get('assessments/data-table', [AssessmentController::class, 'getDataTable'])->name('assessments.courses');
    Route::post('assessments/delete/{id}', [AssessmentController::class, 'delete'])->name('assessments.delete');
    Route::post('assessments/update/{id}', [AssessmentController::class, 'update'])->name('assessments.update');
    Route::patch('assessments/toggle-status/{assessment}', [AssessmentController::class, 'toggleStatus'])->name('assessments.toggleStatus');
    Route::get('assessments/{id}/details', [AssessmentController::class, 'show'])->name('assessments.show');
    Route::patch('assessments/update-practical-content/{id}', [AssessmentController::class, 'updatePracticalContent'])->name('assessments.updatePracticalContent');

    // Questions
    Route::post('questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('questions/data-table', [QuestionController::class, 'getDataTable'])->name('questions.courses');
    Route::post('questions/delete/{id}', [QuestionController::class, 'delete'])->name('questions.delete');
    Route::post('questions/update/{id}', [QuestionController::class, 'update'])->name('questions.update');

    // Axios Request
    // Get topic by course_id
    Route::get('topics/{id}/get-all', [AssessmentController::class, 'getTopicsByCourse'])->name('assessments.getTopicsByCourse');


});

//Course Details
Route::get('/home/topic-list/{id}', [HomeController::class, 'showCourse'])->name('home.topic-list');
Route::get('/lessons/{slug}', [HomeController::class, 'showLesson'])->name('home.show-lesson');
Route::get('/lessons/assessment/{id}', [HomeController::class, 'showAssessment'])->name('home.show-assessment');
Route::get('/lessons/assessment/{id}/start', [HomeController::class, 'startAssessment'])->name('home.start-assessment');
Route::post('/lessons/assessment/{id}/next', [HomeController::class, 'nextQuestion'])->name('home.assessments.next');
Route::get('/lessons/assessment/{id}/result', [HomeController::class, 'result'])->name('home.assessments.result');
Route::get('/lessons/assessment/{assessment_id}/{question_id}', [HomeController::class, 'showQuestion'])->name('home.assessments.show-question');
Route::get('/lessons/assessments/practical/{id}', [HomeController::class, 'showPractical'])->name('home.assessments.showPractical');

require __DIR__ . '/auth.php';
