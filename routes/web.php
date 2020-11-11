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
    return redirect('/login');
});
Auth::routes();
 
Route::group([
    'namespace' => 'API\V1',

    'middleware' => ['web', 'auth']
], function () {
    //Cargo API
    Route::get('cargo', 'CargoController@getAllCargo');
    Route::post('cargo', 'CargoController@store');
    Route::delete('cargo/{id}', 'CargoController@delete');
    Route::get('cargo/{id}', 'CargoController@edit');
    Route::put('cargo/{id}', 'CargoController@update');

    // updated by Gaurav Agrawal on 28-10-2020 to modify api for consignee in PLP1-173
    // Consignee API

    Route::get('consignee', 'ConsigneeController@index');
    Route::get('consignee/{id}', 'ConsigneeController@show');
    Route::put('consignee/{id}', 'ConsigneeController@update');
    Route::post('consignee', 'ConsigneeController@store');
    Route::delete('consignee/{id}', 'ConsigneeController@destroy');

    //Organization API
    Route::get('/organization', 'OrganizationController@getOrganization');
    Route::put('organization/{id}', 'OrganizationController@updateOrganizationDetails');
   // Route::post('/update-organization-rate', 'OrganizationController@updateOrganizationRate');

    //End of comment


    //Department API
    Route::get('department', 'DepartmentController@getAllDepartments');
    Route::post('department', 'DepartmentController@storeDepartments');
    Route::get('department/{id}', 'DepartmentController@editDepartments');
    Route::put('department/{id}', 'DepartmentController@updateDepartments');
    Route::delete('department/{id}', 'DepartmentController@deleteDepartments');

    // Roles & Privileges
    Route::get('/role', 'UserRoleController@getRole');
    Route::post('role', 'UserRoleController@storeRole');
    Route::put('role/{id}', 'UserRoleController@updateRole');
    Route::delete('role/{id}', 'UserRoleController@destroyRole');
    Route::get('role/{id}', 'UserRoleController@editRole');

    
    //Truck Company
    Route::get('truck-company', 'TruckCompanyController@index');
    Route::post('truck-company', 'TruckCompanyController@store');
    Route::delete('truck-company/{id}', 'TruckCompanyController@delete');
    Route::get('truck-company/{id}', 'TruckCompanyController@edit');
    Route::put('truck-company/{id}', 'TruckCompanyController@update');
//  Route::any('truck-company/get', 'TruckCompanyController@getTruckCompanyList');
    
    //Trucks
    Route::get('truck', 'TruckController@getAllTrucks');
    Route::post('truck', 'TruckController@storeTrucks');
    Route::get('truck/{id}', 'TruckController@editTrucks');
    Route::put('truck/{id}', 'TruckController@updateTrucks');
    Route::delete('truck/{id}', 'TruckController@deleteTrucks');


    //Vessel API
    Route::get('vessel', 'VesselController@getAllVessel');
    Route::post('vessel', 'VesselController@storeVessel');
    Route::put('vessel/{id}', 'VesselController@updateVessel');
    Route::delete('vessel/{id}', 'VesselController@destroyVessel');
    Route::get('vessel/{id}', 'VesselController@editVessel');
    Route::get('/vessel/sorted-list/{keyword?}','VesselController@autocomplete');
    
    //Location API
    Route::get('/location', 'LocationController@getAllLocation');
    Route::post('/location', 'LocationController@storeLocation');
    Route::put('/location/{id}', 'LocationController@updateLocation');
    Route::delete('/location/{id}', 'LocationController@destroyLocation');
    Route::get('/location/{id}', 'LocationController@editLocation');
    
     //For User
    Route::get('/users','UserController@index');
    Route::get('/user','UserController@add');
    Route::get('/user/{id?}','UserController@edit');
    Route::post('/user','UserController@store');
    Route::put('user/{id?}', 'UserController@update'); 

    // Dashboard API
    Route::post('dashboard', 'DashboardController@fetchDetails');
    Route::post('csv-export','ExcelDownloadController@csvExport');
});


Route::group([
    'namespace' => 'API\V1',
    'prefix' => 'admin',
    'middleware' => ['web', 'auth']
], function () {

    Route::post('role-privileges/save', 'RoleprivilegeController@savePrivileges');
    Route::any('role-privileges/getPrivileges', 'RoleprivilegeController@getPrivileges');

       

    //cache routes
    Route::post('clear-cache-data', 'BaseController@clearCache');
    Route::post('clear-cache-menu', 'BaseController@clearCacheMenu');
    Route::get('clear-cache', 'BaseController@clearCacheView'); 
   

});
// 'web_access'
Route::group([
    'namespace' => 'API\V1',
    'middleware' => ['web', 'auth']
], function () {
    //Profile API
    Route::get('/profile','ProfileController@index')->name('profile');
    Route::post('updateName', 'ProfileController@updateName');
    Route::post('updatePassword', 'ProfileController@updatePassword');
    Route::post('validateCurrentPassword', 'ProfileController@validateCurrentPassword');
    Route::post('user/image', 'ProfileController@profileImageUpload'); 
    // Dashboard API
    Route::get('/home', 'DashboardController@show')->name('home');
    
    //Planning 
    Route::get('plans', 'BtopPlanningController@list');
    Route::post('plan/list-ajax', 'BtopPlanningController@getPlanningList');
    Route::get('plan', 'BtopPlanningController@add');
    Route::get('plan/{id?}', 'BtopPlanningController@edit');
    Route::delete('plan/{id?}', 'BtopPlanningController@delete');
    Route::post('plan', 'BtopPlanningController@store');
    Route::put('plan/{id?}', 'BtopPlanningController@update');
    

    // Add Truck For Planning
    Route::post('/planning/truck/add','BtopPlanningController@create');
    Route::post('/planning/get-trucks','BtopPlanningController@getTrucks')->name('getTrucks');
    Route::post('plan/truck','BtopPlanningController@storeTruckForBtopPlan');
    Route::delete('plan/truck/{plan_id}/{truck_id}','BtopPlanningController@deleteTruckForBtopPlan');

    //Challan API
    Route::get('/challans', 'ChallanController@index');
    Route::post('/challan/list-ajax', 'ChallanController@getChallanList');
    Route::post('/challan/reconcile', 'ChallanController@reconcileChallan'); 
});


Route::group([
    'namespace' => 'API\V1',
    'middleware' => ['web', 'auth']
], function () {
    //Profile API
    Route::get('/profile','ProfileController@index');
    Route::post('updateName', 'ProfileController@updateName');
    Route::post('updatePassword', 'ProfileController@updatePassword');
    Route::post('validateCurrentPassword', 'ProfileController@validateCurrentPassword');
    Route::post('profile-image-upload', 'ProfileController@profileImageUpload');
    // Dashboard API
    Route::get('/home', 'DashboardController@show')->name('home');
});

Route::any('/password/sendemail', 'API\V1\SetPasswordController@sendEmail');
Route::any('/password/save', 'API\V1\SetPasswordController@savePassword');