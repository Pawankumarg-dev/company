@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('common.errorandmsg')
            <form action="{{ url('qppublish') }}" method="get">
                <div class="form-group">
                    <label for="">Schedule</label>
                    <select name="examschedule_id" class="form-control" >
                        @foreach($examschedules as $ec)
                            @if($ec->id != 93) 
                                <?php 
                                    $date = \Carbon\Carbon::now()->toDateString();
                                    $sdate = \Carbon\Carbon::parse($ec->examdate)->toDateString();
                                    $time = \Carbon\Carbon::now()->toTimeString();
                                    $opentime  = \Carbon\Carbon::parse($ec->starttime)->subHours(1)->subMinutes(30)->toTimeString();
                                    $closetime  = \Carbon\Carbon::parse($ec->starttime)->addHours(1)->addMinutes(30)->toTimeString();
                                ?>
                                @if(
                                    // $sdate == $date &&
                                    // $time > $opentime &&
                                    // $time < $closetime && !is_null($schedule)
                                    1
                                )
                                    <option 
                                        @if(!is_null($schedule) && $schedule->id == $ec->id) selected @endif 
                                        value="{{ $ec->id }}"
                                    >
                                    {{ \Carbon\Carbon::parse($ec->examdate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($ec->starttime)->format('h:i A') }} 
                                    </option>
                                @endif
                            @endif 
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="form-control btn btn-primary" >Show</button>
                </div>
            </form>
        </div>
    
        @if(!is_null($timetable))
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Slno</th>
                        <th>NBER</th>
                        <th>Course</th>
                        <th>Subjet Code</th>
                        <th>Subject</th>
                        {{-- <th>Question Papers</th> --}}
                    </tr>
                    <?php $slno = 1; ?>
                    @foreach($timetable as $tt)
                        <tr>
                            <td>
                                {{ $slno }}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                {{ $tt->nber }}
                            </td>
                            <td>
                                {{ $tt->course }}
                            </td>
                            <td>
                                {{ $tt->scode }}
                            </td>
                            <td>
                                {{ $tt->sname }}
                            </td>
                            {{-- <td>
                                <a href="{{ url('ms/questionpapers') }}/{{ $tt->id }}?examschedule_id={{ $schedule->id }}" class="btn btn-xs btn-primary"  >Question Papers</a>
                            </td> --}}
                        </tr>
                    @endforeach
                </table>
              

                    @if(!is_null($schedule) && $schedule->qpset > 0)
                        <div class=" alert alert-success">
                            Question paper Set #{{ $schedule->qpset }} is released for  {{ \Carbon\Carbon::parse($schedule->examdate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($schedule->starttime)->format('h:i A') }} schedule
                        </div>
                    @else
                        <form action="{{ url('qppublishfor') }}" method="post">
                            <input type="hidden" name="examschedule_id" value="{{ $schedule->id }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="">Set</label>
                                <select name="set" class="form-control" >
                                    <option @if($schedule->qpset == 1)  selected @endif value="1">Set #1</option>
                                    <option @if($schedule->qpset == 2)  selected @endif  value="2">Set #2</option>
                                    <option @if($schedule->qpset == 3)  selected @endif  value="3">Set #3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="form-control btn btn-primary" >Release</button>
                            </div>
                        </form>

                    @endif

            </div>
        @endif
    </div>
</div>
@endsection