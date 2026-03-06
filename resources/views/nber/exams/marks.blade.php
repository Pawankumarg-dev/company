@extends('layouts.smalltable')
@section('content')
    <style>
        .mark{
            width:30px!important;
            margin:0!important;
            line-height: 10px!important;
            background-color: transparent;
            padding: 0 2px;
            border: 1px dotted;
            text-align: right;

        }
        .newbg{
            background-color: yellow;
        }
        .success{
            background-color: lightgreen;
        }
        .disabled{
            background-color: #DDDDDD;
        }
        .danger{
            background-color: red;
        }
        .pass{
            color:green;
            border-color: green;
        }
        .fail{
            color:red;
            border-color: orange;
        }
        .small{
            font-size:8px!important;
        }
        .markheading{
            width:100px!important;
        }
    </style>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
@endsection
@section('table')
    <tr>
        {!! Form::tbHeading('Enrolled Year (Batch)','ay',$academicyears,'year') !!}
        <td>Name</td>
        {!! Form::tbHeading('Enrolment No','cid',$enrolmentnumbers,'enrolmentno') !!}

        <td class="markheading">Mark Internal</td>
        <td class="markheading">Mark External</td>
        <td>Grace Mark</td>
        <td  class="markheading">Total<br /><a href="#"> <i class="fa fa-refresh"> </i> </a></td>

        {!! Form::tbHeading('Subject Code','sid',$subjects,'scode') !!}
        {!! Form::tbHeading('Subject Name','sid',$subjects,'sname') !!}
        {!! Form::tbHeading('Subject Type','stid',$types,'type') !!}


        <td>
            Term
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    @if(Request::has('tid'))
                        @foreach($terms as $a)
                            @if($a==Request::input('tid'))
                                {{$a}}
                            @endif
                        @endforeach
                    @else
                        All
                    @endif
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    @if(Request::has('tid'))
                        <li><a href="{{ Request::url() }}?{{ http_build_query(Request::except('page','tid'))}}">All</a></li>
                    @endif
                    @foreach($terms as $a)
                        <li>
                            @if(Request::has('tid'))
                                @if($a!=Request::input('tid'))
                                    <a href="{{ Request::url() }}?{{ http_build_query(Request::except('page','tid'))}}&tid={{$a}}">
                                        {{$a}}
                                    </a>
                                @endif
                            @else
                                <a href="{{ Request::url() }}?{{ http_build_query(Request::except('page','tid'))}}&tid={{$a}}">
                                    {{$a}}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>

            </div>
        </td>

    </tr>

    @foreach($collections as $c)
        <tr>
            {!! Form::tbText('year',$c->candidate->approvedprogramme->academicyear) !!}
            {!! Form::tbText('name',$c->candidate) !!}
            {!! Form::tbText('enrolmentno',$c->candidate) !!}

            <td>
                <span class="small">{{$c->subject->imin_marks}} </span>
                @if(!empty($c->mark))
                    <input id='IN_{{$c->candidate->id}}_{{$c->subject->id}}'  value="{{$c->mark->internal}}"   inex="IN" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}" class="mark" @if( $c->mark->internal < $c->subject->imin_marks  ) class="mark  fail" @else class="mark  pass" @endif   min="{{$c->subject->imin_marks}}" max="{{$c->subject->imax_marks}}"  aid="{{$c->id}}"  />
                @else
                    <input id='IN_{{$c->candidate->id}}_{{$c->subject->id}}'   inex="IN" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}"  class="mark" min="{{$c->subject->imin_marks}}" max="{{$c->subject->imax_marks}}"  aid="{{$c->id}}" />
                @endif
                <span class="small">{{$c->subject->imax_marks}} </span>
                <div class="dropdown dropdown-left pull-right" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{url('markabsnber')}}/{{$c->id}}/IN">Mark Absent</a></li>
                    </ul>

                </div>
            </td>
            <td>
                <span class="small">{{$c->subject->emin_marks}} </span>
                @if(!empty($c->mark))
                    <input id='EX_{{$c->candidate->id}}_{{$c->subject->id}}'  value="{{$c->mark->external}}"   inex="EX" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}" class="mark" @if( $c->mark->external < $c->subject->emin_marks  ) class="mark  fail" @else class="mark  pass" @endif   min="{{$c->subject->emin_marks}}" max="{{$c->subject->emax_marks}}"  aid="{{$c->id}}"  />
                @else
                    <input id='EX_{{$c->candidate->id}}_{{$c->subject->id}}'   inex="EX" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}"  class="mark" min="{{$c->subject->emin_marks}}" max="{{$c->subject->emax_marks}}"  aid="{{$c->id}}" />
                @endif
                <span class="small">{{$c->subject->emax_marks}} </span>
                <div class="dropdown dropdown-left pull-right" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{url('markabsnber')}}/{{$c->id}}/EX">Mark Absent</a></li>
                    </ul>
                </div>
            </td>
            <td>
                @if(!empty($c->mark))
                    <input id="GR_{{$c->candidate->id}}_{{$c->subject->id}}" class="mark" value="{{$c->mark->grace}}" inex="GR" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}"  aid="{{$c->id}}">
                @else
                    <input id="GR_{{$c->candidate->id}}_{{$c->subject->id}}" class="mark" value="0" inex="GR" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}"  aid="{{$c->id}}">
                @endif
            </td>
            <td>
                <?php
                $total = '';
                $totalmin = '';
                $totalmax = '';
                if(!empty($c->mark)){

                $totalmin = $c->subject->imin_marks + $c->subject->emin_marks;
                $total = (int) $c->mark->internal + (int) $c->mark->external + (int) $c->mark->grace ;

                $totalmax = $c->subject->imax_marks + $c->subject->emax_marks;

                ?>

                @if($c->mark->internal!='Abs' && $c->mark->external !='Abs')
                    <span class="small">{{$totalmin}}</span>
                    @if($total<$totalmin)
                        <span class="label label-danger">{{$total}}</span>
                    @else
                        <span class="label label-success">{{$total}}</span>
                    @endif


                    <span class="small">{{$totalmax}}</span>
                @endif
                <?php } ?>
                @if(!empty($c->mark))
                    @if($c->mark->result_id=='1')
                        Pass


                    @endif
                @endif
            </td>
            {!! Form::tbText('scode',$c->subject) !!}
            {!! Form::tbText('sname',$c->subject) !!}
            {!! Form::tbText('type',$c->subject->subjecttype) !!}
            {!! Form::tbText('syear',$c->subject) !!}

        </tr>
    @endforeach
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            var $tbody = $('table tbody');
            $tbody.find('tr').sort(function(a,b){
                var tda = $(a).find('td:eq(2)').text(); // can replace 1 with the column you want to sort on
                var tdb = $(b).find('td:eq(2)').text(); // this will sort on the second column
                // if a < b return 1
                return tda < tdb ? -1
                    // else if a > b return -1
                    : tda > tdb ? 1
                        // else they are equal - return 0
                        : 0;
            }).appendTo($tbody);
        });
        $('.mark').on('change',function(){
            $(this).addClass('newbg');
            var mark = parseInt($(this).val());
            var min = parseInt($(this).attr('min'));
            var max = parseInt($(this).attr('max'));
            var inex = $(this).attr('inex');
            console.log(max);
            console.log(min);
            console.log(mark);
            if((inex=='GR')||((mark >= 0) && (mark <= max))){
                console.log('p1');
                if(inex!='GR'){
                    if(mark >= min){
                        $(this).removeClass('fail');
                        $(this).addClass('pass');
                    }else{
                        $(this).removeClass('pass');
                        $(this).addClass('fail');
                    }
                }
                var formData = new FormData();
                var token = $('input[name=_token]');

                formData.append('mark', $(this).val());
                formData.append('inex', $(this).attr('inex'));
                formData.append('cid', $(this).attr('cid'));
                formData.append('sid', $(this).attr('sid'));
                formData.append('aid',$(this).attr('aid'));

                $.ajax({
                    url: '{{url("markupdate")}}',
                    method: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    data: formData,
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (data) {
                        if (data.status === 422) {
                            console.log(data);
                        }
                        else {
                            console.log('updated');
                            console.log(data.responseText);
                            $('#'+data.responseText).removeClass('newbg');
                            $('#'+data.responseText).removeClass('danger');
                            $('#'+data.responseText).addClass('success');
                            /*
                            swal({
                                title: 'Updated!',
                                text: '',
                                timer: 1000,
                                showCancelButton: false,
                                showConfirmButton: false
                            }).then(
                                function () {},
                                // handling the promise rejection
                                function (dismiss) {
                                    if (dismiss === 'timer') {
                                        //console.log('I was closed by the timer')
                                    }
                                }
                            );
                            */
                        }
                    }
                });

            }else{
                console.log('p2');
                $(this).removeClass('success');
                $(this).removeClass('pass');
                $(this).removeClass('newbg');
                $(this).addClass('danger');
                swal("Not updated", "Mark entered is invalid", "error");
            }
        });

    </script>
@endsection