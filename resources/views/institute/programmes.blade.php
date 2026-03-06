@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">

                <div class="jumbotron">

                    <p>Please upload the RCI approval letter to begin enrolment.</p>

                    <p>Please start by adding approved programmes.</p>

                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-plus" style="color: blue;"></i>&nbsp;&nbsp;Programmes
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <?php
                            $list = $approvedprogrammes->lists('programme_id')->toArray();
                            ?>
                            @foreach($programmes as $p)
                                @if($p->active_status == '1')
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:modalpop({{$p->id}});">{{$p->course_name}} - {{$p->name}}</a></li>
                                    @endif

                                {{--
                                @if(!in_array($p->id,$list))
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:modalpop({{$p->id}});">{{$p->course_name}} - {{$p->name}}</a></li>
                                @endif
                                --}}
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-12">

                <!--
            <div class="jumbotron">
            <p>
            June 2018 Examination Applications are open.
            </p>
            <p>Please follow the 'Exam Applications' links below. </p>
             </div>
             -->
                <h3><i class="fa fa-list"> </i> Programmes and Candidates</h3>
                <hr />
            </div>

            <!--
                        <div class="col-md-6">


                        <div class="jumbotron">
                        <p>
                            <b>June 2018 Examination Attendance and Halltickets Links are open.</b>
                        </p>
                            <p><b>Please follow the <u>'Attendance and Hallticket'</u> link below.</b></p>
                         </div>

                         </div>
            -->


        </div>

    @include('common.errorandmsg')
    <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload RCI Approval</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                        <form action="{{url('approvedprogramme')}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="container">
                                <div class="form-group">
                                    <label for="filename">RCI Approval Letter</label>
                                    <input type='file' id='filename_0'  name='filename[0]' />
                                    <input type='file' id='filename_1'  name='filename[1]' class="hidden" />
                                    <input type='file' id='filename_2'  name='filename[2]' class="hidden"/>
                                    <input type='file' id='filename_3'  name='filename[3]' class="hidden"/>
                                    <input type='file' id='filename_4'  name='filename[4]' class="hidden"/>
                                    <br />
                                    <a href="javascript:addfile();" id='addlink'>Add more document</a>
                                    <input type='hidden' value="1" id="filecount">
                                    <script>
                                        function addfile(){
                                            var c = $('#filecount').val();


                                            $('#filename_'+c).removeClass('hidden');
                                            $('#filecount').val(parseInt(c)+1);
                                            if(c==4){
                                                $('#addlink').addClass('hidden');
                                            }

                                        }
                                    </script>
                                </div>

                                <div class="form-group">
                                    <label for="email">Maximum intake</label>
                                    <input type='number' name='maxintake' id='maxintake' value="25" style="width:40px;"  min="0"/>
                                </div>
                            </div>
                            <input type='hidden' name="status_id" value='1' />
                            <input type='hidden' name='user_id' id='user_id' value="{{Auth::user()->id}}" />
                            <input type="hidden" name='institute_id' id='institute_id' value="{{$institute->id}}" />
                            <input type='hidden' name='programme_id' id='programme_id' value='' />
                            <input type="hidden" name='academicyear_id' id='academicyear_id' value='6' />
                            <label></label>



                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Upload</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if($approvedprogrammes->count() > 0)
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Programme </th>
                            <th>Maximum Intake</th>
                            <th>Enrolled</th>
                            <th>RCI Approval Letter</th>
                            <th>Batch</th>

                            <th></th>


                            <th>Links</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($approvedprogrammes->sortBy('academicyear_id') as $ap)

                            <tr>
                                <td>{{$ap->programme->course_name}}</td>
                                <td>{{$ap->maxintake}}</td>
                                <td>
                                    {{$ap->candidates()->count()}}
                                    <a href="{{url('pdf')}}/{{$ap->id}}" class="btn btn-link" style="margin-right: 10px!important;"><i class="fa fa-print"></i></a>
                                </td>
                                <td>
                                    @foreach($ap->programmeapprovalfiles as $f)
                                        <i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<a href="{{url('files/rciapproval/'.$f->filename)}}" target="_blank" >{{$f->filename}}</a>&nbsp;&nbsp;
                                        @if($ap->programme->programmegroup->enrolment==1)
                                            <a href="{{url('deleteapfile').'/'.$f->id}}"> <i class="fa fa-times-circle"></i></a> <br />
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    {{$ap->academicyear->year}}
                                </td>


                                <td>
                                    @if($ap->programme->programmegroup->enrolment==1)
                                        @if($ap->academicyear->current==1)
                                            @if($ap->programme->programmegroup->enrolment==1)
                                                @if($ap->academicyear_id==6)
                                                    <button onclick="javascript:editdata({{$ap->programme->id}},{{$ap->id}},{{$ap->maxintake}});" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</button>&nbsp;&nbsp;
                                                    <button  onclick="javascript:deleteap({{$ap->id}});" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Delete</button>
                                                @endif
                                            @endif

                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($ap->programme->programmegroup->enrolment==1)
                                        @if($ap->academicyear->current==1)
                                            <a href="{{url('programme/'.$ap->id)}}"  class="btn btn-default btn-sm"><i class="fa fa-users"></i> &nbsp;&nbsp;Enrolment</a>
                                        @else
                                            <a href="{{url('programme/'.$ap->id)}}"  class="btn btn-default btn-sm"><i class="fa fa-users"></i> &nbsp;&nbsp;Candidates</a>
                                        @endif
                                    @else
                                        <a href="{{url('programme/'.$ap->id)}}"  class="btn btn-default btn-sm"><i class="fa fa-users"></i> &nbsp;&nbsp;Candidates</a>
                                    @endif


                                    {{--
                                            <a href="{{url('studentlogin/'.$ap->id)}}"  class="btn btn-default btn-sm"><i class="fa fa-key"></i> &nbsp;&nbsp;Student Login</a> --!}}
                                    --}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                <form name='myForm' action="{{url('approvedprogramme')}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">

                    <div id="myDeleteModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Confirm</h4>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Confirm Delete?
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger" >Delete</button>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Upload RCI Approval</h4>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        {!! csrf_field() !!}
                                        <div class="container">
                                            <div class="form-group">
                                                <label for="filename">RCI Approval Letter</label>
                                                <input type='file' id='filename'  name='filename' />
                                            </div>

                                            <div class="form-group">
                                    <p>Hi</p>
                                </div>
                            <!--
                                        <div class="form-group">
                                            <label for="academicyear_id">Batch</label>
                                            {{--
                                            {{$batches = $ap->academicyear->whereIn('id', [1,2])->get()}}
                                            <select class="form-control" name="academicyear_id">
                                                @foreach($batches as $batch)
                                                    <option value="{{$batch->id}}">{{$batch->year}}</option>
                                                @endforeach
                                            </select>
                                            --}}
                                    </div>
-->

                                <div class="form-group">
                                    <label for="email">Maximum intake</label>
                                    <input type='number' name='maxintake' id='maxintake' value="25" style="width:40px;"  min="0"/>
                                </div></div>
                            <input type='hidden' name="status_id" value='0' />
                            <input type='hidden' name='user_id' id='user_id' value="{{Auth::user()->id}}" />
                            <input type="hidden" name='institute_id' id='institute_id' value="{{$institute->id}}" />
                            <input type='hidden' name='programme_id' id='programme_id' value='' />
                            <input type="hidden" name='academicyear_id' id='academicyear_id' value='6' />
                            <label></label>



                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" >Upload</button>
                        </div>

                    </div>

            </div>
        </div>



        </form>
    </div>
    </div>
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
