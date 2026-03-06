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

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            You have successfully updated the {{ $expertstage->name }}
                        </div>
                    </div>
                </div>
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
                </table>

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-condensed table-responsive">
                            <tr>
                                <th class="grey-background" colspan="10">
                                    <div class="center-text">
                                        {{ $expertstage->name }}
                                    </div>
                                    <div class="right-text">
                                        <a href="{{ url('/expert/application/edit/stage8/addform/'.$expert->id) }}" class="btn btn-success btn-sm">Add Language</a>
                                    </div>
                                </th>
                            </tr>
                            <tr class="grey-background">
                                <th class="center-text">S. No</th>
                                <th class="center-text">Languages</th>
                                <th class="center-text">Speak</th>
                                <th class="center-text">Read</th>
                                <th class="center-text">Write</th>
                                <th class="center-text">Options</th>
                            </tr>

                            @php $sno='1'; @endphp
                            @foreach($expert->expertlanguages as $el)
                                <tr>
                                    <td class="center-text">{{ $sno }}</td>
                                    <td class="center-text">{{ $el->language->language }}</td>
                                    <td class="center-text">{{ $el->speak_status }}</td>
                                    <td class="center-text">{{ $el->read_status }}</td>
                                    <td class="center-text">{{ $el->write_status }}</td>
                                    <td class="center-text blue-text">
                                        <div class="center-text">
                                            <a href="{{ url('/expert/application/edit/stage8/form/'.$el->id) }}" class="btn btn-info btn-xs">Edit</a>
                                            <a href="{{ url('/expert/application/edit/stage8/delete/'.$el->id) }}" class="btn btn-danger btn-xs">Delete</a>
                                        </div>
                                    </td>
                                </tr>

                                @php $sno++; @endphp
                            @endforeach
                        </table>
                        </div>

                    </div>
                </div>

                <a href="{{ url('/expert/application/edit/'.$expert->id) }}" class="btn btn-info btn-sm">Click here to go Main Edit Page</a>
            </div>
        </div>
    </section>
@endsection