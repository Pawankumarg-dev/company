<div class="row">

    <?php $sd = '' ; $count = 0; ?>
    @foreach($completedexams->sortByDesc('startdate') as $tt)
    @if(in_array($tt->subject->programme->id, $programme_ids))
    @if($tt->examattendances->count() >0)
    <?php $box = 'success'; $btn = 'link'; $tail = ' again' ?>
    @else
    <?php $box = 'warning'; $btn = 'danger'; $tail = ''; ?>
    @endif

    @if($tt->startdate!=$sd)
    @if($sd != '')

    </table>
</div>

@endif

<div class=" col-md-10 col-md-offset-1">
    <table class="table  alert alert-{{$box}} " >
        <?php $count += 1; ?>
        <tr>
            <td>
                <b>{{\Carbon\Carbon::parse($tt->startdate)->toFormattedDateString()}} &nbsp;
                    {{\Carbon\Carbon::parse($tt->startdate)->format('h:i A')}}</b>
            </td>
            <td>

                <button class="btn btn-xs btn-{{$btn}} pull-right" style="margin-left:10px;" data-toggle="modal" data-target="#upload_report_{{$tt->id}}"> <i class="fa fa-upload"></i> &nbsp; Upload Exam Attendance {{$tail}}</button>








                <div id="upload_report_{{$tt->id}}" class="modal fade modal-xs" role="dialog">
                    <div class="modal-dialog">

                        <form class="form-horizontal" action="{{url('exam/upload/report/'.$tt->id)}}" enctype="multipart/form-data" method='post' >
                            {!! csrf_field() !!}

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Upload Exam Attendance Report</h4>
                                    <input type="hidden" name='examtimetable_id' value="{{$tt->id}}" />

                                </div>
                                <div class="modal-body">
                                    @foreach($examattendancefiles as $eaf)
                                        <div class="form-group">
                                            <label class="control-label col-sm-6" for="document"> {{$eaf->description}}</label>
                                            <div class="col-sm-6">
                                                <input type="file" class="form-control" name="file[{{$eaf->id}}]"/>

                                            </div>
                                        </div>
                                    @endforeach









                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div></div>




            </td>
        </tr>

        @endif
        <tr>

            <td>
                {{$tt->subject->programme->course_name}} -
                {{$tt->subject->scode}}
            </td>
            <td>
                {{$tt->subject->sname}}
            </td>
        </tr>
        <?php $sd = $tt->startdate ; ?>

        @endif
        @endforeach
        @if($count!=0)
    </table></div>

@endif

</div>
</table>