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
                        <td class="green-text">{{ $expert->relationtype->name }}'s Name</td>
                        <th class="blue-text">{{ $expert->relation_name }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Gender</td>
                        <th class="blue-text">{{ $expert->gender->gender }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Date of Birth</td>
                        <th class="blue-text">{{ $expert->dob->format("d-m-Y") }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Email ID</td>
                        <th class="blue-text">{{ $expert->email }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Mobile No.</td>
                        <th class="blue-text">
                            {{ $expert->contactnumber1 }}
                            @if($expert->contactnumber2 != "")
                                , {{ $expert->contactnumber2 }}
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <td class="green-text">Status of Disability</td>
                        <th class="blue-text">{{ $expert->has_disability }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Aadhaar Card Number</td>
                        <th class="blue-text">{{ $expert->aadhaarcard_no }}</th>
                    </tr>
                </table>

                <a href="{{ url('/expert/application/edit/stage1/form/'.$expert->id) }}" class="btn btn-info btn-sm">Click here to Edit</a>
            </div>
        </div>
    </section>
@endsection