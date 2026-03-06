@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>
                {{$candidate->name}} ({{$candidate->enrolmentno}})
            </h3>
            @include('common.errorandmsg')
            @if(is_null($candidate->currentapplicant))
                Not applied for the exam
            @endif
            <table class="table table-bordered table-condensed">
                <tr>
                    <th>
                        Marksheet / Certificate
                    </th>
                    <th>
                        Result
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Download
                    </th>
                </tr>
                
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->sl_no_marksheet_term_one) && !is_null($candidate->currentapplicant->term_one_result_id) )
                <tr>
                    <td>
                        Term One Marksheet
                    </td>
                    <td>
                        @if($candidate->currentapplicant->term_one_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->term_one_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                    {{\Carbon\Carbon::parse($candidate->currentapplicant->marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('institute/marksheet')}}/{{$candidate->currentapplicant_id}}/1?v={{$candidate->new_changes}}">Download Term One Marksheet</a>
                    </td>
                    </tr>
                    
                @endif
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->sl_no_marksheet_term_two) && !is_null($candidate->currentapplicant->term_two_result_id))
                    <tr>
                    <td>
                        Term Two Marksheet
                    </td>
                    <td>
                        @if($candidate->currentapplicant->term_two_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->term_two_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('institute/marksheet')}}/{{$candidate->currentapplicant_id}}/2?v={{$candidate->new_changes}}">Download Term Two Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant)  && !is_null($candidate->currentapplicant->slno_certificate))
                    <tr>
                    <td>
                        Certificate
                    </td>
                    <th><span style="color:green;">Pass</span></th>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->certificate_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('institute/certificate')}}/{{$candidate->currentapplicant_id}}">Download Certificate</a>
                    </td>
                    </tr>
                @endif

                
                   
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->reevaluation_sl_no_marksheet_term_one) && !is_null($candidate->currentapplicant->reevaluation_term_one_result_id) )
                <tr>
                    <td>
                        Term One Marksheet (Reevaluated)
                    </td>
                    <td>
                        @if($candidate->currentapplicant->reevaluation_term_one_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->reevaluation_term_one_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                    {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('institute/marksheet')}}/re/{{$candidate->currentapplicant_id}}/1?v={{$candidate->new_changes}}">Download Term One Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant) && !is_null($candidate->currentapplicant->reevaluation_sl_no_marksheet_term_two) && !is_null($candidate->currentapplicant->reevaluation_term_two_result_id))
                <tr>
                    <td>
                        Term Two Marksheet (Reevaluated)
                    </td>
                    <td>
                        @if($candidate->currentapplicant->reevaluation_term_two_result_id == 1)
                        <span style="color:green;">Pass</span>
                        @endif
                        @if($candidate->currentapplicant->reevaluation_term_two_result_id == 0)
                        <span style="color:red;">Fail</span>
                        @endif
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_marksheetissuded_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('institute/marksheet')}}/re/{{$candidate->currentapplicant_id}}/2?v={{$candidate->new_changes}}">Download Term Two Marksheet</a>
                    </td>
                    </tr>
                @endif
                @if(!is_null($candidate->currentapplicant) && (!is_null($candidate->currentapplicant->reevaluation_slno_certificate)))
                    <tr>
                    <td>
                        Certificate  (Reevaluated)
                    </td>
                    <th><span style="color:green;">Pass</span></th>
                    <td>
                        {{\Carbon\Carbon::parse($candidate->currentapplicant->reevaluation_certificate_date)->toFormattedDateString()}}
                    </td>
                    <td>
                    <a href="{{url('institute/certificate')}}/re/{{$candidate->currentapplicant_id}}?v={{$candidate->new_changes}}">Download Certificate</a>
                    </td>
                    </tr>
                @endif
            </table>
        </div>
        
        <div class="col-sm-12" style="">
        <h4>Result - 2023 Oct Exam

            <?php $ra = \App\Reevaluationapplication::where('exam_id',22)->where('orderstatus_id',1)->where('candidate_id',$candidate->id)->count(); ?>
            @if($ra > 0)
                (Reevaluation)
            @endif
        </h4>
            <table class="table table-bordered table-condensed">
                <tr>
                <th>Slno</th>
                    <th>Term</th>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Subject Type</th>
                    <th>Internal Attendance</th>
                    <th>Internal Mark</th>
                    <th>External Attendance</th>
                    <th>External Mark</th>
                    <th>Grace Mark</th>
                    <th>Result</th>
                </tr>
                <?php $slno = 1; ?>
                @foreach($currentapplications as $ca)
                    <tr>
                        <?php $external_mark = $ca->external_mark; ?>
                     
                        <?php $rs = \App\Reevaluationapplicationsubject::where('candidate_id',$ca->candidate_id)->where('exam_id',22)->where('subject_id',$ca->subject_id)->first(); ?>
                        <?php 
                            
                            if(!is_null($rs)){
                                if($rs->reevaluated_marks > $external_mark){
                                    $external_mark = $rs->reevaluated_marks;
                                }
                            }
                        ?>

                    <td>
                        {{$slno}} <?php $slno++; ?>
                    </td>
                    <td>{{$ca->subject->syear}}</td>
                    <td>{{$ca->subject->scode}}</td>
                    <td>{{$ca->subject->sname}}</td>
                    <td>{{$ca->subject->subjecttype->type}}</td>
                    <td>
                        @if($ca->internalattendance_id == 1) Present @endif
                        @if($ca->internalattendance_id == 2) Absent @endif
                        @if($ca->internalattendance_id == 0) NA @endif
                    </td>
                    <td>
                        {{$ca->internal_mark}}
                    </td>
                    <td>
                        @if($ca->externalattendance_id == 1) Present @endif
                        @if($ca->externalattendance_id == 2) Absent @endif
                        @if($ca->externalattendance_id == 0) NA @endif
                    </td>
                    <td>
                        @if(is_null($rs))
                        {{$external_mark}}
                        @else
                            @if($rs->active_status != 0)
                                
                            @else
                                {{$external_mark}}
                            @endif
                        @endif
                    </td>
                    <td>
                        {{$ca->grace}}
                    </td>
                    <td>
                    @if(is_null($rs))
                        @if($ca->reevaluation_result_id == 1)
                            <span style="color:green;">Pass</span>
                        @endif
                        @if($ca->reevaluation_result_id == 0)
                            <span style="color:red;">Fail</span>
                        @endif
                        @if(is_null($ca->reevaluation_result_id))
                            NA
                        @endif
                    @else
                        @if($rs->active_status == 0)
                            @if(
                                $rs->subject->imin_marks <= $rs->application->internal_mark && 
                                ($external_mark +  $rs->application->grace ) >= $rs->subject->emin_marks
                                )
                                <span style="color:green">Pass</span>
                            @else
                                <span style="color:red">Fail</span>
                            @endif
                            </span>
                        @else
                                
                        @endif
                    @endif
                    </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection