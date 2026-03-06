@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li> <a href="{{url('/payment')}}">Payments</a> </li>
                    <li><a href="{{url('/institute/payment/enrolment')}}"> Enrolment Payments</a></li>
                    <li>{{ $academicyear->year }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-right">
                    <a href="{{ url('/institute/payment/enrolment/academicyear/'.$academicyear->id).'/selectstudents' }}" class="btn btn-primary">Add Payment</a>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">Batch</th>
                        <th class="text-center">Date of Payment</th>
                        <th class="text-center">Transaction Bank</th>
                        <th class="text-center">Transaction Number</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center">View Payment Details</th>
                    </tr>



                    @foreach($approvedprogrammes as $ap)
                        <tr>
                            <td class="text-center">{{ $ap->academicyear->year }}</td>
                            <td class="text-center">{{ $ap->programme->course_name }}</td>
                            <td class="text-center">{{ $ap->maxintake }}</td>
                            <td class="text-center">{{ $ap->candidates->count() }}</td>
                            <td class="text-center">
                                <a href="{{url('/institute/payment/enrolment/approvedprogramme/'.$ap->id)}}" class="btn btn-sm btn-info">
                                    Select
                                </a>
                            </td>
                            <td></td>

                        </tr>


                    @endforeach
                </table>


            </div>
        </div>
    </div>
@endsection