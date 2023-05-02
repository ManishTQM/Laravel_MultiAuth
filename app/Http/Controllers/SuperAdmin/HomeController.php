<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\assignRole;
use Spatie\Permission\Models\Permission;

use Spatie\Permission\Models\Role;


class HomeController extends Controller
{
    public function homeIndex(){

        // Role::create(['name'=>'edmins']);
        // $user=Role::firstOrCreate(['name'=>'admin']);
        // $user=Role::removeRole('owner');
        // $role = Role::create(['name' => 'writers']);
        // $permission = Permission::create(['name' => 'Write articless']);
        // $role = Role::findById(1);
        // $permission=Permission::findById(1);
        // $role->givePermissionTo($permission);
        // $role->revokePermissionTo($permission);
        // $permission->removeRole($role);
        // $permission = Permission::firstOrCreate(['name'=>'edit_user']);
        // $permission=Permission::firstOrCreate(['name'=>'delete_user']);
        $permission = Permission::create(['guard_name' => 'admin', 'name' => 'delete_user']);
        $role = Role::findById(4);
        $role->givePermissionTo($permission);
        Auth::user()->givePermissionTo('delete_user');
        // Auth::user()->assignRole('admin');

        
        
        // return "Hello";
        return view('admin.auth.index');

    }
 

    
}

