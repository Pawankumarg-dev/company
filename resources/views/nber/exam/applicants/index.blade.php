@extends('layouts.app')
@section('content')
<style>
    thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
   .table  { border-collapse: collapse; }
   th {border:1px solid #efefef;}
</style>
<script src="{{url('js/tableToExcel.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.btn-primary').removeClass('hidden');
        $(".btn-primary").click(function() {
            var mytable = $(this).data('table');
            var report = $(this).data('report');
            let table = document.getElementById(mytable);
            TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
               name: report + `.xlsx`, // fileName you could use any name
               sheet: {
                  name: 'Sheet 1' // sheetName
               }
            });
        });
    });
    </script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            <h4>{{$exam->name}} Examinations</h4>
            @include('common.errorandmsg')
            <a href="{{url('/nber/exam/applicants')}}?excel=1" class="btn btn-primary btn-xs  "
                style="    position: absolute;
                right: 10px;
                top: 10px;"
            >
                DOWNLOAD  STUDENT LIST .XLS
            </a>

            <a href="{{url('/nber/exam/applicants')}}?allapplications=1" class="btn btn-primary btn-xs "
                style="    position: absolute;
                right: 220px;
                top: 10px;"
            >
                DOWNLOAD ALL APPLICATION & RESULT
            </a>

           {{-- <a href="{{url('files/supplimentary/')}}/Language.xlsx" class="btn btn-primary btn-xs "
                style="    position: absolute;
                right: 350px;
                top: 10px;"
            >
                LANGUAGE WISE APPLICATIONS .XLS
            </a>--}}
        </div>
    </div>
    <div class="row">
		<div class="col-md-5">
            Course: 
            <form action="{{url('/nber/exam/applicants')}}" method="get">
                {{csrf_field()}}
                @include('common.programmes.dropdown')
                @if(!is_null($institute))
                    <input type="hidden" name="institute_id" value="{{$institute->id}}">
                @endif
                @if(!is_null($academicyear))
                    <input type="hidden" name="academicyear_id" value="{{$academicyear->id}}">
                @endif
            </form>
        </div>
        <div class="col-md-5">
            Institutes: 
            <form action="{{url('/nber/exam/applicants')}}" method="get">
                {{csrf_field()}}
                @include('common.institutes.dropdown')
                @if(!is_null($programme))
                    <input type="hidden" name="programme_id" value="{{$programme->id}}">
                @endif
                @if(!is_null($academicyear))
                    <input type="hidden" name="academicyear_id" value="{{$academicyear->id}}">
                @endif
            </form>
        </div>
        @if($exam->id == 26)
            <div class="col-md-2">
                Special Cases
                <form action="{{url('/nber/exam/applicants')}}" method="get">
                    <div class="form-group mb-3">
                        <div class="input-group">
                            {{csrf_field()}}
                            <select name="case" id="case"  class="form-control">>
                                <option value="all" @if($case=='all') selected @endif>All</option>
                                <option value="special" @if($case=='special') selected @endif>Special Cases</option>
                            </select>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary"> Show </button>
                            </span>
                        </div>
                    </div>
                    @if(!is_null($programme))
                        <input type="hidden" name="programme_id" value="{{$programme->id}}">
                    @endif
                    @if(!is_null($institute))
                        <input type="hidden" name="institute_id" value="{{$institute->id}}">
                    @endif
                </form>
            </div>
        @endif
        <div class="col-md-2 hidden">
            Admission Year: 
            <form action="{{url('/nber/exam/applicants')}}" method="get">
                {{csrf_field()}}
                @include('common.academicyears.dropdown')
                @if(!is_null($programme))
                    <input type="hidden" name="programme_id" value="{{$programme->id}}">
                @endif
                @if(!is_null($institute))
                    <input type="hidden" name="institute_id" value="{{$institute->id}}">
                @endif
            </form>
        </div>
    </div>
            @if(!is_null($applicants))
            	<div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success ">
                            No of Applicants: {{$applicants->total()}}
                        </div>
                    </div>
                </div>
                @if($applicants->count()>0)
               
                    <div class="row">
                        <div class="col-md-12">
                            {!! $applicants->appends(Request::except('page'))->render() !!}

                            <table class="table table-bordered table-striped table-hover" id="myTable0">
                                <tr>
                                    <th>
                                        SlNo
                                    </th>
                                    <th>
                                        Enrolment No
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Institute
                                    </th>
                                    <th>
                                        Course
                                    </th>
                                    <th>
                                        Admission Year
                                    </th>
                                    <th>
                                        State
                                    </th>
                                    <th>
                                        District
                                    </th>
                                    <th>
                                        Paper Count
                                    </th>
                                    @if($exam->id==26)
                                    <th>N+2 </th>
                                    @elseif($exam->id==27)
                                    <th class="hidden">Confirmation </th>
                                    @endif

                                    <th class="">
                                        Hallticket - Practial
                                    </th>

                                    <th class="">
                                        Hallticket - Theory
                                    </th>
                                </tr>
                                @foreach($applicants as $applicant)
                                <tr>
                                    <td>
                                        {{$slno}}
                                        <?php $slno++; ?>
                                    </td>
                                    <td>
                                        <a href="{{url('nber/candidate')}}/{{$applicant->candidate_id}}" target="_blank">
                                            {{$applicant->candidate->enrolmentno}}
                                        </a>
                                    </td>

                                    <td>
                                        {{$applicant->candidate->name}}
                                    </td>
                                    <td>
                                        {{$applicant->candidate->approvedprogramme->institute->rci_code}} - 
                                        {{$applicant->candidate->approvedprogramme->institute->name}}
                                    </td>
                              
                                    <td>
                                        {{$applicant->candidate->approvedprogramme->programme->course_name}}
                                    </td>
                                    <td>
                                        {{$applicant->candidate->approvedprogramme->academicyear->year}}
                                    </td>
                                    <td>
                                        {{$applicant->candidate->approvedprogramme->institute->state->state_name}}
                                    </td>
                                    <td>
                                        @if($applicant->candidate->approvedprogramme->institute->district_id > 0)
                                        {{$applicant->candidate->approvedprogramme->institute->district->districtName}}
                                        @else
                                        {{$applicant->candidate->approvedprogramme->institute->rci_district}}

                                        @endif

                                    </td>
                                    <td >
                                        {{ $applicant->applications->count() }}
                                    </td>
                                    <td class="hidden">
                                        {{-- <a href="{{url('/nber/exam/applicants')}}/{{$applicant->id}}" class="btn btn-xs btn-primary">
                                        @if($exam->publish_result == 1)
                                            Result
                                        @else
                                            Application
                                        @endif
                                        </a> --}}
                                        @if($applicant->nplustwoexception==1 && ($exam->id==26))
                                            {{-- <a class="btn btn-xs btn-primary" href="{{ url('nber/exam/exception') }}/{{ $applicant->candidate_id }}">Verify Documents</a> --}}
                                             <?php $exception  = $applicant->nplustwoexceptions()->first(); ?>
                                             @if($exception->status == 1) Approved @endif
                                             @if($exception->status == 2) Rejected @endif
                                        @elseif($exam->id==27)
                                        @if($applicant->confirmed == 0) Confirmation Pending @endif
                                        @if($applicant->confirmed == 1) Confirmed @endif
                                        @endif
                                    </td>
                                   
                                   <td class="hidden">
                            
                                        @if(is_null($applicant->candidate->signature) || $applicant->candidate->signature == '' )
                                            Signature of the student is missing.
                                        @else  
                                            @if($applicant->hallticket_status == 'generated')
                                                @if($applicant->fy_t > 0)
                                                    <a href="{{url('nber/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1" class="btn btn-xs btn-primary ">First Year Hall Ticket(Theory)</a>
                                                @endif
                                                @if($applicant->sy_t > 0)
                                                    <a href="{{url('nber/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2" class="btn btn-xs btn-primary  ">Second Year Hall Ticket (Theory)</a>
                                                @endif


                                                @if($applicant->fy_p > 0)
                                                    <a href="{{url('nber/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1&practical=yes" class="btn btn-xs btn-primary ">First Year Hall Ticket(Practical)</a>
                                                @endif
                                                @if($applicant->sy_p > 0)
                                                    <a href="{{url('nber/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2&practical=yes" class="btn btn-xs btn-primary  ">Second Year Hall Ticket (Practical)</a>
                                                @endif

                                                @if(!is_null($applicant->remarks))
                                                    {{ $applicant->remarks }}
                                                @endif
                                            @else
                                                {{  $applicant->remarks }}
                                            @endif
                                        @endif
                                    
                                   </td>

                                   <td class="hidden">
                                         {{-- PRACTICAL--}}
                                         <?php 
                                         $hallticket  =    $applicant->practicalhalltickets()->where('exam_id',Session::get('exam_id'))->first();
                                     ?>
                                            @if(!is_null($hallticket))
                                     
                                         @if($hallticket->first_year > 0)
                                             <a target="_blank" href="{{url('nber/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1&practical=yes"  class="btn btn-xs btn-primary ">First Year Hall Ticket (Practical)</a>
                                         @endif
                                         @if($hallticket->second_year > 0)
                                             <a target="_blank" href="{{url('nber/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2&practical=yes"  class="btn btn-xs btn-primary ">Second Year Hall Ticket (Practical)</a>
                                         @endif 
                                         @endif
                                    </td>
                                
                                    <td class="">
                                        {{-- THEORY--}}
                                            <?php 
                                                //$hallticket  =    $applicant->halltickets()->where('exam_id',Session::get('exam_id'))->first();
                                                $hallticket= \App\Hallticket::where('exam_id',27)->where('candidate_id',$applicant->candidate_id)->first();
                                            ?>
                                            @if(!is_null($hallticket))
                                                @if(!is_null($applicant->hallticket_no))
                                                    Hallticket Number: {{ $applicant->hallticket_no }} <br />
                                                    {{-- @if($applicant->payment_status == 1  ) --}}
                                                        @if($hallticket->first_year > 0)
                                                            <a target="_blank" href="{{url('nber/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1"  class="btn btn-xs btn-primary ">First Year Hall Ticket (Theory)</a>
                                                        @endif
                                                        @if($hallticket->second_year > 0)
                                                            <a target="_blank" href="{{url('nber/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2"  class="btn btn-xs btn-primary ">Second Year Hall Ticket (Theory)</a>
                                                        @endif 
                                                    {{-- @else
                                                        Payment pending
                                                    @endif --}}
                                                @else
                                                    Pending Hallticket Generation
                                                @endif
                                                @if($hallticket->downloaded == 1)
                                                    Downloaded
                                                @else 
                                                    Not downloaded
                                                @endif
                                            @else
                                                Not generated
                                            @endif
                                         
                                    </td>
                                    

                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @else
                	<div class="row">
                        <div class=" col-md-12">
                            <div class="alert alert-danger">No Applications found</div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
