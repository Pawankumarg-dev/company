@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/edit/stage4/updateform')}}" autocomplete="off" accept-charset="UTF-8"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if (Session::has('messages') )
                        @include('common.errorandmsg')
                    @endif

                    <input type="hidden" name="expertrciqualification_id" value="{{ $expertrciqualification->id }}"/>

                    <div class="form-group">
                        <div class="col-sm-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="application_no" class="control-label col-sm-3">
                            <div class="left-text blue-text">Application No</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="application_no" name="application_no" value="{{ $expertrciqualification->expert->application_no }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-sm-3">
                            <div class="left-text blue-text">Name</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $expertrciqualification->expert->title }} {{ $expertrciqualification->expert->name }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('rcicourse_id') ? 'has-error' : '' }}">
                        <label for="rcicourse_id" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Course</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <select class="form-control" name="rcicourse_id">
                                        <option value="0">-- Select --</option>
                                        @foreach($rcicourses as $r)
                                            <option value="{{ $r->id }}" @if($expertrciqualification->rcicourse_id == $r->id) selected @endif > ({{ $r->mode }}),  {{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('institute_name') ? 'has-error' : '' }}">
                        <label for="institute_name" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Institute / Study Center Name</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="institute_name" name="institute_name"  placeholder="Enter Institute / Study Center Name"  value="{{ $expertrciqualification->institute_name }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#institute_name').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                        <label for="state_id" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Institute / Study Center belongs to the State / UT of</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" name="state_id">
                                        <option value="0">-- Select State / UT --</option>
                                        @foreach($states as $s)
                                            <option value="{{ $s->id }}" @if($expertrciqualification->state_id == $s->id) selected @endif>{{ $s->state_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('exambody_name') ? 'has-error' : '' }}">
                        <label for="exambody_name" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">University / Examination Body</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="exambody_name" name="exambody_name" placeholder="Enter University / Examination Body Name" value="{{ $expertrciqualification->exambody_name }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#exambody_name').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('course_complete_year') ? 'has-error' : '' }}">
                        <label for="course_complete_year" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Course Completion Year</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <div class='input-group date' id='year_datetimepicker'>
                                <input type='text' class="form-control" placeholder="Choose Course Completion Year" id="course_complete_year" name="course_complete_year"  value="{{ $expertrciqualification->course_complete_year }}"/>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#year_datetimepicker').datetimepicker({
                                            viewMode: 'years',
                                            format: 'YYYY'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('certificate_no') ? 'has-error' : '' }}">
                        <label for="certificate_no" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Certificate Number</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="certificate_no" name="certificate_no" placeholder="Enter Certificate Number" value="{{ $expertrciqualification->certificate_no }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection