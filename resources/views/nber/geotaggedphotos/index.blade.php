
@extends('layouts.app')

@section('content')
    <style>
        th, td {
            
            vertical-align: top;
        }
    </style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
                <h4> Geotagged Photos {{$date}}
                    @if($type=='institute')
                        <a href="{{url('/nber/geotaggedphotos')}}/{{$iid}}?institute=yes" target="_blank"
                            class="btn btn-xs btn-primary pull-right"
                        >
                            Marks details
                        </a>
                    @endif
                </h4>
                
                <a href="{{url('/nber/geotaggedphotos')}}/?excel=yes" target="_blank"
                class="btn btn-xs btn-primary pull-right"
            >
                DOWNLOAD PRACTICAL PROGRESS .XLS
            </a>
                @if($type=='date')
                <table class="table table-bordered" style="width:50%;">
                    <tr>
                        <td colspan="2">
                            Institute wise
                        </td>
                        <td>
                             <a target="_blank" href="{{url('nber/geotaggedphotos')}}?institute=yes">Geo tagged Photos</a>
                        </td>
                    </tr>
                    <?php $date = \Carbon\Carbon::now(); ?>
                        <?php 
                            $examstartdate = '2025-05-20';
                            $fromdate = \Carbon\Carbon::parse($examstartdate)->toDateString();
                            for ($i = 0; $i < 24; $i++) {
                                $fromdate = \Carbon\Carbon::parse($fromdate)->addDay()->toDateString();
                        ?>
                            @if($fromdate <= $date)
                                <tr>
                            
                        
                        <td>
                            {{ \Carbon\Carbon::parse($fromdate)->format('D,  d M Y')  }}
                        </td>
                        <td>
                             <a target="_blank" href="{{url('nber/geotaggedphotos')}}?date={{ $fromdate }}">Geo tagged Photos</a>
                        </td>
                        @endif
                    <tr>
                        <?php } ?>
                        <td>
                            All Days
                        </td>
                        <td>
                            
                        </td>
                        <td>
                             <a target="_blank" href="{{url('nber/geotaggedphotos')}}/0">Details</a>
                        </td>
                    </tr>

                </table>
                @endif
			{{csrf_field()}}
				<table class="table table-boarded">
					<tr>
						<th>SlNo</th>
                        <th>Exam Date</th>
						<th>Institute, Course and Schedule</th>
						<th>Photo</th>
                        <th>Examiner</th>
                        <th>Exams</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($gtphotos->sortbyDesc('id') as $photo)
                        @if(!is_null($photo->practicalexam_id) && $photo->practicalexam_id > 0  &&  !is_null($photo->practicalexam->course_id) && $photo->practicalexam->course_id > 0)
                            @if($photo->practicalexam->course->nber_id == $nber_id || Auth::user()->id == 88387)
                            <tr>
                                <td class="align-top">
                                    {{$slno}}
                                    <?php $slno++; ?>
                                </td>
                                <td>
                                    {{\Carbon\Carbon::parse($photo->exam_date)->toDateString()}}
                                </td>
                                
                                <td>
                                    @if(!is_null($photo->practicalexam->institute))
                                    {{$photo->practicalexam->institute->rci_code}}
                                    {{$photo->practicalexam->institute->name}}
                                    {{$photo->practicalexam->institute->address}}
                                    @endif
                                    <br />
                                    Course:     {{$photo->practicalexam->course->name}} <br />
                                    
                                    From: {{\Carbon\Carbon::parse($photo->practicalexam->start_date)->toDateString()}} 
                                    To: {{\Carbon\Carbon::parse($photo->practicalexam->end_date)->toDateString()}} 
                                </td>
                                    
                                <td>
                                    <a href="{{url('files/geotaggedphotos')}}/{{$photo->file}}" target="_blank">
                                        <img src="{{url('files/geotaggedphotos')}}/{{$photo->file}}" style="width:400px">
                                    </a>
                                </td>
                                <td>
                                    {{$photo->practicalexam->faculty->name}} <br>
                                    {{$photo->practicalexam->faculty->email}}<br>
                                    {{$photo->practicalexam->faculty->mobileno}} <br />
                                </td>
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Course</th>
                                            <th>Batch</th>
                                            <th>Marksheet</th>
                                            <th>Subjects</th>
                                        </tr>
                                        @foreach($photo->practicalexam->awardlisttemplates as $template)
                                        <tr>
                                            <td>
                                                {{$template->approvedprogramme->programme->course_name}}
                                            </td>
                                            <td>
                                                {{$template->approvedprogramme->academicyear->year}}
                                            </td>
                                            <td>
                                                @if(!is_null($template->marksheet))
                                                    {{-- 
                                                <a target="_blank" href="{{url('files/externalpractical')}}/{{str_replace(":","_",$template->marksheet)}}"> --}}   
                                                        <a target="_blank" href="{{url('files/externalpractical')}}/{{$template->marksheet}}">

                                                        Download
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($template->subjects as $subject)
                                                    {{$subject->scode}}  
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                                
                            </tr>
                            @endif
                        @endif
					@endforeach
				</table>				
			</div>
		</div>
	</div>
@endsection
