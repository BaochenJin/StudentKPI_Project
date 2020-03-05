<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TotalVal;
use App\Student;
use App\TotalDegree;
use App\User;
use App\Failed;
use App\Below;
use App\Good;
use App\Excellent;
use App;
use Validator;
class TotalValController extends Controller
{
    public function add_total(Request $request) {
        $validation = Validator::make($request->all(),[
            'student_id'=>'required',
            'student' => 'required',
            'course' => 'required',
            'quiz_one' => 'required',
            'quiz_two' => 'required',
            'midterm' => 'required',
            'final' => 'required',
        ]);
        if ($validation->fails()){
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
        
        // dd($request);
        $TotalVal = new TotalVal;
        $TotalVal->student_id = $request->student_id;
        $TotalVal->student_name = $request->student;
        $TotalVal->course = $request->course;
        $TotalVal->quiz1 = $request->quiz_one;
        $TotalVal->quiz2  = $request->quiz_two;
        $TotalVal->midterm = $request->midterm;
        $TotalVal->final = $request->final;
        $TotalVal->save();
        
        $average=($request->quiz_one+$request->quiz_two+$request->midterm+$request->final)/4;
        $midterm=$request->midterm;
        $final=$request->final;
        $totalDegree=new TotalDegree;
        $totalDegree->total_vals_id=$request->student_id;
        if($average>90 && $average<100) {
            $totalDegree->degree="Excellent";
        } else if($average>80 && $average<90) {
            $totalDegree->degree="Good";
        } else if($average>70 && $average<80) {
            $totalDegree->degree="Below";
        } else if($average>0 && $average<70) {
            $totalDegree->degree="Failed";
        }
        if($midterm>90 && $midterm<100) {
            $totalDegree->Midterm="Excellent";
        } else if($midterm>80 && $midterm<90) {
            $totalDegree->Midterm="Good";
        } else if($midterm>70 && $midterm<80) {
            $totalDegree->Midterm="Below";
        } else if($midterm>0 && $midterm<70) {
            $totalDegree->Midterm="Failed";
        }
        if($final>90 && $final<100) {
            $totalDegree->Final="Excellent";
        } else if($final>80 && $final<90) {
            $totalDegree->Final="Good";
        } else if($final>70 && $final<80) {
            $totalDegree->Final="Below";
        } else if($final>0 && $final<70){
            $totalDegree->Final="Failed";
        }
        $totalDegree->degree;
        $totalDegree->save();
        session()->flash('success', 'Add successfully');
        return back();
    }
    public function edit_total(Request $request) {
        // dd($request);
        $validation = Validator::make($request->all(),[
            'id' => 'required',
           
        ]);
        if ($validation->fails()){
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
        $TotalVal = TotalVal::where('id', $request->id)->first();
        $TotalVal->student_name = $request->student;
        $TotalVal->course = $request->course;
        $TotalVal->quiz1 = $request->quiz_one;
        $TotalVal->quiz2  = $request->quiz_two;
        $TotalVal->midterm = $request->midterm;
        $TotalVal->final = $request->final;
        
        $TotalVal->save();
        session()->flash('success', 'Updated successfully');
        return back();
    }

    public function get_totals()
    {
        $TotalVals = TotalVal::get();
        $data["data"] = $TotalVals;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function get_totals_counts()
    {
        $Totals['Excellent']=count(TotalDegree::where('degree','Excellent')->get());
        $Totals['Good']=count(TotalDegree::where('degree','Good')->get());
        $Totals['Below']=count(TotalDegree::where('degree','Below')->get());
        $Totals['Failed']=count(TotalDegree::where('degree','Failed')->get());
        return response()->json($Totals,200,[], JSON_UNESCAPED_UNICODE);
    }

    public function get_total_counts(){
        $testidentify=['Midterm','Final'];
        for($i=0;$i<2;$i++){
            $Totals[$testidentify[$i]]['Excellent']=count(TotalDegree::where($testidentify[$i],'Excellent')->get());
            $Totals[$testidentify[$i]]['Good']=count(TotalDegree::where($testidentify[$i],'Good')->get());
            $Totals[$testidentify[$i]]['Below']=count(TotalDegree::where($testidentify[$i],'Below')->get());
            $Totals[$testidentify[$i]]['Failed']=count(TotalDegree::where($testidentify[$i],'Failed')->get());
            $Totals[$testidentify[$i]]['total']=$Totals[$testidentify[$i]]['Excellent']+$Totals[$testidentify[$i]]['Good']+$Totals[$testidentify[$i]]['Below']+$Totals[$testidentify[$i]]['Failed'];
        }
        return response()->json($Totals,200,[], JSON_UNESCAPED_UNICODE);
    }
    public function get_charts(Request $request){
            $identify=['Midterm','Final'];
            for($i=0;$i<2;$i++)
            {
                $totals[$identify[$i]]['Excellent']=0;
                $totals[$identify[$i]]['Good']=0;
                $totals[$identify[$i]]['Below']=0;
                $totals[$identify[$i]]['Failed']=0;
                $totals[$identify[$i]]['total']=0;
            }
            $stu_data=Student::where(['year'=>$request->year,'semester'=>$request->semester,'course'=>$request->course])->get();
            for($i=0;$i<count($stu_data);$i++)
            {   
                for($j=0;$j<2;$j++)
                {
                    $totals[$identify[$j]]['Excellent']+=count(TotalDegree::where([$identify[$j]=>'Excellent','total_vals_id'=>$stu_data[$i]['id']])->get());
                    $totals[$identify[$j]]['Good']+=count(TotalDegree::where([$identify[$j]=>'Good','total_vals_id'=>$stu_data[$i]['id']])->get());
                    $totals[$identify[$j]]['Below']+=count(TotalDegree::where([$identify[$j]=>'Below','total_vals_id'=>$stu_data[$i]['id']])->get());;
                    $totals[$identify[$j]]['Failed']+=count(TotalDegree::where([$identify[$j]=>'Failed','total_vals_id'=>$stu_data[$i]['id']])->get());;
                }
            }
            for($i=0;$i<2;$i++)
            {
                $totals[$identify[$i]]['total']+=$totals[$identify[$i]]['Excellent']+$totals[$identify[$i]]['Good']+$totals[$identify[$i]]['Below']+$totals[$identify[$i]]['Failed'];
            }
        return response()->json($totals, 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function get_instructors()
    {
        $instructors = User::where('role', 'instructor')->get();
        $data["data"] = $instructors;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
    
   
    // Delete Course

    public function delete_total(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $TotalVal = request('id');
        if (TotalVal::where('id', $TotalVal)->delete()) {
            session()->flash('success', 'Deleted successfully');
            return back();
        } else {
            session()->flash('danger', 'wrong bad behavoir happend');
            return back();
        }
    }
}
