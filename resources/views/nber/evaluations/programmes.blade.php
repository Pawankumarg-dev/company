@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            {{$exam->name}} Evaluations verification
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-bordered">
                                        <thead>
                                        <tr class="bg-info">
                                            <th class="center-text" width="5%">S.No.</th>
                                            <th class="center-text">Course</th>
                                            <th class="center-text">Evaluation Centers</th>
                                        </tr>
                                        </thead>
                                        @php $sno = 1; @endphp
                                        <tbody>
                                        @foreach($programmes as $data)
                                        <tr>
                                            <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                            <td>{{ $data->abbreviation }}</td>


                                    <td style="display: flex; flex-wrap: wrap; gap: 10px;">
                                         @foreach($evaluationcenters as $evaluationcenter)

                                        <table class="table table-condensed table-bordered">
                                        <thead>
                                        <tr class="bg-info">
                                            <th class="center-text">Evaluation center</th>
                                            <th class="center-text">Exam Centers</th>
                                        </tr>


                                        </thead>
                                                                                <tbody>

<?php 
                                                $examcenters=\App\Evaluationcenterdetail::where('exam_id',$exam->id)->where('evaluationcenter_id',$evaluationcenter->id)->where('nber_id',$nber_id)->get()
                                                ?>


@foreach ($examcenters as $examcenter)
    


                                                                                    <tr>
                                            <td class="center-text">{{ $evaluationcenter->code }}</td>
                                            <td class="center-text">{{ $examcenter->externalexamcenter->code }}</td>


                                            <td style="display: flex; flex-wrap: wrap; gap: 10px;">

                                    

                                                 <?php 
                                                 $applications_count =  \App\Allexamstudent::where('externalexamcenter_id',$examcenter->externalexamcenter->id)->where('exam_id',$exam->id)->where('attendance',1)->where('programme_id',$data->id)->groupBy('subject_id')->get(); ?>

                                                @foreach($applications_count as $subject_data)

                                                    @if(empty($subject_data->mark_file))

                                                    <button class="btn btn-danger">mark file not uploaded</button>

                                                    @elseif($subject_data->verified==1)
                                                    <button class="btn btn-success">Verified</button>
                                                    @else
                                                <form action="{{url('/')}}/verify-external" method="post">
                                                     {{csrf_field()}}
                                                    <input type="hidden" name="subject_id" value="{{$subject_data->subject_id}}">
                                                    <input type="hidden" name="program_id" value="{{$data->id}}">
                                                    <input type="hidden" name="evaluationcenter_id" value="{{$evaluationcenter->id}}">
                                                    <input type="hidden" name="externalexamcenter_id" value="{{ $examcenter->externalexamcenter->id }}">

                                                    <button class="btn btn-warning">{{ $subject_data->subject->scode }}</button>
                                                </form>

                                                 @endif
                                                @endforeach
                                            </td>



                                                                                    </tr>
@endforeach
                                                                                </tbody>
                                        </table>


                                        
                                        @endforeach
                                    </td>






                                        
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



