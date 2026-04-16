@extends('layouts.app')
@section('content')
    @include('practicalexaminer._scripts._show_geotagupload')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                @include('common.errorandmsg')
                <?php $slno = 1; ?>
                <h4>Practical Exams</h4>
                <div class="alert alert-danger">
                    <h4>Important Notice</h4>
                    <ul>
                        <li>
                            <h3>Uploading of marks to the portal has to be completed on the same day of practicl
                                examination. </h3>
                        </li>
                        <li>
                            Advisory for practical examiner. Click <a target="_blank"
                                href="{{ url('files/practical_advisory.pdf') }}">here</a>.
                        </li>
                        <li>
                            Please upload geo tagged group photo of External and Internal Examiner and students to download
                            format of the marksheet and to upload the marksheet.
                        </li>
                        <li class="text-muted">
                            Geo tagging can be enabled on your phone . Please follow the <a target="_blank"
                                href="https://www.quora.com/How-do-I-geotag-photos-on-Android">instructions</a>
                        </li>
                        <li>
                            Step by step instructions to use the portal for external practical examiner. Click <a
                                target="_blank" href="{{ url('files/GUIDELINES - EXTERNAL PRACTICAL.pdf') }}">here</a>.
                        </li>

                    </ul>

                </div>


                @include('practicalexaminer._partials._style')
                <table class="table table-bordered">
                    <?php $institute_id = 0;
                    $date = Session::get('date'); ?>
                    <form action="{{ url('practicalexam/home') }}" method="GET">

                        {{ csrf_field() }}
                        <div class="alert alert-info hidden">
                            <h5 style="display: none;"><b>This option to backlog the previous days marks is only availble
                                    today. Please change the date to upload marks of previous days.</b></h5>
                            <br>
                            Exam Date:
                            <?php
                            $date = \Carbon\Carbon::now();
                            
                            ?>

                            <select name="date" id="date">
                                <?php 
                                $fromdate = \Carbon\Carbon::parse($examstartdate)->toDateString();
                                for ($i = 0; $i < 20; $i++) {
                                   $fromdate = \Carbon\Carbon::parse($fromdate)->addDay()->toDateString();
                            ?>
                                <option value="{{ $fromdate }}" @if ($date == $fromdate) selected @endif>
                                    {{ \Carbon\Carbon::parse($fromdate)->format('D,  d M Y') }}</option>
                                <?php } ?>
                            </select>
                            <button class="btn btn-xs btn-primary">Go</button>
                        </div>
                    </form>

                    <?php
                    $geotagged = false;
                    $gtinstitute_id = 0;
                    $markuploadstatus = false;
                    $countoffalse = 0;
                    // $geotagged = false; $gtinstitute_id = 0;$markuploadstatus = false; $countoffalse = 0;
                    // foreach($practicalexams as $exam){
                    
                    //     if($exam->geotaggedphotos()->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->where('faculty_id',$practicalexaminer_id)->count() > 0){
                    
                    //         $geotagged = true;
                    
                    //         $markupload = true;
                    //         if($exam->awardlisttemplates()->count() == 0){
                    //             $markupload = false;
                    //         }
                    //         else{
                    //             foreach($exam->awardlisttemplates()->get() as $template){
                    //                 if(is_null($template->marksheet)){
                    //                     $markupload = false;
                    //                 }
                    //                 foreach($template->subjects()->get() as $subject){
                    //                     if($subject->pivot->marks_upload!=1){
                    //                         $markupload = false;
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //         if(!$markupload){
                    //             $countoffalse++;
                    //             if(!is_null($gtinstitute_id = $exam->geotaggedphotos()->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->where('faculty_id',$practicalexaminer_id)->first())){
                    //                 $gtinstitute_id = $exam->geotaggedphotos()
                    //                         ->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())
                    //                         ->where('faculty_id',$practicalexaminer_id)
                    //                         ->first()->institute_id;
                    //             }
                    //         }else{
                    //             if($countoffalse == 0){
                    //                 $gtinstitute_id = $exam->geotaggedphotos()->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->where('faculty_id',$practicalexaminer_id)->first()->institute_id;
                    //             }
                    //         }
                    
                    //     }
                    // }
                    // if($countoffalse==0){
                    //     $markuploadstatus = true;
                    // }
                    ?>
                    @foreach ($practicalexams as $exam)
                        {{-- {{$exam}}  --}}
                        @if ($institute_id != $exam->institute_id)
                            <tr>
                                <th class="institute" colspan="5">
                                    {{ $exam->institute->rci_code }} - {{ $exam->institute->name }}
                                    @include('practicalexaminer._partials._geotag')
                                </th>
                            </tr>
                            <tr>
                                <th>Cousre</th>
                                <th>Exam Date</th>
                                <th>Batch / Candidates</th>
                                <th>Download format for Marksheet</th>
                                <th>Upload marks</th>
                            </tr>
                        @endif
                        <?php $institute_id = $exam->institute_id;
                        
                        $approvedprogrammes = DB::table('allapplications')
                            ->join('candidates', 'candidates.id', '=', 'allapplications.candidate_id')
                            ->join('subjects', function ($join) {
                                $join->on('subjects.id', '=', 'allapplications.subject_id')->where('subjects.subjecttype_id', '=', 2)->where('subjects.is_external', '=', 1);
                            })
                            ->join('approvedprogrammes', 'candidates.approvedprogramme_id', '=', 'approvedprogrammes.id')
                            ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
                            ->join('courses', 'programmes.course_id', '=', 'courses.id')
                            ->join('academicyears', 'approvedprogrammes.academicyear_id', '=', 'academicyears.id')
                            ->where('allapplications.exam_id', $exam->exam_id)
                            ->where('approvedprogrammes.institute_id', $institute_id)
                            ->where('approvedprogrammes.programme_id', $exam->programme_id)
                        
                            ->select(
                                'courses.name',
                                'academicyears.year',
                                'programmes.numberofterms',
                                'academicyears.display_name_one_year',
                                'academicyears.display_year',
                                'courses.alternative_of',
                                DB::raw('COUNT(candidates.id) as total_candidate'),
                                'programmes.course_id',
                                'approvedprogrammes.academicyear_id',
                                'approvedprogrammes.institute_id',
                                'programmes.abbreviation',
                        
                                'approvedprogrammes.id',
                                'programmes.id as programme_id',
                            )
                            ->groupBy('approvedprogrammes.id')
                        
                            ->get();
                        // echo "<pre>";
                        // print_r( $approvedprogrammes);
                        // echo die();
                        ?>


                        @foreach ($approvedprogrammes as $ap)
                            {{-- @php 
                        $candidate_count = \App\AllApplication::join('candidates', 'candidates.id', '=', 'allapplications.candidate_id')
                            ->join('subjects', function($join) {
                                $join->on('subjects.id', '=', 'allapplications.subject_id')
                                    ->where('subjects.subjecttype_id','=', 2)
                                    ->where('subjects.is_external','=', 1);
                            })
                            ->where('candidates.approvedprogramme_id', $ap->id)
                            ->where('allapplications.exam_id', 28)
                            ->count();


                            //cha
                        @endphp --}}


                            @if ($ap->course_id == $exam->course_id || $ap->alternative_of == $exam->course_id)
                                <tr>
                                    <td>
                                        {{ $ap->name }}
                                    </td>
                                    <td>
                                        {{ $exam->start_date }} To
                                        {{ $exam->end_date }}

                                    </td>
                                    <td>
                                        <?php
                                        $batch = $ap->display_year;
                                        if ($ap->numberofterms == 1) {
                                            $batch = $ap->display_name_one_year;
                                        }
                                        ?>
                                        {{ $batch }} / Candidate: {{ $ap->total_candidate }}
                                    </td>
                                    @php

                                        $now = \Carbon\Carbon::now()->format('Y-m-d');
                                        //    $start = \Carbon\Carbon::parse($exam->start_date)->format('Y-m-d');
                                        //    $end = \Carbon\Carbon::parse($exam->end_date)->addDay()->format('Y-m-d');
                                        $start = '2026-04-12';
                                        $end = '2026-04-17';

                                    @endphp
                                    @if ($now >= $start && $now <= $end)
                                        <td>
                                            <?php
                                            $geotagged = \App\Geotaggedphoto::where('faculty_id', $exam->faculty_id)->where('institute_id', $exam->institute_id)->where('faculty_id', $exam->faculty_id)->count() > 0 ? true : false;
                                            ?>
                                            @if ($geotagged == true)
                                                @include('practicalexaminer._partials._buttons._formlinks')
                                                <?php $term = 1; ?>
                                                @include('practicalexaminer._partials._show_subjects')
                                                @if ($ap->academicyear_id < 12 && $ap->numberofterms == 2)
                                                    <?php $term = 2; ?>
                                                    @include('practicalexaminer._partials._show_subjects')
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{-- @if ($exam->faculty_id == $practicalexaminer_id) --}}
                                            {{-- {{$data}} --}}
                                            {{--    @if ($geotagged == true && $exam->institute_id == $gtinstitute_id && $exam->awardlisttemplates()->where('approvedprogramme_id', $ap->id)->count() > 0 && $exam->practicalexaminer_id == $practicalexaminer_id)    --}}
                                            {{-- @include('practicalexaminer._partials._buttons._uploadlinks')
                                            @endif --}}
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Term</th>
                                                        <th>Upload Marksheet</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                        $subjectIds = \App\PracticalExamSubject::where(
                                                            'practicalexam_id',
                                                            $exam->id,
                                                        )
                                                            ->pluck('subject_id')
                                                            ->toArray();

                                                        $subjects = \App\Subject::where(
                                                            'programme_id',
                                                            $ap->programme_id,
                                                        )
                                                            ->whereIn('id', $subjectIds)
                                                            ->where('subjecttype_id', 2)
                                                            ->orderBy('syear')
                                                            ->get();
                                                    @endphp

                    @forelse($subjects as $subject)
                        <tr>
                            <td>
                                <strong>{{ $subject->scode }}</strong>
                            </td>

                            <td>
                                {{ $subject->syear }}
                            </td>

                            <td>
                                <form
                                    action="{{ url('/practicalexam/awardlisttemplate/upload_entry') }}"
                                    method="POST" enctype="multipart/form-data"
                                    class="upload-form">

                                    {{ csrf_field() }}

                                    <input type="hidden" name="practicalexam_id"
                                        value="{{ $exam->id }}">
                                    <input type="hidden" name="approvedprogramme_id"
                                        value="{{ $ap->id }}">
                                    <input type="hidden" name="institute_id"
                                        value="{{ $ap->institute_id }}">
                                    <input type="hidden" name="term"
                                        value="{{ $term }}">
                                    <input type="hidden" name="subject_id"
                                        value="{{ $subject->id }}">
                                    <input type="file" name="marksheet"
                                        class="file-input d-none">
                                        
                                    @php
                                        $template = $exam->awardlisttemplates()->where('approvedprogramme_id',$ap->id)->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->whereHas('subjects', function($q) use ($subject){
                                            $q->where('subject_id', $subject->id);
                                        })->first();
                                        // echo "<pre>";
                                        // print_r($template);
                                    @endphp

                                    @if (!empty($template->marksheet))
                                        <div class="uploaded-block upload-block">
                                            <a target="_blank"
                                                href="{{ url('files/externalpractical') }}/{{ $template->marksheet }}">
                                                Download (Term {{ $subject->syear }})
                                            </a>
                                            <div class="alert alert-warning">
                                                @if ($template->subjects->count() > 0)
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Subject Code</th>
                                                            <th>Marks</th>
                                                        </tr>

                                                        @foreach ($template->subjects as $subject)
                                                            <tr>
                                                                <td>{{ $subject->scode }}</td>
                                                                <td>
                                                                    <a href="{{ url('practicalexam/awardlisttemplate') }}/{{ $template->id }}?subject_id={{ $subject->id }}"
                                                                        class="btn btn-xs btn-primary">
                                                                        Enter Marks
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @endif
                                            </div>
                                            <div class="mt-2">
                                                <button type="button"
                                                    class="btn btn-sm btn-warning upload-btn">
                                                    Re-upload marksheet
                                                </button>
                                                <span class="uploading hidden text-info small">Uploading, please wait...</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="upload-block">
                                            <button type="button"
                                                class="btn btn-sm btn-success upload-btn">
                                                Upload
                                            </button>
                                          
                                            <span class="uploading hidden text-info small">Uploading, please wait...</span>
                                        </div>
                                    @endif

                                </form>
                            </td>
                        </tr>
                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center text-muted">
                                                                No subjects available
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.upload-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    let form = this.closest('form');
                    let fileInput = form.querySelector('.file-input');
                    fileInput.click();
                });
            });

            document.querySelectorAll('.file-input').forEach(function(input) {
                input.addEventListener('change', function() {
                    if (!this.files || this.files.length === 0) {
                        return;
                    }

                    let file = this.files[0];
                    if (file.size > 1000000) {
                        alert('Please choose a file smaller than 1MB.');
                        this.value = '';
                        return;
                    }

                    let form = this.closest('form');
                    let uploadBlock = form.querySelector('.upload-block');
                    let uploadingText = form.querySelector('.uploading');
                    if (uploadBlock) {
                        uploadBlock.classList.add('hidden');
                    }
                    if (uploadingText) {
                        uploadingText.classList.remove('hidden');
                    }

                    form.submit();
                });
            });

        });
    </script>
@endsection
