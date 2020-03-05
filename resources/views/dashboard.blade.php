@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Dashboard', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
<style>
    .card .card-category i, .card label i {
    font-size: 45px !important;
    color: #1dc7ea !important;
}
.text-dark {
    color: #7c48be !important;
}
strong {
    font-weight: bolder;
    font-family: cursive;
    color: #615d5d;
}
small{
    font-family: cursive;
    font-size: 16px;
}
</style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="form-group col-xs-12 col-sm-12  col-md-4">
                    <label for="year">Year</label>
                    <select id="up_year" onchange="getchart(this.value)" name="year" class="form-control">
                    </select>
                </div>
                <div class="form-group col-xs-12 col-sm-12  col-md-4">
                    <label for="year">Semester</label>
                    <select id="up_quiz_semester" onchange="getchart(this.value)" name="semester" class="form-control">
                        <option value="one">one</option>
                        <option value="two">two</option>
                        <option value="three">three</option>
                        <option value="four">four</option>
                    </select>
                </div>
                <div class="form-group col-xs-12 col-sm-12  col-md-4">
                    <label for="year">Course</label>
                    <select id="up_course" onchange="getchart(this.value)" name="course" class="form-control" required>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="card ">
                        <div class="card-header ">
                            <p class="card-category text-center"><i class="nc-icon nc-notes" ></i></p>
                        </div>
                        <div class="card-body text-center">
                            <small class="text-center text-success">Excellent</small><br>
                           <strong class="text-center" id="excellent"></strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card ">
                        <div class="card-header ">
                            <p class="card-category text-center"><i class="nc-icon nc-layers-3"></i></p>
                        </div>
                        <div class="card-body text-center">
                            <small class="text-center text-warning">Good</small><br>
                           <strong class="text-center" id="good"></strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card ">
                        <div class="card-header ">
                            <p class="card-category text-center"><i class="nc-icon nc-map-big"></i></p>
                        </div>
                        <div class="card-body text-center">
                            <small class="text-center text-danger">Below</small><br>
                           <strong class="text-center" id="below"></strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card ">
                        <div class="card-header ">
                            <p class="card-category text-center"><i class="nc-icon nc-paper-2"></i></p>
                        </div>
                        <div class="card-body text-center">
                            <small class="text-center text-dark" >Failed</small><br>
                           <strong class="text-center" id="failed"></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-header ">
                            <small class="card-title">Totals KBI midterm</small>
                            <p class="card-category">students degrees</p>
                        </div>
                        <div class="card-body ">
                            <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>
                            <div class="legend">
                                <i class="fa fa-circle" style="color: #1DC7EA"></i>Excellent
                                <i class="fa fa-circle text-warning"></i>Good
                                <i class="fa fa-circle" style="color: #9368E9"></i>Below
                                <i class="fa fa-circle text-danger"></i>Failed
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-header ">
                            <small class="card-title">Totals KBI final</small>
                            <p class="card-category">students degrees</p>
                        </div>
                        <div class="card-body ">
                            <div id="chartUSers" class="ct-chart ct-perfect-fourth"></div>
                            <div class="legend">
                                <i class="fa fa-circle" style="color: #1DC7EA"></i>Excellent
                                <i class="fa fa-circle text-warning"></i>Good
                                <i class="fa fa-circle" style="color: #9368E9"></i>Below
                                <i class="fa fa-circle text-danger"></i>Failed
                            </div>
                            
                           
                        </div>
                    </div>
                </div>
          
            </div>
            
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            let z;
            for (let index = 2000; index < 2050; index++) {
                z =`<option value="${index}">${index}</option>`;
                $('#year').append(z);
                $('#up_year').append(z)
            }
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
            $.ajax({
                url: 'totals-counts',
                type: 'get',
                success: function(res) {
                    $('#failed').text(res.Failed)
                    $('#good').text(res.Good)
                    $('#below').text(res.Below)
                    $('#excellent').text(res.Excellent)
                    console.log(res);
                    
                }
            })
            // Javascript method's body can be found in assets/js/demos.js
            let labelss=[];
            let labelssxx=[];
            let labelsss=[];
            let labelssxxx=[];
            $.ajax({
                url:"total-counts",
                type: "get",
                success: function(res) {
                        labelss.push(''+Math.round(res['Midterm'].Excellent*100/res['Midterm'].total)+'%')
                        labelss.push(''+Math.round(res['Midterm'].Good*100/res['Midterm'].total)+'%')
                        labelss.push(''+Math.round(res['Midterm'].Below*100/res['Midterm'].total)+'%')
                        labelss.push(''+Math.round(res['Midterm'].Failed*100/res['Midterm'].total)+'%')
                        labelssxx.push(res['Midterm'].Excellent)
                        labelssxx.push(res['Midterm'].Good)
                        labelssxx.push(res['Midterm'].Below)
                        labelssxx.push(res['Midterm'].Failed)
                        labelsss.push(''+Math.round(res['Final'].Excellent*100/res['Final'].total)+'%')
                        labelsss.push(''+Math.round(res['Final'].Good*100/res['Final'].total)+'%')
                        labelsss.push(''+Math.round(res['Final'].Below*100/res['Final'].total)+'%')
                        labelsss.push(''+Math.round(res['Final'].Failed*100/res['Final'].total)+'%')
                        labelssxxx.push(res['Final'].Excellent)
                        labelssxxx.push(res['Final'].Good)
                        labelssxxx.push(res['Final'].Below)
                        labelssxxx.push(res['Final'].Failed)
                        demo.initDashboardPageCharts('chartPreferences',labelss,labelssxx,'chartUSers',labelsss,labelssxxx);
                }
            });
            demo.showNotification();

        });
        function getchart()
        {
                let labelss=[];
                let labelssxx=[];
                let labelsss=[];
                let labelssxxx=[];
                let year=$("#up_year").val();
                let semester=$("#up_quiz_semester").val()
                let course=$("#up_course").val()
                console.log(year+semester+course);
                $.ajax({
                    url:`get-charts?year=${year}&semester=${semester}&course=${course}`,
                    type: "get",
                    success: function(res) {
                        console.log(res);
                        labelss.push(''+Math.round(res['Midterm'].Excellent*100/res['Midterm'].total)+'%')
                        labelss.push(''+Math.round(res['Midterm'].Good*100/res['Midterm'].total)+'%')
                        labelss.push(''+Math.round(res['Midterm'].Below*100/res['Midterm'].total)+'%')
                        labelss.push(''+Math.round(res['Midterm'].Failed*100/res['Midterm'].total)+'%')
                        labelssxx.push(res['Midterm'].Excellent)
                        labelssxx.push(res['Midterm'].Good)
                        labelssxx.push(res['Midterm'].Below)
                        labelssxx.push(res['Midterm'].Failed)
                        labelsss.push(''+Math.round(res['Final'].Excellent*100/res['Final'].total)+'%')
                        labelsss.push(''+Math.round(res['Final'].Good*100/res['Final'].total)+'%')
                        labelsss.push(''+Math.round(res['Final'].Below*100/res['Final'].total)+'%')
                        labelsss.push(''+Math.round(res['Final'].Failed*100/res['Final'].total)+'%')
                        labelssxxx.push(res['Final'].Excellent)
                        labelssxxx.push(res['Final'].Good)
                        labelssxxx.push(res['Final'].Below)
                        labelssxxx.push(res['Final'].Failed)
                        demo.initDashboardPageCharts('chartPreferences',labelss,labelssxx,'chartUSers',labelsss,labelssxxx);
                    }
                });
        }
    </script>
@endpush