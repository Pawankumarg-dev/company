@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>
                August 2023 Examinations - View Exam Application
                </h4>
            <h3>
            {{ $candidate->name }} ({{ $candidate->enrolmentno }})
            </h3>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <tr>
                        <td class="center-text" rowspan="4" width="15%">
                            <img src="{{ asset('/files/enrolment/photos/'.$candidate->photo) }}" style="width: 100px;" class="img" />
                        </td>
                        <td width="10%">Enrolment No.</td>
                        <td class="bold-text orange-text">{{ $candidate->enrolmentno }}</td>
                    </tr>
                    <tr>
                        <td width="10%">Name</td>
                        <td class="bold-text orange-text">{{ $candidate->name }}</td>
                    </tr>
                    <tr>
                        <td width="10%">Course</td>
                        <td class="bold-text orange-text">
                            {{ $candidate->approvedprogramme->programme->course_name }}
                        </td>
                    </tr>
                    <tr>
                        <td width="10%">Batch</td>
                        <td class="bold-text orange-text">
                            ({{ $candidate->approvedprogramme->academicyear->year }})
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive">

                <table class="table table-bordered table-condensed">
                    <tr>
                        <th class="center-text orange-text" width="5%">S.No.</th>
                        <th class="center-text orange-text" width="5%">Paper Year</th>
                        <th class="center-text orange-text" width="5%">Paper Type</th>
                        <th class="center-text orange-text" width="5%">Paper Code</th>
                        <th class="center-text orange-text" width="60%">Paper Name</th>
                        <th class="center-text orange-text" width="10%">Language</th>
                    </tr>
                        @php $sno = 1; @endphp
                        @foreach($candidate->subjects as $application)
                            <tr>
                                <td class="center-text blue-text">{{ $sno }}@php $sno++; @endphp</td>
                                <td class="center-text blue-text">{{ $application->syear }}</td>
                                <td class="center-text blue-text">{{ $application->subjecttype->type }}</td>
                                <td class="center-text blue-text">{{ $application->scode }}</td>
                                <td class="blue-text">{{ $application->sname }}</td>
                                <td class="center-text blue-text">{{\App\Language::find($application->pivot->language_id)->language }}</td>

                            </tr>
                        @endforeach
                </table>
            </div>
               
            </div>
        </div>
    </div>
@endsection