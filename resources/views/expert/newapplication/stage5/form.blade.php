@extends('layouts.expertpool')

@section('content')
    <!--header-->
    <header class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 5 - RCI CRR Number Details
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/new/checkstage5')}}" autocomplete="off" accept-charset="UTF-8"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if (Session::has('messages') )
                        @include('common.errorandmsg')
                    @endif

                    <input type="hidden" name="expert_id" value="{{ $expert->id }}"/>

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
                            <input type="text" class="form-control" id="application_no" name="application_no" value="{{ $expert->application_no }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-sm-3">
                            <div class="left-text blue-text">Name</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $expert->title }} {{ $expert->name }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('has_crr_no') ? 'has-error' : '' }}">
                        <label for="has_crr_no" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Do you have RCI's Central Rehabilitation Register (CRR) Number</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" id="has_crr_no1" name="has_crr_no" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" id="has_crr_no2" name="has_crr_no" value="No">No</label>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $("#yesfield").hide();

                                        $("#has_crr_no1").click(function () {
                                            $("#yesfield").show();
                                        });
                                        $("#has_crr_no2").click(function () {
                                            $("#yesfield").hide();
                                        });
                                    })
                                </script>
                            </div>
                        </div>
                    </div>

                    <div id="yesfield">
                        <div class="form-group {{ $errors->has('crr_no') ? 'has-error' : '' }}">
                            <label for="crr_no" class="control-label col-sm-3">
                                <div class="left-text">
                                    <div class="blue-text">RCI's Central Rehabilitation Register (CRR) Number</div>
                                    <div class="red-text">(mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="crr_no" name="crr_no"  placeholder="Enter CRR Number"  value="{{ old('crr_no') }}"/>
                                <script>
                                    $(document).ready(function () {
                                        $('#crr_no').keyup(function () {
                                            $(this).val($(this).val().toUpperCase());
                                        });
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('crr_no_issued_year') ? 'has-error' : '' }}">
                            <label for="crr_no_issued_year" class="control-label col-sm-3">
                                <div class="left-text">
                                    <div class="blue-text">CRR No Issued Year</div>
                                    <div class="red-text">(mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-3">
                                <div class='input-group date' id='year_datetimepicker'>
                                    <input type='text' class="form-control" placeholder="Choose CRR No Issued Year" id="crr_no_issued_year" name="crr_no_issued_year"  value="{{ old('crr_no_issued_year') }}"/>
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

                        <div class="form-group {{ $errors->has('crr_no_expiry_year') ? 'has-error' : '' }}">
                            <label for="crr_no_expiry_year" class="control-label col-sm-3">
                                <div class="left-text">
                                    <div class="blue-text">CRR No Expiry Year</div>
                                    <div class="red-text">(mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-3">
                                <div class='input-group date' id='year2_datetimepicker'>
                                    <input type='text' class="form-control" placeholder="Choose CRR No Expiry Year" id="crr_no_expiry_year" name="crr_no_expiry_year"  value="{{ old('crr_no_expiry_year') }}"/>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>

                                    <script type="text/javascript">
                                        $(function () {
                                            $('#year2_datetimepicker').datetimepicker({
                                                viewMode: 'years',
                                                format: 'YYYY'
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('crr_no_issued_year') ? 'has-error' : '' }}">
                            <label for="crr_no_issued_year" class="control-label col-sm-3">
                                <div class="left-text">
                                    <div class="blue-text">CRR No Issued Year</div>
                                    <div class="red-text">(mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-3">
                                <div class='input-group date' id='year2_datetimepicker'>
                                    <input type='text' class="form-control" placeholder="Choose CRR No Issued Year" id="crr_no_issued_year" name="crr_no_issued_year"  value="{{ old('crr_no_issued_year') }}"/>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>

                                    <script type="text/javascript">
                                        $(function () {
                                            $('#year2_datetimepicker').datetimepicker({
                                                viewMode: 'years',
                                                format: 'YYYY'
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('file_crr_no') ? 'has-error' : '' }}">
                            <label for="file_crr_no" class="control-label col-sm-3">
                                <div class="left-text">
                                    <div class="blue-text">Upload CRR Certificate</div>
                                    <div class="red-text">The upload file should be less than 1 MB (mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-3">
                                <input type="file" title="Upload" class="btn btn-info" id="file_crr_no" name="file_crr_no">
                                <script>
                                    $('input[type=file]').bootstrapFileInput();
                                    $('.file-inputs').bootstrapFileInput();
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
        </div>

    </header>
    <!-- ./header-->
@endsection