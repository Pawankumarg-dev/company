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
                        <span class="h5-text">{{$title}}</span>
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
                            {{ $title }}
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{url('/tracking/correctionrequest/checkdetails/')}}">

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

                            <div class="form-group {{ $errors->has('reference_number') ? 'has-error' : '' }}">
                                <label for="reference_number" class="control-label col-sm-5">Correction Request Ref. No.</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="reference_number" name="reference_number" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-3"></div>
        </div>
    </div>
    {{-- ./container --}}

@endsection
