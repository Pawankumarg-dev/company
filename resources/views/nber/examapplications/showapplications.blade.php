@extends('layouts.app')

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

                <div class="left-text">
                    <a href=" {{ url('/nber/examapplications/'.$exam->id.'/show-candidates/'.$candidate->approvedprogramme_id) }} " class="btn btn-sm btn-primary">
                        <span class="glyphicon glyphicon-triangle-left"></span>
                        Go Back
                    </a>
                </div>
                <div class="center-text">
                    <a href=" {{ url('/nber/examapplications/'.$exam->id.'/show-batches') }} " class="btn btn-sm btn-success">
                        <span class="glyphicon glyphicon-eye-open"></span>
                        View Institute-wise Exam Batches
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover">
                        <tr>
                            <th colspan="2" rowspan="5">
                                <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 100px;" class="img" />
                            </th>
                            <th>Enrolment</th>
                            <th colspan="4" class="blue-text">{{ $candidate->enrolmentno }}</th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th colspan="4" class="blue-text">{{ $candidate->name }}</th>
                        </tr>
                        <tr>
                            <th>Father's Name</th>
                            <th colspan="4" class="blue-text">{{ $candidate->fathername }}</th>
                        </tr>
                        <tr>
                            <th>DoB</th>
                            <th colspan="4" class="blue-text">{{ $candidate->dob->format('m-d-Y') }}</th>
                        </tr>
                        <tr>
                            <th>Course</th>
                            <th colspan="4" class="blue-text">{{ $candidate->approvedprogramme->programme->course_name }}</th>
                        </tr>

                        <tr>
                            <th colspan="7" class="center-text text-primary">
                                Exam Application Details
                            </th>
                        </tr>

                        <tr class="grey-background">
                            <th rowspan="2" class="center-text">S. No.</th>
                            <th colspan="4" class="center-text">Subject</th>
                            <th rowspan="2" class="center-text">Language</th>
                            <th rowspan="2" class="center-text">Options</th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">Year</th>
                            <th class="center-text">Type</th>
                            <th class="center-text">Code</th>
                            <th class="center-text">Name</th>
                        </tr>


                        @php $sno='1'; $th_year1='0'; $th_year2='0'; $pr_year1='0'; $pr_year2='0'; @endphp
                        @foreach($applications as $app)
                            @if($app->subject->syear == '1')
                                @if($app->subject->subjecttype_id == '1')
                                    @if($th_year1 == '0')
                                        <tr>
                                            <th colspan="7" class="center-text red-text">
                                                First Year - {{ $app->subject->subjecttype->type }}
                                            </th>
                                        </tr>
                                        @php $th_year1++; @endphp
                                    @endif
                                @else
                                    @if($pr_year1 == '0')
                                        <tr>
                                            <th colspan="7" class="center-text red-text">
                                                First Year - {{ $app->subject->subjecttype->type }}
                                            </th>
                                        </tr>
                                        @php $pr_year1++; @endphp
                                    @endif
                                @endif
                            @else
                                @if($app->subject->subjecttype_id == '2')
                                    @if($th_year2 == '0')
                                        <tr>
                                            <th colspan="7" class="center-text red-text">
                                                Second Year - {{ $app->subject->subjecttype->type }}
                                            </th>
                                        </tr>
                                        @php $th_year2++; @endphp
                                    @endif
                                @else
                                    @if($pr_year2 == '0')
                                        <tr>
                                            <th colspan="7" class="center-text red-text">
                                                Second Year - {{ $app->subject->subjecttype->type }}
                                            </th>
                                        </tr>
                                        @php $pr_year2++; @endphp
                                    @endif
                                @endif
                            @endif
                            <tr>
                                <td class="center-text blue-text">{{ $sno }}</td>
                                <td class="center-text blue-text">{{ $app->subject->syear }}</td>
                                <td class="center-text blue-text">{{ $app->subject->subjecttype->type }}</td>
                                <td class="center-text blue-text">{{ $app->subject->scode }}</td>
                                <td class="left-text blue-text">{{ $app->subject->sname }}</td>
                                <td class="center-text blue-text">{{ $app->language->language }}</td>
                                <td class="center-text">
                                    <a href=" {{ url('/nber/examapplications/edit-candidate-application/'.$app->id) }}" class="btn btn-xs btn-danger" id="deleteapplication_{{ $app->id }}" onclick="ConfirmDelete({{ $app->id }})">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        function ConfirmDelete(app_id) {

        }
    </script>
@endsection