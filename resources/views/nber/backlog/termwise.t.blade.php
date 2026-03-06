@extends('layouts.app')

@section('content')
<style>
    .rotate {
        -webkit-transform: rotate(-180deg);        
        -moz-transform: rotate(-180deg);            
        -ms-transform: rotate(-180deg);         
        -o-transform: rotate(-180deg);         
        transform: rotate(-180deg);
        writing-mode: vertical-lr;
	}
    .rotate45 {
        -webkit-transform: rotate(-135deg);        
        -moz-transform: rotate(-135deg);            
        -ms-transform: rotate(-135deg);         
        -o-transform: rotate(-135deg);         
        transform: rotate(-135deg);
        writing-mode: vertical-lr;
    }
    .fail{
        background-color:red;
        color:white;
    }
    .internal{
        background-color:#ccc;
    }

    .external{
        background-color:#aaa;
    }
    .orange-text{
        color: orangered !important;
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('common.errorandmsg')
                <h4>
                Marks - {{Session::get('examname')}}  Exam
                </h4>
                <h6> {{$ap->institute->rci_code}} - {{$ap->institute->name}} </h6>
                <h3>{{$ap->programme->name}} - {{$ap->academicyear->year}} Batch</h3>
                <h6 class="text-muted">
                    NA = Not Applied, ABS = Absent , ANM = Attendance is not marked, IN = Internal, EX = External
                </h6>


                <table class="table table-bordered table-condensed table-hover table-sm">
                    <tr>
                        <th  rowspan="4" class="rotate">Sl No</th>
                        <th rowspan="4">Enrolment No</th>
                        <th rowspan="4">Candidate</th>
                        <th class="text-center text-muted" colspan="{{$subjects->where('subjecttype_id',1)->count() * 2}}">Theory</th>
                        <th class="text-center text-muted" colspan="{{$subjects->where('subjecttype_id',2)->count() * 2}}">Practical</th>
                    </tr>
                    <tr>
                        @foreach($subjects as $s)
                            <th class="rotate45" colspan="2">
                                {{$s->scode}}
                            </th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($subjects as $s)
                            <td class="rotate">
                                <small class="text-muted">
                                    Min: {{$s->imin_marks}}
                                    Max: {{$s->imax_marks}}
                                </small>
                            </td>
                            <td class="rotate">
                                <small class="text-muted">
                                    Min: {{$s->emin_marks}}
                                    Max: {{$s->emax_marks}}
                                </small>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($subjects as $s)
                            <th class="rotate internal">IN</th>
                            <th class="rotate external">EX</th>
                        @endforeach
                    </tr>
                    <?php $slno= 1;?>
                    @foreach($ap->applicants->sortBy('candidate.enrolmentno') as $a)
                        <tr>
                            <td class="text-center">
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                {{$a->candidate->enrolmentno}}
                            </td>
                            <td>
                                {{$a->candidate->name}}
                            </td>
                            @foreach($subjects as $s)
                                <?php 
                                    //$m = $applications->where('candidate_id',$a->candidate_id)->where('subject_id',$s->id)->first(); 
                                    $m = array_filter($applications, function ($subarray) use ($a,$s) {
                                        return isset($subarray['candidate_id']) && isset($subarray['subject_id'] ) && $subarray['candidate_id'] === $a->candidate_id && $subarray['subject_id'] === $s->id;
                                    },ARRAY_FILTER_USE_BOTH);
                                    print_r($m[array_keys($m)[0]]);

                                 ?>
                                 <td>
                                 </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
