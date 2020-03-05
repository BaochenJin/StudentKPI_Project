@extends('layouts.app', ['activePage' => 'course-management', 'activeButton' => 'laravel', 'title' => 'Course management', 'navName' => 'Add course'])

@section('content')
    <div class="content">
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Add course') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('course.index') }}" class="btn btn-sm btn-default">{{ __('Back to list') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('course.store') }}" enctype="multipart/form-data">
                                @csrf
                                <h6 class="heading-small text-muted mb-4">{{ __('course details') }}</h6>
                                <div class="pl-lg-4">
    
                                        <input type="hidden" name="instructor" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ auth()->user()->id }}" >
                                    <div class='row'>
                                        <div class="col-4 form-group{{ $errors->has('year') ? ' has-danger' : '' }}">
                                                <label class="blockquote blockquote-primary" for="input-year">{{ __('Year') }}</label>
                                                <select name="year" id="input-year" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" required autofocus>
                                                <?php
                                                    $currentDate=getdate();
                                                    for($i=0;$i<5;$i++)
                                                    {
                                                        echo "<option value=".($currentDate['year']+$i).">".($currentDate['year']+$i)."</option>";
                                                    }
                                                ?>
                                                </select>
                                        </div>
                                        <div class="col-4 form-group{{ $errors->has('semester') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-semester">{{ __('semester') }}</label>
                                                <select name="semester" id="input-semester" class="form-control{{ $errors->has('semester') ? ' is-invalid' : '' }}">
                                                <?php
                                                    $currentDate=getdate();
                                                    for($i=1;$i<5;$i++)
                                                    {
                                                        echo "<option value=".$i.">".$i."</option>";
                                                    }
                                                ?>
                                                </select>
                                        </div>
                                        <div class="col-4 form-group{{ $errors->has('course code') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-course">{{ __('Course code') }}</label>
                                                <input type="courseCode" name="courseCode" id="input-course" class="form-control{{ $errors->has('course code') ? ' is-invalid' : '' }}" placeholder="{{ __('course code') }}" value="AI">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 form-group{{ $errors->has('total') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-total">{{ __('Average for total grade') }}</label>
                                            <input type="number" name="total" id="input-total" class="form-control{{ $errors->has('total') ? ' is-invalid' : '' }}" value="3" placeholder="{{ __('Average for total grade') }}">
                                        </div>
                                        <div class="col-4 form-group{{ $errors->has('final') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-final">{{ __('Final exam grade average') }}</label>
                                            <input type="number" name="final" id="input-final" class="form-control{{ $errors->has('final') ? ' is-invalid' : '' }}" value="3" placeholder="{{ __('Final exam grade average') }}">
                                        </div>
                                        <div class="col-4 form-group{{ $errors->has('midterm') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-midterm">{{ __('Midterm exam grade average') }}</label>
                                            <input type="number" name="midterm" id="input-midterm" class="form-control{{ $errors->has('midterm') ? ' is-invalid' : '' }}" value="3" placeholder="{{ __('Midterm exam grade average') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 form-group{{ $errors->has('excellent') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-excellent">{{ __('Excellent of grade average') }}</label>
                                            <input type="number" name="excellent" id="input-excellent" class="form-control{{ $errors->has('excellent') ? ' is-invalid' : '' }}" value="3" placeholder="{{ __('Excellent of grade average') }}">
                                        </div>
                                        <div class="col-4 form-group{{ $errors->has('good') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-good">{{ __('Good of grade average') }}</label>
                                            <input type="number" name="good" id="input-good" class="form-control{{ $errors->has('good') ? ' is-invalid' : '' }}" value="3" placeholder="{{ __('Good of grade average') }}">
                                        </div>
                                        <div class="col-4 form-group{{ $errors->has('below') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-below">{{ __('Below-Average grade') }}</label>
                                            <input type="number" name="below" id="input-below" class="form-control{{ $errors->has('below') ? ' is-invalid' : '' }}" value="3" placeholder="{{ __('Below-Average grade') }}">
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('failed') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-failed">{{ __('Failed grade average') }}</label>
                                            <input type="number" name="failed" id="input-failed" class="form-control{{ $errors->has('failed') ? ' is-invalid' : '' }}" value="3" placeholder="{{ __('Failed grade average') }}">
                                        </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-fill btn-success mt-4">{{ __('Add Course') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection