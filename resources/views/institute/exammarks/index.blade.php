@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Examination - Mark Entry
                </div>
            </div>
        </div>
    </section>

    {{--
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                        <tr>
                            <td class="center-text blue-text" colspan="7">
                                Course: {{ $approvedprogramme->programme->course_name }}<br>
                                Batch: {{ $approvedprogramme->academicyear->year }}
                            </td>
                        </tr>
                        <tr>
                            <td class="center-text blue-text" colspan="7">
                                <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/view-internal-theory-marks/'.$approvedprogramme->id) }}" target="_blank"
                                   class="btn btn-success">
                                    <span class="glyphicon glyphicon-download"></span>
                                    Internal Theory Mark
                                </a>
                                <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/view-internal-practical-marks/'.$approvedprogramme->id) }}" target="_blank"
                                   class="btn btn-success">
                                    <span class="glyphicon glyphicon-download"></span>
                                    Internal Practical Mark
                                </a>
                                <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/view-external-practical-marks/'.$approvedprogramme->id) }}" target="_blank"
                                   class="btn btn-success">
                                    <span class="glyphicon glyphicon-download"></span>
                                    External Practical Mark
                                </a>
                            </td>
                        </tr>

                        @if(Session::has('message'))
                            <tr>
                                <td class="center-text" colspan="7">
                                    <div class="alert alert-success">
                                        {{ Session::get('message') }}
                                    </div>
                                </td>
                            </tr>
                        @endif

                        <tr class="grey-background">
                            <th class="center-text">
                                S. No
                            </th>
                            <th class="center-text">
                                Photo
                            </th>
                            <th class="center-text">
                                Enrolment Number
                            </th>
                            <th class="center-text">
                                Name
                            </th>
                            <th class="center-text">
                                Date of Birth
                            </th>
                            <th class="center-text">
                                Total Subjects Applied
                            </th>
                            <th class="center-text">
                                Options
                            </th>
                        </tr>

                        @php $sno = '1'; @endphp

                        @foreach($candidates as $c)
                            @if($c->applications->where('exam_id', $exam->id))
                                <tr class="blue-text center-text">
                                    <td>{{ $sno }}</td>
                                    <td class="center-text">
                                        <img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 100px;" class="img" />
                                    </td>
                                    <td>{{ $c->enrolmentno }}</td>
                                    <td>{{ $c->name }}</td>
                                    <td>{{ $c->dob->format('d-m-Y') }}</td>
                                    <td>
                                        {{ $applications->where('candidate_id', $c->id)->count() }}<br>

                                    </td>
                                    <td>
                                        <div class="center-text">
                                            @if($exam->status_id == '1')
                                                @if($approvedprogramme->programme->programmegroup->mark_entry_institutes==1)
                                                    @if(\App\Mark::where('exam_id', $exam->id)->where('candidate_id', $c->id)->count() > '0')
                                                        <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/showform/'.$c->id) }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span>  &nbsp;Edit Marks</a>
                                                    @else
                                                        <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/showform/'.$c->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span>  &nbsp;Add Marks</a>
                                                    @endif
                                                @else
                                                    <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/view-candidate-marks/'.$c->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span>  &nbsp;View Marks</a>
                                                @endif
                                            @else

                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
    --}}

    <section class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="text-center">
                    {{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}
                </p>
            </div>

            <div class="panel-heading">
                <p class="text-center">
                    {{ $approvedprogramme->programme->common_name }} [{{ $approvedprogramme->programme->common_code }}] - {{ $approvedprogramme->academicyear->year }} Batch
                </p>
            </div>

            <div class="panel-body">

                <section class="container">
                    <div class="row">
                        {{-- Internal Theory Mark Entry --}}
                        <div class="col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title blue-text">
                                        Internal Theory Mark Entry
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <ul>
                                     {{--   <li>
                                            <a href=" {{ url('/institute/exammarksentry/download-internal-theory-markentry-form/') }}" class="btn btn-info btn-sm" target="_blank">Download Mark Entry Form</a>
                                            
                                        </li> --}}
                                        <li>
                                            <a href="{{ url('/institute/exammarksentry/internal-theory/add-form/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to enter the Mark</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/exammarksentry/internal-theory/view/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to view the Mark</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                      {{-- ./Internal Theory Mark Entry --}}

                        {{-- Internal Practical Mark Entry --}}
                        <div class="col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title blue-text">
                                        Internal Practical Mark Entry
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <ul>
                                    {{--<li>
                                        <a href=" {{ url('/institute/exammarksentry/download-internal-practical-markentry-form/') }}" class="btn btn-info btn-sm" target="_blank">Download Mark Entry Form</a>
                                            
                                            <a href="{{ url('/institute/exammarksentry/download-internal-theory-markentry-form/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to download Mark Entry Form</a>
                                            
                                        </li>--}}
                                        <li>
                                            <a href="{{ url('/institute/exammarksentry/internal-practical/add-form/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to enter the Mark</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/exammarksentry/internal-practical/view/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to view the Mark</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- ./Internal Practical Mark Entry --}}

                        {{-- External Practical Mark Entry --}}
                        <div class="col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title blue-text">
                                        External Practical Mark Entry
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <ul>
                                    {{--<li>
                                        <a href=" {{ url('/institute/exammarksentry/download-external-practical-markentry-form/') }}" class="btn btn-info btn-sm" target="_blank">Download Mark Entry Form</a>
                                            
                                            <a href="{{ url('/institute/exammarksentry/download-internal-theory-markentry-form/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to download Mark Entry Form</a>
                                            
                                        </li>--}}
                                        <li>
                                            <a href="{{ url('/institute/exammarksentry/external-practical/add-form/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to enter the Mark</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/institute/exammarksentry/external-practical/view/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to view the Mark</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- ./Internal Practical Mark Entry --}}

                        {{--
                        <div class="col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title blue-text">
                                        External Practical Mark Entry
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <ul>
                                        <li>
                                            <a href="{{ url('/institute/exammarksentry/external-practical/add-form/'.$exam->id.'/'.$approvedprogramme->id) }}">Click here to enter the Mark</a>
                                        </li>
                                        <li>
                                            <a href="">Click here to view the Mark</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                         --}}
                    </div>
                </section>

            </div>
        </div>
    </section>




@endsection