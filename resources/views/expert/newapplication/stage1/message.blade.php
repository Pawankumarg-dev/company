@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-stripped table-bordered table-condensed">
                    <tr>
                        <td class="center-text green-text" colspan="2">You have successfully completed the
                            <b>Stage 1 of the Online Expert Pool Application</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="center-text" colspan="2">
                            Kindly note down the following for your future references.
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
                        <td class="green-text">Date of Birth</td>
                        <th class="blue-text">{{ $expert->dob->format("d-m-Y") }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Email ID</td>
                        <th class="blue-text">{{ $expert->email }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Mobile No.</td>
                        <th class="blue-text">{{ $expert->contactnumber1 }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Stage-I status</td>
                        <th class="blue-text">Completed</th>
                    </tr>
                </table>

                <a href="{{ url('/expert/application/new/applystage2/'.$expert->id) }}" class="btn btn-info" target="_blank">Click here to apply Stage-II</a>

            </div>
        </div>
    </section>
@endsection