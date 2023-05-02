<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\assignRole;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use DataTables;
use Carbon\Carbon;


use Spatie\Permission\Models\Role;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        session(['userLogin',true]);
        return redirect()->route('auth.index')->with('success','You are Logged in sucessfully.');    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function homeIndex(){

        // $user=Role::firstOrCreate(['name'=>'user']);

        $permission = Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'user_list']);
        $role = Role::findById(5);
        // $role->givePermissionTo($permission);
        Auth::user()->givePermissionTo('user_list');
        Auth::user()->assignRole('user');


        // $role = Role::findById(5);
        // $role->givePermissionTo($permission);
        // $permission=Permission::findById(2);
        // Auth::user()->givePermissionTo($permission);
        // Auth::user()->assignRole('user');

        // $role->revokePermissionTo($permission);
        // auth()->user()->revokePermissionTo($permission);
        // $permission->removeRole($role);

        return "Hello";
        return redirect()->route('auth.index')->with('success','You are Logged in sucessfully.');    

    }

    public function index(Request $request )
    {
        // dd($request);
        if($request->ajax()){
            $user = User::latest()->get();
            // dd($user);
            return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('email',function($row){
                return $row->email;
            })
            ->addColumn('created_at',function($row){
                 $value = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('M d, Y');;
                 return $value; 
            })
            ->addColumn('action',function($row){
                $btn="<div>";

            if(Auth::guard('web')->user()->hasPermissionTo('edit_user_list'))
            {
                
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
            }
       
    
            if(Auth::guard('web')->user()->hasPermissionTo('delete_user'));
            {
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';  
            } 
      
                "</div>";        
                
                return $btn;
            })

            ->rawColumns(['action'])
            ->make(true);

        }
        return view('auth.users');
    }

    public function userDestroy($id)
    {
        // dd('fdf');
        User::find($id)->delete();
     
        return response()->json(['success'=>'Users deleted successfully.']);
    }
}
