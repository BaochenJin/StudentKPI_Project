<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $model)
    {
        return view('course.index',['courses'=> $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_course(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'course_name' => 'required',

        ]);
        if ($validation->fails()){
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
        $Course = new Course;
        $Course->course_name = $request->course_name;
        $Course->save();
        session()->flash('success', 'Add successfully');
        return back();
    }
    public function get_courses()
    {
        $courses = Course::get();
        $data["data"] = $courses;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    // Edit Course
    public function editCourse(Request $req)
    {
           
        $this->validate($req, [
            'course_name' => 'required',
            'id' => 'required'
        ]);
        $Course = Course::where('id', $req->id)->first();
        if ($Course) {
            $Course->course_name = $req->course_name;
            $Course->save();
            session()->flash('success', 'Updated successfully');
            return back();
        } else {
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
    }
    // Delete Course

    public function deleteCourse(Request $request)
    {
    $this->validate($request, [
        'id' => 'required',
    ]);

    $CourseId = request('id');
    if (Course::where('id', $CourseId)->delete()) {
        session()->flash('success', 'Deleted successfully');
        return back();
    } else {
        session()->flash('danger', 'wrong bad behavoir happend');
        return back();
    }
    }
   
}
