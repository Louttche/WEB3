<?php
   
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Post;
  
class ExcelController extends Controller
{   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        $posts = Post::orderBy('title', 'asc')->get();

        if(request()->hasFile('file'))
            Excel::import(new UsersImport,request()->file('file'));
        else{
            return view('admin.profile', ['posts' => $posts, 'noFileMsg' => "No file selected."]);
        }

        return view('admin.profile', ['posts' => $posts, 'noFileMsg' => ""]);
    }
}