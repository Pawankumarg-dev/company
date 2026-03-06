@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>Classroom Attendance and Internal Marks</h4>
                <h6>{{ $approvedprogramme->institute->rci_code }} - {{ $approvedprogramme->institute->rci_name }}</h6>
                <h6><b>{{ $approvedprogramme->programme->course->name }}</b> <small>Rev. {{ $approvedprogramme->programme->revision_year }}</small></h6>
                <h6>Batch: <b> {{ $approvedprogramme->academicyear->year }}</b></h6>
            </div>
        </div>
        @if($attendances->count() > 0 )
            
            <h4>Classroom Attendance
            {{-- @if(!is_null($attendances->first()->attendance_t)) --}}
                <a  class="pull-right btn btn-xs btn-primary" style="margin-bottom: 10px;" target="_blank" href="{{ url('files/attendance/') }}/{{ $attendances->first()->document_t }}">
                    <span class="fa fa-download"></span> &nbsp;Attendance Theory
                </a>
                <a  class="pull-right btn btn-xs btn-primary " style="margin-right: 10px;margin-bottom:10px;" target="_blank" href="{{ url('files/attendance/') }}/{{ $attendances->first()->document_p }}">
                    <span class="fa fa-download"></span> &nbsp;Attendance Practical
                </a>
            {{-- @endif --}}
            </h4>
            <table class="table table-contensed table-stripped table-bordered">
                <tr>
                    <th>Slno</th>
                    <th>Enrolment No</th>
                    <th>Candidate Name</th>
                    <th>Attendance Theory</th>
                    <th>Attendance Practical</th>
                </tr>
                <?php $slno = 1; ?>
                @foreach($attendances as $a)
                    <tr>
                        <td>
                            {{ $slno }}
                            <?php $slno++ ; ?>
                        </td>
                        <td>
                            {{ $a->enrolmentno }} 
                        </td>
        
                        <td>
                            {{ $a->name }}
                            @if($a->status != 'Verified')
                            <small>{{ $a->status }}</small>
                            @endif
                        </td>
                        <td>
                            {{ $a->attendance_t }}
                        </td>
                        <td>
                            {{ $a->attendance_p }}
                        </td>
                    </tr>
                @endforeach 
            </table>
            <h3>Internal Marks</h3>
            <ul class="nav nav-tabs">
                <li  class="active" ><a   data-toggle="tab" href="#tt1"> Theroy - Term I</a></li>
                <li  ><a   data-toggle="tab" href="#tp1"> Practical - Term I</a></li>
                @if($approvedprogramme->academicyear_id < 12 && $approvedprogramme->programme->numberofterms == 2)
                    <li ><a   data-toggle="tab" href="#tt2"> Theroy - Term II</a></li>
                    <li  ><a   data-toggle="tab" href="#tp2"> Practical - Term II</a></li>
                @endif
            </ul>
            
            <div class="tab-content">
                <div id="tt1" class="tab-pane fade in active">
                    <?php 
                        $subjects = $internals['theory']['term1']['subjects']; 
                        $internal  = $internals['theory']['term1']['marks']; 
                        $title = "Theory Term I";
                        $filename = "mstt1";
                    ?>
                    @include('nber.verify.classroomattendanceandinternals.internal')
                </div>
                <div id="tp1" class="tab-pane fade in active">
                    <?php 
                        $subjects = $internals['practical']['term1']['subjects']; 
                        $internal  = $internals['practical']['term1']['marks']; 
                        $title = "Practical Term I";
                        $filename = "mspt1";
                    ?>
                    @include('nber.verify.classroomattendanceandinternals.internal')
                </div>
                @if($approvedprogramme->academicyear_id < 12 && $approvedprogramme->programme->numberofterms == 2)
                    <div id="tt2" class="tab-pane fade in active">
                        <?php 
                            $subjects = $internals['theory']['term2']['subjects']; 
                            $internal  = $internals['theory']['term2']['marks']; 
                            $title = "Theory Term II";
                            $filename = "mstt2";
                        ?>
                        @include('nber.verify.classroomattendanceandinternals.internal')
                    </div>
                    <div id="tp2" class="tab-pane fade in active">
                        <?php 
                            $subjects = $internals['practical']['term2']['subjects']; 
                            $internal  = $internals['practical']['term2']['marks']; 
                            $title = "Practical  Term II";
                            $filename = "mspt2";
                        ?>
                        @include('nber.verify.classroomattendanceandinternals.internal')
                    </div>
                @endif
            </div>
        
        @endif
    </div>
@endsection
