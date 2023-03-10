<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request, $column = null, $sorting = null)
    {
        $search = $request['search'] ?? "";
        if ($search == "") {
            if ($sorting != null) {
                $students = Student::orderBy($column, $sorting)->paginate(15);
                $links = $students->appends(['sortby' => $column, 'order' => $sorting])->links();
            } else
                $students = Student::paginate(15);
        } else {
            $students = Student::where('name', 'like', '%' . $search . '%')->orWhere('city', 'like', '%' . $search . '%')->orWhere('phone', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->orWhere('id', $search)->paginate(15);
        }
        return view('student', compact('students'));
    }


    // Pagination, Searching, Sorting with API
    public function list(Request $request)
    {
        $search         = $request['search'];
        $perpage        = $request['perpage'] ? $request['perpage'] : 20;
        $validation = Validator::make(
            $request->all(),
            [
                'inOrder'       => 'in:asc,desc,DESC,ASC',
                'orderBy'       => 'in:id,name,email,phone,city,ID,NAME,EMAIL,PHONE,CITY'
            ],
            [
                'inOrder.in'    => 'The selected inOrder is invalid, You can only enter asc or desc',
                'orderBy.in'    => 'The selected Orderby is invalid, You can only enter id / name / email / phone /city'
            ]
        );
        if ($validation->fails())
            return response()->json([
                'status'    => false,
                'error'     => $validation->errors()
            ]);

        $inOrder = $request['inOrder'] ? $request['inOrder'] : 'ASC';
        $orderBy = $request['orderBy'] ? $request['orderBy'] : 'name';

        if ($search) {
            $students = Student::where('name', 'like', '%' . $search . '%')->orWhere('city', 'like', '%' . $search . '%')->orWhere('phone', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->orWhere('id', $search)->orderBy($orderBy,$inOrder)->paginate($perpage);

            if (sizeof($students) == 0) {
                return response()->json([
                    'status'     => false,
                    'message'    => 'No Data Found'
                ]);
            }
        } else {
            $students = Student::orderBy($orderBy, $inOrder)->paginate($perpage);
        }

        return response()->json([
            'status'    => true,
            'message'   => 'Students:',
            'students'  => $students
        ]);
    }
}
