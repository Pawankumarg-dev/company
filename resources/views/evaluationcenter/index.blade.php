@extends('layouts.evaluationcenter')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="center-text">
                                <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                                <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                                <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{$title}}
                                </div>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST"
                                      action="{{url('/evaluationcenter/checklogin')}}" autocomplete="off" accept-charset="UTF-8"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    @if (Session::has('messages') )
                                        @include('common.errorandmsg')
                                    @endif

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

                                    <div class="form-group {{ $errors->has('evaluationcenter_code') ? 'has-error' : '' }}">
                                        <label for="evaluationcenter_code" class="control-label col-sm-4">
                                            <div class="left-text">
                                                <div class="blue-text">Evaluation Center Code</div>
                                            </div>
                                        </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="evaluationcenter_code" name="evaluationcenter_code" placeholder="Enter Evaluation Center Code" value="{{ old('evaluationcenter_code') }}"/>
                                            <script>
                                                $(document).ready(function () {
                                                    $('#evaluationcenter_code').keyup(function () {
                                                        $(this).val($(this).val().toUpperCase());
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('evaluationcenter_password') ? 'has-error' : '' }}">
                                        <label for="evaluationcenter_password" class="control-label col-sm-4">
                                            <div class="left-text">
                                                <div class="blue-text">Password</div>
                                            </div>
                                        </label>
                                        <div class="col-sm-6">
                                            <input type='password' class="form-control" placeholder="Enter password" id="evaluationcenter_password" name="evaluationcenter_password"/>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="panel-footer">
                                Please contact NIEPMD-NBER in case of any queries
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection