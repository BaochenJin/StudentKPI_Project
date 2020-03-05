<?php

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

Route::get('/home', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::resource("course",'CourseController');
	Route::post("add-student",'StudentController@add_student');
	Route::post("edit-student",'StudentController@edit_student');
	Route::post("delete-student",'StudentController@delete_student');
	Route::get("all-students",'StudentController@get_students');
	Route::get("get-student-period",'StudentController@get_period');
	Route::get("all-courses-student",'StudentController@courses_student');
	Route::get("get-course-unique",'StudentController@course_unique');
	Route::get("get-student-id",'StudentController@student_id');
	
	Route::post("add-total",'TotalValController@add_total');
	Route::post("edit-total",'TotalValController@edit_total');
	Route::post("delete-total",'TotalValController@delete_total');
	Route::get("all-totals",'TotalValController@get_totals');
	Route::get("all-instructors",'TotalValController@get_instructors');
	Route::get("totals-counts",'TotalValController@get_totals_counts');
	Route::get("midterm-counts",'TotalValController@get_data_midterm');
	Route::get("final-counts",'TotalValController@get_data_final');
	Route::get("total-counts",'TotalValController@get_total_counts');
	Route::get("get-charts",'TotalValController@get_charts');
	

	Route::post("add-course",'CourseController@add_course');
	Route::get("all-courses",'CourseController@get_courses');
	Route::post("edit-course",'CourseController@editCourse');
	Route::post("delete-course",'CourseController@deleteCourse');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

