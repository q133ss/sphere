<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Broadcast::routes(["middleware" => "auth"]);

Route::get('/', 'SiteController@index')->name('home');
Route::get('/profile', function(){
    return redirect()->route(auth()->user()->role->name . '.profile');
})->middleware(['auth']);
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::view('/consent', 'site.consent')->name('consent');
Route::view('/pravila', 'site.pravila')->name('pravila');
Route::view('/oferta', 'site.oferta')->name('oferta');
Route::view('/oferta_teacher', 'site.oferta_teacher')->name('oferta.teacher');
Route::view('/oferta_student', 'site.oferta_student')->name('oferta.student');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/posts', 'HomeController@posts')->name('posts.index');
Route::get('/posts/{post}', 'HomeController@post')->name('posts.show');


Route::group([
    'middleware' => ['auth']
], function(){
    Route::get('/chat/users', 'ChatController@users');
    Route::get('/chat/getMessages', 'ChatController@getMessages');
    Route::post('/chat/message', 'ChatController@message');
    Route::delete('/lessons/deleteFile/{id}', 'LessonController@deleteFile');
    Route::get('/materials', function(){ return App\Material::all(); });
    Route::post('/profile', 'UserController@update')->name('profile.update');
    Route::post('/profile/photo', 'UserController@uploadPhoto')->name('profile.uploadPhoto');
    Route::post('/profile/docs', 'UserController@uploadDocs')->name('profile.uploadDocs');
    Route::get('/student_dashboard/payments', 'PaymentController@index')->name('student.payments.index');
    Route::get('/teacher_dashboard/payments', 'PaymentController@index')->name('teacher.payments.index');
    Route::post('/payments', 'PaymentController@store')->name('payments.store');

    Route::view('/student_dashboard/tickets', 'tickets.index')->name('student.tickets.index');
    Route::view('/teacher_dashboard/tickets', 'tickets.index')->name('teacher.tickets.index');
    Route::view('/admin_dashboard/tickets', 'tickets.index')->name('admin.tickets.index');
    Route::post('/tickets/{ticket}/reply', 'TicketController@reply');
    Route::get('/tickets/{ticket}/getMessages', 'TicketController@getMessages');
    Route::post('/tickets/{ticket}/close', 'TicketController@close');
    Route::apiResource('/tickets', 'TicketController')->only(['index', 'store']);

    Route::get('/subjects', 'UserController@getSubjects');
    Route::post('/notifications/read', 'NotificationController@read');
    Route::get('/notifications', 'NotificationController@index');
    Route::delete('/notifications/{notification}', 'NotificationController@destroy');

    Route::resource('/lessons', 'LessonController');
    Route::post('/lessons/{lesson}/addMaterial', 'LessonController@addMaterial');
    Route::put('/lessons/{lesson}/saveBoard', 'LessonController@saveBoard');
    Route::post('/lessons/{lesson}/done', 'LessonController@done');
});

Route::group([
    'prefix' => 'admin_dashboard',
    'namespace' => 'Admin',
    'as' => 'admin.',
    'middleware' => ['role:1']
], function(){
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('/profile', 'UserController@showProfile')->name('profile');
    Route::post('/users/{user}/confirm', 'UserController@confirm')->name('users.confirm');
    Route::resource('/posts', 'PostController');
    Route::post('/posts/{post}/removePreview', 'PostController@removePreview')->name('posts.removePreview');
    Route::post('/posts/{post}/removeDetail', 'PostController@removeDetail')->name('posts.removeDetail');
    Route::resource('/faq', 'FaqController');
    Route::resource('/users', 'UserController');
    Route::resource('/questions', 'QuestionController');
    Route::resource('/materials', 'MaterialController');
    Route::post('/questions/{question}/reply', 'QuestionController@reply')->name('questions.reply');
    Route::get('/payments', 'PaymentController@index')->name('payments.index');
    Route::get('/conflicts', 'ConflictController@index')->name('conflicts.index');
    Route::delete('/files/{file}', 'FileController@destroy')->name('files.destroy');
});

Route::group([
    'prefix' => 'student_dashboard',
    'namespace' => 'Student',
    'as' => 'student.',
    'middleware' => ['role:1|2']
], function(){
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('/profile', 'UserController@showProfile')->name('profile');
    Route::get('/find', 'FindController@index')->name('find.index');
    Route::get('/schedule', 'ScheduleController@index')->name('schedule.index');
    Route::get('/teachers/my', 'TeacherController@my')->name('teachers.my');
    Route::get('/teachers', 'TeacherController@index')->name('teachers.index');
    Route::get('/teachers/{id}/getSchedule', 'TeacherController@getSchedule');
    Route::get('/teachers/{id}', 'TeacherController@show')->name('teachers.show');
    Route::post('/teachers/{id}/subscribe', 'TeacherController@subscribe');
    Route::post('/teachers/{id}/unsubscribe', 'TeacherController@unsubscribe');
    Route::resource('/lessons', 'LessonController')->only(['index', 'show']);
    Route::get('/pay', 'PayController@index')->name('pay.index');
    Route::get('/edit', 'EditController@index')->name('edit.index');
    Route::post('/edit/update', 'EditController@update')->name('edit.update');
    //Ajax filter
    Route::post('/lessons', 'LessonFilterController@filter')->name('lessons.filter');
});

Route::group([
    'prefix' => 'teacher_dashboard',
    'namespace' => 'Teacher',
    'as' => 'teacher.',
    'middleware' => ['role:1|3']
], function(){
    Route::get('/', 'DashboardController@index')->name('index');
    Route::view('/info', 'teacher.info')->name('info');
    Route::get('/profile', 'UserController@showProfile')->name('profile');
    Route::get('/students', 'UserController@showStudents')->name('students.index');
    Route::post('/students', 'UserController@search')->name('students.find');
    Route::post('/subscribe', 'SubscribeController@store')->name('subscribe.store');
    Route::get('/subscribe', 'SubscribeController@index')->name('subscribe.index');
    Route::apiResource('/schedule', 'ScheduleController');
    Route::resource('/lessons', 'LessonController')->only(['index', 'show']);
    Route::get('/materials', 'MaterialController@index')->name('material.index');
    Route::get('/material/file', 'MaterialController@file')->name('material.file');
    Route::get('/material/book/{id}', 'MaterialController@show')->name('material.show');
    //Route::get('/materials/install', 'MaterialController@install')->name('material.install');
});


//Quiz check, delete late
Route::post('/asd', function (){
    dd($_POST);
})->name('check');
