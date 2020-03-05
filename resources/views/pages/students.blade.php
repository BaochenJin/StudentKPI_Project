@extends('layouts.app', ['activePage' => 'typography', 'title' => 'Students', 'navName' => 'Students', 'activeButton' => 'laravel'])

@section('content')
<style>
    #table_filter{
        text-align: center !important;
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
                        <h4 class="mb-0">Students</h4>
                        {{ csrf_field() }}
                        <form action="add-student" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="form-group col-xs-12 col-sm-12  col-md-2">
                                    <label for="year">Year</label>
                                    <select id="year" name="year" class="form-control">
                                        <option selected disabled>Choose Year</option>
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12  col-md-2">
                                    <label for="year">semester</label>
                                    <select id="semester" name="semester" class="form-control" required>
                                        <option selected disabled>Choose semester</option>
                                        <option value="one">one</option>
                                        <option value="two">two</option>
                                        <option value="three">three</option>
                                        <option value="four">four</option>
                                    </select>
                                </div>
                               
                                <div class="form-group col-xs-12 col-sm-12  col-md-2">
                                    <label for="year">Course</label>
                                    <select id="course" name="course" class="form-control" required>
                                        <option selected disabled>Choose Course</option>
                                    </select>
                                </div>
                              
                     
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-12  col-md-2">
                                    <label for="student_name">Student name</label>
                                    <input type="text" id="student_name" name="student_name" class="form-control" required>
                                </div>
                        
                                <div class="form-group col-xs-12 col-sm-12  col-md-2">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for=""></label><br>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mt-1" >Add new</button>
                                </div>
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
                                        <th>year</th>
                                        <th>student_name</th>
                                        <th>email</th>
                                        <th>semester</th>
                                        <th>course</th>
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
                                <form action="delete-student" method="POST">
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
                                            <form action="edit-student" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input id="updateId" name="id" hidden />
                                                <div class="row">
                                                    <div class="form-group col-xs-12 col-sm-12  col-md-4">
                                                        <label for="year">Year</label>
                                                        <select id="up_year" name="year" class="form-control">
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-xs-12 col-sm-12  col-md-4">
                                                        <label for="year">Semester</label>
                                                        <select id="up_quiz_semester" name="semester" class="form-control">
                                                            <option value="one">one</option>
                                                            <option value="two">two</option>
                                                            <option value="three">three</option>
                                                            <option value="four">four</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-xs-12 col-sm-12  col-md-4">
                                                        <label for="year">Course</label>
                                                        <select id="up_course" name="course" class="form-control" required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-xs-12 col-sm-12 ">
                                                    <label for="student_name">Student name</label>
                                                    <input type="text" id="up_student_name" name="student_name" class="form-control" required>
                                                </div>
                                        
                                                <div class="form-group col-xs-12 col-sm-12 ">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="up_email" name="email" class="form-control" required>
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


    function updateBranch(id,student_name,semester,email,year,course) {
        $('#updateId').val(id)
        $('#up_course').val(course)
        z =`<option value="${year}" selected>${year}</option>`;
        $('#up_year').append(z)
        v =`<option value="${semester}" selected>${semester}</option>`;
        $('#up_quiz_semester').append(v)
        $('#up_student_name').val(student_name)
        $('#up_email').val(email)
        $('#updateModal').modal('show');


    }



    $(document).ready(function () {
        let z;
        let v;
        let i = 1;
        for (let index = 2000; index < 2050; index++) {
            z =`<option value="${index}">${index}</option>`;
            $('#year').append(z);
            $('#up_year').append(z)
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
                    $('#up_course').append(v)
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
            "ajax": "all-students",
            "columns": [
                
                { "data":function (data) {
                    return `<span>${i++}</span>`
                  }
                },                
                { "data": "year", "defaultContent": "" },
                { "data": "student_name", "defaultContent": "" },
                { "data": "email", "defaultContent": "" },
                { "data": "semester", "defaultContent": "" },
                { "data": "course", "defaultContent": "" },
                
                {
                    "data": function (data) {
                        return `<div class="btn-group "style="cursor: pointer">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                        <i class="fa fa-ellipsis-v padding " ></i>
                                    </a>
                                    <div class="dropdown-menu" x-placement="bottom-start" id="bottomStart"> 
                                        <a class="dropdown-item" onclick="deletebranch('${data.id}')" href="#">
                                            delete
                                        </a> 
                                        <a class="dropdown-item" onclick="updateBranch('${data.id}','${data.student_name}','${data.semester}','${data.email}','${data.year}','${data.course}')" href="#">
                                            edit
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
@if (session()->get('role') == 'coordinator')
<script>

    function deletebranch(id) {
        $('#branchId').val(id)
        $('#deleteGroup').modal('show');
    }



    function updateBranch(id,student_name,semester,email,year,course) {
        $('#updateId').val(id)
        $('#up_course').val(course)
        z =`<option value="${year}" selected>${year}</option>`;
        $('#up_year').append(z)
        v =`<option value="${semester}" selected>${semester}</option>`;
        $('#up_quiz_semester').append(v)
        $('#up_student_name').val(student_name)
        $('#up_email').val(email)
        $('#updateModal').modal('show');


    }



    $(document).ready(function () {
       
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
            "ajax": "all-students",
            "columns": [
                
                { "data":function (data) {
                    return `<span>${i++}</span>`
                  }
                },                
                { "data": "year", "defaultContent": "" },
                { "data": "student_name", "defaultContent": "" },
                { "data": "email", "defaultContent": "" },
                { "data": "semester", "defaultContent": "" },
                { "data": "course", "defaultContent": "" },
               

            ],


        });
    });
    function checkandopenmodal() {
        $('#addstudentexcel').modal('show');
    }
</script>
@endif
@endsection