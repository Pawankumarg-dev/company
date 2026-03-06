@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                {{ $exam->name }} Examinations
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/'.$exam->id) }}">{{ $exam->name }} Examinations</a>
                                            </li>
                                            <li class="active">Exam Applications</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th width="20%">Programme Code</th>
                                            <th width="10%">Batch</th>
                                            <th width="70%">Links</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($approvedprogrammes as $ap)
                                            @if($exambatches->where('programme_id', $ap->programme_id)
                                            ->where('academicyear_id', $ap->academicyear_id)->count() == '1')
                                                <tr>
                                                    <td>{{ $ap->programme->course_name }}</td>
                                                    <td>{{ $ap->academicyear->year }}</td>
                                                    <td>
                                                        @if($exam->institute_markentry == 1)
                                                            @if($ap->applications->where('exam_id', $exam->id)->count() != 0)
                                                                <a href="{{url('/institute/exammarksentry/'.$exam->id.'/showlist/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                            @else

                                                            @endif
                                                        @endif

                                                        @if($exam->status_id == 1 ||$exam->status_id == 3)
                                                            <a href="{{url('/institute/practicalexam/'.$exam->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>
                                                        @endif

                                                        <a href="{{url('applications/'.$ap->id).'/'.$exam->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>

                                                        @if($exam->status_id==1)
                                                            {{--<a href="{{url('/institute/practicalexam/'.$e->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>--}}

                                                            {{--
                                                            <a href="{{url('applications/'.$ap->id).'/'.$e->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>
                                                            <a href="{{url('/institute/exammarksentry/'.$e->id.'/showlist/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                            <a href="{{url('/institute/practicalexam/'.$e->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>
                                                            --}}

                                                            {{--
                                                                <a href="{{url('marks/'.$ap->id).'/'.$e->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                            --}}
                                                            @if($ap->programme->programmegroup->attendance_upload==1)
                                                                @if($ap->applications->where('exam_id', $exam->id)->count() != 0)
                                                                    <a href="{{url('halltickets/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance</a>
                                                                @endif
                                                            @endif
                                                            @if($ap->programme->programmegroup->hallticket_download==1)
                                                                @if($ap->applications->where('exam_id', $exam->id)->count() != 0)
                                                                    <a href="{{url('/institute/hallticket-download/'.$exam->id.'/show-candidates-list/'.$ap->id)}}" class="btn btn-info btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Theory Hallticket</a>
                                                                @endif
                                                            @endif
                                                        @elseif($exam->status_id==0 || $exam->status_id == 3)
                                                        @else
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @foreach($approvedprogrammes as $ap)
                                            @if($exambatches->where('programme_id', $ap->programme_id)
                                            ->where('academicyear_id', $ap->academicyear_id)->count() == '1')
                                                <tr>
                                                    <td>{{ $ap->programme->course_name }}</td>
                                                    <td>{{ $ap->academicyear->year }}</td>
                                                    <td>
                                                        @if($exam->institute_markentry == 1)
                                                            @if($ap->applications->where('exam_id', $exam->id)->count() != 0)
                                                                <a href="{{url('/institute/exammarksentry/'.$exam->id.'/showlist/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                            @else

                                                            @endif
                                                        @endif

                                                        @if($exam->status_id == 1 ||$exam->status_id == 3)
                                                            <a href="{{url('/institute/practicalexam/'.$exam->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>
                                                        @endif

                                                            <a href="{{url('applications/'.$ap->id).'/'.$exam->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>

                                                        @if($exam->status_id==1)
                                                            {{--<a href="{{url('/institute/practicalexam/'.$e->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>--}}

                                                            {{--
                                                            <a href="{{url('applications/'.$ap->id).'/'.$e->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>
                                                            <a href="{{url('/institute/exammarksentry/'.$e->id.'/showlist/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                            <a href="{{url('/institute/practicalexam/'.$e->id.'/showpage/'.$ap->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Practical Exam</a>
                                                            --}}

                                                            {{--
                                                                <a href="{{url('marks/'.$ap->id).'/'.$e->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                            --}}
                                                            @if($ap->programme->programmegroup->attendance_upload==1)
                                                                @if($ap->applications->where('exam_id', $exam->id)->count() != 0)
                                                                    <a href="{{url('halltickets/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance</a>
                                                                @endif
                                                            @endif
                                                            @if($ap->programme->programmegroup->hallticket_download==1)
                                                                @if($ap->applications->where('exam_id', $exam->id)->count() != 0)
                                                                    <a href="{{url('/institute/hallticket-download/'.$exam->id.'/show-candidates-list/'.$ap->id)}}" class="btn btn-info btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Theory Hallticket</a>
                                                                @endif
                                                            @endif
                                                        @elseif($exam->status_id==0 || $exam->status_id == 3)
                                                        @else
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
