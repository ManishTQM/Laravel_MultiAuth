<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Mailseting;
use App\Models\Super_Admin;
use Hash;
use App\Jobs\WelcomeJob;
use App\Mail\WelcomeMail;
use App\Helpers\helpers;
// 
// use Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

use DataTables;

use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\assignRole;
use Spatie\Permission\Models\Permission;

use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Config;


class SuperAdminAuthController extends Controller
{
    // use mail;
    function __construct()  
	{
		$this->middleware('super');
		// $this->middleware('verified');
		$this->middleware('permission:permision', ['only' => ['permision', 'addRole','showRole','editPermision','addNew','addNewPermission','addPermisionNew','viewRole']]);
		$this->middleware('permission:add_user', ['only' => ['signupView', 'store']]);
		$this->middleware('permission:delete_user', ['only' => ['userDestroy']]);
		$this->middleware('permission:edit_list', ['only' => ['editUser', 'userEdits']]);
		$this->middleware('permission:user_list', ['only' => ['index']]);
	
	
	}
    public function getLogin(){
        return view('super_admin.auth.login');
    }
 
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        if(Auth::guard('super')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
            $user = Auth::guard('super')->user();
            if($user->status== 0){
                // dd($user);
                session(['superadminLogin',true]);

                // session(['adminLogin',true]);
                return redirect()->route('super_admin.allView')->with('success','You are Logged in sucessfully.');            }
        }else {
            return back()->with('error','Whoops! invalid email and password.');
        }
    }
 
    public function superAdminLogout(Request $request)
    {
        Auth::guard('super')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('superadminLogin')->with('error','Super Admin Logout Successfully');

        // return redirect('/login');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $user = User::latest()->get();
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

                if(Auth::guard('super')->user()->hasPermissionTo('edit_list'))
                {
                $btn = "<a href='". route('super.editUser', [$row->id]) ."' data-toggle='tooltip' data-original-title='Edit' class='edit btn btn-primary btn-sm editPost'>Edit</a>";
                
            }
            if(Auth::guard('super')->user()->hasPermissionTo('delete_user'))
                {               
                     $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';                
                }
                "</div>";   
                return $btn;
                
            })
            ->rawColumns(['action'])
            ->make(true);

        }
        return view('super_admin.auth.users');
    }



    public function permision(User $user ){
        $role=Role::all('id');
        foreach($role as $roles){
            $rolePermissions[] = Permission::select('roles.name as role_name','permissions.name as permission_name','permissions.guard_name as permission_guard','permissions.id as permission_id')
            ->join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->join('roles','role_has_permissions.role_id','=','roles.id')
            ->where("role_has_permissions.role_id", $roles->id)
            ->get();
        }
        return view('super_admin.auth.permision',compact('rolePermissions'));
    }
    public function addRole(User $user ){
        $permission = Permission::all();
        // dd($permission);
        return view('super_admin.auth.addRole',compact('permission','user'));
    }
    public function showRole(){
        $role = Role::all();
        // dd($permission);
        return view('super_admin.auth.showRole',compact('role'));
    }
  
    


    public function editPermision(Request $request, Permission $permission,User $user ,$id){
        // dd($request->all(),$id);
        $role=Role::find($id);
        
        $this->validate($request, [
          
            'permission' => 'required',
        ]);
        
        $role->syncPermissions($request->get('permission'));
        // dd($role);
        
        Auth::user()->assignRole($role);
        return redirect()->route('showRole.index');
    }

    public function addNew(Request $request){
        // dd($request);
        
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->get('name')]);

        $role->syncPermissions($request->get('permission'));
        Auth::user()->assignRole($role->name);
    
        return redirect()->route('showRole.index')
                        ->with('success','Role created successfully');
    }
    public function addNewPermission(Request $request){
        // dd($request);
        // $user=Role::all();
        // dd($user);
        return view('super_admin.auth.addPermision');
    }
    public function addPermisionNew(Request $request){
        // dd($request->all());
        $permission = Permission::create(['name' => $request->get('name')]);
        return redirect()->route('showRole.index')
        ->with('success','Permission created successfully');
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $data = $request->all();
        // $abc =Config::get('mail');
        // dd($abc);
        // dd($data);
        $user = Super_Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // $data=$user;
        // $maildata = \App\Helpers::mail($data);
        //  dd($maildata);
        $user->roles()->attach($request->rid);
        dispatch(new WelcomeJob($user,$data));
        event(new Registered($user));
        return redirect()->route('super_admin.userList')
        ->with('success','User has ben created successfully');
      
       
    }
    
    public function signupView()
    {
        $role=Role::all();
        $mail=Mailseting::all();
        // dd($role);
        return view('super_admin.auth.register',compact('role','mail'));
     

       
    }
    public function viewRole(User $user ,$id){
        // dd($id);
        // $id = $_GET['id'];
        $role = Role::find($id);
        $permission= Permission::all();
        // dd($permison);
        foreach($role as $roles){
            $rolePermissions= Permission::select('roles.name as role_name','permissions.name as permission_name','permissions.guard_name as permission_guard','permissions.id as permission_id')
            ->join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->join('roles','role_has_permissions.role_id','=','roles.id')
            ->where("role_has_permissions.role_id", $role['id'])
            ->where('permissions.guard_name','super')
            ->get();
        }
        // dd($rolePermissions);
        return view('super_admin.auth.viewRole',compact('rolePermissions','permission','user','role'));
    }
    public function allView(){

            return view('super_admin.auth.all');
        }

    public function editUser($id){
        $user=User::find($id);
        return view('super_admin.auth.edituser',compact('user'));
        }

    public function userEdits(Request $request,User $user,$id){

       request()->validate([
            'name' => 'required|max:255',
            'email' => 'required',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        // $user->update($validated);
        return view('super_admin.auth.users')->with('message', 'Role Updated succesfully.');
    //   dd($user);
        }


        public function userDestroy($id)
        {
            // dd('fdf');
            User::find($id)->delete();
         
            return response()->json(['success'=>'Users deleted successfully.']);
        }


   
}
