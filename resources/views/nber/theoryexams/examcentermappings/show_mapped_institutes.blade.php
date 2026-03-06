@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations - Exam Center Mappings
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/exams') }}">Exams</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/'.$exam->id) }}">{{ $exam->name }} Theory</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/'.$exam->id) }}">Exam Centre Mappings</a>
                                                </li>
                                                <li class="active">Mapped Institutes</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p class="center-text">
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/updateinstitutemappingform/'.$exam->id) }}" class="btn btn-sm btn-primary">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Institute Mapping
                                                            </a>
                                                            <a href="" class="btn btn-sm btn-primary">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Candidate Mapping
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Exam Centers
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/showmappedinstitutes/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Institutes
                                                            </a>
                                                            <a href="{{ url('/nber/theoryexams/examcentermapping/showmappedcandidates/'.$exam->id) }}" class="btn btn-sm btn-success">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Mapped Candidates
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>

                                                @if(Session::has('message'))
                                                    @php echo '<script> swal("Exam Centre Mappings", "Updated Successfully!!!!" , "success") </script>'  @endphp
                                                @endif

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    Details of Institutes Mapped
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <p class="pull-right">
                                                                                <a href="{{ url('/nber/theoryexams/examcentermapping/downloadmappedinstitutes/'.$exam->id) }}" class="btn btn-sm btn-success" target="_blank">
                                                                                    <span class="glyphicon glyphicon-download-alt"></span>&nbsp;Mapped Institutes
                                                                                </a>
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-hover table-condensed" role="table">
                                                                            <thead>
                                                                            <tr>
                                                                                <th class="center-text" width="5%">S.No.</th>
                                                                                <th class="center-text" width="5%">Institute Code</th>
                                                                                <th class="center-text">Institute Name</th>
                                                                                <th class="center-text" width="6%">Exam Center Code</th>
                                                                                <th class="center-text" width="6%">Update</th>
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                            @if($collections->count() == 0)
                                                                                <tr>
                                                                                    <td colspan="5" class="center-text red-text">No Records Found</td>
                                                                                </tr>
                                                                            @else
                                                                                @php $sno = 1; $count = 0; @endphp
                                                                                <input type="hidden" id="exam-id" value="{{ $exam->id }}" />

                                                                                @foreach($collections as $collection)
                                                                                    <tr>
                                                                                        <td class="center-text blue-text">{{ $sno }}</td>
                                                                                        <td class="center-text blue-text">{{ $collection->instituteCode }}</td>
                                                                                        <td class="blue-text">{{ $collection->instituteName }}</td>
                                                                                        <td class="center-text blue-text">{{ $collection->examcenterCode }}</td>
                                                                                        <td class="center-text blue-text">
                                                                                            <input type="hidden" id="institute-id-{{ $count }}" value="{{ $collection->instituteID }}" />
                                                                                            <select id="exam-center-{{ $count }}" onchange="updateExamCenter({{ $count }})">
                                                                                                <option value="0">0</option>
                                                                                                @foreach($examcenters as $examcenter)
                                                                                                    <option value="{{ $examcenter->id }}" @if($examcenter->id == $collection->examcenterId) selected  @endif >{{ $examcenter->code }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @php $sno++; $count++; @endphp
                                                                                @endforeach
                                                                            @endif
                                                                            </tbody>
                                                                        </table>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Update Exam Center Modal -->
    <div class="modal fade" id="update-exam-center-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div id="loader-div" class="col-sm-12 content-hide">
                            <div class="form-group">
                                <div id="loader" class="loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {

        });

        function updateExamCenter(count) {
            $.ajax({
                url: "{{ url('/nber/theoryexams/examcentermapping/ajarequest/updatedexamcenter/') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: "{{ csrf_token() }}", examId: $('#exam-id').val(), examcenterId: $('#exam-center-'+count).val(), instituteId: $('#institute-id-'+count).val()},
                beforeSend:function() {
                    $('#update-exam-center-modal').modal({backdrop: 'static', keyboard: false});

                    if($('#loader-div').hasClass('content-hide')) {
                        $('#loader-div').removeClass('content-hide').addClass('content-show');
                    }
                },
                success:function(response) {
                    window.location = response;
                },
            });
        }
    </script>
@endsection
