
<table class="table table-bordered table-condensed">
    <tr>
        <th>Slno</th>
        <th>Exam Center Code</th>
        <th>Exam Center</th>
        <th>Exam Center Address</th>
        <th>Contact</th>
        <th>
            OTP Confirmation
        </th>
        <th>
            Question Papers Downloaded - Mock Drill
        </th>
        @if($show=='all')
            <th>Institute</th>
        @endif
        {{-- <th>Evaluation Center</th>
        
        <th>Confirmation</th>
        <th>No of students</th>
        <th>Hallticket</th> --}}
        @if($show=='all')
            <th></th>
        @endif
    </tr>
    <?php $slno = 1; ?>
    @foreach($examcenters->sortBy('institute.rci_code') as $ec)
    @if(!is_null($ec->externalexamcenter))
    
        <tr>
            <td>{{$slno}}
                <?php $slno++ ; ?>
            </td>
            <td>
                {{$ec->externalexamcenter->code}}
                <small class="text-muted">
                    Temp Code : {{ $ec->externalexamcenter->id }}
                </small>
            </td>
            <td>
                <a href="{{url('nber/excenter')}}/{{$ec->externalexamcenter_id}}" target="_blank">
                {{$ec->externalexamcenter->name}}
                </a>
            </td>
            <td>
                {{$ec->externalexamcenter->address}}
                <br />
                {{$ec->externalexamcenter->lgdistrict->districtName}}
                <br />
                {{$ec->externalexamcenter->lgstate->state_name}}
                <br />
                PIN: {{$ec->externalexamcenter->pincode}}
            
            </td>
            <td>
                Contact Persion:{{$ec->externalexamcenter->contactperson}} <br />
                Mobile:{{$ec->externalexamcenter->contactnumber1}}<br />
                Email:{{$ec->externalexamcenter->email1}}
            </td>
            <td class="text-center">
                @if($ec->externalexamcenter->questionpaperotps->count() > 0)
                    {{ $ec->externalexamcenter->questionpaperotps()->where('exam_id',27)->count() }}
                @else 
                    0
                @endif
            </td>
            <td class="text-center">
                @if($ec->externalexamcenter->questionpaperdownloadhistories->count() > 0)
                    {{ $ec->externalexamcenter->questionpaperdownloadhistories()->where('id','>',8054)->count() }}
                @else 
                    0
                @endif
            </td>
            
        {{-- <td>
            @if(!is_null($ec->states) && $ec->states->count() > 0)
                @foreach($ec->states as $state)
                    <span class="badge text-bg-info">
                    {{$state->state_name}} 
                    </span>

                    @if($state->pivot->statezone_id > 0)
                    <span class="badge text-bg-warning" style="background-color:blue;">
                        {{\App\Statezone::find($state->pivot->statezone_id)->name}}
                    </span>
                    @endif
                @endforeach
            @endif
            <a href="{{url('nber/exam/examcenter/')}}/{{$ec->id}}/edit" class="btn btn-xs btn-secondary">Modify</a>
        </td> --}}
        
        @if($show=='all')
            <td>
                @if(!is_null($ec->institute->rci_code)) {{ $ec->institute->rci_code }} @endif - {{ $ec->institute->name }} <br />
                @if(!is_null($ec->institute->district_id)) {{$ec->institute->district->districtName}} @endif <br />
                {{ $ec->institute->state->state_name}} 
            </td>
        @endif
        <td class="hidden"></td>
            <td class="hidden">
                {{-- <input type="checkbox" data-id="{{$ec->externalexamcenter->id}}" @if($ec->externalexamcenter->confirm_availability == 1) data-chkval="1" @else data-chkval="0" @endif class="confirmation availability availability_{{ $ec->externalexamcenter->id }}"> Availability <br />
                <input type="checkbox" data-id="{{$ec->externalexamcenter->id}}" @if($ec->externalexamcenter->confirm_address == 1)  data-chkval="1" @else data-chkval="0" @endif class="confirmation address address_{{ $ec->externalexamcenter->id }}"> Address<br />
                <input type="checkbox" data-id="{{$ec->externalexamcenter->id}}" @if($ec->externalexamcenter->confirm_mobile == 1)  data-chkval="1" @else data-chkval="0" @endif class="confirmation mobile mobile_{{ $ec->externalexamcenter->id }}"> Mobile 		<br />					
                <input type="checkbox" data-id="{{$ec->externalexamcenter->id}}" @if($ec->externalexamcenter->confirm_email == 1)  data-chkval="1" @else data-chkval="0" @endif class="confirmation email email_{{ $ec->externalexamcenter->id }}"> Email 							 --}}
            </td>
            <td class="hidden">
                @if($show=='all')
                    <?php
                    $institutes = \App\Examcenter::where('exam_id',Session::get('exam_id'))->where('externalexamcenter_id',$ec->externalexamcenter_id)->pluck('institute_id')->toArray();
                        $students = \App\Maxstudent::where('exam_id',Session::get('exam_id'))->whereIn('institute_id',$institutes)->sum('max_student');
                        // $ms = \App\Maxstudent::where('institute_id',$ec->institute_id)->first();
                        // if(!is_null($ms)){
                        // 	$students = $ms->max_student;
                        // }else{
                        // 	$students = 0;
                        // }
                    ?>
                @else
                    <?php 
                        $institutes = \App\Examcenter::where('exam_id',Session::get('exam_id'))->where('externalexamcenter_id',$ec->externalexamcenter_id)->pluck('institute_id')->toArray();
                        $students = \App\Maxstudent::where('exam_id',Session::get('exam_id'))->whereIn('institute_id',$institutes)->sum('max_student');
                    ?>
                        
                @endif
                {{ $students }}
            </td>
            <td class="hidden">Not generated</td>
        @if($show=='all')
            <td>
                {{-- <form action="{{ url('nber/exam/examcenter') }}/{{ $ec->id }}" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                     {{ csrf_field() }}
                <button class="btn btn-xs btn-danger">Delete</button>
            </form> --}}
            {{-- <a class="btn btn-xs btn-warning" href="{{ url('nber/excenter/')}}/{{$ec->externalexamcenter->id}}/edit">Edit Exam Center Details</a>		 --}}
            </td>
        @endif
        @if($show=='ec')
        <td>
            {{-- <a class="btn btn-xs btn-warning" href="{{ url('nber/excenter/')}}/{{$ec->externalexamcenter->id}}/edit">Edit Exam Center Details</a> --}}
        </td>
        @endif
        <td>

        </td>
        </tr>
        @endif
    @endforeach
</table>