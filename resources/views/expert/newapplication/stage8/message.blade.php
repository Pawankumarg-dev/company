@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-stripped table-bordered table-condensed">
                    <tr>
                        <td class="center-text green-text" colspan="2">You have successfully completed the
                            <b>Stage 8 of the Online Expert Pool Application</b>
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
                        <td class="green-text">Stage-VIII status</td>
                        <th class="blue-text">Completed</th>
                    </tr>
                </table>

                <table class="table table-bordered table-condensed table-responsive">
                    <tr class="grey-background">
                        <th class="center-text">S. No</th>
                        <th class="center-text">Languages</th>
                        <th class="center-text">Speak</th>
                        <th class="center-text">Read</th>
                        <th class="center-text">Write</th>
                    </tr>

                    @if($expert->expertlanguages->count() == "0")
                        <tr>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                        </tr>
                    @else
                        @php $sno='1'; @endphp
                        @foreach($expert->expertlanguages as $el)
                            <tr>
                                <td class="center-text">{{ $sno }}</td>
                                <td class="center-text">{{ $el->language->language }}</td>
                                <td class="center-text">{{ $el->speak_status }}</td>
                                <td class="center-text">{{ $el->read_status }}</td>
                                <td class="center-text">{{ $el->write_status }}</td>
                            </tr>

                            @php $sno++; @endphp
                        @endforeach
                    @endif
                </table>

                <a href="{{ url('/expert/application/new/applystage9/'.$expert->id) }}" class="btn btn-info">Click here to apply for Stage-IX</a>

            </div>
        </div>
    </section>
@endsection