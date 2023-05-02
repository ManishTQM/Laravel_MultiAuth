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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container"><br><br>
    <input name="_token" value="{{ csrf_token() }}" id="_token" type="hidden">
        @can('add_user')
        <a href="{{route('super_admin.regSuper')}}"><span><button class="btn btn-primary">Add Users</button></a><br><br>
        @endcan
        @can('export_excell')
        <a href="{{route('users.getExcel')}}"><span><button class="btn btn-success">Export Excell</button></a><br><br>
       @endcan
       @can('export_pdf')
        <form action="{{route('users.getPdf')}}">
        <div class="input-group">
        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
        <input type="text" class="form-control" name="key" id="key" placeholder="Type here...">
        <button  class="btn btn-success">Export Pdf</button>
        </form>
        @endcan


        </div>
    <!-- <h1>DAtaTable</h1> -->
    <table class="table table-bordered data-table user_table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created Date</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                You're logged in!
            </div>
        </div>
    </div>
</div>
   
</x-app-layout> 
</html>

</body>
<script>
    $(function(){
      var table = $(".user_table").DataTable({
        processing:true,
        serverSide:true,
        searching: false,
        
        ajax:"{{ route('super_admin.index') }}",
        columns:[
            {data:'DT_RowIndex'},
            {data:'name'},
            {data:'email'},
            {data:'created_at'},
            {data:'action'}
        ]
      });
    });


    $('body').on('click', '.deletePost', function () {
     
     var id = $(this).data("id");
     var csrf_token = $('#_token').val();
     confirm("Are You sure want to delete this User!");
     $.ajax({
         type: "get",
         url: "{{ url('admin/usersDestroy') }}"+'/'+id,
         success: function (data) {
            //  table.draw();
            alert('User delete successfully');
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
 });




    $(document).ready(function () {
        $("#key").on("keyup", function () {
            var value = $(this).val().toLowerCase();
        $(".user_table tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

});
</script>
















