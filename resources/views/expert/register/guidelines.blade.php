@extends('layouts.expertpool')

@section('content')
    <!--header-->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background">
                    <div class="center-text">
                        NIEPMD-NBER
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text">
                        Experts Pool
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text">
                        <div class="bold-text">Guidelines for Registering Experts Pool</div>
                        (Please read the guidelines carefully before filling the form)
                    </div>
                    <p></p>
                    <ol>
                        <li></li>
                        <li>
                            <a href="{{ url('/examinerexperts/register/') }}">
                                Click here to register for Experts Pool
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <!--header-->
@endsection