@extends('layouts.app')

@section('content')
    @if (Session::has('messages') )
        @include('common.errorandmsg')
    @endif
    <section class="container">
        <div class="row">
            <div class="col-md-12">
            <h3>Candidate Enrolment - {{Session::get('academicyear')}}</h3>
            <table class="table table-bordered table-condensed">
                <tr>
                    <th rowspan="2"> Programme</th>
                    <th rowspan="2" class="text-center"> Alloted</th>
                    <th rowspan="2" class="text-center" >Uploaded</th>
                    <th colspan="2" class="text-center " >Verification</th> 
                    <th rowspan="2" class="text-center" > Candidate's List </th>
                </tr>
                <tr class="">
                    <th>
                        By TTI
                    </th>
                    <th>
                        By Student <small class='text-muted'>No of students completed OTP Verification</small>
                    </th>
                </tr>
                @foreach($approvedprogrammes as $ap)
                    <tr>
                        <td>{{ $ap->programme->course_name }}</td>
                        <td class="text-center">{{$ap->maxintake}}</td>
                        <td class="text-center">
                            {{$ap->candidates->count()}}
                            @if($ap->candidates->where('incomplete_2024_data',1)->count() > 0)
                                <div
                                    class="alert alert-danger hidden"
                                >
                                    Some of the condidate details are incomplete. Please update all the details.

                                    <a href="{{url('programme/'.$ap->id)}}"  class="btn btn-danger btn-xs" style="margin-top:10px;"><i class="fa fa-users"></i> &nbsp;&nbsp;Update Missing Data</a>
                                </div>
                            @endif
                        </td>
                        <td class="">
                            @if($ap->academicyear_id == 12)
                                @if(is_null($ap->admissiondeclaration->opt_verified_on))
                                
                                    <a href="{{url('programme/'.$ap->id)}}"  style="marigin-right:10px; margin-top:10px;" class="btn btn-danger btn-xs">Not Verified</a>
                                @else
                                    <span  class="label label-xs label-success" >
                                        Verified 
                                    </span>
                                   
                                @endif
                            @endif
                        </td>
                        <td class="text-center ">
                            {{$ap->candidates->where('is_mobile_number_verified','Yes')->count()}}
                        </td> 
                      {{--  <td class="">
                            <div class="">
                                   @php
                                    $incidentalstatus = \App\Http\Controllers\Institute\IncidentalchargeController::checkIncidentalChargesPaid($ap->id);
                                @endphp
                                @if($incidentalstatus == "")
                                    <span class="label label-danger">Not Paid</span>
                                    <a href="{{ url('/institute/incidentalpayments/'.$ap->academicyear_id) }}" class="btn btn-xs btn-primary">Make Payment</a>
                                    <small>Online payment is not available temporarily. Please check back again in few days.</small>
                                @elseif($incidentalstatus == "NO INFORMATION")
                                    <span class="label label-danger">{{ $incidentalstatus }}</span>
                                    <small>Online payment is not available temporarily. Please check back again in few days.</small>

                                    <a href="{{ url('/institute/incidentalpayments/'.$ap->academicyear_id) }}" class="btn btn-xs btn-primary">Enter Details</a>
                                    @elseif($incidentalstatus == "APPROVED")
                                    <span class="label label-success">{{ $incidentalstatus }}</span> 
                                    <a href="{{ url('/institute/incidentalpayments/'.$ap->academicyear_id) }}" target="_blank" class="btn btn-xs btn-primary">Check Details</a>
                                @else
                                    <span class="label label-warning">{{ $incidentalstatus }}</span>
                                    <a href="{{ url('/institute/incidentalpayments/'.$ap->academicyear_id) }}" class="btn btn-xs btn-primary" target="_blank">Check Details</a>
                                @endif
                               @if($ap->incidentalpayments->count() == 0)
                                <a href="{{ url('/institute/incidentalpayments/'.$ap->academicyear_id) }}" class="btn btn-xs btn-primary hidden" target="_blank">Make Payment</a>
                               @endif

                            </div>
                        </td> --}}
                        <td class="center-text ">
                            
                                <a href="{{url('programme/'.$ap->id)}}"  class="btn btn-info btn-xs "><i class="fa fa-users"></i> &nbsp;&nbsp;Candidate List</a>
                            
                        </td>
                        <td style="display:none;">
                            {{$ap->programme->recognised_by}}
                            @if($ap->programme->recognised_by == 'RCI')
                                <a class="btn btn-xs btn-primary" href="javascrip:editRB();">Edit</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            </div>
        </div>
    </section>
@endsection