@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Course Coordinators</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>Course Coordinators Details</h3>
                            </div>
                            <div class="col-sm-6">
                                <div class="pull-right">
                                    <a href="{{ url('/institute/coursecoordinators/create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Member</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <th width="3%">S.No.</th>
                                <th width="13%">Course</th>
                                <th width="30%">Name</th>
                                <th>Email Address</th>
                                <th width="7%">Mobile Number</th>
                                <th width=6%">DoB</th>
                                <th width="10%">Link</th>
                            </tr>
                            @php $sno = '1'; @endphp
                            @foreach($approvedcoursecoordinators as $acc)
                                @if(\App\Coursecoordinator::find($acc->coursecoordinator_id))
                                    <tr>
                                        <td>{{ $sno }}</td>
                                        <td>{{ $acc->programme->common_code }}</td>
                                        <td>{{ $acc->coursecoordinator->title->title }} {{ $acc->coursecoordinator->name }}</td>
                                        <td>
                                            @if(!is_null($acc->coursecoordinator->email_address2))
                                                {{ $acc->coursecoordinator->email_address1 }}, <br>{{$acc->coursecoordinator->email_address2}}
                                            @else
                                                {{ $acc->coursecoordinator->email_address1 }} <br>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!is_null($acc->coursecoordinator->mobile_number2))
                                                {{ $acc->coursecoordinator->mobile_number1 }}, <br>{{$acc->coursecoordinator->mobile_number2}}
                                            @else
                                                {{ $acc->coursecoordinator->mobile_number1 }}<br>
                                            @endif
                                        </td>
                                        <td>{{ $acc->coursecoordinator->dob->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ url('/institute/coursecoordinators/download/'.$acc->coursecoordinator->id) }}" class="btn btn-info btn-sm" target="_blank">
                                                <span class="glyphicon glyphicon-eye-open"></span> View
                                            </a>
                                        </td>

                                    </tr>
                                    @php $sno++; @endphp
                                @endif
                            @endforeach

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
