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
            border-color: red;
        }
        .markheading{
            width:100px!important;
        }
    </style>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
@endsection
@section('table')
    <tr>


        {!! Form::tbHeading('Enrolment No','cid',$enrolmentnumbers,'enrolmentno') !!}

        <th>
            Name

        </th>
        {!! Form::tbHeading('Subject Code','sid',$subjects,'scode') !!}
        {!! Form::tbHeading('Subject Name','sid',$subjects,'sname') !!}
        {!! Form::tbHeading('Subject Type','stid',$types,'type') !!}


        <th>
            Term

        </th>

        <th class="markheading">Minimum Internal Mark</th>
        <th class="markheading">Maximum Internal Mark</th>
        <th class="markheading">Mark Internal secured</th>

        <th class="markheading">Minimum External Mark</th>
        <th class="markheading">Maximum External Mark</th>
        <th class="markheading">Mark External secured</th>
        <td>Result</td>

    </tr>
    @foreach($collections as $c)
        <tr>
            {!! Form::tbText('enrolmentno',$c->candidate) !!}
            {!! Form::tbText('name',$c->candidate) !!}
            {!! Form::tbText('scode',$c->subject) !!}
            {!! Form::tbText('sname',$c->subject) !!}
            {!! Form::tbText('type',$c->subject->subjecttype) !!}
            {!! Form::tbText('syear',$c->subject) !!}
            {!! Form::tbText('imin_marks',$c->subject) !!}
            {!! Form::tbText('imax_marks',$c->subject) !!}
            <td>
                @if(!empty($c->mark))
                    <input id='IN_{{$c->candidate->id}}_{{$c->subject->id}}'  value="{{$c->mark->internal}}"   inex="IN" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}"  min="{{$c->subject->imin_marks}}" max="{{$c->subject->imax_marks}}"  aid="{{$c->id}}"  @if( $c->mark->internal < $c->subject->imin_marks && $c->mark->internal != NULL) class="mark  fail" @else class="mark pass" @endif @if($exam->status_id != 1) disabled=='true' @endif />
                @else
                    <input id='IN_{{$c->candidate->id}}_{{$c->subject->id}}'  class="mark" inex="IN" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}"  min="{{$c->subject->imin_marks}}" max="{{$c->subject->imax_marks}}" aid="{{$c->id}}" @if($exam->status_id != 1) disabled=='true' @endif />
                @endif
                @if($exam->status_id == 1)
                    <div class="dropdown dropdown-left pull-right" >
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{url('markabs')}}/{{$c->id}}/IN">Mark Absent</a></li>
                        </ul>

                    </div>
                @endif
            </td>

            @if($c->subject->subjecttype->type=='Practical')
                {!! Form::tbText('emin_marks',$c->subject) !!}
                {!! Form::tbText('emax_marks',$c->subject) !!}
                <td>
                    @if(!empty($c->mark))
                        <input id='EX_{{$c->candidate->id}}_{{$c->subject->id}}'  value="{{$c->mark->external}}"
                               inex="EX" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}"
                               @if($c->subject->subjecttype->type=='Theory') disabled=='true' class="mark disabled"
                               @else
                               @if( $c->mark->external < $c->subject->emin_marks  ) class="mark  fail"
                               @else class="mark  pass"
                               @endif
                               @endif
                               min="{{$c->subject->emin_marks}}" max="{{$c->subject->emax_marks}}"  aid="{{$c->id}}"
                               @if($exam->status_id != 1) disabled=='true'
                                @endif  />
                    @else
                        <input id='EX_{{$c->candidate->id}}_{{$c->subject->id}}'   inex="EX" cid="{{$c->candidate->id}}"
                               sid="{{$c->subject->id}}"
                               @if($c->subject->subjecttype->type=='Theory') disabled=='true'  class="mark disabled "
                               @else class="mark"
                               @endif    min="{{$c->subject->emin_marks}}" max="{{$c->subject->emax_marks}}"  aid="{{$c->id}}"
                               @if($exam->status_id != 1) disabled=='true'
                                @endif />
                    @endif
                    @if($c->subject->subjecttype->type=='Practical')
                        @if($exam->status_id == 1)
                            <div class="dropdown dropdown-left pull-right" >
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{url('markabs')}}/{{$c->id}}/EX">Mark Absent</a></li>
                                </ul>

                            </div>
                        @endif
                    @endif
                </td>

            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
            {{--}}
            <td>
                @if(!empty($c->mark))
                    <input id='EX_{{$c->candidate->id}}_{{$c->subject->id}}'  value="{{$c->mark->external}}"
                           inex="EX" cid="{{$c->candidate->id}}" sid="{{$c->subject->id}}"
                           @if($c->subject->subjecttype->type=='Theory') disabled=='true' class="mark disabled"
                           @else
                           @if( $c->mark->external < $c->subject->emin_marks  ) class="mark  fail"
                           @else class="mark  pass"
                           @endif
                           @endif
                           min="{{$c->subject->emin_marks}}" max="{{$c->subject->emax_marks}}"  aid="{{$c->id}}"
                           @if($exam->status_id != 1) disabled=='true'
                            @endif  />
                @else
                    <input id='EX_{{$c->candidate->id}}_{{$c->subject->id}}'   inex="EX" cid="{{$c->candidate->id}}"
                           sid="{{$c->subject->id}}"
                           @if($c->subject->subjecttype->type=='Theory') disabled=='true'  class="mark disabled "
                           @else class="mark"
                           @endif    min="{{$c->subject->emin_marks}}" max="{{$c->subject->emax_marks}}"  aid="{{$c->id}}"
                           @if($exam->status_id != 1) disabled=='true'
                            @endif />
                @endif
                @if($c->subject->subjecttype->type=='Practical')
                    @if($exam->status_id == 1)
                        <div class="dropdown dropdown-left pull-right" >
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{url('markabs')}}/{{$c->id}}/EX">Mark Absent</a></li>
                            </ul>

                        </div>
                    @endif
                @endif

            </td>
            --}}
            <td>
                @if(!empty($c->mark))
                    @if($c->mark->result_id=='1')
                        Pass
                    @else

                    @endif
                @endif
            </td>
        </tr>
    @endforeach
@endsection
@section('script')
    <script>
        $('.mark').on('change',function(){
            $(this).addClass('newbg');
            var mark = parseInt($(this).val());
            var min = parseInt($(this).attr('min'));
            var max = parseInt($(this).attr('max'));
            if(mark>= 0 && mark<=max){
                console.log(mark);
                if(mark>=min){
                    $(this).removeClass('fail');
                    $(this).addClass('pass');
                }else{
                    $(this).removeClass('pass');
                    $(this).addClass('fail');
                }
                var formData = new FormData();
                var token = $('input[name=_token]');

                formData.append('mark', $(this).val());
                formData.append('inex', $(this).attr('inex'));
                formData.append('cid', $(this).attr('cid'));
                formData.append('sid', $(this).attr('sid'));
                formData.append('aid',$(this).attr('aid'));


                $.ajax({
                    url: '{{url("updatemark")}}',
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

                        } else {
                            console.log('updated');
                            console.log(data.responseText);
                            $('#'+data.responseText).removeClass('newbg');
                            $('#'+data.responseText).removeClass('danger');
                            $('#'+data.responseText).addClass('success');
                        }
                    }

                });

            }else{
                $(this).removeClass('success');
                $(this).removeClass('pass');
                $(this).removeClass('newbg');
                $(this).addClass('danger');
            }


        });
    </script>
@endsection