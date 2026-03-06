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

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover">
                        <tr class="grey-background">
                            <th>S. No</th>
                            <th>Roll No</th>
                            <th>Photo</th>
                            <th>Candidate Name</th>
                            <th>Father's Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Category</th>
                            <th>Options</th>
                        </tr>

                        @php $sno = 1; @endphp
                        @foreach($examcenterdetails as $detail)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td>{{ $detail->baslpcandidate->roll_no }}</td>
                                <td class="center-text" width="10%">
                                    <img src="{{asset('/files/baslp/photos')}}/{{ $detail->baslpcandidate->file_photo}}"  style="width: 100px;" class="img" />
                                </td>
                                <td>{{ $detail->baslpcandidate->name }}</td>
                                <td>{{ $detail->baslpcandidate->relation_name }}</td>
                                <td>{{ $detail->baslpcandidate->dob->format('d-m-Y') }}</td>
                                <td>{{ $detail->baslpcandidate->gender->gender }}</td>
                                <td>{{ $detail->baslpcandidate->community->community }}</td>
                                <td>
                                    <a href="{{ url('/nber/baslp-exam/download-candidate-hallticket/'.$detail->id) }}"
                                       class="btn btn-info btn-sm" target="_blank">
                                        Download Admit Card
                                    </a>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                        {{--
                        @foreach($examcenterdetails as $details)
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
                                    <a href="{{ url('/nber/baslp-exam/'.$e->id.'/show-candidates-list') }}"
                                       class="btn btn-info btn-sm">
                                        Candidates Admit Card
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        --}}
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection