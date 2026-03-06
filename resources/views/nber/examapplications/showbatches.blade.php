@extends('layouts.app')
@inject('examapplication', "App\Http\Controllers\Nber\ExamapplicationController")

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Exam Applications
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover">
                        <tr class="grey-background">
                            <th rowspan="2" class="center-text">S. No.</th>
                            <th colspan="2" class="center-text">Institute</th>
                            <th rowspan="2" class="center-text">Course</th>
                            <th rowspan="2" class="center-text">Batch</th>
                            <th colspan="2" class="center-text">Theory</th>
                            <th colspan="2" class="center-text">Practical</th>
                            <th colspan="2" class="center-text">Total</th>
                            <th rowspan="2" class="center-text">Options</th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">Code</th>
                            <th class="center-text">Name</th>
                            <th class="center-text">Candidates<br>Count</th>
                            <th class="center-text">Subjects<br>Count</th>
                            <th class="center-text">Candidates<br>Count</th>
                            <th class="center-text">Subjects<br>Count</th>
                            <th class="center-text">Candidates<br>Count</th>
                            <th class="center-text">Subjects<br>Count</th>
                        </tr>

                        @php $sno=1; set_time_limit(0); @endphp
                        @foreach($approvedprogrammes as $ap)
                            @php
                                $th_candidates = 0;
                                $pr_candidates = 0;
                                $th_subjects = 0;
                                $pr_subjects = 0;

                                /*
                                foreach (\App\Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $ap->id)->cursor() as $app) {
                                    if($app->subject->subjecttype_id == '1') {
                                    $th_subjects++;
                                    }
                                    else{
                                    $pr_subjects++;
                                    }
                                }

                                foreach (\App\Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $ap->id)->groupBy('candidate_id')->cursor() as $app) {
                                    if($app->subject->subjecttype_id == '1') {
                                    $th_candidates++;
                                    }
                                    else{
                                    $pr_candidates++;
                                    }
                                }
                            */
                            @endphp

                            <tr>
                                <td>{{ $sno }}</td>
                                <td>{{ $ap->institute->code }}</td>
                                <td>{{ $ap->institute->name }}</td>
                                <td>{{ $ap->programme->course_name }}</td>
                                <td>{{ $ap->academicyear->year }}</td>
                                <td>{{ $th_candidates }}</td>
                                <td>{{ $th_subjects }}</td>
                                <td>{{ $pr_candidates }}</td>
                                <td>{{ $pr_subjects }}</td>
                                <td>
                                    {{ $th_candidates + $pr_candidates }}
                                </td>
                                <td>
                                    {{ $th_subjects + $pr_subjects }}
                                </td>
                                <td>
                                    <a href=" {{ url('/nber/examapplications/'.$exam->id.'/show-candidates/'.$ap->id) }} " class="btn btn-xs btn-success">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        View
                                    </a>
                                </td>
                                @php $sno++; @endphp
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection