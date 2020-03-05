@extends('layouts.app', ['activePage' => 'Course-management', 'activeButton' => 'laravel', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Course'])

@section('content')
<style>
    #table_filter{
        text-align: center !important;
    }
    
</style>
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body">

                        {{ csrf_field() }}
                        <form action="add-course" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <div class="form-group col-xs-12 col-sm-12  col-md-2">
                                    <label for="course_name">Course name</label>
                                    <input type="text" id="course_name" name="course_name" class="form-control" required>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">


                            <table id="table" class=" table" 
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Course name</th>
                                        <th>actions</th>
                                   

                                    </tr>

                                </thead>
                            

                            </table>
                        </div>


                        <!-- deleteGroup Modal -->
                        <div id="deleteGroup" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <form action="/delete-course" method="POST">
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
                                            <form action="edit-course" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input id="updateId" name="id" hidden />
                                                <div class="form-group">
                                                    <label for="UpdatedName">Course name</label>
                                                    <input type="text" id="UpdatedName" name="course_name" class="form-control"
                                                        required>
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
<script>

    function deleteCourse(id) {
        $('#branchId').val(id)
        $('#deleteGroup').modal('show');
    }



    function updateCourse(id, name) {
        $('#UpdatedName').val(name);
        $('#updateId').val(id)
        $('#updateModal').modal('show');


    }



    $(document).ready(function () {
        let z;
        let i = 1;
        for (let index = 2000; index < 2050; index++) {
            z +=`<option value="${index}">${index}</option>`;
            $('#year').append(z);
        }
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
            "ajax": "all-courses",
            "columns": [
                { "data":function (data) {
                    return `<span>${i++}</span>`
                  }
                },
                { "data": "course_name", "defaultContent": "" },
                {
                    "data": function (data) {
                        return `<div class="btn-group "style="cursor: pointer" >
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                        <i class="fa fa-ellipsis-v padding " ></i>
                                    </a>
                                    <div class="dropdown-menu" x-placement="bottom-start" id="bottomStart"> 
                                        <a class="dropdown-item" onclick="deleteCourse('${data.id}')" href="#">
                                            delete
                                        </a> 
                                        <a class="dropdown-item" onclick="updateCourse('${data.id}','${data.course_name}')" href="#">
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
@endsection

