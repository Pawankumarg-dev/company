@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Login for Stage-IV (RCI Professional Qualification)
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/new/stage4login/')}}" autocomplete="off" accept-charset="UTF-8"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if (Session::has('messages') )
                        @include('common.errorandmsg')
                    @endif

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

                    <div class="form-group {{ $errors->has('application_no') ? 'has-error' : '' }}">
                        <label for="application_no" class="control-label col-sm-4">
                            <div class="left-text">
                                <div class="blue-text">Application No.</div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="application_no" name="application_no" placeholder="Enter Application No." value="{{ old('application_no') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#application_no').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
                        <label for="dob" class="control-label col-sm-4">
                            <div class="left-text">
                                <div class="blue-text">Date of Birth (DoB)</div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <div class='input-group date' id='dob_datetimepicker'>
                                <input type='text' class="form-control" placeholder="Choose Date of Birth" id="dob" name="dob"/>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>

                                <script type="text/javascript">
                                    $(function () {
                                        $('#dob_datetimepicker').datetimepicker({
                                            viewMode: 'years',
                                            format: 'DD-MM-YYYY'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-4"></div>
        </div>
    </section>
@endsection