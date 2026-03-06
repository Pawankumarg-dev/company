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
                <h3>JUNE 2025 EXAMINATION - QUESTION PAPERS
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
                                    $omr = \App\Omrcode::where('omr_code',$omr_code)->first();
                                    $qplanguages = \App\Qplanguage::where('omr_code',$omr_code)->where('externalexamcenter_id',$externalexamcenter_id)->get();
                                    $qplanguage_ids = \App\Qplanguage::where('omr_code',$omr_code)->where('externalexamcenter_id',$externalexamcenter_id)->pluck('language_id')->toArray();
                                
                                ?>
                               @if($exam->programme_id == 70)
                                    @foreach ($omr->languages as $paper)
                                        <form target="_blank" action="{{ url('examcenter/downloadqp') }}" method="post"
                                            class="">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="language_id" value="{{ $paper->pivot->language_id }}">
                                            <input type="hidden" name="examtimetable_id" value="2689">
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
                                @else 
                                
                                @if($omr_code == 36115)
                                            <a class="btn btn-xs btn-primary  " href="{{ url('files/36115') }}/dc_1_36115_2.pdf">English</a>
                                            <a class="btn btn-xs btn-primary  " href="{{ url('files/36115') }}/dc_2_36115_2.pdf">Hindi</a>
                                            <a class="btn btn-xs btn-primary  " href="{{ url('files/36115') }}/dc_4_36115_2.pdf">Telugu</a>
                                            <a class="btn btn-xs btn-primary  " href="{{ url('files/36115') }}/dc_9_36115_2.pdf">Marathi</a>
                                            <a class="btn btn-xs btn-primary  " href="{{ url('files/36115') }}/dc_11_36115_2.pdf">Tamil</a>
                                            <a class="btn btn-xs btn-primary  " href="{{ url('files/36115') }}/dc_14_36115_2.pdf">Bilingual</a>
                                @endif

                                @foreach ($qplanguages as $paper)
                                    <form target="_blank" action="{{ url('examcenter/downloadqp') }}" method="post"
                                        class="">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="language_id" value="{{ $paper->language_id }}">
                                        <input type="hidden" name="examtimetable_id" value="{{ $exam->examtimetable->id }}">
                                        {{-- <input type="hidden" name="rand_string" value="{{ $paper->pivot->rand_string }}"> --}}
                                        <input type="hidden" name="agent" class="agent">
                                        <input type="hidden" name="password">
                                        <button type="submit" class="btn btn-xs btn-primary  "
                                            style="margin-right:5px;margin-bottom:5px;float:left">
                                            {{ $paper->language->language }}
                                        </button>
                                        {{--  <a target="_blank" class="btn btn-xs btn-primary @if (in_array($paper->id, $language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a> --}}
                                    </form>
                                @endforeach 
                                <a href="javascript:unhide({{ $omr_code }})" class="show_{{ $omr_code }}" >Show more</a>
                                <br />
                                <br />
                                <div class="more_{{ $omr_code }} hidden">
                                    @foreach ($omr->languages as $paper)
                                        @if(!in_array($paper->pivot->language_id,$qplanguage_ids))
                                            <form target="_blank" action="{{ url('examcenter/downloadqp') }}" method="post"
                                                class="">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="language_id" value="{{ $paper->pivot->language_id }}">
                                                <input type="hidden" name="examtimetable_id" value="{{ $exam->examtimetable->id }}">
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
                                        @endif
                                    @endforeach
                                </div>

                                @if($exam->subject->omr_code == 14116)
                                    <?php 

                                        $omr_code = 14117;
                                        $omr = \App\Omrcode::where('omr_code',$omr_code)->first();
                                    ?>

                                <div style="float:left;">

                                        <hr />

                                        <b>Alternative Paper</b>

                                        <br />
                                        <br />


                                                @foreach ($qplanguages as $paper)
                                                <form target="_blank" action="{{ url('examcenter/downloadqp') }}" method="post"
                                                    class="">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="language_id" value="{{ $paper->language_id }}">
                                                    <input type="hidden" name="examtimetable_id" value="2466">
                                                    {{-- <input type="hidden" name="rand_string" value="{{ $paper->pivot->rand_string }}"> --}}
                                                    <input type="hidden" name="agent" class="agent">
                                                    <input type="hidden" name="password">
                                                    <button type="submit" class="btn btn-xs btn-primary  "
                                                        style="margin-right:5px;margin-bottom:5px;float:left">
                                                        {{ $paper->language->language }}
                                                    </button>
                                                    {{--  <a target="_blank" class="btn btn-xs btn-primary @if (in_array($paper->id, $language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a> --}}
                                                </form>
                                                @endforeach 
                                                <a href="javascript:unhide({{ $omr_code }})" class="show_{{ $omr_code }}" >Show more</a>
                                                <br />
                                                <br />
                                                <div class="more_{{ $omr_code }} hidden">
                                                @foreach ($omr->languages as $paper)
                                                    @if(!in_array($paper->pivot->language_id,$qplanguage_ids))
                                                        <form target="_blank" action="{{ url('examcenter/downloadqp') }}" method="post"
                                                            class="">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="language_id" value="{{ $paper->pivot->language_id }}">
                                                            <input type="hidden" name="examtimetable_id" value="2466">
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
                                                    @endif
                                                @endforeach
                                                </div>

                                            </div>






                                @endif
                                @endif

                                @if($omr_code == 9113)
                                            <br />
                                            <b>45 Mraks Paper</b>
                                            <br />
                                            <a class="btn btn-xs btn-primary  " target="_blank" href="{{ url('files/9115') }}/dc_1_9115_2.pdf">English</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_2_9115_2.pdf">Hindi</a>
                                            <a class="btn btn-xs btn-primary  " target="_blank" href="{{ url('files/9115') }}/dc_3_9115_2.pdf">Oriya</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_4_9115_2.pdf">Telugu</a>
                                            

                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_5_9115_2.pdf">Malayalam</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_7_9115_2.pdf">Gujrathi</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_8_9115_2.pdf">Assamese</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_9_9115_2.pdf">Marathi</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_10_9115_2.pdf">Kannada</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_11_9115_2.pdf">Tamil</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_12_9115_2.pdf">Punjabi</a>
                                            <a class="btn btn-xs btn-primary  "  target="_blank" href="{{ url('files/9115') }}/dc_14_9115_2.pdf">Bilingual</a>
                                @endif



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
