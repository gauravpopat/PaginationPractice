<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        
        if($search == ""){
            $students = Student::paginate(15);
        }
        else{
            $students = Student::where('name','like','%'.$search.'%')->orWhere('city','like','%'.$search.'%')->orWhere('phone','like','%'.$search.'%')->orWhere('email','like','%'.$search.'%')->paginate(15);
        }
        return view('student', ['students' => $students]);
    }
}
