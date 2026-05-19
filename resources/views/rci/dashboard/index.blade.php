@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">

        {{-- ============================= --}}
        {{-- NI Wise Admission --}}
        {{-- ============================= --}}

        <div class="col-md-12">

            <div class="panel panel-info">

                <div class="panel-heading">
                    NI Wise Admission
                </div>

                <div class="panel-body">

                    <table class="table table-bordered table-striped table-hover">

                        <thead>

                            <tr>
                                <th>NBER</th>
                                <th>Applications Received</th>
                                <th>Not verified</th>
                                <th>Verified</th>
                                <th>Correction Required</th>
                                <th>Incomplete</th>
                                <th>Rejected</th>
                            </tr>

                        </thead>

                        <tbody>

                            @php
                                $totalApplications = 0;
                                $totalNotVerified = 0;
                                $totalVerified = 0;
                                $totalCorrection = 0;
                                $totalIncomplete = 0;
                                $totalRejected = 0;
                            @endphp

                            @foreach($nberData as $data)

                                @php
                                    $totalApplications += $data['applications'];
                                    $totalNotVerified += $data['not_verified'];
                                    $totalVerified += $data['verified'];
                                    $totalCorrection += $data['correction_required'];
                                    $totalIncomplete += $data['incomplete'];
                                    $totalRejected += $data['rejected'];
                                @endphp

                                <tr>

                                    <td>{{ $data['name'] }}</td>

                                    <td>{{ $data['applications'] }}</td>

                                    <td>{{ $data['not_verified'] }}</td>

                                    <td>{{ $data['verified'] }}</td>

                                    <td>{{ $data['correction_required'] }}</td>

                                    <td>{{ $data['incomplete'] }}</td>

                                    <td>{{ $data['rejected'] }}</td>

                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr>

                                <th>Total</th>

                                <th>{{ $totalApplications }}</th>

                                <th>{{ $totalNotVerified }}</th>

                                <th>{{ $totalVerified }}</th>

                                <th>{{ $totalCorrection }}</th>

                                <th>{{ $totalIncomplete }}</th>

                                <th>{{ $totalRejected }}</th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>


        {{-- ============================= --}}
        {{-- Course Admissions --}}
        {{-- ============================= --}}

        <div class="col-md-12">

            <div class="panel panel-info">

                <div class="panel-heading">
                    Course Admissions
                </div>

                <div class="panel-body">

                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>
                                <th>Programme</th>
                                <th>Abbreviation</th>
                                <th>NBER</th>
                                <th>Maximum Intake</th>
                                <th>Applications Received</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($programmeData as $programme)

                                <tr>

                                    <td>{{ $programme['programme'] }}</td>

                                    <td>{{ $programme['abbreviation'] }}</td>

                                    <td>{{ $programme['nber'] }}</td>

                                    <td>{{ $programme['max_intake'] }}</td>

                                    <td>{{ $programme['applications'] }}</td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection