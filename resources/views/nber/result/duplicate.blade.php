@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>
                    {{$candidate->name}} - {{$candidate->enrolmentno}}
                </h4>
                @include('common.errorandmsg')
                <div>
                    @if(!is_null($changes))
                        <div class="alert alert-danger">
                            <ul>
                                {!!$changes!!}
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="alert alert-danger">
                    Duplicate entries found for the passed pappers. Please choose the entry to calcluate Result.
                </div>
                <form action="{{url('fixduplicates')}}" method="post">
                    {{ csrf_field() }}
                    <table  class="table table-bordered ">
                        <tr>
                            <td rowspan="2"> 
                                Exam
                            </td>
                            <td rowspan="2"> 
                                Subject Code
                            </td>
                            <td rowspan="2"> 
                                Subject
                            </td>
                            <td colspan="2">
                                Internal
                            </td>
                            <td colspan="3">
                                External
                            </td>
                            <td rowspan="2">Total</td>
                            <td rowspan="2">
                                Select
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Attendance
                            </td>
                            <td>
                                Mark
                            </td>
                            <td>
                                Attendance
                            </td>
                            <td>
                                Mark
                            </td>
                            <td>
                                Grace
                            </td>
                        </tr>
                        <?php $subject_id = 0 ; ?>
                        @foreach($subjects as $application)
                            <tr>
                                <td>
                                    {{$application->exam}}
                                </td>
                                <td>
                                    {{$application->scode}}
                                </td>
                                <td>
                                    {{$application->sname}}
                                </td>
                                <td>
                                    {{$application->internalattendance}}
                                </td>
                                <td>
                                    {{$application->internal_mark}}
                                </td>
                                <td>
                                    {{$application->externalattendance}}
                                </td>
                                <td>
                                    {{$application->external_mark}}
                                </td>
                                <td>
                                    {{$application->grace}}
                                </td>
                                <td>
                                    {{$application->internal_mark + $application->external_mark + $application->grace }}
                                </td>
                                <td>
                                    <input type="radio" name="subject_{{$application->subject_id}}" value="{{$application->id}}" >
                                    <input type="hidden" name="application_{{$application->id}}" value="{{$application->exam_id}}" >
                                    <?php $subject_id = $application->subject_id; ?>
                                </td>
                                
                            </tr>
                        @endforeach
                    </table>
                    <input type="hidden" name='subject_ids' value="{{$duplicatesubject_ids}}">
                    <input type="hidden" name='candidate_id' value="{{$candidate->id}}">
                    <button type="submit" class="btn btn-primary btn-xs pull-right" >Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
