<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App;
use Validator;
class StudentController extends Controller
{
    public function add_student(Request $request) {
        $validation = Validator::make($request->all(),[
            'year' => 'required',
            'semester' => 'required',
            'course' => 'required',
            'student_name' => 'required',
            'email' => 'required',
            
           
        ]);
        if ($validation->fails()){
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
        $student = new Student;
        $student->year = $request->year;
        $student->semester = $request->semester;
        $student->course = $request->course;
        $student->student_name = $request->student_name;
        $student->email = $request->email;
        $student->save();
        session()->flash('success', 'Add successfully');
        return back();
    }
    public function edit_student(Request $request) {
        $validation = Validator::make($request->all(),[
            'id' => 'required',
           
        ]);
        if ($validation->fails()){
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
        $student = Student::where('id', $request->id)->first();
        $student->year = $request->year;
        $student->semester = $request->semester;
        $student->course = $request->course;
        $student->student_name = $request->student_name;
        $student->email = $request->email;
        $student->save();
        session()->flash('success', 'Add successfully');
        return back();
    }

    public function get_period(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'quiz' => 'required',
           
        ]);
        if ($validation->fails()){
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
        $students = Student::where('quiz', $request->quiz)->get();
        $data["data"] = $students;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function courses_student(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'student' => 'required',
           
        ]);
        if ($validation->fails()){
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
        $students = Student::where('student_name', $request->student)->first();
        $data["data"] = $students;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function course_unique(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'student' => 'required',
           
        ]);
        if ($validation->fails()){
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
        $students = Student::where('student_name', $request->student)->get();
        $data["data"] = $students;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function get_students()
    {
        $students = Student::get();
        $data["data"] = $students;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    // Delete Course

    public function delete_student(Request $request)
    {
    $this->validate($request, [
        'id' => 'required',
    ]);

    $CourseId = request('id');
        if (Student::where('id', $CourseId)->delete()) {
            session()->flash('success', 'Deleted successfully');
            return back();
        } else {
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
    }
    public function student_id(Request $request)
    {
        $id=Student::where(['student_name'=>$request->student,'course'=>$request->course])->value('id');
        $data=['id'=>$id];
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
