@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-stripped table-bordered table-condensed">
                    <tr>
                        <td class="center-text green-text" colspan="2">You have successfully completed the
                            <b>Stage 2 of the Online Expert Pool Application</b>
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
                            @if($expert->street3 != "")
                                {{ $expert->street3 }},<br>
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
                    <tr>
                        <td class="green-text">Stage-II status</td>
                        <th class="blue-text">Completed</th>
                    </tr>
                </table>

                <a href="{{ url('/expert/application/new/applystage3/'.$expert->id) }}" class="btn btn-info">Click here to apply for Stage-III</a>

            </div>
        </div>
    </section>
@endsection