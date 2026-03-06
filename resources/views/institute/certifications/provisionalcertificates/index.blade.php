@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/institute/certifications/')}}">Certifications</a></li>
                    <li>Provisional Certificates</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th class="center-text" colspan="7">
                                {{ $institute->code }} - {{ $institute->name }}
                            </th>
                        </tr>
                        <tr>
                            <th rowspan="2" width="2%">Sl. No.</th>
                            <th colspan="5">Candidate Details</th>
                            <th rowspan="2" width="10%">Provisional Certificates</th>
                        </tr>
                        <tr>
                            <th width="10%">Course</th>
                            <th width="3%">Batch</th>
                            <th width="5%">Photo</th>
                            <th width="5%">Enrolment No</th>
                            <th width="15%">Name</th>
                        </tr>

                        @php $sno = '1'; @endphp
                        @foreach($provisionalcertificates as $pc)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td>{{ $pc->candidate->approvedprogramme->programme->common_code }}</td>
                                <td>{{ $pc->candidate->approvedprogramme->academicyear->year }}</td>
                                <td class="center-text">
                                    <img src="{{asset('/files/enrolment/photos')}}/{{$pc->candidate->photo}}"
                                         style="width: 80px;" class="img" />
                                </td>
                                <td>{{ $pc->candidate->enrolmentno }}</td>
                                <td>{{ $pc->candidate->name }}</td>
                                <td class="center-text">
                                    <a href="{{ url('/online-provisional-certificate/'.$pc->candidate_id.'/'.$pc->folio_number) }}"
                                       class="btn btn-success btn-sm"
                                       target="_blank"
                                    >
                                        <span class="glyphicon glyphicon-print"></span> Print
                                    </a>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection