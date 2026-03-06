@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('common.errorandmsg')
                <h4>
                Mark Entry - {{Session::get('examname')}}  Exam
                </h4>
                <h6> {{$ap->institute->rci_code}} - {{$ap->institute->name}} </h6>
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
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Practical</td>
                        <td>External</td>
                        <td>
                            @if(!is_null($markentries) && !is_null($markentries->external_practical))
                                <a href="{{url('files/markfiles/')}}/{{$markentries->external_practical}}" target="_blank">Award List</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Theory</td>
                        <td>Internal</td>
                        <td>
                            @if(!is_null($markentries) && !is_null($markentries->internal_theory))
                                <a href="{{url('files/markfiles/')}}/{{$markentries->internal_theory}}" target="_blank">Award List</a>
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
                        @if( Session::get('exam_id')  < 22 or Session::get('exam_id')  < 23  )
                            <th  class="center-text">
                                Mark Entry 
                            </th>
                        @endif
                        <th>
                            View
                        </th>
                    </tr>
                    @foreach($subjects as $s)
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
                            @if(Session::get('exam_id') < 22 || Session::get('exam_id')  == 23 )
                                <td  class="center-text">
                                    <a href="{{url('nber/markentry/')}}/{{$ap->id}}/{{$s->id}}" class="btn btn-xs btn-primary" >Add Mark Entry (Only if not entered)</a>
                                    <a href="{{url('nber/editmarkentry/')}}/{{$ap->id}}/{{$s->id}}" class="btn btn-xs btn-primary" >Edit Mark Entry</a>
                                </td>
                            @endif
                            <td  class="center-text">
                                <a href="{{url('nber/markentry/view/')}}/{{$ap->id}}/{{$s->id}}" class="btn btn-xs btn-primary" >View</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
