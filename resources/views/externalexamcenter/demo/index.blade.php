@extends('layouts.externalexamcenter')

@section('content')
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background">
                    <div class="center-text">
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background minus15px-margin-top">
                    <div class="center-text bold-text">

                        {{$title}}

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/demoexternalexamcenter/checklogin')}}" autocomplete="off" accept-charset="UTF-8"
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

                    <div class="form-group {{ $errors->has('demoexternalexamcenter_code') ? 'has-error' : '' }}">
                        <label for="demoexternalexamcenter_code" class="control-label col-sm-4">
                            <div class="left-text">
                                <div class="blue-text">Exam Center Code</div>
                            </div>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="demoexternalexamcenter_code" name="demoexternalexamcenter_code" placeholder="Enter Exam Center Code" value="{{ old('demoexternalexamcenter_code') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#demoexternalexamcenter_code').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('demoexternalexamcenter_password') ? 'has-error' : '' }}">
                        <label for="demoexternalexamcenter_password" class="control-label col-sm-4">
                            <div class="left-text">
                                <div class="blue-text">Password</div>
                            </div>
                        </label>
                        <div class="col-sm-6">
                            <input type='password' class="form-control" placeholder="Enter password" id="demoexternalexamcenter_password" name="demoexternalexamcenter_password"/>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-3"></div>
        </div>
    </section>

@endsection