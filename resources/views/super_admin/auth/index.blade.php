<!-- @entends('admin.admin_master')
@section('admin') -->



<h1>Welcome Super Admin</h1>


<h3>Login Name :{{Auth::guard('super')->user()->name}}</h3>
<h3>Login email :{{Auth::guard('super')->user()->email}}</h3>


<a href="{{route('superAdmin.logout')}}"><span><i class="fas fa-unlock-alt"></i></span>Logout</a>