@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4>
                    Mark Entry - {{Session::get('examname')}} Exam
                    </h4>
                    <h6>
                    {{$institute->rci_code}} - 
                        {{$institute->name}}
                    </h6>
                    
                  
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th rowspan="1" width="5%" class="center-text">Batch</th>
                                <th rowspan="1"  width="15%">Course</th>
                                <th colspan="1" class="center-text">Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        @foreach($approvedprogrammes as $approvedprogramme)
                            {{ $approvedprogramme->programme->abberviation }}
                            @if($approvedprogramme->programme->nber_id == $nber_id )
                                {{-- @if($approvedprogramme->applicants->count() > 0 || $approvedprogramme->oldapplicantsofexam(Session::get('exam_id'))->count() > 0) --}}
                                    <tr>
                                        <td class="center-text">{{ $approvedprogramme->academicyear->year }}</td>
                                        <td>{{ $approvedprogramme->programme->course_name }}</td>
                                        <td class="center-text">
                                            {{--<a href="{{url('nber/markentry/apid/')}}/{{$approvedprogramme->id}}" class=" btn btn-info btn-sm">Subject Wise</a>--}}
                                            <a href="{{url('nber/markentry/termwise/')}}/{{$approvedprogramme->id}}/1" class=" btn btn-warning btn-sm">Term 1</a>
                                            @if($approvedprogramme->academicyear_id < $academicyear_id || $approvedprogramme->programme_id == 57)
                                                <a href="{{url('nber/markentry/termwise/')}}/{{$approvedprogramme->id}}/2" class=" btn btn-warning btn-sm">Term 2</a>
                                            @endif
                                            {{--,{{$approvedprogramme->applicants->count()}}, {{ $approvedprogramme->oldapplicantsofexam(Session::get('exam_id'))->count()}} --}}
                                            {{--<a href="{{url('nber/examapplications/')}}/{{$approvedprogramme->id}}/22"  class=" btn btn-info btn-sm"> Exam Applications </a>--}}
                                        </td>
                                    </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
