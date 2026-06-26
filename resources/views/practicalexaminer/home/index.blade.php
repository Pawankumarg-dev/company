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

                        <li>
                            Please follow scheme of Examination 2026 <a
                                target="_blank" href="https://nber-rehabcouncil.gov.in/files/notice/SoE_NBER.pdf">here</a>.
                        </li>
                    </ul>

                </div>
                @include('practicalexaminer._partials._style')
                <table class="table table-bordered">
                    <?php $institute_id = 0;
                    $date = Session::get('date'); 
                    $geotagged = false;
                    ?>
                    @foreach ($practicalexams as $exam)
                        {{-- {{$exam}}  --}}
                        @if ($institute_id != $exam->institute_id)
                            <tr>
                                <th class="institute" colspan="4">
                                    {{ $exam->institute->rci_code }} - {{ $exam->institute->name }}
                                    @include('practicalexaminer._partials._geotag')
                                </th>
                            </tr>
                            <tr>
                                <th>Course</th>
                                <th>Exam Date</th>
                                <th>Batch / Candidates</th>
                                {{-- <th>Download format for Marksheet</th> --}}
                                <th></th>
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
                                'programmes.id as programme_id'
                            )
                            ->groupBy('approvedprogrammes.id')                       
                            ->get();
                        // echo "<pre>";
                        // print_r( $approvedprogrammes);
                        // echo die();
                        ?>


                        @foreach ($approvedprogrammes as $ap)
                           
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
                                        $start = \Carbon\Carbon::parse($exam->start_date)->format('Y-m-d');
                                         $end = \Carbon\Carbon::parse($exam->end_date)->addDay()->format('Y-m-d');
                                        // $start = '2026-06-08';
                                        // $end = '2026-06-30';

                                    @endphp
                                    @if ($now >= $start && $now <= $end)
                                     <?php
                                    $geotagged = \App\Geotaggedphoto::where('faculty_id', $exam->faculty_id)->where('institute_id', $exam->institute_id)->where('faculty_id', $exam->faculty_id)->where('exam_date',$now)->count() > 0 ? true : false;
                                    ?>
                                       
                                        <td style="padding: 0px">
                                            
                                            @if ($geotagged == true && $exam->faculty_id == $practicalexaminer_id)
                                            <table class="table table-bordered table-striped" >
                                                <thead>
                                                    <tr>
                                                        <th> Awardlist Formate</th>
                                                        <th>Subject Code / <small>Name</small></th>
                                                        <th>Term</th>
                                                        <th>Upload Marksheet</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                        $subjectIds = \App\PracticalExamSubject::where(
                                                            'practicalexam_id',
                                                            $exam->id
                                                        )
                                                            ->pluck('subject_id')
                                                            ->toArray();

                                                        $subjects = \App\Subject::where(
                                                            'programme_id',
                                                            $ap->programme_id
                                                        )
                                                            ->whereIn('id', $subjectIds)
                                                            ->where('subjecttype_id', 2)
                                                            ->where('is_external',1)
                                                            ->orderBy('syear')
                                                            ->get();
                                                    @endphp

                                    @forelse($subjects as $subject)
                                        <tr>
                                            <td>
                                                <form action="{{url('practicalexam/awardlisttemplate/download')}}" method="POST">
                                                        {{ csrf_field() }}
                                                <input type="hidden" name="practicalexam_id" value="{{$exam->id}}">
                                                <input type="hidden" name="approvedprogramme_id" value="{{$ap->id}}">
                                                <input type="hidden" name="institute_id" value="{{$ap->institute_id}}">
                                                <input type="hidden" name="term" value="{{$subject->syear}}">
                                                    <input type="hidden" name="subject_ids" value="{{ $subject->id }}">
                                                    <button type="submit" class="btn btn-sm btn-primary">Download</button>
                                                </form>
                                            </td>
                                            <td>
                                                <strong>{{ $subject->scode }}:</strong> {{ $subject->sname }}
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
                                                        <input type="hidden" name="practicalexam_id" value="{{ $exam->id }}">
                                                        <input type="hidden" name="approvedprogramme_id" value="{{ $ap->id }}">
                                                        <input type="hidden" name="institute_id" value="{{ $ap->institute_id }}">
                                                        <input type="hidden" name="term" value="{{ $subject->syear }}">
                                                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                                        <input type="file" name="marksheet" class="file-input hidden" accept="application/pdf">
                                                        <input type="hidden" name="latitude">
                                                        <input type="hidden" name="longitude">
                                                        @php
                                                            // ->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())
                                                            $template = $exam->awardlisttemplates()->where('approvedprogramme_id',$ap->id)->whereHas('subjects', function($q) use ($subject){
                                                                $q->where('subject_id', $subject->id);
                                                            })->first(); 
                                                            // echo "<pre>";
                                                            // print_r($template);
                                                        @endphp
                                                        <input type="hidden" name="awardlist_id"  value="{{ $template->id ?? '' }}">
                                                        @if (!empty($template->marksheet))
                                                            @if ($template->verified ==1)
                                                                <div >
                                                                   <strong style="color: green">Verified</strong> 
                                                                </div>
                                                            @else
                                                              <div class="uploaded-block upload-block text-center">
                                                                <a target="_blank"
                                                                    href="{{ url('files/externalpractical') }}/{{ $template->marksheet }}">
                                                                    Download (Term {{ $subject->syear }})
                                                                </a>
                                                                <div >
                                                                    <button  type="button"
                                                                        class="btn btn-xs btn-warning upload-btn ">
                                                                        Re-upload
                                                                    </button>
                                                                    <span class="uploading hidden text-info small">Uploading, please wait...</span>
                                                                </div>
                                                                <div style="margin-top:5px;" >
                                                                    @if ($template->subjects->count() > 0)
                                                                            @foreach ($template->subjects as $subject)
                                                                            
                                                                            <a href="{{ url('practicalexam/awardlisttemplate') }}/{{ $template->id }}?subject_id={{ $subject->id }}"
                                                                                class="btn btn-xs btn-primary ">
                                                                                Enter Marks
                                                                            </a>                                                            
                                                                            @endforeach                                                    
                                                                    @endif
                                                                </div>
                                                                
                                                            </div>  
                                                            @endif
                                                        @else
                                                            <div class="upload-block col-form-label-sm text-center">
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
                                  @endif
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
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.upload-btn').forEach(btn => {

                btn.addEventListener('click', async function () {

                    let form = btn.closest('form');
                    let fileInput = form.querySelector('.file-input');
                    let uploadingText = form.querySelector('.uploading');

                    let latInput = form.querySelector('input[name="latitude"]');
                    let lngInput = form.querySelector('input[name="longitude"]');

                    const getLocation = (attempts = 1) => {
                        return new Promise((resolve, reject) => {
                            if (!navigator.geolocation) {
                                return reject('Geolocation not supported');
                            }

                            let tries = 0;

                            const tryOnce = () => {
                                tries++;
                                navigator.geolocation.getCurrentPosition(function (position) {
                                    if (position && position.coords && isFinite(position.coords.latitude) && isFinite(position.coords.longitude)) {
                                        return resolve(position);
                                    }
                                    if (tries < attempts) {
                                        setTimeout(tryOnce, 500 * tries);
                                    } else {
                                        reject('Invalid position');
                                    }
                                }, function (error) {
                                    if (error && error.code === error.PERMISSION_DENIED) {
                                        return reject('Permission denied');
                                    }
                                   
                                    if (tries < attempts) {
                                        setTimeout(tryOnce, 500 * tries);
                                    } else {
                                        try {
                                            let watchId = navigator.geolocation.watchPosition(function (pos) {
                                                navigator.geolocation.clearWatch(watchId);
                                                return resolve(pos);
                                            }, function (err2) {
                                                try { navigator.geolocation.clearWatch(watchId); } catch (e) {}
                                                return reject('Unable to get position');
                                            }, { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 });
                                        } catch (e) {
                                            return reject('Unable to get position');
                                        }
                                    }
                                }, { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 });
                            };

                            tryOnce();
                        });
                    };

                    // Try to get location first (more reliable UX) before opening file dialog
                    try {
                        const position = await getLocation(1);
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        latInput.value = Number(latitude);
                        lngInput.value = Number(longitude);
                    } catch (err) {
                        console.log(err)
                        if (typeof err === 'string' && err.toLowerCase().includes('permission')) {
                            alert('Location permission denied. Please enable location for this site and try again.');
                        } else {
                            alert('Could not get location. Please ensure location services are enabled and retry.');
                        }

                        latInput.value ='';
                        lngInput.value = '';
                    }

                    // Now open file picker
                    fileInput.click();

                    fileInput.onchange = function () {

                        const file = fileInput.files && fileInput.files[0];
                        if (!file) return;
                        const name = file.name || '';
                        const ext = name.split('.').pop().toLowerCase();
                        const mime = file.type || '';
                        if (ext !== 'pdf' && mime !== 'application/pdf') {
                            alert('Please choose a PDF file');
                            fileInput.value = '';
                            return;
                        }

                        if (!fileInput.files || fileInput.files.length === 0) return;
                        if (fileInput.files[0].size > 1000000) {
                            alert('Please choose file under 1MB');
                            fileInput.value = '';
                            return;
                        }

                        // Final sanity check: coordinates exist and look valid
                        const latVal = parseFloat(latInput.value);
                        const lngVal = parseFloat(lngInput.value);
                        // if (!isFinite(latVal) || !isFinite(lngVal)) {
                        //     alert('Location not available. Please try again.');
                        //     fileInput.value = '';
                        //     return;
                        // }

                        if (uploadingText) {
                            uploadingText.classList.remove('hidden');
                        }
                        btn.style.display = 'none';
                        form.submit();
                    };

                });

            });

        });
    </script>
@endsection
