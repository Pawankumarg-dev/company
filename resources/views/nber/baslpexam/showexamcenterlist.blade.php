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
                    <table class="table table-bordered table-condensed">
                        <tr class="grey-background">
                            <th>S. No</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Options</th>
                        </tr>

                        @php $sno = 1; @endphp
                        @foreach($examcenterdetails as $detail)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td>{{ $detail->baslpexamcenter->code }}</td>
                                <td>
                                    {{ $detail->baslpexamcenter->name }}<br>{{ $detail->baslpexamcenter->address }},
                                    {{ $detail->baslpexamcenter->city->name }},
                                    {{ $detail->baslpexamcenter->city->state->state_name }} - {{ $detail->baslpexamcenter->pincode }}.
                                </td>
                                <td>
                                    <a href="{{ url('/nber/baslp-exam/'.$detail->baslpexam->id.'/show-candidates-list/'.$detail->baslpexamcenter->id) }}"
                                       class="btn btn-info btn-sm">
                                        View Exam Centers
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