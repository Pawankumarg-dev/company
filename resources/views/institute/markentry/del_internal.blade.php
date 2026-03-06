@extends('layouts.app')

@section('content')
    <style>
     .mentry{
        width:30px;
        border: 1px solid #ccc;
     }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>
                    2023 Examination -
                    Internal Practical Mark Entry
                </h4>
                <h3> {{$ap->programme->course_name}} - ({{$ap->academicyear->year}} Batch)
                </h3>

                <h5>1st Year Internal Practical </h5>
                <?php $slno = 1; ?>
                <?php $subject_ids = $ap->programme->subjects->where('syear',1)->where('subjecttype_id',2)->sortBy('order')->pluck('id'); ?>

                <table class="table table-bordered table-condensed table-hover table-sm">
                    <tr>
                        <th>Sl No</th>
                        <th>Name</th>
                        <th>Enrolment No</th>   
                        @foreach($ap->programme->subjects->where('syear',1)->where('subjecttype_id',2)->sortBy('order') as $subject)
                            <th>{{$subject->scode}}</th>
                        @endforeach
                    </tr>
                    @foreach($ap->candidates as $c)
                        <tr>
                            <td>
                                {{$slno}} <?php $slno++ ?>
                            </td>
                            <td>
                                {{$c->name}}
                            </td>
                            <td>
                                {{$c->enrolmentno}}
                            </td>
                            @foreach($subject_ids as $sid)
                            <td>
                                
                            <?php $aexisting = $c->subjects->where('id',$sid); ?>
                          
                            @if($aexisting->count()>0)
                            <input type="text" class="mentry"
                                    name="{{$aexisting->first()->pivot->id}}" >
                              
                                @else
                                    NA
                                @endif                   
                            </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection