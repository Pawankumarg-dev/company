@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3><i class="fa fa-arrow-right"> </i> Exam Applications, Mark Entry, Attendance Upload, Hall ticket & more  </h3>

                <hr />
            </div>
        </div>
        @include('common.errorandmsg')
        @foreach($exams as $exam)

            <?php $display = 0 ; ?>
            @foreach($approvedprogrammes->sortBy('academicyear_id') as $ap)
                <?php
                foreach($exam->programmegroups as $pg){
                    if($pg->id == $ap->programme->programmegroup->id){
                        if($ap->academicyear->order <= $exam->academicyear->order){
                            $display =1 ;
                        }
                    }
                }
                ?>
            @endforeach
            @if($display==1)

                <h4><i class="fa fa-calendar"></i> {{$exam->name}}
                    @if($exam->status_id==1)
                        <div class="pull-right">
                            <a href="{{url('qpdownload')}}/{{$exam->id}}" class="btn btn-xs btn-info">Question Papers</a>



                            <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#timetable"><i class="fa fa-table"></i>&nbsp;Time Table </button>

                            @include('institute.exam.timetable')

                        </div>
                    @endif
                </h4>
                <hr />

                {{-- Exam Attendance Upload
                @if($exam->id==2)
                    @include('institute.exam.attendance')
                @endif
                --}}

                <div class="row">
                    <div class="col-md-12">
                        @if($approvedprogrammes->count() > 0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Programme </th>
                                    <th>Programme Code</th>
                                    <th>Batch</th>
                                    <th>Links</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($approvedprogrammes->sortBy('academicyear_id') as $ap)
                                    <?php $isin = 0 ;
                                    foreach($exam->programmegroups as $pg){
                                        if($pg->id == $ap->programme->programmegroup->id){
                                            $isin =1 ;
                                        }
                                    }
                                    ?>
                                    @if($isin==1)
                                        @if($ap->academicyear->order <= $exam->academicyear->order)
                                            @if($exam->id == '7')
                                                @if($ap->academicyear->year != '2014')
                                                    <tr>
                                                        <td>
                                                            {{$ap->programme->name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->programme->course_name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->academicyear->year}}
                                                        </td>
                                                        <td>
                                                            @if($exam->status_id==1)
                                                                <a href="{{url('applications/'.$ap->id).'/'.$exam->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>

                                                                @if($exam->institute_markentry == 1)
                                                                    <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                                @endif

                                                                {{--
                                                                @if($ap->programme->programmegroup->mark_entry_institutes==1)
                                                                    <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                                @endif
                                                                --}}

                                                                @if($ap->programme->programmegroup->attendance_upload==1)
                                                                    <a href="{{url('halltickets/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance & Hallticket</a>
                                                                @endif
                                                            @elseif($exam->status_id==0)
                                                                @foreach($erd as $e)
                                                                    @if($e->exam_id == $exam->id)
                                                                        @if($e->programme_id == $ap->programme_id)
                                                                            @if($e->academicyear_id == $ap->academicyear_id)
                                                                                @if($e->publish_status == 1)
                                                                                    <a href="{{url('/result/'.$exam->id).'/'.$ap->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                                        <i class="fa fa-eye"></i> Result
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @else

                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @elseif($exam->id == '6')
                                                @if($ap->academicyear->year != '2014')
                                                    <tr>
                                                        <td>
                                                            {{$ap->programme->name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->programme->course_name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->academicyear->year}}
                                                        </td>
                                                        <td>
                                                            @if($exam->status_id==1)
                                                                <a href="{{url('applications/'.$ap->id).'/'.$exam->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>

                                                                @if($ap->programme->programmegroup->mark_entry_institutes==1)               <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                                @endif
                                                                @if($ap->programme->programmegroup->attendance_upload==1)
                                                                    <a href="{{url('halltickets/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance & Hallticket</a>
                                                                @endif
                                                            @elseif($exam->status_id==0)
                                                                @foreach($erd as $e)
                                                                    @if($e->exam_id == $exam->id)
                                                                        @if($e->programme_id == $ap->programme_id)
                                                                            @if($e->academicyear_id == $ap->academicyear_id)
                                                                                @if($e->publish_status == 1)
                                                                                    <a href="{{url('/result/'.$exam->id).'/'.$ap->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                                        <i class="fa fa-eye"></i> Result
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @else

                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @elseif($exam->id == '5')
                                                @if($ap->academicyear->year != '2014')
                                                    <tr>
                                                        <td>
                                                            {{$ap->programme->name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->programme->course_name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->academicyear->year}}
                                                        </td>
                                                        <td>
                                                            @if($exam->status_id==1)
                                                                <a href="{{url('applications/'.$ap->id).'/'.$exam->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>

                                                                @if($ap->programme->programmegroup->mark_entry_institutes==1)               <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                                @endif
                                                                @if($ap->programme->programmegroup->attendance_upload==1)
                                                                    <a href="{{url('halltickets/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance & Hallticket</a>
                                                                @endif
                                                            @elseif($exam->status_id==0)
                                                                @foreach($erd as $e)
                                                                    @if($e->exam_id == $exam->id)
                                                                        @if($e->programme_id == $ap->programme_id)
                                                                            @if($e->academicyear_id == $ap->academicyear_id)
                                                                                @if($e->publish_status == 1)
                                                                                    <a href="{{url('/result/'.$exam->id).'/'.$ap->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                                        <i class="fa fa-eye"></i> Result
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @else

                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @elseif($exam->id == '3')
                                                @if($ap->programme->id == '9' || $ap->programme->id == '11' ||
                                                    $ap->programme->id == '12' || $ap->programme->id == '13' ||
                                                    $ap->programme->id == '20')
                                                    <tr>
                                                        <td>
                                                            {{$ap->programme->name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->programme->course_name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->academicyear->year}}
                                                        </td>
                                                        <td>

                                                            @if($exam->status_id==1)
                                                                <a href="{{url('applications/'.$ap->id).'/'.$exam->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>

                                                                @if($ap->programme->programmegroup->mark_entry_institutes==1)               <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                                @endif
                                                                @if($ap->programme->programmegroup->attendance_upload==1)
                                                                    <a href="{{url('halltickets/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance & Hallticket</a>
                                                                @endif
                                                            @elseif($exam->status_id==0)
                                                                @foreach($erd as $e)
                                                                    @if($e->exam_id == $exam->id)
                                                                        @if($e->programme_id == $ap->programme_id)
                                                                            @if($e->academicyear_id == $ap->academicyear_id)
                                                                                @if($e->publish_status == 1)
                                                                                    <a href="{{url('/result/'.$exam->id).'/'.$ap->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                                        <i class="fa fa-eye"></i> Result
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                {{--}}
                                                                <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> &nbsp;&nbsp;Marks</a>
                                                                --}}
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endif
                                            @elseif($exam->id == '5')
                                                @if($ap->programme->id == '9' || $ap->programme->id == '21')
                                                    <tr>
                                                        <td>
                                                            {{$ap->programme->name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->programme->course_name}}
                                                        </td>
                                                        <td>
                                                            {{$ap->academicyear->year}}
                                                        </td>
                                                        <td>

                                                            @if($exam->status_id==1)
                                                                <a href="{{url('applications/'.$ap->id).'/'.$exam->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>

                                                                @if($ap->programme->programmegroup->mark_entry_institutes==1)               <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                                @endif
                                                                @if($ap->programme->programmegroup->attendance_upload==1)
                                                                    <a href="{{url('halltickets/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance & Hallticket</a>
                                                                @endif
                                                            @elseif($exam->status_id==0)
                                                                @foreach($erd as $e)
                                                                    @if($e->exam_id == $exam->id)
                                                                        @if($e->programme_id == $ap->programme_id)
                                                                            @if($e->academicyear_id == $ap->academicyear_id)
                                                                                @if($e->publish_status == 1)
                                                                                    <a href="{{url('/result/'.$exam->id).'/'.$ap->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                                        <i class="fa fa-eye"></i> Result
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                {{--}}
                                                                <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> &nbsp;&nbsp;Marks</a>
                                                                --}}
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr>
                                                    <td>
                                                        {{$ap->programme->name}}
                                                    </td>
                                                    <td>
                                                        {{$ap->programme->course_name}}
                                                    </td>
                                                    <td>
                                                        {{$ap->academicyear->year}}
                                                    </td>
                                                    <td>
                                                        @if($exam->status_id==1)
                                                            <a href="{{url('applications/'.$ap->id).'/'.$exam->id}}"  class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Exam Applications</a>

                                                            @if($ap->programme->programmegroup->mark_entry_institutes==1)               <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Marks Entry</a>
                                                            @endif

                                                            @if($ap->programme->programmegroup->attendance_upload==1)
                                                                <a href="{{url('halltickets/'.$ap->id).'/'.$exam->id}}" class="btn btn-primary btn-sm"><i class="fa fa-th"></i> &nbsp;&nbsp;Attendance & Hallticket</a>
                                                            @endif
                                                        @elseif($exam->status_id==0)
                                                            @foreach($erd as $e)
                                                                @if($e->exam_id == $exam->id)
                                                                    @if($e->programme_id == $ap->programme_id)
                                                                        @if($e->academicyear_id == $ap->academicyear_id)
                                                                            @if($e->publish_status == 1)
                                                                                <a href="{{url('/result/'.$exam->id).'/'.$ap->id}}" class="btn btn-info btn-sm" target="_blank">
                                                                                    <i class="fa fa-eye"></i> Result
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{--}}
                                                             <a href="{{url('marks/'.$ap->id).'/'.$exam->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> &nbsp;&nbsp;Marks</a>
                                                             --}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>

            @endif
        @endforeach
    </div>
    <script>
        function modalpop(id){
            $('#programme_id').val(id);
            $('#myForm').attr('action',"{{url('approvedprogramme')}}");
            $('#myModal').modal('show');
        }
        function editdata(pid,id,maxintake){
            $('#programme_id').val(pid);
            $('form').attr('action',"{{url('approvedprogramme')}}/"+id+"/edit");
            $('#myModal').modal('show');
            $('#maxintake').val(maxintake);
        }
        function deleteap(id){
            $('form').attr('action',"{{url('approvedprogramme')}}/"+id+"/delete");
            $('#myDeleteModal').modal('show');

        }
    </script>
@endsection
