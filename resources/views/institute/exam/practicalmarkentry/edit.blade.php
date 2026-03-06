@extends('layouts.app')
@section('content')
@include('institute.exam.practicalmarkentry._style')
@include('institute.exam.practicalmarkentry._scripts')
<div class="container">
    @include('institute.exam.practicalmarkentry.ajax._getFailedSubjects')
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            @include('common.errorandmsg')
            @include('institute.exam.practicalmarkentry._heading')
            @include('institute.exam.practicalmarkentry._alert_edit')
            <form action="{{url('institute/exam/practicalmarkentry')}}/{{$approvedprogramme->id}}" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="_method" value="PUT"> 
                {{ csrf_field() }}
                <?php $editshow = 'edit'; ?>
                @include('institute.exam.practicalmarkentry._hiddeninput')
                @include('institute.exam.practicalmarkentry.buttons._savebtn')
                @include('institute.exam.practicalmarkentry.buttons._cancelbtn')
                @if($supplementary == 'Yes')
                    <input type="hidden" name="supplementary" value="Yes" />
                    <table class="table  table-bordered">
                        <tr>
                            <td style="width:40%;vertical-align:top!important;">
                                

                @endif
                <table class="table  table-bordered">
                    @include('institute.exam.practicalmarkentry._thead')
                    @foreach ($marks as $internal)
                    <tr>
                            
                            @include('institute.exam.practicalmarkentry._commoncolumns')
                            <?php $slno++; ?>
                            @if($supplementary != 'Yes')
                                
                                @foreach ($subjects as $subject )
                                    <td class="text-center">
                                        <?php 
                                            $mark = $internal[$subject->scode]; 
                                            if($mark==0){ $mark = '';}
                                            if($mark==-1){ $mark = 0;}
                                            if($mark==-2){ $mark = 'Absent';}
                                        ?>
                                        <?php $value = $mark!='Absent' ? $mark : '' ?>
                                        @include('institute.exam.practicalmarkentry.input._mark')
                                        <br>
                                        @include('institute.exam.practicalmarkentry.input._absent')
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </table>
                @if($supplementary == 'Yes')
                        </td>
                        <td style="wdith:60%">
                            <table id="supplementary" class="table  table-bordered hidden" >
                                <tr>
                                    <td style="width:150px;">Candidate Name</td>
                                    <th id="candidatename"></th>
                                </tr>
                                <tr>
                                    <td  style="width:150px;">Enrolment No</td>
                                    <th id="enrolmentno"></th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h5><b>Backlog subjects</b></h5>
                                        <div  class="alert alert-warning" id="failed"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td  colspan="2">
                                        <h5><b>Internal backlog subjects </b></h5>
                                        <div class="alert alert-warning" id="internalfailed"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        </tr>
                    </table>
                @endif
                @include('institute.exam.practicalmarkentry.buttons._savebtn')
            </form>
        </div>
    </div>
</div>
@endsection