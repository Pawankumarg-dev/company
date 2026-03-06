@extends('layouts.app')

@section('content')

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    BASLP Exam
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr class="grey-background">
                                <th>S. No</th>
                                <th>Name</th>
                                <th>Date of Exam</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Options</th>
                            </tr>

                            @php $sno = 1; @endphp
                            @foreach($exams as $e)
                                <tr>
                                    <td>{{ $sno }}</td>
                                    <td>{{ $e->name }}</td>
                                    <td>{{ $e->date->format("d-m-Y") }}</td>
                                    <td>
                                        {{\Carbon\Carbon::createFromFormat('H:i:s', $e->starttime)->format('h:i A')}}
                                    <td>
                                        {{\Carbon\Carbon::createFromFormat('H:i:s', $e->endtime)->format('h:i A')}}
                                    </td>
                                    <td>
                                        <a href="{{ url('/nber/baslp-exam/'.$e->id.'/show-examcenters-list') }}"
                                        class="btn btn-info btn-sm">
                                            View Exam Centers
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                </div>
            </div>
        </div>
    </section>

@endsection