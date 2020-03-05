@extends('layouts.app', ['activePage' => 'maps', 'title' => 'Management', 'navName' => 'Management', 'activeButton' => 'laravel'])

@section('content')
  <style>
      #table_filter{
          text-align: center !important;
      }
     .alert-dark{
         background: #c4000b !important
     }
     .badge{
         font-weight: 300 !important;
     }
     td > h4 {
         margin: 0 !important
     }
     .btn-group{
         margin-top: 10px !important
     }
     .final{
        background-color: #efa724;
        padding: 2px 17px;
        color: #FFF;
        border-radius: 5px;
    }
    .midterm{
        background-color: #88005e;
        padding: 2px 17px;
        color: #FFF;
        border-radius: 5px;
    }
  </style>
<section>
    @if (session()->get('role') == 'instructor')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="mb-0">Management</h4>
                        {{ csrf_field() }}
                        <form action="add-total" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="student_id" id="student_id">
                                <div class="form-group col-xs-12 col-sm-12 col-md-2">
                                    <label for="year">Student</label>
                                    <select id="student" name="student" class="form-control" required onchange="getCourses(this.value)">
                                        <option value="" selected disabled>Choose Student</option>
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-2">
                                    <label for="year">Course</label>
                                    <select id="course" name="course" class="form-control" onclick="getStudentID(this.value)" required >
                                        <option value="" selected disabled>Choose Course</option>
                                    </select>
                                </div>
                               
                                
                            </div>
                            <div class="row" id="addDegrees">
                                
                            </div>
                        </form>
                        {{-- for the validation errors --}} @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif {{-- for the session messages --}} @if (session()->has('success'))
                        <div class="alert alert-success"  role="alert">{{ session()->get('success') }}
                        </div>
                        @elseif (session()->has('danger'))
                        <div class="alert alert-danger"  role="alert">{{ session()->get('danger') }}
                        </div>
                        @endif
                        <div style="margin-top:20px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">


                            <table id="table" class="table" 
                                style="width:100%">
                                <thead >
                                    <tr>
                                        <th>id</th>
                                        <th>student name</th>
                                        <th>course</th>
                                        <th>quiz one</th>
                                        <th>quiz two</th>
                                        <th>midterm</th>
                                        <th>final</th>
                                        @if (session()->get('role') == 'instructor')

                                        <th>action</th>
                                        @endif
                                        

                                    </tr>

                                </thead>
                               

                            </table>
                        </div>


                        <!-- deleteGroup Modal -->
                        <div id="deleteGroup" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <form action="/delete-total" method="POST">
                                    @csrf
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                            <h1 class="modal-title" id="deletedbrnchName" style="margin-right:60%"></h1>
                                        </div>
                                        <div class="modal-body">
                                            <input name="id" id="branchId" type="hidden">
                                            <p class="text-center">Are you sure ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" ID="submitDeleteGroup" class="btn btn-primary">Delete</button>

                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Exit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- {{-- update modal --}} -->
                        <div class="modal" id="updateModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            <div id="model">Edit</div>
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="">
                                            <form action="edit-total" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input id="updateId" name="id" hidden/>
                                                <input id="update_studentId" name="student_id" hidden/>
                                                <div class="row">

                                                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                                        <label for="year">Student</label>
                                                        <select id="up_student" name="student" class="form-control" required>
                                                            <option value="" selected disabled>Choose Student</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                                        <label for="year">Course</label>
                                                        <select id="up_course" name="course" onclick="updateStudentID(this.value)" class="form-control" required >
                                                            <option value="" selected disabled>Choose Course</option>
                                                        </select>
                                                    </div>
                                                
                                                    
                                                </div>
                                                <div class="row">

                                                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                                        <label for="degree">Quize one</label>
                                                        <input type="number" id="up_quiz1" name="quiz_one" class="form-control"min="0" oninput="this.value = Math.abs(this.value)" required>
                                                    </div>
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                                        <label for="degree">Quiz two</label>
                                                        <input type="number" id="up_quiz2" name="quiz_two" class="form-control"min="0" oninput="this.value = Math.abs(this.value)" required>
                                                    </div>
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                                        <label for="degree">Midterm</label>
                                                        <input type="number" id="up_midterm" name="midterm" class="form-control"min="0" oninput="this.value = Math.abs(this.value)" required>
                                                    </div>
                                                    <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                                        <label for="degree">Final</label>
                                                        <input type="number" id="up_final" name="final" class="form-control"min="0" oninput="this.value = Math.abs(this.value)" required>
                                                    </div>
                                                 
                                                </div>

                                                <div class="form-group-prepend">
                                                    <button type="submit" class="btn btn-primary"
                                                       >update</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">exit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<div id="print-content" style="display:none">
    <div style="text-align:center">
        <h2 id="fullName"></h2>
        <img id="BarCode">
    </div>

</div>
@if (session()->get('role') == 'instructor')
    
<script>
 
    function deletebranch(id) {
        $('#branchId').val(id)
        $('#deleteGroup').modal('show');
    }



    function updateBranch(id,student_name,course,quiz1, quiz2,midterm,final) {
        console.log(quiz1);
                        $('#up_student').html('<option value="">Choose Student</option>')

                        $('#up_course').html('<option value="" selected>Choose Course</option>');


        $('#updateId').val(id)
        $('#up_quiz1').val(quiz1);
        $('#up_quiz2').val(quiz2);
        $('#up_midterm').val(midterm);
        $('#up_final').val(final);
        c =`<option value="${student_name}" selected >${student_name}</option>`;
        $('#up_student').append(c);

        $.ajax({
            url: `get-course-unique?student=${student_name}`,
            type: "get",
            success: function(res) {
                // $('#up_student').html('<option value="">Choose Student</option>')
                // $('#up_student').html('<option value="">Choose Student</option>')

            $('#up_course').html('<option value="" selected>Choose Course</option>'); 
                   console.log(res);
                let students = res.data;
                for(let student of students) {
                    f =`<option value="${student.course}" selected>${student.course}</option>`;
                    $('#up_course').append(f);
                
                }
            }
        })
        $('#updateModal').modal('show');


    }
    function getStudentID(course){
        let sutName=$('#student').val();
        $.ajax({
            url:`get-student-id?student=${sutName}&course=${course}`,
            type:"get",
            success:function(res) {
                $("#student_id").val(res.id);
            }
        })
        
    }
    function updateStudentID(course){
        let sutName=$('#up_student').val();
        $.ajax({
            url:`get-student-id?student=${sutName}&course=${course}`,
            type:"get",
            success:function(res) {
                $("#updae_studentId").val(res.id);
            }
        })
        
    }
    function getCourses(val) {
        $('#course').html('<option value="" selected disabled>Choose Course</option>');

        $.ajax({
            url: `get-course-unique?student=${val}`,
            type: "get",
            success: function(res) {
                console.log(res);
                let students = res.data;
                for(let student of students) {
                    
                    y =`<option value="${student.course}" selected>${student.course} Quiz</option>`;
                    $('#course').append(y);
                    $('#addDegrees').html(`
                    <div class="form-group col-xs-12 col-sm-12 col-md-2">
                                    <label for="quiz_one">Quiz one</label>
                                    <input type="number" id="quiz_one" name="quiz_one" class="form-control"min="0" oninput="this.value = Math.abs(this.value)" required>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-2">
                                    <label for="quiz_two">Quiz two</label>
                                    <input type="number" id="quiz_two" name="quiz_two" class="form-control"min="0" oninput="this.value = Math.abs(this.value)" required>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-2">
                                    <label for="midterm">Midterm</label>
                                    <input type="number" id="midterm" name="midterm" class="form-control"min="0" oninput="this.value = Math.abs(this.value)" required>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-2">
                                    <label for="final">Final</label>
                                    <input type="number" id="final" name="final" class="form-control"min="0" oninput="this.value = Math.abs(this.value)" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for=""></label><br>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mt-1" >Add new</button>
                                </div>
                    `)
                }
            }
        })
    }




    $(document).ready(function () {
        let z;
        let v;
        let i = 1;
        
        
        // All Students
        $.ajax({
            url : "all-students",
            type: 'get',
            success: function(res) {
                let students = res.data;
                for(let student of students) {
                    v =`<option value="${student.student_name}">${student.student_name}</option>`;
                    $('#student').append(v);
                }
                // console.log(res.data);
            }
        })
       
        table = $('#table').DataTable({
            //   "lengthMenu": [[25,50,100,250,500,1000], [25,50,100,250,500,1000]],
            // "dom":  "<'row'<'col-md-2'l><'col-md-3'i><'col-md-2'B><'col-md-5'p>>",
               
            dom: 'Bfrtip',
        // buttons: [
        //     'colvis', 'csv', 'excel', 'pdf', 'print'
        // ],
        buttons: [
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            'colvis'
        ],
            "ajax": "all-totals",
            "columns": [
                
                { "data":function (data) {
                    return `<span>${i++}</span>`
                  }
                },                
                { "data": "student_name", "defaultContent": "" },
                { "data": "course", "defaultContent": "" },
                { "data": function(data) {
                    if(data.quiz1 >= 95 && data.quiz1 <= 100) {
                        return `<span>A+</span>`
                    }
                    if(data.quiz1 >= 90 && data.quiz1 <= 94) {
                        return `<span>A</span>`
                    }
                    if(data.quiz1 >= 85 && data.quiz1 <= 89) {
                        return `<span>B</span>`
                    }
                    if(data.quiz1 >= 80 && data.quiz1 <= 84) {
                        return `<span>B+</span>`
                    }
                    if(data.quiz1 >= 75 && data.quiz1 <= 79) {
                        return `<span>C</span>`
                    }
                    if(data.quiz1 >= 70 && data.quiz1 <= 74) {
                        return `<span>C+</span>`
                    }
                    if(data.quiz1 >= 65 && data.quiz1 <= 69) {
                        return `<span>D</span>`
                    }
                    if(data.quiz1 >= 60 && data.quiz1 <= 64) {
                        return `<span>D+</span>`
                    }
                    if(data.quiz1 >= 0 && data.quiz1 <= 59) {
                        return `<span>Failed</span>`
                    }
                  
                } },
                { "data": function(data) {
                    if(data.quiz2 >= 95 && data.quiz2 <= 100) {
                        return `<span>A+</span>`
                    }
                    if(data.quiz2 >= 90 && data.quiz2 <= 94) {
                        return `<span>A</span>`
                    }
                    if(data.quiz2 >= 85 && data.quiz2 <= 89) {
                        return `<span>B</span>`
                    }
                    if(data.quiz2 >= 80 && data.quiz2 <= 84) {
                        return `<span>B+</span>`
                    }
                    if(data.quiz2 >= 75 && data.quiz2 <= 79) {
                        return `<span>C</span>`
                    }
                    if(data.quiz2 >= 70 && data.quiz2 <= 74) {
                        return `<span>C+</span>`
                    }
                    if(data.quiz2 >= 65 && data.quiz2 <= 69) {
                        return `<span>D</span>`
                    }
                    if(data.quiz2 >= 60 && data.quiz2 <= 64) {
                        return `<span>D+</span>`
                    }
                    if(data.quiz2 >= 0 && data.quiz2 <= 59) {
                        return `<span>Failed</span>`
                    }
                  
                } },
                { "data": function(data) {
                    if(data.midterm >= 95 && data.midterm <= 100) {
                        return `<span>A+</span>`
                    }
                    if(data.midterm >= 90 && data.midterm <= 94) {
                        return `<span>A+</span>`
                    }
                    if(data.midterm >= 85 && data.midterm <= 89) {
                        return `<span>B</span>`
                    }
                    if(data.midterm >= 80 && data.midterm <= 84) {
                        return `<span>B+</span>`
                    }
                    if(data.midterm >= 75 && data.midterm <= 79) {
                        return `<span>C</span>`
                    }
                    if(data.midterm >= 70 && data.midterm <= 74) {
                        return `<span>C+</span>`
                    }
                    if(data.midterm >= 65 && data.midterm <= 69) {
                        return `<span>D</span>`
                    }
                    if(data.midterm >= 60 && data.midterm <= 64) {
                        return `<span>D+</span>`
                    }
                    if(data.midterm >= 0 && data.midterm <=59) {
                        return `<span>Failed</span>`
                    }
                  
                } },
                { "data": function(data) {
                    if(data.final >= 95 && data.final <= 100) {
                        return `<span>A</span>`
                    }
                    if(data.final >= 90 && data.final <= 94) {
                        return `<span>A+</span>`
                    }
                    if(data.final >= 85 && data.final <= 89) {
                        return `<span>B</span>`
                    }
                    if(data.final >= 80 && data.final <= 84) {
                        return `<span>B+</span>`
                    }
                    if(data.final >= 75 && data.final <= 79) {
                        return `<span>C</span>`
                    }
                    if(data.final >= 70 && data.final <= 74) {
                        return `<span>C+</span>`
                    }
                    if(data.final >= 65 && data.final <= 69) {
                        return `<span>D</span>`
                    }
                    if(data.final >= 60 && data.final <= 64) {
                        return `<span>D+</span>`
                    }
                    if(data.final >= 0 && data.final <= 59) {
                        return `<span>Failed</span>`
                    }
                  
                } },
            
              
                {
                   
                    "data": function (data) {
                    return `<div class="btn-group " style="cursor: pointer">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <i class="fa fa-ellipsis-v padding " ></i>
                                </a>
                                <div class="dropdown-menu" x-placement="bottom-start" id="bottomStart"> 
                                    <a class="dropdown-item" onclick="updateBranch('${data.id}','${data.student_name}','${data.course}','${data.quiz1}','${data.quiz2}','${data.midterm}','${data.final}')" href="#">
                                        edit
                                    </a> 
                                    <a class="dropdown-item" onclick="deletebranch('${data.id}')" href="#">
                                        delete
                                    </a> 
                                </div>
                            </div>
                            `;

                    }
                },

            ],


        });
    });

    function checkandopenmodal() {
        $('#addstudentexcel').modal('show');
    }
</script>
@endif
@if(session()->get('role') == 'coordinator')
    <script>

$(document).ready(function () {
        let z;
        let v;
        let i = 1;
        for (let index = 2000; index < 2050; index++) {
            z =`<option value="${index}">${index}</option>`;
            $('#year').append(z);
            $('#up_year').append(z);
        }
        // All Courses
        $.ajax({
            url : "all-courses",
            type: 'get',
            success: function(res) {
                let courses = res.data;
                for(let course of courses) {
                    v =`<option value="${course.course_name}">${course.course_name}</option>`;
                    $('#course').append(v);
                    $('#up_course').append(v);
                }
                // console.log(res.data);
            }
        })
        table = $('#table').DataTable({
            //   "lengthMenu": [[25,50,100,250,500,1000], [25,50,100,250,500,1000]],
            // "dom":  "<'row'<'col-md-2'l><'col-md-3'i><'col-md-2'B><'col-md-5'p>>",
               
            dom: 'Bfrtip',
        // buttons: [
        //     'colvis', 'csv', 'excel', 'pdf', 'print'
        // ],
        buttons: [
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            'colvis'
        ],
            "ajax": "all-totals",
            "columns": [
                
                { "data":function (data) {
                    return `<span>${i++}</span>`
                  }
                },
                { "data": "student_name", "defaultContent": "" },
                { "data": "course", "defaultContent": "" },
                { "data": "quiz", "defaultContent": "" },
                { "data": "quiz_period", "defaultContent": "" },
                { "data": "degree", "defaultContent": "" },
               

            ],


        });
    });
    </script>
@endif
@endsection
