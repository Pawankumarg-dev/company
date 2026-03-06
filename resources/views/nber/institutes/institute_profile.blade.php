@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Institute Profile
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/institutes/showinstitutes') }}">Institute Lists</a>
                                                </li>
                                                <li class="active">{{ $institute->code }} (Profile)</li>
                                            </ul>
                                        </section>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    Profile
                                                </div>
                                            </div>

                                            <div class="panel-body">
                                                @if(Session::has('message'))
                                                    <script>
                                                        swal("Congrats!!!", "Institute's Profile details updated successfully", "success");
                                                    </script>
                                                @endif

                                                <form class="form-horizontal" action="{{url('/nber/institute/update-profile')}}" method="post" onsubmit="return validateForm()">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="instituteId" value="{{ $institute->id }}">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" role="table">
                                                            <tr>
                                                                <td class="bold-text blue-text" width="5%">Code</td>
                                                                <td width="95%">
                                                                    <div class="col-sm-2">
                                                                        <input type="text" id="instituteCode" name="instituteCode" class="form-control blue-text" value="{{ $institute->code }}" maxlength="5">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-text blue-text" width="5%">Name</td>
                                                                <td width="95%">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" id="instituteName" name="instituteName" class="form-control blue-text" value="{{ $institute->name }}">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bold-text blue-text" width="5%">Password</td>
                                                                <td width="95%">
                                                                    <div class="col-sm-2">
                                                                        <input type="text" id="institutePassword" name="institutePassword" class="form-control blue-text" value="{{ $institute->user->confirmation_code }}">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                                        <span class="glyphicon glyphicon-ok"></span>&nbsp;
                                                                        Update Profile
                                                                    </button>
                                                                    <button type="reset" class="btn btn-danger btn-sm">
                                                                        <span class="glyphicon glyphicon-remove"></span>&nbsp;
                                                                        Cancel
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </table>
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

    <script>
        function validateForm() {
            if(!$('#instituteCode').val()) {
                swal("Error Occurred!!!", "Please enter the Institute Code", "success");
                return false;
            }

            if(!$('#instituteName').val()) {
                swal("Error Occurred!!!", "Please enter the Institute Name", "error");
                return false;
            }

            if(!$('#institutePassword').val()) {
                swal("Error Occurred!!!", "Please enter the Institute Password", "error");
                return false;
            }

            return true;
        }
    </script>

@endsection
