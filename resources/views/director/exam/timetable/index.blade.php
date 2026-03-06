@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
            <?php $slno = 1; ?>
            <h3>{{$exam->name}} Examinations</h3>
            <div class="alert alert-success">
                Click <a target="_blank" href="{{ url('files/director/SOP.pdf') }}">here</a> for SOP - uploading question papers for June exam 2025.
            </div>
        </div>
    </div>
            @if(!is_null($timetables))
            	<div class="row hidden">
                    <div class="col-md-12">
                <div class="alert alert-success ">No of Applicants: {{$countofcandidates}}</div>
                </div>
                </div>
                <div class="alert alert-danger hidden"
                >
                    Please complete uploading all the remaining question papers for the  examinations till 23th Jan 2025,  tomorrow (19th Jan 2025) before 10:00 AM. The portal will be closed for processing the question papers from 10:00 AM onwards.
                    <ul>
                        <li>
                            Kindly upload all the 3 sets of each question papers, of each languages uploaded. 
                        </li>
                        <li>
                            Please do not upload question papers with out encrypting. 
                        </li>
                        <li>
                            Please make sure the password saved in the portal matches with the pdf password.
                        </li>
                        
                    </ul>
                </div>
            	<div class="row">

        		
                </div>
                @if($timetables->count()>0)
            	<div class="row">

        		<div class="col-md-12">
                    
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>
                                SlNo
                            </th>
                            <th>
                                Course 
                            </th>
                            <th>
                                Revision / Syllubus
                            </th>
                            <th>
                                Term
                            </th>
                            <th>
                                Subject Code
                            </th>
                            <th>
                                Subject OMR Code
                            </th>
                            <th>
                                Subject
                            </th>
                            <th>Upload Question Paper</th>
                        </tr>
                        @foreach($timetables as $timetable)
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                {{$timetable->course}}
                            </td>

                            <td>
                                {{$timetable->revision}}
                            </td>
                            <td>
                                {{ $timetable->syear }}
                            </td>
                            <td>
                                {{$timetable->scode}}
                            </td>
                            <td>
                                {{$timetable->omr_code}}
                            </td>
                            <td>
                                {{$timetable->sname}}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{url('qp/exam/timetable/')}}/{{$timetable->omr_code}}">Question Paper Upload</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                </div>
                @else
                	<div class="row">
                        <div class=" col-md-12">
                    <div class="alert alert-danger">No schedule found</div>
                </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection