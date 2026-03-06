@extends('layouts.expertpool')

@section('content')
    <!--header-->
    <header class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 6 - Teaching Experience
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/edit/stage6/checkaddform/')}}" autocomplete="off" accept-charset="UTF-8"
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

                    <div class="form-group {{ $errors->has('is_presently_working') ? 'has-error' : '' }}">
                        <label for="is_presently_working" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Is Presently working here?</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" id="is_presently_working1" name="is_presently_working" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" id="is_presently_working2" name="is_presently_working" value="No">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $("#yesfield").show();

                            $("#is_presently_working1").click(function () {
                                $("#yesfield").hide();
                                var date=new Date();
                                var dateval=date.getDate()+"-"+(date.getMonth()+1)+"-"+date.getFullYear();
                                $("#to_date").val(dateval);
                                $("#to_date").prop("disabled", true);
                            });
                            $("#is_presently_working2").click(function () {
                                $("#yesfield").show();
                                $("#to_date").val("");
                                $("#to_date").prop("disabled", false);
                            });
                        })
                    </script>

                    <div class="form-group {{ $errors->has('designation') ? 'has-error' : '' }}">
                        <label for="designation" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Designation</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Designation" value="{{ old('designation') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#designation').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                        <label for="department" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Department</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department" value="{{ old('department') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#department').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('organization_category') ? 'has-error' : '' }}">
                        <label for="organization_category" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Organization Category</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" name="organization_category">
                                        <option value="0">-- Select --</option>>
                                        <option value="Government Organization">Government Organization</option>
                                        <option value="Aided Organization">Aided OrganizationOrganization</option>
                                        <option value="Non-Government Organization">Non-Government Organization</option>
                                        <option value="Private Organization">Private Organization</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('organization_type') ? 'has-error' : '' }}">
                        <label for="organization_type" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Organization Type</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" name="organization_type">
                                        <option value="0">-- Select --</option>>
                                        <option value="School">School</option>
                                        <option value="College">College</option>
                                        <option value="National Institute">National Institute</option>
                                        <option value="University">University</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('organization_name') ? 'has-error' : '' }}">
                        <label for="organization_name" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Organization Name</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="organization_name" name="organization_name" placeholder="Enter Organization Name" value="{{ old('organization_name') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#organization_name').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('organization_address') ? 'has-error' : '' }}">
                        <label for="organization_address" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Organization Address</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="5" id="organization_address" name="organization_address" placeholder="Enter Organization's Full Address"  value="{{ old('organization_address') }}"></textarea>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                        <label for="state_id" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Organization belongs to the State / UT of</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" name="state_id">
                                        <option value="0">-- Select State / UT --</option>

                                        @foreach($states as $s)
                                            <option value="{{ $s->id }}">{{ $s->state_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('from_date') ? 'has-error' : '' }}">
                        <label for="from_date" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">From Date</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <div class='input-group date' id='fromdate_datetimepicker'>
                                <input type='text' class="form-control" placeholder="Choose From Date" id="from_date" name="from_date"  value="{{ old('from_date') }}"/>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#fromdate_datetimepicker').datetimepicker({
                                            format: 'DD-MM-YYYY'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div id="yesfield">
                        <div class="form-group {{ $errors->has('to_date') ? 'has-error' : '' }}">
                            <label for="to_date" class="control-label col-sm-3">
                                <div class="left-text">
                                    <div class="blue-text">To Date</div>
                                    <div class="red-text">(mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-3">
                                <div class='input-group date' id='todate_datetimepicker'>
                                    <input type='text' class="form-control" placeholder="Choose To Date" id="to_date" name="to_date"  value="{{ old('to_date') }}"/>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>
                                    <script type="text/javascript">
                                        $(function () {
                                            $('#todate_datetimepicker').datetimepicker({
                                                format: 'DD-MM-YYYY'
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('file_experience') ? 'has-error' : '' }}">
                            <label for="file_experience" class="control-label col-sm-3">
                                <div class="left-text">
                                    <div class="blue-text">Upload Experience Certificate</div>
                                    <div class="red-text">The upload file should be less than 1 MB (mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-3">
                                <input type="file" title="Upload" class="btn btn-info" id="file_experience" name="file_experience">
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