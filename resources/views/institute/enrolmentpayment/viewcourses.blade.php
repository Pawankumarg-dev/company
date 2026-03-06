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
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center">S. No</th>
                        <th class="text-center">Batch</th>
                        <th class="text-center">Programmme</th>
                        <th class="text-center">Maximum Intake</th>
                        <th class="text-center">Enrolled Students</th>
                        <th class="text-center">Payment Entry Link</th>
                    </tr>

                    @php $sno = '1'; @endphp

                    @foreach($approvedprogrammes as $ap)
                        <tr>
                            <td class="text-center">{{ $sno }}</td>
                            <td class="text-center">{{ $ap->academicyear->year }}</td>
                            <td class="text-center">{{ $ap->programme->course_name }}</td>
                            <td class="text-center">{{ $ap->maxintake }}</td>
                            <td class="text-center">{{ $ap->candidates->count() }}</td>
                            <td class="text-center">
                                <a href="{{url('/institute/payment/enrolment/course/'.$ap->id)}}" class="btn btn-sm btn-info">
                                    Select
                                </a>
                            </td>

                        </tr>

                        @php $sno++; @endphp
                    @endforeach
                </table>


            </div>
        </div>
    </div>
@endsection