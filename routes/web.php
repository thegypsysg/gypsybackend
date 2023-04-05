<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\EmployerContactController;
use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Admin\EmployerJobLocationController;
use App\Http\Controllers\Admin\HealthCareSettingController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\JobCategoryController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TownController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\AppGroupController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DynamicOptionController;
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
Route::get('/', function(){
    return redirect('/login');
});
Route::get("/foo", function() {
     Artisan::call('storage:link');
});
Route::get('login', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login'])->name('login'); 

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', function(){
        return view('pages.dashboard');
    })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('job-categories', [JobCategoryController::class, 'index'])->name('job-categories.index');
    Route::get('major-cities', [CityController::class, 'index'])->name('major-cities.index');
    Route::get('health-care', [HealthCareSettingController::class, 'index'])->name('health-care.index');

    Route::resource('app-groups', AppGroupController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('cities', CityController::class);
    Route::resource('towns', TownController::class);
    Route::resource('zones', ZoneController::class);
    
    Route::resource('inquiries', InquiryController::class);
    Route::resource('healthcaresettings', HealthCareSettingController::class);
    Route::resource('users', UserController::class);
    Route::resource('skills', SkillController::class);

    Route::post('countries/update-active/{country}', [CountryController::class,'updateActive'])->name('updateActive');
    Route::post('countries/update-favorite/{country}', [CountryController::class,'updateFavorite'])->name('updateFavorite');
    Route::post('countries/upload-image', [CountryController::class, 'uploadImage'])->name('uploadImage');
    Route::get('countries/image-remove/{id}', [CountryController::class, 'imageRemove'])->name('imageRemove');
    Route::post('skills/upload-image', [SkillController::class, 'uploadImage'])->name('skills.uploadImage');
    Route::get('skills/image-remove/{id}', [SkillController::class, 'imageRemove'])->name('skills.imageRemove');

    Route::resource('employers', EmployerController::class);
    Route::post('employers/upload-image', [EmployerController::class, 'uploadImage'])->name('employers.uploadImage');
    Route::get('employers/image-remove/{id}', [EmployerController::class, 'imageRemove'])->name('employers.imageRemove');
    Route::post('employers/update-active/{employer}', [EmployerController::class,'updateActive'])->name('employers.updateActive');
    Route::post('employers/update-featured/{employer}', [EmployerController::class,'updateFeatured'])->name('employers.updateFeatured');
    Route::get('employers/info/{employer}', [EmployerController::class,'mainInfo'])->name('employers.mainInfo');

    Route::resource('employer-contacts', EmployerContactController::class);
    Route::resource('employer-job-locations', EmployerJobLocationController::class);
    Route::get('/country/{country_name}', [DynamicOptionController::class, 'getCities'])->name('getCities');
    Route::get('/city/{city_name}', [DynamicOptionController::class, 'getTowns'])->name('getTowns');

    Route::post('healthcares/upload-image', [HealthCareSettingController::class, 'uploadImage'])->name('healthcares.uploadImage');
    Route::get('healthcares/image-remove/{id}', [HealthCareSettingController::class, 'imageRemove'])->name('healthcares.imageRemove');
});

