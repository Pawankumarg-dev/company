@extends('layouts.app')

@section('content')
<script>
        function addgrace(id, cname, scode){
            swal({
                title: 'Grace Mark for '  + cname + ' (' + scode + ')'  ,
                text: "Enter the grace mark ",
				input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Update!',
				inputValidator: (value) => {
					if (value == '' ||  value > 3 || value < 1) 
					{
						return 'Grace marks can only be between 1 to 3'
					}
					else {
						var formData = new FormData();
						var token = $('input[name=_token]');
                        formData.append('id', id);
                        formData.append('grace', value);
                        formData.append('exam_id', {{Session::get('exam_id')}});
						$.ajax({
							url: '{{url("nber/markentry/addgracemark")}}',
							method: 'POST',
							dataType: 'json',
							contentType: false,
							processData: false,
							headers: {
								'X-CSRF-TOKEN': token.val()
							},
							data: formData,
							success: function (data) {
								console.log(data);
								if(data=='success'){
									swal({
										type: 'success',
										title: 'Grace mark Added',
										showConfirmButton: false,
										timer: 3000
									});
									setTimeout(function(){
										location.reload();
									}, 3000); 
								}else{
									swal({
										type: 'warning',
										title: 'Could not update',
										showConfirmButton: false,
										timer: 1500
									});
								}
							},
							error: function (data) {
                                console.log(data);
								swal({
									type: 'warning',
									title: 'Could not update ',
									showConfirmButton: false,
									timer: 1500
								});
							}
						});
					}
				},
            }).then((result) => {
                
            })
        }
    </script>
<style>
    thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
    .table  { border-collapse: collapse; }
    th,td {border:1px solid #efefef;}
    .rotate {
        -webkit-transform: rotate(-180deg);        
        -moz-transform: rotate(-180deg);            
        -ms-transform: rotate(-180deg);         
        -o-transform: rotate(-180deg);         
        transform: rotate(-180deg);
        writing-mode: vertical-lr;
	}
    .rotate45 {
        -webkit-transform: rotate(-135deg);        
        -moz-transform: rotate(-135deg);            
        -ms-transform: rotate(-135deg);         
        -o-transform: rotate(-135deg);         
        transform: rotate(-135deg);
        writing-mode: vertical-lr;
    }
    .fail{
        background-color:red!important;
        color:white;
    }
    .internal{
        background-color:#fff;
        min-width: 30px!important;
    }

    .external{
        background-color:#eee;
        min-width: 30px!important;
    }
    .orange-text{
        color: orangered !important;
    }
    .main td, .main th{
        padding:0 !important;
        font-size:12px;
    }
    .pending-text{
        color: darkorange !important;
    }
    .text-darkgreen{
        color: darkgreen !important;
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('common.errorandmsg')
                {{ csrf_field() }}

                <h4>
                Marks - {{Session::get('examname')}}  Exam
                </h4>
                <h6> {{$ap->institute->rci_code}} - {{$ap->institute->name}} </h6>
                <h3>{{$ap->programme->name}} - {{$ap->academicyear->year}} Batch, Term {{$term}}</h3>
                 <table class="table table-bordered table-condensed table-hover table-sm" style="margin-right:20px;">
                    <tr>
                        <th class="text-darkgreen">IN</th>
                        <td>Internal</td>
                        <th class="text-darkgreen">EX</th>
                        <td>External</td>
                        <th class="text-darkgreen">TO</th>
                        <td>Total</td>
                        <th class="text-darkgreen">GM</th>
                        <td>Grace Mark</td>
                        <th>GT</th>
                        <td>Grand Total</td>

                    </tr>
                    <tr>
                        <th class="text-muted">NA</th>
                        <td>Not Applied</td>
                        <th><span class="orange-text">ABS</span></th>
                        <td>Absent</td>
                        <th> <span class="blue-text"> ANM</span></th>
                        <td>Attendance is not marked</td>
                        <th> <span class="pending-text"> PEN</span></th>
                        <td>Evaluation Pending / Mark not entered</td>
                    </tr>
                    <tr>
                        <th>P</th>
                        <td>Pass</td>
                        <th>F</th>
                        <td>Fail</td>
                        <th class="fail"></th>
                        <td>Fail</td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>
    @if($applicants->count()>0)
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <table class="main table table-bordered table-condensed table-hover table-sm" style="margin-right:20px;">
                        <thead>
                            <tr>
                                <th  rowspan="4" class="rotate text-center">Sl No</th>
                                <th rowspan="4" class="rotate  text-center">Enrolment No</th>
                                <th rowspan="4"  class="rotate  text-center">Student Name</th>
                                <th rowspan="4"  class="rotate  text-center">Attendance Theory %</th>
                                <th rowspan="4"  class="rotate  text-center">Attendance Practical %</th>
                                <th class="text-center text-muted" colspan="{{$subjects->where('subjecttype_id',1)->count() * 4}}">Theory</th>
                                <th class="text-center text-muted" colspan="{{$subjects->where('subjecttype_id',2)->count() * 4}}">Practical</th>
                                <th  class="text-center rotate text-muted" rowspan="3"> 
                                        <small>
                                            Min: {{$subjects->sum('imin_marks') + $subjects->sum('emin_marks')}}
                                            Max: {{$subjects->sum('imax_marks') + $subjects->sum('emax_marks')}}
                                        </small>
                                </th>
                                {{-- <th  class="text-center rotate" rowspan="3"> Pass/Fail</th> --}}
                            </tr>
                            <tr>
                                <?php $alt = 0; ?>
                                @foreach($subjects as $s)
                                    <th class="text-center @if($alt == 0) external @else internal @endif" colspan="4">
                                        {{$s->scode}}
                                    </th>
                                    <?php if($alt==0) { $alt = 1;} else {$alt = 0;} ?>
                                @endforeach
                            </tr>
                            <tr>
                                <?php $alt = 0; ?>

                                @foreach($subjects as $s)
                                    <td class="rotate @if($alt == 0) external @else internal @endif">
                                        <small class="text-muted">
                                            <?php
                                                $imin = $s->imin_marks; $imax = $s->imax_marks; 
                                                $emin = $s->emin_marks; $emax = $s->emax_marks;
                                                $tmin = $s->emin_marks +  $s->imin_marks;
                                                $tmax = $s->emax_marks +  $s->imax_marks;
                                            ?>
                                            Min: {{$imin}}
                                            Max: {{$imax}}
                                        </small>
                                    </td>
                                    <td class="rotate @if($alt == 0) external @else internal @endif">
                                        <small class="text-muted">
                                            Min: {{$emin}}
                                            Max: {{$emax}}
                                        </small>
                                    </td>
                                    <td class="@if($alt == 0) external @else internal @endif">

                                    </td>
                                    <td  class="rotate @if($alt == 0) external @else internal @endif">
                                        <small class="text-muted">
                                            Min: {{$tmin}}
                                            Max: {{$tmax}}
                                        </small>
                                    </td>
                                    <?php if($alt==0) { $alt = 1;} else {$alt = 0;} ?>

                                @endforeach
                            </tr>
                            <tr>
                                <?php $alt = 0; ?>
                                @foreach($subjects as $s)
                                    <th class="rotate text-darkgreen @if($alt == 0) external @else internal @endif">IN</th>
                                    <th class="rotate text-darkgreen @if($alt == 0) external @else internal @endif">EX</th>
                                    <th class="rotate text-darkgreen @if($alt == 0) external @else internal @endif">GM</th>
                                    <th class="rotate text-darkgreen @if($alt == 0) external @else internal @endif">TO</th>
                                    <?php if($alt==0) { $alt = 1;} else {$alt = 0;} ?>
                                @endforeach
                                <th class="rotate ">GT</th>
                            <th  class="rotate "> Pass/Fail</th>

                            </tr>
                        </thead>
                        <?php 
                            $slno= 1;
                        ?>
                        @foreach($applicants->sortBy('candidate.enrolmentno') as $a)
                            @if(!is_null($a->candidate)) 
                            <?php $passfail = 'P'; $showresult = 0; ?>
                            <tr>
                                <td class="text-center">
                                    {{$slno}}
                                    <?php $slno++; ?>
                                </td>
                                <td>
                                @if(!is_null($a->candidate)) 
                                    <a target="_blank" href="{{url('nber/candidate')}}/{{$a->candidate_id}}">
                                    {{$a->candidate->enrolmentno}} 
                                    </a>
                                @else
                                {{$a->candidate->enrolmentno}} 
                                @endif
                                </td>
                                <td>
                                    
                                    @if(!is_null($a->candidate))
                                    {{$a->candidate->name}} 
                                    @else
                                    {{$a->candidate->name}} 
                                    @endif
                                    
                                </td>
                                <td>
                                    <?php $attn = \App\Attendance::where('candidate_id',$a->candidate_id)->first();

                                    ?>
                                    @if(!is_null($attn))
                                        {{$attn->attendance_t}}%
                                    @endif
                                </td>
                                <td>
                                @if(!is_null($attn))
                                        {{$attn->attendance_p}}%
                                    @endif
                                </td>
                                <?php $grandtotal = 0; $alt = 0; ?>
                                @foreach($subjects as $s)
                                    <?php 
                                        //$m = $applications->where('candidate_id',$a->candidate_id)->where('subject_id',$s->id)->first(); 
                                    
                                        $result = array_filter($applications, function ($subarray) use ($a,$s) {
                                            return isset($subarray['candidate_id']) && isset($subarray['subject_id'] ) && (int)$subarray['candidate_id'] === (int)$a->candidate_id && (int)$subarray['subject_id'] === (int)$s->id;
                                        });
                                        $m = null; $grace =''; $total =0 ;
                                        if(array_keys($result)!= null){
                                            $m = $result[array_keys($result)[0]];
                                        }
                                        if(!is_null($m)){
                                            if(!($m['internalattendance_id'] == 2 && $m['externalattendance_id'] == 2 )){
                                                $showresult = 1;
                                            }
                                            $in = $m['internal_mark'];
                                            $ex = $m['external_mark'];
                                            $grace = $m['grace'];
                                            $id = $m['id'];
                                            if($s->id == 854 || $s->id == 861 || $s->id == 871){
                                                $total = $in;
                                                $grandtotal += $total;
                                                
                                                $imin = $s->imin_marks; 
                                                $imax = $s->imax_marks; 
                                                $tmin = $imin ;
                                                $tmax = $imax ;

                                                if(($in) < $imin  ||  $m['internalattendance_id'] < 1){
                                                    $passfail = 'F';
                                                }
                                            }else{
                                                $total = $in + $ex + $grace;
                                                $grandtotal += $total;
                                                
                                                $imin = $s->imin_marks; 
                                                $imax = $s->imax_marks; 
                                                $emin = $s->emin_marks; 
                                                $emax = $s->emax_marks;
                                                $tmin = $imin + $emin;
                                                $tmax = $imax + $emax;

                                                if($in < $imin || ($ex + $grace) < $emin || ($total) < $tmin || $m['internalattendance_id'] == 2 || $m['internalattendance_id'] < 1 ||$m['internalattendance_id'] == 2){
                                                    $passfail = 'F';
                                                }
                                            }
                                            
                                        }
                                    ?>
                                    <td   class="text-center @if($alt == 0) external @else internal @endif @if(!is_null($m) && $in!='' && ($in + $grace)<$imin) fail @endif"  >
                                        @if(is_null($m))
                                            <span class="text-muted">NA</span>
                                        @endif
                                        @if(!is_null($m) && $m['internalattendance_id'] == 1)
                                            @if(is_null($in))
                                                <span class="rotate pending-text"> PEN  </span>
                                            @else
                                                {{$in}}
                                            @endif
                                        @endif
                                        
                                        @if(!is_null($m) && $m['internalattendance_id'] == 2)
                                            <span class="rotate orange-text"> ABS  </span>
                                        @endif
                                        @if(!is_null($m) && $m['internalattendance_id'] < 1)
                                            <span class="rotate blue-text"> ANM  </span>
                                        @endif
                                    </td>
                                    @if($s->id == 854 || $s->id == 861 || $s->id == 871)
                                        <td class="@if($alt == 0) external @else internal @endif"></td>
                                    @else
                                        <td  class="@if($alt == 0) external @else internal @endif @if(!is_null($m) && $ex !='' && ($grace+$ex)<$emin) fail  @endif text-center">
                                            @if(is_null($m))
                                                <span class="text-muted">NA</span>
                                            @endif
                                            @if(!is_null($m) && $m['externalattendance_id'] == 1)
                                                @if(is_null($ex))
                                                    <span class="rotate pending-text"> PEN  </span>
                                                @else
                                                    {{$ex}}
                                                @endif
                                            @endif
                                            @if(!is_null($m) && $m['externalattendance_id'] == 2)
                                                <span class="rotate orange-text"> ABS  </span>
                                            @endif
                                            @if(!is_null($m) && $m['externalattendance_id'] < 1)
                                                <span class="rotate blue-text"> ANM  </span>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="@if($alt == 0) external @else internal @endif text-center">
                                        <?php if($grace == 0){$grace='';} ?>
                                        {{$grace}} 
                                        @if(!is_null($m) && $grace < 1 && (($in < $imin && $in + 4 > $imin) || ($ex < $emin && $ex + 4 > $emin) ) && $m['externalattendance_id'] == 1 && $m['internalattendance_id'] == 1)
                                          {{--  <a href="javascript:addgrace({{$id}},'{{$a->candidate->name}}','{{$s->scode}}')">+</a> --}}
                                        @endif
                                    </td>
                                        {{-- <td class="text-center">

                                       @if($m['internal_mark'] < $imin || ($m['external_mark'] + $m['grace']) < $emin || $m['internalattendance_id'] == 2 || $m['internalattendance_id'] < 1 || $m['internalattendance_id'] == 2)
                                                    F
                                                @else
                                                    P
                                                @endif

                                    </td> --}}
                                    @if($s->id == 854 || $s->id == 861 || $s->id == 871)
                                        <td   class="@if(!is_null($m) && $total !='' && ( $in < 1  ) || $total<$tmin) fail @endif  @if($alt == 0) external @else internal @endif text-center" >
                                            @if(!is_null($m) && !($m['internalattendance_id'] == 2 && $m['externalattendance_id'] == 2 ))
                                                {{$total}}
                                            @endif
                                        </td>
                                    @else
                                        <td   class="@if(!is_null($m) && ($total !='' && ( $in < 1 || $ex < 1 ) || $total<$tmin)) fail @endif  @if($alt == 0) external @else internal @endif text-center" >
                                            @if(!is_null($m) && !($m['internalattendance_id'] == 2 && $m['externalattendance_id'] == 2 ))
                                                {{$total}}
                                            @endif
                                        </td>
                                    @endif
                                    <?php if($alt==0) { $alt = 1;} else {$alt = 0;} ?>
                                @endforeach
                                <td class="text-center  @if($passfail=='F' && $showresult == 1) fail @endif">
                                    @if($showresult == 1)
                                        {{$grandtotal}}
                                    @endif
                                </td>
                                <td class="text-center  @if($passfail=='F' && $showresult == 1) fail @endif">
                                    @if($showresult == 1)
                                        {{$passfail}}
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
  
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-condensed table-hover table-sm">
                        <tr>
                            <th>
                                Code
                            </th>
                            <th>
                                Subject
                            </th>
                            <th>Internal </th>
                            <th>
                                External
                            </th>
                        </tr>

                        
                        <?php echo $countoftheorysubjects = $subjects->where('subjecttype_id',1)->count(); $intheory = true; $ss = 0;?>

                        @foreach($subjects as $s)
                         @if($s->subjecttype_id==1)
                          <?php $ss++ ?>
                        @endif
                        @endforeach
                        @foreach($subjects as $s)
                            @if($s->subjecttype_id==1)
                        
                            <tr>
                                <td>{{$s->scode}}</td>
                                <td>{{$s->sname}}</td>
                                @if($intheory)
                                <td rowspan="{{$ss}}">
                                    <?php $ms = \App\Internalmarksheet::where('approvedprogramme_id',$ap->id)->where('term',$term)->where('exam_id',$exam_id)->where('subjecttype_id',1)->first();
                                    $intheory = false;
                                    ?>
                                    @if(!is_null($ms))
                                    <a target="_blank" href="{{url('/files/internalmarksheets/')}}/{{str_replace('/tmp','',$ms->filename)}}">Mark Sheet</a>
                                    @endif
                                </td>
                                @endif
                                <td>
                                    <?php $sheet = \App\Examattendancesheet::where('exam_id',$exam_id)->where('approvedprogramme_id',$ap->id)->where('subject_id',$s->id)->first();
                                    if(!is_null($sheet)){?>
                                        <a target="_blank" href="{{url('/files/examattendancefiles/')}}/{{str_replace('/tmp','',$sheet->filename)}}">Attendance Sheet</a>
                                    <?php }
                                    ?>
                                Bundle Number: {{$ap->id}}-{{$ap->institute->dummy_code}}-{{$ap->programme->id}}-{{$s->id}}
                                </td>
                            </tr>
                            @endif
                        @endforeach
                   

                        <?php $countofpracticalsubjects = $subjects->where('subjecttype_id',2)->count(); $inpractical = true;  $ss = 0;?>
                        @foreach($subjects as $s)
                         @if($s->subjecttype_id==2)
                          <?php $ss++?>
                        @endif
                        @endforeach
                        @foreach($subjects as $s)
                         @if($s->subjecttype_id==2)
                            <tr>
                                <td>{{$s->scode}}</td>
                                <td>{{$s->sname}}</td>
                                @if($inpractical)
                                    <td rowspan="{{$ss}}">
                                        <?php $ms = \App\Internalmarksheet::where('approvedprogramme_id',$ap->id)->where('term',$term)->where('exam_id',$exam_id)->where('subjecttype_id',2)->first();
                                        $inpractical = false;
                                        ?>
                                        @if(!is_null($ms))
                                        <a target="_blank" href="{{url('/files/internalmarksheets/')}}/{{str_replace('/tmp','',$ms->filename)}}">Mark Sheet</a>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    <?php $alt = \App\Awardlisttemplate::where('approvedprogramme_id',$ap->id)->where('term',$term)->get();
                                    foreach($alt as $template){
                                        foreach($template->subjects()->get() as $subject){
                                            if($subject->pivot->marks_upload==1 && $subject->id == $s->id){
                                            ?>
                                                    <a target="_blank" href="{{url('/files/externalpractical/')}}/{{str_replace(':','_',$template->marksheet)}}">Mark Sheet</a> or 
                                                    <a target="_blank" href="{{url('/files/externalpractical/')}}/{{$template->marksheet}}">Mark Sheet</a>
                                            <?php
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-sm-12">         
                    <div class="alert alert-danger">
                        No Applications 
                    </div>                
                </div>
            </div>
        </div>
    @endif

   
@endsection
