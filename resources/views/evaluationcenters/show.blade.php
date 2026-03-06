@extends('layouts.app')
@section('content')
<script>
        function validateFile(btn) {
            var filename = '.filename_'+btn;
            var ext = $(filename).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf','png','jpg','jpeg']) == -1){
                swal("Error Occurred!!!", "Please upload the scanned file in .pdf/.png/.jpg/.jpeg format only.", "error");
                $(filename).val(null);
                return false;
            }
            else if ($(filename)[0].files[0].size > 1048576) {
                swal("Error Occurred!!!", "Please upload the scanned file less than 1 MB file size.", "error");
                $(filename).val(null);
                return false;
            }
            else {
                $('.ext_'+btn).val(ext);
                $('.btn-'+btn).attr('disabled',false);
            }

        }
</script>
<style>
        
    </style>
    <?php $markentry = 0; ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h6>June 2024  Examinations
                </h6>
                <h3>Answer booklet Bundles </h3>
                <?php $slno = 1; ?>
                <table class="table table-bordered  table-hover">
                    <tr>
                        <th>NBER</th>
                        <td>{{ $subject->programme->nber->name_code }}</td>
                    </tr>

                    <tr>
                        <th>Course</th>
                        <td>{{ $subject->programme->course_name }}</td>
                    </tr>
                    <tr>
                        <th>Subject Code</th>
                        <td>{{ $subject->scode }}</td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td>{{ $subject->sname }}</td>
                    </tr>
                </table>
                <table class="table table-bordered  table-hover">
                    <tr>
                        <th>Slno</th>
                        @if (!$is_deo)
                            <th>Exam Center</th>
                            <th>
                                Institute
                            </th>
                        @endif
                        <th>
                            Bundle Number
                        </th>
                        @if($attendance == 0)
                            @if (!$is_deo)
                                <th>
                                    Print Cover sheet for Bundles
                                </th>
                                <th>
                                    Print Foil Sheets
                                    <small>You may choose to print all langauages together or separate as required</small>
                                </th>
                            @endif
                            @if ($is_deo)
                                <th>Mark Entry</th>
                            @endif
                        @else
                            @if (!$is_deo)
                                <th colspan="2">Attendance Marking</th>
                            @endif
                        @endif
                    </tr>
                    @foreach ($applications as $ep)
                        <?php 
                            $ready = 0;
                            //$ep = $ep->approvedprogramme->exampapers()->where('subject_id',$subject->id)->first();
                            if(!is_null($ep)){
                                $ready =  (is_null($ep->attendance) || $ep->scan_copy == 0) ? 0 : 1;
                                
                            }
                        ?>
                        @if(!is_null($ep))
                            <tr 
                            {{--class="@if($ep->evaluated < $ep->present) bg-danger @else bg-success  @endif" --}}
                                class="@if(!$ready) bg-danger @else bg-sucess @endif @if($attendance==1 && $ready) hide @endif"
                            >
                                <td>
                                    {{ $slno }}
                                    <?php $slno++; ?>
                                </td>
                                <?php $dummy_code ='';
                                if(!is_null($ep->approvedprogramme->institute)){
                                    $dummy_code = $ep->approvedprogramme->institute->dummy_code;
                                }
                                ?>
                                @if (!$is_deo)
                                    <td>
                                        @if(!is_null($ep))
                                        {{$ep->externalexamcenter->code }}

                                        @endif

                                    </td>
                                    <td>
                                       
                                        {{ $dummy_code }}
                                    </td>
                                @endif
                                <td>
                                    {{ $ep->approvedprogramme->id }}-{{ $dummy_code }}-{{ $ep->approvedprogramme->programme->id }}-{{ $subject->id }}
                                </td>
                                @if($attendance == 0)
                                    @if (!$is_deo)
                                        <td class="text-center">
                                            @if(!is_null($ep->attendance))
                                            <a target="_blank" class="btn btn-xs btn-primary"
                                                href="{{ url('printcover') }}/{{ $ep->approvedprogramme->id }}/{{ $subject->id }}">
                                                Print Coversheet
                                            </a>
                                            @endif
                                        </td>
                                    
                                        <td>
                                            @if(!is_null($ep->attendance))
                                                <a target="_blank" class="btn btn-xs btn-primary"
                                                    href="{{ url('evaluationcenterfoilsheet') }}/{{ $ep->approvedprogramme->id }}/{{ $subject->id }}">
                                                    Print Foilsheet (All)
                                                </a>
                                                
                                                    
                                                        
                                                        @foreach($ep->languages as $l)
                                                        
                                                        <a target="_blank" class="btn btn-xs btn-info" style="margin-left:5px;"
                                                            href="{{ url('evaluationcenterfoilsheet') }}/{{ $ep->approvedprogramme->id }}/{{ $subject->id }}?language_id={{$l->id}}">
                                                            {{$l->language}}
                                                        </a>
                                                        @endforeach
                                                        
                                                    
                                                
                                            @endif
                                        </td>
                                    @endif
                                    @if ($is_deo)
                                    <td>
                                        <a target="_blank" class="btn btn-xs  @if($ep->evaluated < $ep->present) btn-success @else btn-warning @endif "
                                            href="{{ url('evaluationcentermarkentry') }}/{{ $ep->approvedprogramme->id }}/{{ $subject->id }}">
                                            Mark Entry
                                        </a>
                                        
                                    </td>
                                    @endif
                                @else
                                   
                                    @if(!$ready && !$is_deo)
                                        <td
                                            class="@if($ep->scan_copy == 0) bg-danger @else bg-success @endif"
                                        >
                                            <form action="{{url('evaluationcenter/attendancesheet')}}"   enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="approvedprogramme_id" value="{{$ep->approvedprogramme_id}}">
                                                <input type="hidden" name="subject_id" value="{{$ep->subject->id}}">
                                                <input type="hidden" name="examtimetable_id"  value="{{$ep->examtimetable_id}}">
                                                <input type="hidden" name="exampaper_id" value="{{$ep->id}}">
                                                <input type="hidden" class="ext_{{$ep->id}}" name="ext" />
                                            
                                                @if($ep->scan_copy == 0 || is_null($ep->attendance))
                                                    <span class="badge badge-yellow">
                                                    Choose Scanned copy of attendance sheet
                                                    </span>
                                                @else
                                                <span class="badge badge-success">
                                                    Uploaded
                                                </span> 
                                                <a href="{{url('files/examattendancefiles/')}}/{{$ep->filename}}" target="_blank">Download</a>
                                                @endif 
                                                <input type="file" class="form-control filename_{{$ep->id}}" id="filename" name="filename" onchange="validateFile({{$ep->id}})" style="background:transparent;border:none;">
                                                <button type="submit" class="btn  @if($ep->scan_copy != 0) btn-primary @else  btn-light @endif  btn-xs btn-{{$ep->id}}" disabled>  
                                                    @if($ep->scan_copy == 0) Upload @else Re-upload  @endif
                                                </button>
                                            </form>
                                        </td>
                                        <?php 
                                        //  $saids = \App\Newapplicant::where('approvedprogramme_id',$ep->approvedprogramme_id)->get()->pluck('id')->toArray();
                                        //  $marked = \App\Newapplication::whereIn('newapplicant_id',$saids)->where('subject_id',$subject->id)->whereIn('externalattendance_id',[1,2])->count();
                                        ?>
                                        <td
                                            class="@if($ep->attendance == 0) bg-danger @else bg-success @endif" 
                                        >
                                            <a href="{{url('evaluationcenter/attendance')}}/{{$ep->approvedprogramme_id}}?subject_id={{$ep->subject_id}}&examschedule_id={{$ep->examschedule_id}}" class="btn @if(($ep->attendance == 0)) btn-danger @else btn-success @endif--}} btn-sm">Mark Attendance</a>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
