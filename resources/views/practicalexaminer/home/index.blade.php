@extends('layouts.app')
@section('content')
@include('practicalexaminer._scripts._show_geotagupload')
<div class="container">
    
	<div class="row">
		<div class="col-md-12">
            @include('common.errorandmsg')
            <?php $slno = 1; ?>
            <h4>Practical Exams</h4>
            <div class="alert alert-danger" >
                <h4>Important Notice</h4>
                <ul>
                    <li>
                        <h3>Uploading of marks to the portal has to be completed on the same day of practicl examination. </h3>
                    </li>
                    <li>
                        Advisory for practical examiner. Click <a target="_blank" href="{{url('files/practical_advisory.pdf')}}">here</a>.
                    </li>
                    <li>
                        Please upload geo tagged group photo of External and Internal Examiner and students to download format of the marksheet and to upload the marksheet.
                    </li>
                    <li class="text-muted">
                        Geo tagging can be enabled on your phone . Please follow the <a target="_blank" href="https://www.quora.com/How-do-I-geotag-photos-on-Android">instructions</a>
                    </li>
                    <li>
                        Step by step instructions to use the portal for external practical examiner. Click <a target="_blank" href="{{url('files/GUIDELINES - EXTERNAL PRACTICAL.pdf')}}">here</a>.
                    </li>
                    
                </ul>

            </div>
            
            
            @include('practicalexaminer._partials._style')
            <table class="table table-bordered">
                <?php $institute_id = 0; $date = Session::get('date'); ?>
                <form action="{{url('practicalexam/home')}}" method="GET">
                    
                    {{ csrf_field() }}
                    <div class="alert alert-info ">
                        <h5 style="display: none;"><b>This option to backlog the previous days marks is only availble today. Please change the date to upload marks of previous days.</b></h5>
                        <br>
                        Exam Date: 
                        <?php 
                            $examenddate = '2025-07-16';
                            $date = \Carbon\Carbon::now(); 
                            if($date > $examenddate){
                                $date = $examenddate;
                            }
                        ?>
                        
                        <select name="date" id="date">
                            <?php 
                                $fromdate = \Carbon\Carbon::parse($examstartdate)->toDateString();
                                for ($i = 0; $i < 64; $i++) {
                                   $fromdate = \Carbon\Carbon::parse($fromdate)->addDay()->toDateString();
                            ?>
                                @if($fromdate <= $date)
                                    <option value="{{ $fromdate }}" @if(Session::get('date')==$fromdate) selected @endif > {{ \Carbon\Carbon::parse($fromdate)->format('D,  d M Y') }}</option>
                                @endif
                            <?php } ?>
                            
                    </select>
                        <button class="btn btn-xs btn-primary">Go</button>
                    </div>
                </form>
                @if(Session::has('date'))
                            <?php $date = Session::get('date'); ?>
                        @endif
                <?php
                    $geotagged = false; $gtinstitute_id = 0;$markuploadstatus = false; $countoffalse = 0;
                    foreach($practicalexams as $exam){
                        if($exam->geotaggedphotos()->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->where('faculty_id',$practicalexaminer_id)->count() > 0){
                            
                            $geotagged = true;
                            
                            $markupload = true;
                            if($exam->awardlisttemplates()->count() == 0){
                                $markupload = false;
                            }
                            else{
                                foreach($exam->awardlisttemplates()->get() as $template){
                                    if(is_null($template->marksheet)){
                                        $markupload = false;
                                    }
                                    foreach($template->subjects()->get() as $subject){
                                        if($subject->pivot->marks_upload!=1){
                                            $markupload = false;
                                        }
                                    }
                                }
                            }
                            if(!$markupload){
                                $countoffalse++;
                                if(!is_null($gtinstitute_id = $exam->geotaggedphotos()->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->where('faculty_id',$practicalexaminer_id)->first())){
                                    $gtinstitute_id = $exam->geotaggedphotos()
                                            ->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())
                                            ->where('faculty_id',$practicalexaminer_id)
                                            ->first()->institute_id;
                                }
                            }else{
                                if($countoffalse == 0){
                                    $gtinstitute_id = $exam->geotaggedphotos()->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->where('faculty_id',$practicalexaminer_id)->first()->institute_id;
                                }
                            }

                        }
                    }
                    if($countoffalse==0){
                        $markuploadstatus = true;
                    }
                ?>
                @foreach($practicalexams as $exam)
                    @if($exam->institute->additionalpracticalexams->count() > 0)
                        @if($institute_id  != $exam->institute_id)
                            <tr>
                                <th class="institute" colspan="4">
                                    {{$exam->institute->rci_code}} - {{$exam->institute->name}}
                                    @include('practicalexaminer._partials._geotag')
                                </th>
                            </tr>
                            <tr>
                                <th>Cousre</th>
                                <th>Batch</th>
                                <th>Download format for Marksheet</th>
                                <th>Upload marks</th>
                            </tr>
                        @endif
                        <?php $institute_id = $exam->institute_id; ?>
                        @foreach ( $exam->institute->approvedprogrammes->sortByDesc('academicyear_id') as $ap )
                            @if($ap->academicyear_id > 8 && $ap->academicyear_id < 14)
                                @if($ap->programme->course_id == $exam->course_id || $ap->programme->course->alternative_of == $exam->course_id )
                                    <tr>
                                        <td>
                                            {{$ap->programme->course->name}}
                                        </td>
                                        <td>
                                            <?php 
                                                $batch = $ap->academicyear->display_year ; 
                                                if($ap->programme->numberofterms==1){
                                                    $batch = $ap->academicyear->display_name_one_year;
                                                }
                                            ?>
                                            {{$batch}}
                                        </td>
                                        <td>
                                            <?php $gtagged = $exam->geotaggedphotos()->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->where('faculty_id',$practicalexaminer_id)->where('institute_id',$ap->institute_id)->count() > 0 ? true : false; ?>
                                            @if($geotagged == true && $exam->institute_id == $gtinstitute_id && $exam->faculty_id == $practicalexaminer_id) 
                                                @include('practicalexaminer._partials._buttons._formlinks')
                                                <?php $term = 1; ?>
                                                @include('practicalexaminer._partials._show_subjects')
                                                @if($ap->academicyear_id < 12 && $ap->programme->numberofterms==2)
                                                    <?php $term = 2;  ?>
                                                    @include('practicalexaminer._partials._show_subjects')
                                                @endif
                                            @endif 
                                        </td>
                                        <td>
                                            @if($exam->faculty_id == $practicalexaminer_id)   
                                        {{--    @if($geotagged == true && $exam->institute_id == $gtinstitute_id && $exam->awardlisttemplates()->where('approvedprogramme_id',$ap->id)->count()>0 && $exam->practicalexaminer_id == $practicalexaminer_id)    --}}
                                                @include('practicalexaminer._partials._buttons._uploadlinks')
                                            @endif
                                        </td>                        
                                    </tr>    
                                @endif
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </table>
            <br>
            <br>
            <br>
            <br>
            <br>

            @include('common.errorandmsg')
        </div>
    </div>
</div>
@endsection
