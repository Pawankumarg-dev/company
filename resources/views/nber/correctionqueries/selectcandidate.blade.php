@extends('layouts.app');

@section('content')

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    Add New Entry - Correction Query
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-4"></div>

            <div class="col-sm-4 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    <form class="form-horizontal" role="form" method="POST"
                          autocomplete="off" accept-charset="UTF-8"
                          action="{{url('/nber/correction-query/check-candidate/')}}" onsubmit="return validateform()">
                        {{ csrf_field() }}

                        <div class="form-group left-text">
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

                        <div class="form-group {{ $errors->has('enrolmentno') ? 'has-error' : '' }}">
                            <label for="enrolmentno" class="control-label col-sm-5">
                                <div class="left-text">
                                    <div class="blue-text">Enrolment Number</div>
                                    <div class="red-text">(mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="enrolmentno" name="enrolmentno"
                                       placeholder="Enrolment Number"
                                       value="{{ old('enrolmentno') }}" />
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('enrolmentno') ? 'has-error' : '' }}">
                            <label for="enrolmentno" class="control-label col-sm-5">
                                <div class="left-text">
                                    <div class="blue-text">Query Type</div>
                                    <div class="red-text">(mandatory)</div>
                                </div>
                            </label>
                            <div class="col-sm-6">
                                <select class="form-control" name="correctionquery_type" id="correctionquery_type">
                                    <option value="0">-- Select --</option>>
                                    <option value="1">Correction</option>
                                    <option value="2">Verification</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-5 left-text">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-sm-4"></div>
        </div>
    </section>

    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog red-background">
            <div class="modal-content">
                <div class="modal-header red-background">
                    <h3><span class="glyphicon glyphicon-alert"></span>&nbsp; Alert Message</h3>
                </div>

                <div class="modal-body">
                    <span class="red-text" id="alertmessage">

                    </span>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateform() {
            var enrolmentno = document.getElementById('enrolmentno');
            var cq_type = document.getElementById('correctionquery_type');

            if(enrolmentno.value == "") {
                $('#modal').modal('show');
                $('#alertmessage').text('Enrolment Number cannot be left blank!!!');
                return false;
            }
            if(cq_type.options[cq_type.selectedIndex].value == '0'){
                $('#modal').modal('show');
                $('#alertmessage').text('Please select a query type!!!');
                return false;
            }
        }
    </script>
@endsection