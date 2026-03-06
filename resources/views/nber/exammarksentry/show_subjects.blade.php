@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Exam - Mark Entry
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed blue-text">
                        <tr class="grey-background">
                            <th class="center-text" colspan="2">Institute Code & Name</th>
                            <th class="left-text" colspan="3">
                                {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                            </th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text" colspan="2">Course Code & Batch</th>
                            <th class="left-text" colspan="3">
                                {{ $approvedprogramme->programme->course_name }} - {{ $approvedprogramme->academicyear->year }} Batch
                            </th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">S. No</th>
                            <th class="center-text">Term / Year</th>
                            <th class="center-text">Subject Type</th>
                            <th class="center-text">Subject Name</th>
                            <th class="center-text">Subject Code</th>
                        </tr>

                        @php $sno = 1; @endphp
                        @php $count = 1; $th_year1 = 0; $th_year2 = 0; $pr_year1 = 0; $pr_year2 = 0; @endphp
                        @foreach($subjects as $s)
                            @if($s->syear == '1')
                                @if($s->subjecttype_id == '1')
                                    @if($th_year1 == '0')
                                        <tr>
                                            <th colspan="5" class="center-text red-text">
                                                First Year - {{ $s->subjecttype->type }}
                                            </th>
                                        </tr>
                                        @php $th_year1++; @endphp
                                    @endif
                                @else
                                    @if($pr_year1 == '0')
                                        <tr>
                                            <th colspan="5" class="center-text red-text">
                                                First Year - {{ $s->subjecttype->type }}
                                            </th>
                                        </tr>
                                        @php $pr_year1++; @endphp
                                    @endif
                                @endif
                            @else
                                @if($s->subjecttype_id == '2')
                                    @if($th_year2 == '0')
                                        <tr>
                                            <th colspan="5" class="center-text red-text">
                                                Second Year - {{ $s->subjecttype->type }}
                                            </th>
                                        </tr>
                                        @php $th_year2++; @endphp
                                    @endif
                                @else
                                    @if($pr_year2 == '0')
                                        <tr>
                                            <th colspan="5" class="center-text red-text">
                                                Second Year - {{ $s->subjecttype->type }}
                                            </th>
                                        </tr>
                                        @php $pr_year2++; @endphp
                                    @endif
                                @endif
                            @endif
                            <tr>
                                <td class="center-text">{{ $sno }}</td>
                                <td class="center-text">{{ $s->syear }}</td>
                                <td class="center-text">{{ $s->subjecttype->type }}</td>
                                <td class="left-text">{{ $s->sname }}</td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/exams/marks-entry/'.$exam->id.'/update-marks/'.$approvedprogramme->id.'/subject/'.$s->id) }}" class="btn btn-sm btn-primary">{{ $s->scode }}</a>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
