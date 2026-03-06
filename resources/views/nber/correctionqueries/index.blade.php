@extends('layouts.app');

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    <img src="{{asset('images/correctionquery_blue.png')}}" width="30px" height="30px" class="glyphicon glyphicon-picture"/>
                    Correction Query
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <a href="{{ url('/nber/correction-query/select-candidate/') }}" class="btn btn-sm pull-right" style="background-color: darkgreen; color: white; font-weight: bold">
                    <span class="glyphicon glyphicon-plus"></span>
                    Correction Query
                </a>
            </div>
        </div>
    </section>

    {{--
    <section class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="panel">
                    <div class="panel-body center-text">
                        <a href="{{ url('/nber/correction-query/new-entry') }}" target="_blank">
                            <img src="{{ asset('/images/new_entry_icon.png') }}" width="50%"><br>
                            <span class="btn btn-primary">Add New Correction Query Entry</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel">
                    <div class="panel-body center-text">
                        <a href="">
                            <img src="{{ asset('/images/edit_entry_icon.png') }}" width="50%"><br>
                            <span class="btn btn-primary">Edit Correction Query Entry</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel">
                    <div class="panel-body center-text">
                        <a href="">
                            <img src="{{ asset('/images/view_entry_icon.png') }}" width="50%"><br>
                            <span class="btn btn-primary">View Correction Query Entry</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel">
                    <div class="panel-body center-text">
                        <a href="">
                            <img src="{{ asset('/images/delete_entry_icon.png') }}" width="50%"><br>
                            <span class="btn btn-primary">Delete Correction Query Entry</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    --}}
@endsection