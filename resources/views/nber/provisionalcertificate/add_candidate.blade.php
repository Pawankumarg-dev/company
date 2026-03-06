<form class="form-horizontal" role="form" method="POST"
      autocomplete="off" accept-charset="UTF-8"
      action="{{ url('/provisionalcertificate/add-candidate/') }}"
      onsubmit="return validateNewDetailsForm()">
    {{ csrf_field() }}

    <div class="modal" id="newDetails" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    Add Candidate Details
                </div>

                <div class="modal-body">
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

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <span class="glyphicon glyphicon-ok"></span> Submit
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>