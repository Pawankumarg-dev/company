@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @include('common.errorandmsg')
            <h4>Subjects</h4>
            <table class="table table-bordered table-condensed">
                <tr>
                    <th>Slno</th>
                    <th>NBER</th>
                    <th rowspan="1">
                        Course
                    </th>
                    <th>
                        Exam
                    </th>
                    <th>
                        Exam Date Time
                    </th>
                    <th rowspan="1">
                        Subject Code/ Subject OMR Code
                    </th>
                
                    <th rowspan="1">
                        Subject
                    </th>
                    <th rowspan="1">
                        No of Answer booklets
                    </th>
                    
                    <th>
                        Waiting for exam attendance details / completion of exam
                    </th>
                    @if (!$is_deo)
                    <th>
                        Dummy Enrolment Numbers
                    </th>
                    @endif
                    <th style="width:22%">
                        @if (!$is_deo)
                        Coversheet and Foil sheets
                        @else
                        Mark entry
                        @endif

                    </th>

                    @if (!$is_deo)
                    <th>
                        Marks Entry
                    </th>
                    @endif
                </tr>
                @php $slno = 1; @endphp
                @foreach($exampapers as $ep)
                @if ( ($ep->sum_of_present > 0 || $ep->sum_of_attendance == 0 || $ep->scan_copy == 0))
                <tr
                    class="@if($ep->sum_of_present == $ep->sum_of_evaluated && $ep->sum_of_attendance != 0 ) bg-success @else bg-danger @endif">
                    <td>
                        {{$slno}}
                        @php
                        $slno ++;
                        @endphp
                    </td>
                    <td>
                        {{$ep->programme->nber->short_name_code}}
                    </td>
                    <td>
                        {{$ep->programme->course_name}}
                    </td>
                    <td>
                        {{$ep->examschedule->description}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($ep->examschedule->examdate)->toDateString()}}
                        -
                        {{\Carbon\Carbon::parse($ep->examschedule->starttime)->format('g:i A')}} to
                        {{\Carbon\Carbon::parse($ep->examschedule->endtime)->format('g:i A')}}
                    </td>
                    <td>
                        {{$ep->subject->scode}}/ {{$ep->subject->omr_code}}
                        
                    
                    

                    
                    </td>
                  
                    <td>
                        {{$ep->subject->sname}}
                    @php

                        $alternativeIds = [];
                        if (!empty($ep->alternativesubject_id)) {
                            $ids = explode(',', $ep->alternativesubject_id); 
                            $alternativeIds = \App\Alternativesubject::whereIn('id', $ids)->pluck('scode')->toArray();
                            echo ' / ';
                        }
                        
                    @endphp
                    {{ implode(', ', $alternativeIds) }}
                    </td>
                    <td class="text-center">
                        {{$ep->sum_of_present}}
                    </td>
                    <td class="text-center">
                        <?php $pending = $ep->sum_of_theory - ($ep->sum_of_present + $ep->sum_of_absent) ; ?>
                        {{$pending < 0 ? 0 : $pending}}
                    </td>
                    @if (!$is_deo)
                    <td>
                        @if($pending < 1) {{-- @if($pending < 1 && $ep->scan_copy == 1) --}} <a target="_blank"
                            style="margin-right:5px;"
                            href="{{url('evaluationcenterdummynumbers')}}/{{$ep->approvedprogramme_id}}/{{$ep->subject->id}}?downloaddummy=1&type=pdf"
                            class="btn btn-xs  @if($ep->sum_of_present == $ep->sum_of_evaluated  && $pending == 0) btn-warning @else btn-primary @endif">
                            Download PDF</a>
                            <a target="_blank" style="margin-top:5px;"
                                href="{{url('evaluationcenterdummynumbers')}}/{{$ep->approvedprogramme_id}}/{{$ep->subject->id}}?downloaddummy=1&type=excel"
                                class="btn btn-xs  @if($ep->sum_of_present == $ep->sum_of_evaluated  && $pending == 0) btn-warning @else btn-info @endif">Download
                                Excel</a>
                            @endif
                    </td>
                    @endif

                      <td>
                        @if($pending < 1 && !$is_deo) <?php $sheet=1;?> 
                        @foreach(explode(',', $ep->externalexamcenter_ids) as $externalexamcenter_id)
                        <?php $applications_count =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',27)->where('subject_id',$ep->subject->id)->where('attendance',1)->count(); ?>
                                                <?php $exam_center =  \App\Externalexamcenter::where('id',$externalexamcenter_id)->first(); ?>

                            @if($applications_count>0)
                                                        <a target="_blank"
                                href="{{ url('evaluationcentercouversheet/' . $externalexamcenter_id . '/' . $ep->subject->id.'/'.$ep->approvedprogramme_id) }}"
                                class="btn btn-xs @if($ep->sum_of_present == $ep->sum_of_evaluated && $pending == 0) btn-warning @else btn-primary @endif">
                                Coversheet {{$exam_center->code}}
                            </a>
                            
                            <a target="_blank"
                                href="{{ url('evaluationcenterfoilsheet/' . $externalexamcenter_id . '/' . $ep->subject->id.'/'.$ep->approvedprogramme_id) }}"
                                class="btn btn-xs @if($ep->sum_of_present == $ep->sum_of_evaluated && $pending == 0) btn-warning @else btn-primary @endif">
                                @if($is_deo) Mark Entry @else  Foilsheet  {{$exam_center->code}} @endif
                            </a>


                            @endif
                        @endforeach
                        @else
                                                    @foreach(explode(',', $ep->externalexamcenter_ids) as $externalexamcenter_id)
                                                        @php
                                                            $papers = \App\Allexamstudent::where('externalexamcenter_id', $externalexamcenter_id)
                                                                ->where('exam_id', 27)
                                                                ->where('subject_id', $ep->subject_id)
                                                                ->whereNull('attendance')
                                                                ->count();
                                                        @endphp
                                                        @if($papers > 0)
                                                            @php $exam_center = \App\Externalexamcenter::find($externalexamcenter_id);  @endphp
                                                            <button class="btn btn-xs  btn-danger">Attendance Not Marked {{ $exam_center->code }}</button>
                                                        @endif
                                                    @endforeach
                        
                        @endif
                    </td>

                    <td style="gap:10px" class="">
                        @if($pending < 1 && !$is_deo) <?php $sheet=1;?> 
                            @foreach(explode(',', $ep->externalexamcenter_ids) as $externalexamcenter_id)
                            <?php $applications_count =  \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',27)->where('subject_id',$ep->subject->id)->where('attendance',1)->count(); ?>
                            @if($applications_count>0)
    <?php $exam_center =  \App\Externalexamcenter::where('id',$externalexamcenter_id)->first(); ?>
                            @php


                            $pdfPath='files/markfiles/27_' . $externalexamcenter_id . '_' . $ep->subject->id . '.pdf';


                            @endphp



                            <a target="_blank"
                            href="{{ url('markentry/' . $externalexamcenter_id . '/' . $ep->subject->id) }}"
                            class="btn btn-xs @if (file_exists($pdfPath)) btn-warning @else btn-primary @endif" @if (file_exists($pdfPath)) disabled @endif>
                             @if (file_exists($pdfPath)) Update Marks{{$exam_center->code}} @else Mark Entry {{$exam_center->code}} @endif
                        </a>



                        @endif

                            @endforeach
                        @endif

                    </td>

                    {{-- <td>
                        @if($pending < 1) <a target="_blank " class="hidden"
                            href="{{url('evaluationcenter')}}/{{$ep->subject->id}}"
                    class="btn btn-xs @if($ep->sum_of_present == $ep->sum_of_evaluated && $pending == 0 ) btn-warning
                    @else btn-primary @endif">
                    @if($is_deo) Mark Entry @else Open @endif</a>
                    @endif 
                    </td> --}}
                    @if (!$is_deo)

                    <td class="hidden">
                        @if($pending > 0 || $ep->scan_copy == 0)
                        <a target="_blank" class="" href="{{url('evaluationcenter')}}/{{$ep->subject->id}}?attendance=1"
                            class="btn btn-xs  @if($ep->sum_of_present == $ep->sum_of_evaluated  && $pending == 0 ) btn-warning @else btn-primary @endif">
                            Attendance Marking </a>
                        @endif
                    </td>
                    @endif
                </tr>
                @endif
                @endforeach
            </table>
        </div>
    </div>
</div>
<style>
    .btn-xs {
        margin: 3px;
    }
</style>
@endsection