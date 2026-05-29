@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="row text-right" style="margin-right: 20px;">
                <div style="margin-bottom:15px;">
                    <a class="btn btn-success btn-sm" href="{{ route('verifyattnninternal') }}">Back</a>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>SL NO.</th>
                            <th>Enrolment No</th>
                            <th>Candidate Name</th>
                            <th>Term</th>
                            <th>Theory </th>
                            <th>Practical </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($internal_details) > 0)
                            @foreach ($internal_details as $index => $internal_detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $internal_detail->enrolmentno }}</td>
                                    <td>{{ $internal_detail->name }}</td>
                                    <td>{{ $internal_detail->term }}</td>
                                    <td>{{ $internal_detail->attendance_t . ' % ' }} <br> <button type="button"
                                            class="btn btn-sm btn-success add-attendance-btn"
                                            data-enrolmentno="{{ $internal_detail->enrolmentno }}"
                                            data-term="{{ $internal_detail->term }}" data-type="theory">Add</button></td>
                                    <td>{{ $internal_detail->attendance_p . ' % ' }} <br> <button type="button"
                                            class="btn btn-sm btn-success add-attendance-btn"
                                            data-enrolmentno="{{ $internal_detail->enrolmentno }}"
                                            data-term="{{ $internal_detail->term }}" data-type="practical">Add</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center text-danger">
                                <td colspan="6">No Data Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="col-md-6" style="height: 1500px;">
                <div style="font-size:20px; margin-left:10px;">Attendance</div>
                @if (count($internal_details) > 0)
                    @php
                        $internal_detail = $internal_details[0];
                    @endphp
                    <div id="iframeContainer" style="border:1px solid #ccc; overflow-y:auto;" >
                        <div class="iframeWrapper" style="height:500px;" style="margin-bottom:20px;">
                            <div style="font-size:16px; margin:10px;">Theory</div>
                            <button class="btn btn-sm btn-info"
                                onclick="window.open('{{ url('/files/attendance/' . $internal_detail->document_t) }}', '_blank')">
                                Open PDF Full View
                            </button>
                            <iframe id="pdf1" src="{{ url('/files/attendance/' . $internal_detail->document_t) }}"
                                style="width: 100%; height: 100%; border: 1px solid #ccc;" style="border:1px solid #ccc;">
                            </iframe>
                        </div>

                        <div class="iframeWrapper" style="height: 500px;">
                            <div style="font-size:16px; margin:10px;">Practical</div>

                            <button class="btn btn-sm btn-info"
                                onclick="window.open('{{ url('/files/attendance/' . $internal_detail->document_p) }}', '_blank')">
                                Open PDF Full View
                            </button>
                            <iframe id="iframePractical" src="{{ url('/files/attendance/' . $internal_detail->document_p) }}"
                                style="width: 100%; height: 100%; border: 1px solid #ccc;" style="border:1px solid #ccc;">
                            </iframe>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12  text-right " style="margin-top: 20px;">
                            @if ($internal_detail->enable_edit == 0)
                                <a href="{{ url('/nber/exam/verifyattendancedata', [$internal_detail->id, $internal_detail->term]) }}"
                                    class="btn btn-sm btn-success">
                                    Verify
                                </a>
                            @else
                                <strong>Already Verified</strong>
                            @endif
                        </div>
                    </div>
            </div>
        </div>
        @endif

    </div>



@endsection

@section('script')
    <!-- Modal for adding attendance increment -->
    <div class="modal fade" id="addAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="addAttendanceLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style = "width:350px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="addAttendanceLabel">Add Attendance</h4>
                </div>
                <div class="modal-body">
                    <form id="addAttendanceForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="enrolmentno" id="modalEnrolmentno">
                        <input type="hidden" name="term" id="modalTerm">
                        <input type="hidden" name="type" id="modalType">

                        <div class="form-group">
                            <label for="attendanceValue">Maximum attendance increase: 5 %. </label>
                            <input type="number" class="form-control" id="attendanceValue" name="value" min="1"
                                max="5" step="any" required>
                        </div>
                    </form>
                    <div id="addAttendanceFeedback" style="display:none;" class="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="submitAddAttendance" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            var modal = $('#addAttendanceModal');

            $(document).on('click', '.add-attendance-btn', function(e) {
                e.preventDefault();
                var enrol = $(this).data('enrolmentno');
                var term = $(this).data('term');
                var type = $(this).data('type');
                $('#modalEnrolmentno').val(enrol);
                $('#modalTerm').val(term);
                $('#modalType').val(type);
                $('#attendanceValue').val('');
                $('#addAttendanceFeedback').hide();
                modal.modal('show');
            });

            $('#submitAddAttendance').on('click', function() {
                var form = $('#addAttendanceForm');
                var data = form.serialize();
                var value = parseFloat($('#attendanceValue').val());
                if (isNaN(value) || value < 1 || value > 5) {
                    $('#addAttendanceFeedback').removeClass().addClass('alert alert-danger').text(
                        'Please enter  minimum 1% and maximum 5% attendance increase').show();
                    return;
                }

                $.ajax({
                    url: '{{ url('/nber/exam/add-attendance') }}',
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(resp) {
                        if (resp.success) {
                            $('#addAttendanceFeedback').removeClass().addClass(
                                'alert alert-success').text('Attendance updated to ' + resp
                                .new + ' %').show();
                            var enrol = $('#modalEnrolmentno').val();
                            var type = $('#modalType').val();
                            var selector = 'button.add-attendance-btn[data-enrolmentno="' +
                                enrol + '"][data-type="' + type + '"]';
                            var btn = $(selector);
                            var cell = btn.closest('td');
                            cell.contents().filter(function() {
                                return this.nodeType === 3;
                            }).first().replaceWith(resp.new + ' % ');
                            setTimeout(function() {
                                modal.modal('hide');
                            }, 800);
                        } else {
                            $('#addAttendanceFeedback').removeClass().addClass(
                                    'alert alert-danger').text(resp.error || 'Update failed')
                                .show();
                        }
                    },
                    error: function(xhr) {
                        var msg = 'Server error';
                        if (xhr.responseJSON && xhr.responseJSON.error) msg = xhr.responseJSON
                            .error;
                        $('#addAttendanceFeedback').removeClass().addClass('alert alert-danger')
                            .text(msg).show();
                    }
                });
            });
        });
    </script>
@endsection
