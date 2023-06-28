<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('clinic/', [TestController::class, 'getClinic']); */

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
	/* Route::get('/', function () {
		return view('home');
	}); */
	
	Route::get('/', 'HomeController@index')->name('clinic.home');
	
	Route::group(['middleware' => ['guest']], function() {

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::get('/patient_login', 'LoginController@patient_login')->name('patient.login.show');
        Route::post('/patient_login', 'LoginController@patient_gen_otp')->name('patient.gen.otp');
		Route::get('/patient_verification', 'LoginController@patient_verify')->name('patient.verify.show');
		Route::post('/patient_verification', 'LoginController@patient_verify_process')->name('patient.login.perform');
        Route::get('/patient_register', 'LoginController@patient_register')->name('patient.register.show');
        Route::post('/patient_register', 'LoginController@patient_register_save')->name('patient.register.save');
        Route::post('/login', 'LoginController@login')->name('login.perform');
        Route::get('/logout', 'LoginController@logout')->name('login.logout');        

    });	
	
	Route::group(['prefix' => 'ca_dashboard', 'middleware' => ['clinicAdminAccess']], function() {
		Route::get('/', 'ClinicController@dashboard')->name('clinic.admin.dashboard');
		Route::get('/my-clinic', 'ClinicController@show')->name('my-clinic.show');
		Route::resource('staffs', 'StaffController');
		Route::get('doctors', 'DoctorController@index')->name('doctors.index');
		Route::get('doctor', 'DoctorController@view')->name('doctor.view');
	 
	});
	
	Route::group(['prefix' => 'doctor_dashboard', 'middleware' => ['doctorAdminAccess']], function() {
		Route::get('/', 'DoctorController@dashboard')->name('doctor.dashboard');
		Route::get('/patients', 'DoctorController@patients')->name('doctor.patients');
		Route::resource('timings', 'TimingController');
		Route::post('timings-save', 'TimingController@save')->name('timings.save');
		Route::get('/update-token/{patient_id}/{slot_id}/{status}', 'DoctorController@update_token')->name('doctor.update_token');
	});
	
	Route::group(['prefix' => 'staff_dashboard', 'middleware' => ['staffAccess']], function() {
		Route::get('/', 'ClinicController@dashboard')->name('dashboard');
		
	});
	
	Route::group(['prefix' => 'user_dashboard', 'middleware' => ['patientAccess']], function() {
		Route::get('/', 'PatientController@dashboard')->name('patient.dashboard');
		Route::get('/book-appointment/{doctor_id}/{slot_id}', 'PatientController@book_appointment')->name('patient.book_appointment');
		Route::get('/refresh-status/{doctor_id}/{slot_id}', 'PatientController@refresh_status')->name('patient.refresh_status');
		
	});
	
});
