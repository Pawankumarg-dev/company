@extends('layouts.expertpool')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Examination Expert - Edit Application
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            You have successfully update the Stage-II Application
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-stripped table-bordered table-condensed">
                            <tr class="grey-background">
                                <td class="text-left green-text" colspan="2">
                                    <b>Stage {{$expertstage->id}} {{ $expertstage->name }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="green-text">Application No.</td>
                                <th class="blue-text">{{ $expert->application_no }}</th>
                            </tr>
                            <tr>
                                <td class="green-text">Name</td>
                                <th class="blue-text">{{ $expert->title }} {{ $expert->name }}</th>
                            </tr>
                            <tr>
                                <td class="green-text">Address</td>
                                <th class="blue-text">
                                    @if($expert->door_no != "")
                                        {{ $expert->door_no }},
                                    @endif
                                    @if($expert->building_name != "")
                                        {{ $expert->building_name }},<br>
                                    @endif
                                    @if($expert->street1 != "")
                                        {{ $expert->street1 }},<br>
                                    @endif
                                    @if($expert->street2 != "")
                                        {{ $expert->street2 }},<br>
                                    @endif
                                    @if($expert->landmark != "")
                                        Landmark: {{ $expert->landmark }},<br>
                                    @endif
                                    @if($expert->postoffice != "")
                                        Post Office: {{ $expert->postoffice }},<br>
                                    @endif
                                    @if($expert->talukoffice != "")
                                        Taluk Office: {{ $expert->talukoffice }},<br>
                                    @endif
                                    @if($expert->city_id != "")
                                        District: {{ $expert->city->name }},<br>
                                        State: {{ $expert->city->state->state_name }},<br>
                                    @endif
                                    @if($expert->pincode != "")
                                        Pincode: {{ $expert->pincode }}
                                    @endif
                                </th>
                            </tr>
                        </table>

                    </div>
                </div>

                <a href="{{ url('/expert/application/edit/'.$expert->id) }}" class="btn btn-info btn-sm">Click here to go Main Edit Page</a>
            </div>
        </div>
    </section>
@endsection