@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/edit/stage3/updateform')}}" autocomplete="off" accept-charset="UTF-8"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if (Session::has('messages') )
                        @include('common.errorandmsg')
                    @endif

                    <input type="hidden" name="expertqualification_id" value="{{ $expertqualification->id }}"/>

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
                            <input type="text" class="form-control" id="application_no" name="application_no" value="{{ $expertqualification->expert->application_no }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-sm-3">
                            <div class="left-text blue-text">Name</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $expertqualification->expert->title }} {{ $expertqualification->expert->name }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('course_type') ? 'has-error' : '' }}">
                        <label for="course_type" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Course Type</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" name="course_type">
                                        <option value="0">-- Select Title --</option>
                                        <option value="Certificate Course" @if($expertqualification->course_type == "Certificate Course") selected @endif >Certificate Course</option>
                                        <option value="Diploma Course" @if($expertqualification->course_type == "Diploma Course") selected @endif >Diploma Course</option>
                                        <option value="Graduation Course" @if($expertqualification->course_type == "Graduation Course") selected @endif >Graduation Course</option>
                                        <option value="Post-Graduation Course" @if($expertqualification->course_type == "Post-Graduation Course") selected @endif >Post-Graduation Course</option>
                                        <option value="Post-Graduation Diploma Course" @if($expertqualification->course_type == "Post-Graduation Diploma Course") selected @endif >Post-Graduation Diploma Course</option>
                                        <option value="Ph.D Course" @if($expertqualification->course_type == "Ph.D Course") selected @endif >Ph.D Course</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('course_name') ? 'has-error' : '' }}">
                        <label for="course_name" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Course Name</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="course_name" name="course_name" placeholder="Enter Course Name" value="{{ $expertqualification->course_name }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#course_name').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('course_mode') ? 'has-error' : '' }}">
                        <label for="course_mode" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Course Mode</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <select class="form-control" name="course_mode">
                                        <option value="0">-- Select --</option>
                                        <option value="Regular" @if($expertqualification->course_mode == 'Regular') selected @endif >Regular</option>
                                        <option value="Distance" @if($expertqualification->course_mode == 'Distance') selected @endif >Distance</option>
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
                            <input type="text" class="form-control" id="institute_name" name="institute_name"  placeholder="Enter Institute / Study Center Name"  value="{{ $expertqualification->institute_name }}"/>
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
                                            <option value="{{ $s->id }}" @if($expertqualification->state_id == $s->id) selected @endif>{{ $s->state_name }} </option>
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
                            <input type="text" class="form-control" id="exambody_name" name="exambody_name" placeholder="Enter University / Examination Body Name" value="{{ $expertqualification->exambody_name }}"/>
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
                                <input type='text' class="form-control" placeholder="Choose Course Completion Year" id="course_complete_year" name="course_complete_year"  value="{{ $expertqualification->course_complete_year }}"/>
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
                            <input type="text" class="form-control" id="certificate_no" name="certificate_no" placeholder="Enter Certificate Number" value="{{ $expertqualification->certificate_no }}"/>
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