<!DOCTYPE html>
<html>
<head>
    <title>Super Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    
</head>
<body>
<x-app-layout>
<div class="flex-col w-full ">
        <div class="flex w-full bg-slate-50">
        </div>
    </div>
    <x-slot name="header">
   
            <div>
            <a href="{{route('addRole.index')}}"><button class="btn btn-primary">Add Role</button></a></div>
<a href="{{route('showRole.index')}}"><button class="btn btn-primary my-5">Show Role</button></a>
            <br><table class="table table-bordered data-table user_table">
        <thead>
            <tr>
                <th>Permision Id</th>
                <th>Permision Name</th>
                <th>Guard Name</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($rolePermissions as $user_permission)
            @foreach ($user_permission as $per)
            <tr>
                <td>{{ $per->permission_id }}</td>
                <td>{{ $per->permission_name }}</td>
                <td>{{ $per->permission_guard }}</td>
                <td>{{ $per->role_name }}</td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
    </div>
</div>  
</div>
</div>
</x-app-layout> 
</html>
</body>














