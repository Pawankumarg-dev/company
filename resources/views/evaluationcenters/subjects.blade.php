@extends('layouts.app')
@section('content')
<script>
    function validateFile() {
            var ext = $("#filename").val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf']) == -1){
                //swal("Error Occurred!!!", "Please upload the scanned file in .pdf format only.", "error");
                //$('#filename').val(null);
                //return false;
            }
            else if ($("#filename")[0].files[0].size > 1048576) {
                swal("Error Occurred!!!", "Please upload the scanned file less than 1 MB file size.", "error");
                $("#filename").val(null);
                return false;
            }
            else {
                //$('#filename_link').attr('href', $('#filename').val());
                //$('#filename_display').html($('#filename')[0].files[0].name); //->filename

            }

        }
</script>
<div class="container">
	<div class="row">
		<div class="col-12">
            <h6>Sept-Oct 2023 Examinations
            </h6>
            <h3>Answer booklet Bundles </h3>
            @if (Session::has('messages') )
	<script>
		$(document).ready(function () {
		
		//$.notify("{{Session::get('messages')}}", "success", { position:"right bottom" });
		swal({

  type: 'success',
  title: '{{Session::get('messages')}}',
  showConfirmButton: false,
  timer: 1500
});
		});
		<?php Session::forget('messages'); ?>
	</script>
@endif
<?php
$markentry = Session::get('markentry');
?>
            <h4>
                Examinations held on 
            {{\Carbon\Carbon::parse($examdate)->format('d-M-Y')}} 
                            {{\Carbon\Carbon::parse($starttime)->format('h:i A')}} to 
                            {{\Carbon\Carbon::parse($endtime)->format('h:i A')}}
            </h4>
            <?php $slno = 1;  ?>
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>Slno</th>
                    <th>Exam Center</th>
                    <th>
                        NBER
                    </th>
                    <th>
                        Programme
                    </th>
                    <th>
                        Subject
                    </th>
                    @if($markentry==0)
                    <th>
                        Institute
                    </th>
                    @endif
                    <th>
                        Bundle Number
                    </th>
                    @if($markentry==0)
                    <th>
                       Print Cover sheet for Bundles
                    </th>
                    <th>
                        Dummy Enrolment Numbers
                    </th>
                    <th>Print Foil Sheets</th>
                    @endif

                    <th>Status of Mark Entry</th>
                    @if($markentry==1)
                    <th>Mark Entry</th>
                    @endif
                </tr>
                @foreach($approvedprogrammes  as $ap)
                    <?php $application = \App\Kvdailysubject::where('approvedprogramme_id',$ap->id)->where('examdate',$examdate)->where('starttime',$starttime)->first(); ?>
                    @if(!is_null($application) )
                    {{--@if(!is_null($application->applied_candidate_count))--}}
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                {{\App\Externalexamcenter::find($ap->institute->externalexamcenter_id)->code}}
                            </td>
                            <td>
                                {{$ap->programme->nber->name_code}}
                            </td>
                            <td>
                            <b>
                            {{$ap->programme->course_name}}</b>
                            </td>
                            <td>
                                <b>
                                {{$application->subject->scode}} 
                                </b>
                                {{$application->subject->sname}} 
                            </td>
                            @if($markentry==0)
                            <td>
                                {{$ap->institute->dummy_code}}
                                </td>
                                @endif
                                <td>
                                    {{$ap->id}}-{{$ap->institute->dummy_code}}-{{$ap->programme->id}}-{{$application->subject->id}}
                                </td>
                                <?php
                                   // $language_ids = \App\Currentapplication::where('subject_id',$application->subject_id)->where('approvedprogramme_id',$ap->id)->pluck('language_id')->unique();
                                    $language_ids = explode(",",$application->languages);
                                    $languages = \App\Language::whereIn('id',$language_ids)->get();
                                    ?>
                            @if($markentry==0)

                                <td>
                                    
                                    @foreach($languages as $l)
                                        <a  class="btn btn-primary btn-xs" style="margin-right:3px;margin-top:2px;" target="_blank" href="{{url('printcover')}}/{{$ap->id}}/{{$application->subject_id}}?examdate={{$examdate}}&starttime={{$starttime}}&endtime={{$endtime}}&language_id={{$l->id}}">
                                            {{$l->language}}
                                        </a>
                                    @endforeach
                                </td>
                           
                            <td>
                                <a  target="_blank"  href="{{url('evaluationcenterdummynumbers')}}/{{$ap->id}}/{{$application->subject_id}}?examdate={{$examdate}}&starttime={{$starttime}}&endtime={{$endtime}}&kvdailysubject_id={{$application->id}}"  class="btn btn-info btn-sm" style="margin-left:10px;" target="_blank">Get Dummy Numbers</a>
                            </td>
                            <td>
                            @foreach($languages as $l)
                                <a  class="btn btn-primary btn-xs" style="margin-right:3px;margin-top:2px;" target="_blank" href="{{url('evaluationcenterfoilsheet')}}/{{$ap->id}}/{{$application->subject_id}}?&examdate={{$examdate}}&starttime={{$starttime}}&kvdailysubject_id={{$application->id}}&language_id={{$l->id}}">
                                    {{$l->language}}
                                </a>
                            @endforeach
                            </td>
                            @endif

                            <td>
                                <?php 
                                    $status = 'Pending';
                                    $statusclass = "danger";
                                    $status_id = \App\Kvdailysubject::where('id',$application->id)->first()->evaluation_status;
                                    if($status_id == 1){
                                        $status = 'Incomplete';
                                        $statusclass = "warning";
                                    }
                                    if($status_id == 2){
                                        $status = 'Completed';
                                        $statusclass = "success";
                                    }
                                ?>
                                <span class="label label-{{$statusclass}}">{{$status}}</span>
                            </td>
                            
                            @if($markentry==1)
                            <td>
                            <a  target="_blank"  href="{{url('evaluationcentermarkentry')}}/{{$ap->id}}/{{$application->subject_id}}?examdate={{$examdate}}&starttime={{$starttime}}&endtime={{$endtime}}&kvdailysubject_id={{$application->id}}"  class="btn btn-warning btn-sm" style="margin-left:10px;" target="_blank">Mark Entry</a>
                            </td>
                            @endif
                        </tr>
                    {{-- @endif --}}
                    @endif
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection