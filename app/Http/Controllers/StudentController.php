<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request, $column = null, $sorting = null)
    {
        $search = $request['search'] ?? "";
        if($search == ""){
            if($sorting != null)
            $students = Student::orderBy($column,$sorting)->paginate(15);
            else
            $students = Student::paginate(15);
        }
        else{
            $students = Student::where('name','like','%'.$search.'%')->orWhere('city','like','%'.$search.'%')->orWhere('phone','like','%'.$search.'%')->orWhere('email','like','%'.$search.'%')->orWhere('id',$search)->paginate(15);
        }
        return view('student', ['students' => $students]);
    }
}
