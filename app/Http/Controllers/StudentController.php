<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;

class StudentController extends Controller
{
    use ResponseTrait;
    public function index(Request $request, $column = null, $sorting = null)
    {
        $search = $request['search'] ?? "";
        if ($search == "") {
            if ($sorting != null) {
                $students = Student::orderBy($column, $sorting)->paginate(15);
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
            return $this->validationErrorsResponse($validation);

        $inOrder = $request['inOrder'] ? $request['inOrder'] : 'ASC';
        $orderBy = $request['orderBy'] ? $request['orderBy'] : 'name';

        if ($search) {
            $students = Student::where('name', 'like', '%' . $search . '%')->orWhere('city', 'like', '%' . $search . '%')->orWhere('phone', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->orWhere('id', $search)->orderBy($orderBy, $inOrder)->paginate($perpage);

            if (sizeof($students) == 0) {
                return $this->returnResponse('false', 'No Record Found');
            }
        } else {
            $students = Student::orderBy($orderBy, $inOrder)->paginate($perpage);
        }

        return $this->returnResponse(true, 'Students Information', $students);
    }
}
