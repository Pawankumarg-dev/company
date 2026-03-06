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

    <section class="container">
        <div class="row">

        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed blue-text">
                        <tr class="grey-background">
                            <th class="center-text">S. No</th>
                            <th class="center-text">Institute Code</th>
                            <th class="center-text">Course</th>
                            <th class="center-text">Batch</th>
                        </tr>

                        @php $sno = 1; @endphp
                        @foreach($approvedprogrammes as $ap)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td>{{ $ap->institute->code }}</td>
                                <td>{{ $ap->programme->course_name }}</td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/exams/marks-entry/'.$exam->id.'/show-subjects/'.$ap->id) }}" class="btn btn-sm btn-info">{{ $ap->academicyear->year }}</a>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </section>

    {{--
    <section class="container-fluid">
        <div class="row">
            @foreach($institutes as $i)
                <div class="col-sm-1 well well-sm white-background minus15px-margin-top center-text">
                    {{ $i->code }}
                </div>
            @endforeach
        </div>
    </section>
    --}}


@endsection