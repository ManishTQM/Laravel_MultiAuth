<?php

namespace App\Http\Controllers;

// require 'vendor/autoload.php';
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;


class UserController extends Controller
{
    //
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
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
   
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';                
                
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        }
        return view('users');
    }

    public function getPdf(Request $request)
    {   
        
         $users = User::where('name','LIKE','%'.$request->key.'%')->orWhere('email','LIKE','%'.$request->key.'%')->get(); 
         
        if(isset($users) && !empty($users)){
            foreach ($users as $key => &$value) {
                $value->new_created_at = Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('M d, Y');
            }
        } else {
            dd("No data Found");
        }

         $html= view('pdf',compact('users'))->render();
         $mpdf = new \Mpdf\Mpdf();
         $mpdf->WriteHTML($html);
         $mpdf->autoScriptToLang=true;
         $mpdf->autoLangToFont=true;
         $mpdf->Output();
        
    }

    public function getExcel(Request $request)
    {
        // dd($request->key);
        // $users = User::get();         
        $users = User::where('name','LIKE','%'.$request->key.'%')->orWhere('email','LIKE','%'.$request->key.'%')->get(); 
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet()->setTitle('Id');
        $activeWorksheet->setCellValue('A1', 'id');
        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Name');
        $before=$spreadsheet->addSheet($myWorkSheet, 1);
        $before->setCellValue('A1', 'name');
        $myWorkSheets = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Email');
        $befores=$spreadsheet->addSheet($myWorkSheets, 2);
        $befores->setCellValue('A1', 'email');
        // $activeWorksheet->setCellValue('B3', 'Hiiiii !');
        $rowCount = 2;
        foreach($users as $data)
        {
        $activeWorksheet->setCellValue('A' . $rowCount, $data['id']);
        $before->setCellValue('A' . $rowCount, $data['name']);
        $befores->setCellValue('A' . $rowCount, $data['email']);
        $rowCount++;
        }
        $writer = new Xlsx($spreadsheet);
        // $writer->save('hello world.xlsx');
        // redirect output to client browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Users.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function edit($id)
    {
        $users = User::find($id);
        return response()->json($users);
    }

    public function destroy($id)
    {
        // dd('fdf');
        User::find($id)->delete();
     
        return response()->json(['success'=>'Users deleted successfully.']);
    }

    public function store(Request $request)
    {
        User::updateOrCreate(['id' => $request->id],
                ['name' => $request->name, 'email' => $request->email,'password' => $request->password]);        
   
        return response()->json(['success'=>'User saved successfully.']);
    }

}