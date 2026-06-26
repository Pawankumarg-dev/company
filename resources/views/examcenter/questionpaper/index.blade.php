@extends('layouts.app')
@section('content')
    <script>
        function showAll() {
            $('.hide').removeClass('hide');
            $('.showall').addClass('hide');
        }
    </script>

    <style>
        .hide {
            display: none;
        }

        .badge-success {
            background-color: green;
        }

        .badge-yellow {
            background-color: yellow;
            color: black;
        }
    </style>
    <script>
        $(document).ready(function() {

            $('.agent').val(window.navigator.userAgent);

        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>2026 EXAMINATION - QUESTION PAPERS
                </h3>
                @include('common.errorandmsg')
                <h4>
                    <span
                        style="background-color:#F39532;color:white;border-radius:5px;padding:0 5px;margin-right:10px;">{{ \Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y') }}
                    </span>
                    <span style="background-color:#46974E;color:white;border-radius:5px;padding:0 5px;">
                        {{ \Carbon\Carbon::parse($schedule->starttime)->format('h:i A') }} to
                        {{ \Carbon\Carbon::parse($schedule->endtime)->format('h:i A') }}
                    </span>
                </h4>
                <?php $slno = 1; ?>
                <a href="{{ url('examcenter/schedule') }}" class="pull-right btn btn-xs btn-primary"
                    style="margin-top:-35px;">Back</a>
                <br> <br>
                <div class="alert alert-danger">
                    Close this page only after downloading all the Question Papers. This page is accessible only <b>one
                        time</b> for the scheduled examination session.
                </div>
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>Slno</th>
                        <th>
                            Programme
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

                        <th>
                            Number of Students
                        </th>
                        <th>
                            NBER
                        </th>

                        <th>
                            Download Question Paper
                            <a href="javascript:showAll();" class="btn btn-warning btn-xs pull-right showall hidden ">Show All
                                Languages</a>
                        </th>
                        <th class="bg-success">
                            Password
                        </th>
                    </tr>
                    <?php $slno = 1; ?>
                    @foreach ($exams as $exam)
                        <tr>
                            <td>
                                {{ $slno }} <?php $slno++; ?>
                            </td>
                            <td>
                                @if($exam->subject->omr_code == 30113 || $exam->subject->omr_code == 30114 || $exam->subject->omr_code == 30115 || $exam->subject->omr_code == 30117)
                                    C.C.C.G. 
                                @else 
                                    {{ $exam->courses }}
                                @endif
                            </td>
                            <td>
                                @if($exam->subject->omr_code == 30113)
                                    CCGMC
                                @endif

                                @if($exam->subject->omr_code == 30114)
                                    CCGMD
                                @endif

                                @if($exam->subject->omr_code == 30115)
                                    CCGME
                                @endif

                                @if($exam->subject->omr_code == 30117)
                                    CCGMG
                                @endif

                                    {{ $exam->subjectcode }}
                            </td>
                            <td>
                                
                                
                                @if($exam->subject->omr_code == 14116)
                                14116, <br /> 14117 (Alternative)
                                @else 
                                {{ $exam->subject->omr_code }}
                                @endif
                            </td>
                            <td>
                                @if($exam->subject->omr_code == 14116)

                                {{ $exam->subject->sname }} / 
                                Receptive & Expressive Language
                                @else 
                                {{ $exam->subject->sname }} 
                                @endif
                            </td>

                            <td>
                                {{ $exam->no_of_student }}
                            </td>
                            <td>
                                {{ $exam->programme->nber->name_code }} 
                            </td>

                            <td>
                                <?php
                                    $omr_code = $exam->examtimetable->subject->omr_code;

                                    
                                if($omr_code == '38112'){
                                $omr_code=39112;
                                }
                                // if($omr_code == '25213'){
                                // $omr_code=26213;
                                // }


                                
                                if($omr_code == '30118'){
                                $omr_code=30113;
                                }

                                if($omr_code == '38113'){
                                $omr_code=39113;
                                }

                                if($omr_code == '38116'){
                                $omr_code=39116;
                                }


                                    $omr = \App\Omrcode::where('omr_code',$omr_code)->first();

                                    


                                    // $qplanguages = \App\Qplanguage::where('omr_code',$omr_code)->where('externalexamcenter_id',$externalexamcenter_id)->get();
                                
                            $apply_lang = \App\Subject::where('omr_code', $exam->examtimetable->subject->omr_code)
                                    ->join('allexamstudents', function ($join) use ($externalexamcenter_id) {
                                        $join->on('subjects.id', '=', 'allexamstudents.subject_id')
                                            ->where('allexamstudents.externalexamcenter_id', '=', $externalexamcenter_id);
                                    })
                                    ->leftjoin('languages', 'allexamstudents.language_id', '=', 'languages.id')
                                    ->select(
                                        'languages.id',
                                        'languages.language',
                                        DB::raw('COUNT(*) as candidates')
                                    )
                                    ->groupBy('languages.id', 'languages.language')
                                    ->get();
                                    ?>

                                
                                @foreach ($apply_lang as $paper)

                                <?php 

                                        // $omr_codes=$exam->subject->omr_code;

                                        // if($omr_codes==33111){
                                        //     $omr_codes=34111;
                                        // }elseif($omr_codes==33211){
                                        //     $omr_codes=34211;
                                        // }
                              

                                        ?>




                                    <form target="_blank" action="{{ url('examcenter/downloadqp') }}" method="post"
                                        class="pre">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="language_id" value="{{ $paper->id }}">
                                        <input type="hidden" name="examtimetable_id" value="{{ $exam->examtimetable->id }}">
                                        <input type="hidden" name="omr_code" value="{{ $omr_code }}">
                                        <input type="hidden" name="allexampaper_id" value="{{ $exam->id }}">

                                        {{-- <input type="hidden" name="rand_string" value="{{ $paper->pivot->rand_string }}"> --}}
                                        <input type="hidden" name="agent" class="agent">
                                        <input type="hidden" name="password">
                                        <button type="submit" class="btn btn-xs btn-primary  "
                                            style="margin-right:5px;margin-bottom:5px;float:left">
                                            {{ $paper->language }} paper: {{$paper->candidates}}
                                        </button>
                                        {{--  <a target="_blank" class="btn btn-xs btn-primary @if (in_array($paper->id, $language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a> --}}
                                    </form>
                                @endforeach 
                                <a href="javascript:unhide({{ $omr_code }})" class="show_{{ $omr_code }}" >Show more</a>
                                <br />
                                <br />
                           
     <div class="more_{{ $omr_code }} hidden">

<?php


                                    
                $qp = DB::table('examtimetable_language as etl')
    ->join('languages as l', 'etl.language_id', '=', 'l.id')
    ->where('etl.exam_id', 28)
    ->where('etl.omr_code', $omr_code)
    ->select('etl.*', 'l.language') // adjust columns as needed
    ->get();

   
?>


                                    @foreach ($qp as $paper)
                                            <form target="_blank" action="{{ url('examcenter/downloadqp') }}" method="post"
                                                class="">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="language_id" value="{{ $paper->language_id}}">
                                                <input type="hidden" name="examtimetable_id" value="{{ $paper->examtimetable_id }}">
                                                <input type="hidden" name="omr_code" value="{{ $omr_code }}">
                                                <input type="hidden" name="allexampaper_id" value="{{ $exam->id }}">

                                                {{-- <input type="hidden" name="rand_string" value="{{ $paper->pivot->rand_string }}"> --}}
                                                <input type="hidden" name="more" value="1">
                                        <input type="hidden" name="password">

                                                <input type="hidden" name="agent" class="agent">
                                                <button type="submit" class="btn btn-xs btn-primary  "
                                                    style="margin-right:5px;margin-bottom:5px;float:left">
                                                    {{ $paper->language }}
                                                </button>
                                                {{--  <a target="_blank" class="btn btn-xs btn-primary @if (in_array($paper->id, $language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a> --}}
                                            </form>
                                    @endforeach
                                </div>
                               
                            <td class="bg-success "><b class="text-red   ">{{ $exam->password }}</b></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <script>
        function unhide(omr_code){
            $('.more_'+omr_code).removeClass('hidden');
            $('.show_'+omr_code).addClass('hidden');
        }
    </script>
@endsection
