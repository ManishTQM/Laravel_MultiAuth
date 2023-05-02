<!-- @entends('admin.admin_master')
@section('admin') -->

@can('edit_user')
   Hello
@endcan



<h1>Welcome Admin</h1>


<h3>Login Name :{{Auth::guard('admin')->user()->name}}</h3>
<h3>Login email :{{Auth::guard('admin')->user()->email}}</h3>



<a href="{{route('admin.logout')}}"><span><i class="fas fa-unlock-alt"></i></span>Logout</a>