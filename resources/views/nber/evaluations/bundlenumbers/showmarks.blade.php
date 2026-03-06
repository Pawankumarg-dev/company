@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/nber/evaluations')}}">Evaluations</a></li>
                    <li><a href="{{url('/nber/evaluations/bundles')}}">Exam Bundles</a></li>
                    <li><a href="{{url('/nber/evaluations/bundles/'.$exam->id)}}">{{ $exam->name }} Examinations</a></li>
                    <li><span class="bold-text blue-text">{{ $bundle_number }}</span></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="9" class="right-text">
                                <a href="{{ url('/nber/evaluations/bundles/updatemarks/'.$exam->id.'/'.$bundle_number) }}"
                                    class="btn btn-primary"
                                >
                                    <span class="glyphicon glyphicon-pencil"></span>&nbsp;  Update Marks
                                </a>
                            </th>
                        </tr>

                        <tr class="green-background">
                            <th rowspan="2" width="3%">S.No.</th>
                            <th rowspan="2" width="10%">Dummy Number</th>
                            <th rowspan="2" width="3%">Inst. Code</th>
                            <th rowspan="2" width="10%">Enrolment No</th>
                            <th rowspan="2">Name</th>
                            <th rowspan="2" width="10%">Subject Code</th>
                            <th colspan="3" class="center-text">External</th>
                        </tr>
                        <tr class="green-background">
                            <th class="center-text">Minimum<br>Marks</th>
                            <th class="center-text">Marks<br>Obtained</th>
                            <th class="center-text">Maximum<br>Marks</th>
                        </tr>
                        </thead>

                        @php $sno = 1; @endphp
                        @foreach($applications as $application)
                            @php
                                $mark = $marks->where('application_id', $application->id)->first();
                            @endphp
                            <tbody>
                            <tr>
                                <td class="blue-text">{{ $sno }}</td>
                                <td class="red-text bold-text">{{ $application->dummy_number }}</td>
                                <td class="blue-text">{{ $application->candidate->approvedprogramme->institute->code }}</td>
                                <td class="red-text bold-text">{{ $application->candidate->enrolmentno }}</td>
                                <td class="blue-text">{{ $application->candidate->name }}</td>
                                <td class="brown-text bold-text">{{ $application->subject->scode }}</td>
                                <td class="blue-text center-text  bold-text">{{ $application->subject->emin_marks }}</td>
                                <td class="center-text bold-text">
                                    @if(!is_null($mark))
                                        @if($mark->external == "")
                                            <span class="red-text">
                                                Not Entered
                                            </span>
                                        @elseif($mark->external < $application->subject->emin_marks)
                                            <span class="red-text">
                                                {{ $mark->external }}
                                            </span>
                                        @else
                                            <span class="green-text">
                                                {{ $mark->external }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="red-text">
                                                Not Entered
                                            </span>
                                    @endif
                                </td>
                                <td class="blue-text center-text bold-text">{{ $application->subject->emax_marks }}</td>
                            </tr>
                            </tbody>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection