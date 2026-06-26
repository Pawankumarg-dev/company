@extends('layouts.app')
@section('content')
    <main>
        <style>
            .bg{
                background: #f3f3f3;
            }
            th{
                background-color: #F39532;
                color: #333;
            }
        </style>

                    @include('common.errorandmsg')

        <div class="container">
            <div class="row">

              
                <div class="col-sm-12">
                       <div class="alert alert-success">
                    <ul>
                        


                        <li>
                            As per the June 2026 Exam schedule, attendance uploading and internal marks updating will close on 18-05-2026.
                        </li>
                       <li>
                            For any issues, please contact the concerned NBER-NI.
                        </li>
                       <li>
                           Please refer to Scheme of Examination 2026, section B & C for examination related guidelines.
                        </li>
                    </ul>
                </div>


                 <div class="alert alert-success ">


        <h5 class="text-primary">
            Payment Notice: Affiliation & Registration Fees
        </h5>

        <p>
            Payment of Affiliation Fees for the academic years <strong>2024–25 & 2025–26</strong> and enrolment (registration) fees of students must be paid as per norms in SOE.
        </p>

        <ul>
            <li><strong>Affiliation Fees:</strong> Rs 10,000/- (per batch / per year)</li>
            <li><strong>Registration Fees:</strong> Rs 500/- (per student)</li>
        </ul>

        <p>
            Fees may be paid through the <strong>payment gateway</strong>. If already paid, details must be submitted in the format provided on the dashboard.
        </p>

        <p class="text-danger">
            <strong>Note:</strong> In case of non-receipt of the above-mentioned fees, hall tickets may not be generated.
        </p>

    </div> 
                    <h4>
                    {{$exam->name}} Examinations
                    </h4>

                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2" width="5%" class="center-text">Batch</th>
                                <th rowspan="2" class="center-text">Course</th>
                                <th rowspan="2" class="center-text" >Classroom Attendance</th>
                                <th rowspan="1" colspan="2" style=""  class="center-text  ">Internal Marks</th>
                                <th rowspan="1" colspan="1" style="display:none;"  class="center-text  ">External Marks</th>
                                <th rowspan="2" class="center-text"> Exam Applications / Hall ticket / Result</th>
                            </tr>
                            
                            <tr class="">
                                <th class="center-text ">
                                    Theory
                                </th>
                                <th class="center-text ">
                                    Practical
                                </th>
                                <th class="center-text hidden ">
                                    Practical
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $batch = 0; $class="bg"; $previousclass = 'nonbg'; $tclass= '';?>
                        @foreach($approvedprogrammes as $approvedprogramme)
                            <?php 
                                $year = $approvedprogramme->academicyear->year; 
                                if($batch!=$year){
                                    $tclass = $class;
                                    $class = $previousclass;
                                    $previousclass = $tclass;
                                    $batch = $year;
                                }
                            ?>
                            <tr class="{{$class}}">
                               <?php
                               $kk=0;
                               $date = \Carbon\Carbon::today()->toDateString();
                                $record = \App\Internalmarksheet::where('approvedprogramme_id', $approvedprogramme->id)
                                    ->where('exam_id', $exam->id)
                                    ->first();


                              $allowedYears = [11, 12, 13, 14, 15, 16];

                                    if ($date < '2026-05-19' && (($record && $record->verified != 1) || ($exam->id == 29 && in_array($approvedprogramme->academicyear_id, $allowedYears)))) {
                                        $kk = 0;
                                    }

                                    if($approvedprogramme->id==11039 && $date < '2026-06-08'){
                                      $kk = 1;  
                                    }



                                ?>
                                <td class="center-text">{{ $year }}</td>
                                <td>{{ $approvedprogramme->programme->course_name }}</td>
                                <td class="center-text ">
                                    {{--@if($exam->download_marksheet == 1)
                                        <a href="{{ url('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id) }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-th"></i> &nbsp;&nbsp;  Marksheet and Certificates
                                    </a>
                                    @endif--}}
                                   {{-- @if($exam->attendance_upload == 1) --}}
                                    @if($kk==1)

                                     @if($approvedprogramme->academicyear_id !=12)
                                        <a href="{{url('attendanceupload/'.$approvedprogramme->id).'/'.$exam->id.'/1'}}" class="btn btn-primary btn-xs"><i class="fa fa-th"></i> &nbsp;&nbsp;Term 1</a>
                                    @endif

                                        @if($approvedprogramme->programme->numberofterms==2 && $approvedprogramme->academicyear_id < 14)

                                        <a href="{{url('attendanceupload/'.$approvedprogramme->id).'/'.$exam->id.'/2'}}" class="btn btn-primary btn-xs"><i class="fa fa-th"></i> &nbsp;&nbsp;Term 2</a>
                                        @endif
                                        @endif
                                </td>

                                <td class="center-text">

                                    @if($kk==1 && $approvedprogramme->programme_id !=57)

                                        <?php $subjecttype_id = 1 ?>
                                        @include('institute.exam.home._markentrylinks')
                                    @endif
                                </td>


                                <td class="center-text" >
                                    @if($kk==1 && $approvedprogramme->programme_id !=57)
                                        <?php $subjecttype_id = 2 ?>
                                        @include('institute.exam.home._markentrylinks')
                                    @endif
                                </td>

                                <td class="hidden">
                                    @if( $exam->id == 26 && ($approvedprogramme->programme_id == 57 || ($approvedprogramme->id==8797 && $approvedprogramme->institute_id==1031)))
                                        <a 
                                        href="{{url('institute/exam/practicalmarkentry')}}/{{$approvedprogramme->id}}?exam_id={{$exam->id}}&subjecttype_id=2&syear=1"
                                        class = "btn-primary btn-xs hidden"
                                        style="margin-left:10px;margin-top:5px;"
                                        >
                                        External Practical 
                                        </a>
                                    @endif
                                </td>
                                
                                <td class="center-text" >
                                    @if($exam->id!=30)
                                    <a 
                                        href="{{url('institute/exam/applicants?exam_id=')}}{{$exam->id}}&approvedprogramme_id={{$approvedprogramme->id}}"
                                        class="btn btn-primary btn-sm "
                                        style="margin-left:10px;"
                                    >
                                    <i class="fa fa-clone"></i> &nbsp;&nbsp;
                                         @if($exam->publish_result ==1 && $exam->id < 30 )  Result @else Exam Applications @endif
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
