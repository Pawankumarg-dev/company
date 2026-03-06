@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} @if($exam->examtype_id == '2') Supplementary @endif - External Practical Examination<br>
                    Candidate Hall ticket
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover" role="table">
                        <tr>
                            <th colspan="2" class="left-text">Institute</th>
                            <td colspan="5" class="left-text blue-text">{{ $approvedprogramme->institute->code }} - {{ $approvedprogramme->institute->name }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="left-text">Course</th>
                            <td colspan="5" class="left-text blue-text">{{ $approvedprogramme->programme->course_name }} - {{ $approvedprogramme->programme->name }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="left-text">Batch</th>
                            <td colspan="5" class="left-text blue-text">{{ $approvedprogramme->academicyear->year }}</td>
                        </tr>
                        <tr>
                            <th rowspan="2" class="center-text" width="5%">S.No.</th>
                            <th colspan="5" class="center-text">Candidate</th>
                            <th rowspan="2" class="center-text" width="8%">Options</th>
                        </tr>
                        <tr>
                            <th class="center-text">Photo</th>
                            <th class="center-text" width="8%">Enrolment No.</th>
                            <th class="center-text">Name</th>
                            <th class="center-text">Father's Name</th>
                            <th class="center-text" width="10%">Date of Birth</th>
                        </tr>

                        @php $sno = '1'; @endphp
                        @foreach($candidates as $c)
                            <tr>
                                <td class="center-text" >{{ $sno }}</td>
                                <td class="center-text">
                                    <img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 100px;" class="img" />
                                </td>
                                <td class="center-text">{{ $c->enrolmentno }}</td>
                                <td class="center-text">{{ $c->name }}</td>
                                <td class="center-text">{{ $c->fathername }}</td>
                                <td class="center-text">
                                    {{ $c->dob->format('d-m-Y') }}
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/institute/practicalexam/'.$exam->id.'/downloadhallticket/'.$c->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        View Hall ticket
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
@endsection