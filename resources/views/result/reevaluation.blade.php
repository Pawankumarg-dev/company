@extends('layouts.result')

@section('content')
    <style>
        .h3-text {
            font-size: 30px;
            font-weight: bold;
        }
        .center-text {
            text-align: center !important;
        }
        .left-text {
            text-align: left !important;
        }
        .right-text {
            text-align: right !important;
        }
        .bold-text {
            font-weight: bold;
        }
        .red-text {
            color: red;
        }
        .green-text {
            color: green;
        }
        .blue-text {
            color: blue;
        }
        .h4-text {
            font-size: 16px;
            font-weight: bold;
        }
        .h5-text {
            font-size: 15px;
            font-weight: bold;
        }
        .h6-text {
            font-size: 13px;
        }
        .h7-text {
            font-size: 12px;
        }
        .h8-text {
            font-size: 10px;
        }

    </style>


    {{-- container --}}
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-12">
                <div class="center-text">
                    <div class="text-primary">
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h5-text">{{ $reevaluation->exam->name }} Examination - Re-evaluation Result Page</span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Student Re-evaluation Result Page
                        </div>
                    </div>
                    <div class="panel-body">
                        @if($reevaluation->publish_status == '1')
                            <form class="form-horizontal" role="form" method="POST" action="{{url('/reevaluationresult')}}/{{$reevaluation->exam->id}}">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('enrolmentno') ? 'has-error' : '' }}">
                                    <label for="enrolmentno" class="control-label col-sm-4">Enrolment Number</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="enrolmentno" name="enrolmentno"
                                               value="" />
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
                                    <label for="dob" class="control-label col-sm-4">Date of Birth</label>
                                    <div class="col-sm-7">
                                        <input type="date" class="form-control" id="dob" name="dob"
                                               value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-5 col-sm-5">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <b>No Re-evaluation Result is activated</b>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-3"></div>
        </div>
    </div>
    {{-- ./container --}}

@endsection



