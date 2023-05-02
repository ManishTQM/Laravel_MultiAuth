<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SuperAdmin\Permissions;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;

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

//----------------------------Admin-----------------------//

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
 
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', function () {
            return view('admin/auth/index');
        })->name('AadminDashboard');

        Route::get('/pdf',[UserController::class,'getPdf'])->middleware(['auth:admin'])->name('users.getPdf');
        Route::get('/excel',[UserController::class,'getExcel'])->middleware(['auth:admin'])->name('users.getExcel');
        Route::get('/admin_userlist',[AdminAuthController::class,'index'])->middleware(['auth:admin'])->name('admin.index');
        Route::get('/usersDestroy/{id}',[UserController::class,'destroy'])->middleware(['auth:admin'])->name('users.destroy');
        Route::get('/logout',[AdminAuthController::class,'AdminLogout'])->name('admin.logout')->middleware('admin');
        Route::get('/home',[HomeController::class,'homeIndex'])->middleware(['auth:admin'])->name('home.homeIndex');
    });
});

//----------------------------Super-Admin-----------------------//

Route::group(['prefix' => 'superadmin', 'namespace' => 'SuperAdmin'], function () {
    Route::get('/login', [SuperAdminAuthController::class, 'getLogin'])->name('superadminLogin');
    Route::post('/login', [SuperAdminAuthController::class, 'postLogin'])->name('superadminLoginPost');
});
Route::group([
    'namespace' => 'SuperAdmin',
    'prefix' => 'superadmin',
    'middleware' => ['auth', 'verified'],
], function () {});
Route::group(['middleware' => 'auth:super'], function () {
    Route::get('/', function () {
        return view('super_admin/auth/index');
    })->name('superAdminDashboard');
    
        Route::post('/superadmin/datasave', [SuperAdminAuthController::class, 'store'])->middleware(['auth:super'])->name('super_admin.superadminRegister');
      
        Route::get('/superadmin/registers', [SuperAdminAuthController::class, 'signupView'])->middleware(['super','verified'])->name('super_admin.regSuper');
        Route::get('/home',[SuperAdminAuthController::class,'homeIndex'])->middleware(['auth:super'])->name('super_admin.homeIndex');
        Route::get('/superadmin/userList',[SuperAdminAuthController::class,'index'])->middleware(['auth:super'])->name('super_admin.userList');
        Route::get('/superadmin/permission',[SuperAdminAuthController::class,'permision'])->middleware(['auth:super'])->name('super_admin.permission');
        Route::get('/superadmin/super_admin',[SuperAdminAuthController::class,'allView'])->middleware(['auth:super'])->name('super_admin.allView');
        Route::get('/superadmin/add_role',[SuperAdminAuthController::class,'addRole'])->middleware(['auth:super'])->name('addRole.index');
        Route::get('/superadmin/show_role',[SuperAdminAuthController::class,'showRole'])->middleware(['auth:super'])->name('showRole.index');
        Route::get('/superadmin/index',[SuperAdminAuthController::class,'index'])->middleware(['auth:super'])->name('super_admin.index');
        Route::get('/superadmin/view_role/{id}',[SuperAdminAuthController::class,'viewRole'])->middleware(['auth:super'])->name('role.view');
        Route::get('/superadmin/edit/{id}',[SuperAdminAuthController::class,'editUser'])->middleware(['auth:super'])->name('super.editUser');
        Route::post('/superadmin/editUsers/{id}',[SuperAdminAuthController::class,'userEdits'])->middleware(['auth:super'])->name('super_admin.editUsers');
        Route::post('/superadmin/superAdmin_permisions/{id}',[SuperAdminAuthController::class,'editPermision'])->middleware(['auth:super'])->name('super_admin.editpermision');
        Route::post('/superadmin/addNewRole',[SuperAdminAuthController::class,'addNew'])->middleware(['auth:super'])->name('super_admin.addNewRole');
        Route::get('/superadmin/addPermission',[SuperAdminAuthController::class,'addNewPermission'])->middleware(['auth:super'])->name('super_admin.addNewPermission');
        Route::post('/superadmin/addPermisionNew',[SuperAdminAuthController::class,'addPermisionNew'])->middleware(['auth:super'])->name('super_admin.addPermisionNew');
        Route::get('/logout',[SuperAdminAuthController::class,'superAdminLogout'])->name('superAdmin.logout')->middleware('auth:super');

    
        
       
        
    });
    Route::get('/test-mail',function(){
        $message = "Testing mail";
        \Mail::raw('Hi ,welcome Manish!',function($message){
            // dd($message);
            $message->to('manishsingh19970@gmail.com')
            ->subject('Testing mail');
        });
        dd('sent');
    });


    Route::middleware('auth:super')->group(function () {
        Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                    ->name('verification.notice');
    
        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                    ->middleware(['signed', 'throttle:6,1'])
                    ->name('verification.verify');
    
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                    ->middleware('throttle:6,1')
                    ->name('verification.send');
    });


//----------------------------End-Super-Admin-----------------------//

Route::get('/', function () {
    return view('welcome');
});

//----------------------------User-----------------------//

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/delete/{id}',[AuthenticatedSessionController::class,'userDestroy'])->middleware(['auth'])->name('auth.destroy');
Route::get('/home',[AuthenticatedSessionController::class,'homeIndex'])->middleware(['auth'])->name('auth.homeIndex');
Route::get('/users',[AuthenticatedSessionController::class,'index'])->middleware(['auth'])->name('auth.index');
require __DIR__.'/auth.php';
