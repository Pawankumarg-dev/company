@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Incidental Charges Payment - {{ $academicyear->year }} || View Institutes
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="breadcrumb col-sm-12">
                                            <li><a href="{{url('/')}}">Home</a></li>
                                            <li><a href="{{url('/nber/payments/')}}">Payments</a></li>
                                            <li><a href="{{url('/nber/payments/incidentalcharge')}}">Incidental Charges</a></li>
                                            <li><b>{{ $academicyear->year }} : View Institutes</b></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="5%">S.No.</th>
                                                    <th width="5%">Institute Code</th>
                                                    <th>Institute Name</th>
                                                    <th width="15%">Course Code</th>
                                                    <th>Course Abbreviation</th>
                                                    <th>Term</th>
                                                </tr>
                                                </thead>

                                                @php $sno = 1; @endphp
                                                <tbody>
                                                @foreach($approvedprogrammes as $approvedprogramme)
                                                    <tr>
                                                        <td class="center-text">{{ $sno }} @php $sno++; @endphp</td>
                                                        <td class="center-text">{{ $approvedprogramme->institute->code }}</td>
                                                        <td>{{ $approvedprogramme->institute->name }}</td>
                                                        <td>{{ $approvedprogramme->programme->course_name }}</td>
                                                        <td>{{ $approvedprogramme->programme->name }}</td>
                                                        <td class="center-text">{{ $approvedprogramme->programme->numberofterms }}</td>
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
        </div>
    </section>
@endsection
