@extends('layouts.expertpool')

<style>
    .imageupload {
        margin: 20px 0;
    }
</style>

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-stripped table-bordered table-condensed">
                    <tr>
                        <td class="center-text green-text" colspan="2">You have successfully completed the
                            <b>Stage 10 of the Online Expert Pool Application</b>
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
                        <td class="green-text">Photo</td>
                        <th class="blue-text">
                            <img src="{{asset('/files/experts/photo')}}/{{ $expert->file_photo}}"  style="width: 100px;" class="img" />

                        </th>
                    </tr>
                    <tr>
                        <td class="green-text">Stage-X status</td>
                        <th class="blue-text">Completed</th>
                    </tr>
                </table>


                {{--
                <a href="{{ url('/expert/application/print/'.$expert->id) }}" class="btn btn-info">Print Application</a>
                --}}

            </div>
        </div>
    </section>
@endsection