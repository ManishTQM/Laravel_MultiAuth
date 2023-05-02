<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;
use DataTables;
use Carbon\Carbon;


class AdminAuthController extends Controller
{
    public function getLogin(){
        return view('admin.auth.login');
    }
 
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        if(Auth::guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
            $user = Auth::guard('admin')->user();
            if($user->status == 0){
                session(['adminLogin',true]);
                return redirect()->route('admin.index')->with('success','You are Logged in sucessfully.');
                // dd($user);
            }
        }else {
            return back()->with('error','Whoops! invalid email and password.');
        }
    }
 
    public function AdminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('adminLogin')->with('error','Admin Logout Successfully');

        // return redirect('/login');
    }
    public function adminRegister(Request $request)
    {
        // dd("kkdkdddd");
        return view('admin.admin_register');

        // return redirect('/login');
    }

    public function adminRegisterCreate(Request $request)
        {
            // dd($request->all());
            // Admin::insert
            Admin::insert ([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at'=>Carbon::now(),
            ]);
            return redirect()->route('adminLogin')->with('error','Admin Created Successfully');

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

            if(Auth::guard('admin')->user()->hasPermissionTo('edit_user'))
            {
                
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
            }

            if(Auth::guard('admin')->user()->hasPermissionTo('delete_user'))
            {
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';  
            } 
            
                "</div>";        
                
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        }
        return view('admin.auth.users');
    }

}

