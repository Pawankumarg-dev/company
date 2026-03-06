@extends('layouts.app')

@section('content')
<script>
    function validateFile(fileid) {
            var ext = $("#"+fileid).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf']) == -1){
                swal("Error Occurred!!!", "Please upload the scanned file in .pdf format only.", "error");
                $('#'+fileid).val(null);
                return false;
            }
            else if ($("#"+fileid)[0].files[0].size > 2097152) {
                swal("Error Occurred!!!", "Please upload the scanned file less than 2 MB file size.", "error");
                $("#"+fileid).val(null);
                return false;
            }
            else {
            }
        }
</script>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('common.errorandmsg')
                <h4>Mark Entry</h4>
                <h3>{{$ap->programme->name}} - {{$ap->academicyear->year}} Batch</h3>

                <table class="table table-bordered table-condensed table-hover table-sm">
                    <tr>
                        <th>Theory/Practical</th>
                        <th>Internal/External</th>
                        <th>Award List</th>
                    </tr>
                    <tr>
                        <td>Practical</td>
                        <td>Internal</td>
                        <td>
                            @if(!is_null($markentries) && !is_null($markentries->internal_practical))
                                <a href="{{url('files/markfiles/')}}/{{$markentries->internal_practical}}" target="_blank">Award List</a>
                            @else
                                <form action="{{url('institute/markentry/uploadawardlist')}}"   enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="approvedprogramme_id" value="{{$ap->id}}">
                                    <input type="hidden" name="type" value="internal_practical">
                                    <input type="file" class="form-control" id="internal_practical" name="internal_practical" onchange="validateFile('internal_practical')" >
                                    <button type="submit" class="btn btn-info btn-sm"> Upload</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Practical</td>
                        <td>External</td>
                        <td>
                            @if(!is_null($markentries) && !is_null($markentries->external_practical))
                                <a href="{{url('files/markfiles/')}}/{{$markentries->external_practical}}" target="_blank">Award List</a>
                            @else
                                <form action="{{url('institute/markentry/uploadawardlist')}}"   enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="approvedprogramme_id" value="{{$ap->id}}">
                                    <input type="hidden" name="type" value="external_practical">
                                    <input type="file" class="form-control" id="external_practical" name="external_practical" onchange="validateFile('external_practical')" >
                                    <button type="submit" class="btn btn-info btn-sm"> Upload</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Theory</td>
                        <td>Internal</td>
                        <td>
                            @if(!is_null($markentries) && !is_null($markentries->internal_theory))
                                <a href="{{url('files/markfiles/')}}/{{$markentries->internal_theory}}" target="_blank">Award List</a>
                            @else
                                <form action="{{url('institute/markentry/uploadawardlist')}}"   enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="approvedprogramme_id" value="{{$ap->id}}">
                                    <input type="hidden" name="type" value="internal_theory">
                                    <input type="file" class="form-control" id="internal_theory" name="internal_theory" onchange="validateFile('internal_theory')" >
                                    <button type="submit" class="btn btn-info btn-sm"> Upload</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered table-condensed table-hover table-sm">
                    <tr>
                        <th>
                            Type
                        </th>
                        <th>Term</th>
                        <th>
                            Subject Code
                        </th>
                        <th>
                            Subject
                        </th>
                        <th>Number of Students</th>
                        <th  class="center-text">
                            Internal 
                        </th>
                        <th  class="center-text">
                            External 
                        </th>
                        <th>Status</th>
                    </tr>
                    @foreach($subjects as $s)
                        <?php 
                            $c = $ap->applications->where('subject_id',$s->id)->count(); 
                            if($s->subjecttype_id == 1){
                                $e = $ap->applications->where('subject_id',$s->id)->whereIn('internalattendance_id',[1,2])->count(); 
                            }else{
                                $e = $ap->applications->where('subject_id',$s->id)->whereIn('internalattendance_id',[1,2])->whereIn('externalattendance_id',[1,2])->count(); 
                            }
                        ?>
                        @if($c > 0)
                            <tr>
                                <td>
                                    {{$s->subjecttype->type}}
                                </td>
                                <td>
                                    {{$s->syear}}
                                </td>
                                <td>
                                    {{$s->scode}}
                                </td>
                                <td>
                                    {{$s->sname}}
                                </td>
                                <td class="text-center">
                                    {{$c}}
                                </td>
                                <td  class="center-text">
                                    
                                    <a href="{{url('institute/markentry/internal')}}/{{$ap->id}}/{{$s->id}}" class="btn btn-xs btn-primary" >Mark Entry</a>
                                </td>
                                <td  class="center-text">
                                    @if($s->subjecttype_id == 2)
                                        @if(!($s->id == 854  || $s->id == 871))
                                            <a href="{{url('institute/markentry/external')}}/{{$ap->id}}/{{$s->id}}" class="btn btn-xs btn-primary" >Mark Entry</a>
                                        @endif
                                    @endif
                                    
                                </td>
                                <td>
                                    <?php
                                        if($e < $c){
                                            $status = 'Incomplete';
                                            $statusclass = "warning";
                                        }else{
                                            $status = 'Completed';
                                            $statusclass = "success";
                                        }
                                    ?>
                                    <span class="label label-{{$statusclass}}">{{$status}}</span>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
