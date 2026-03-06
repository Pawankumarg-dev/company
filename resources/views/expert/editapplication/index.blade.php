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
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-6 well well-sm white-background minus15px-margin-top">
                    <table class="table table-bordered table-condensed">
                        <tr class="grey-background">
                            <th class="text-center">S. No</th>
                            <th class="text-center">Stages</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Options</th>
                        </tr>

                        @php $sno='1'; @endphp
                        @foreach($expertstages as $es)
                                <tr>
                                    @if($es->id <= $expert->stages_passed)
                                        <td class="blue-text text-center">{{ $sno }}</td>
                                        <td class="blue-text text-left">Stage - {{ $sno }} ({{ $es->name }})</td>
                                        <td class="blue-text text-center">Completed</td>
                                        <td class="blue-text text-center">
                                            <a href="{{ url('/expert/application/edit/stage'.$es->id.'/display/'.$expert->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        </td>
                                    @else
                                        <td class="red-text text-center">{{ $sno }}</td>
                                        <td class="red-text text-left">Stage - {{ $sno }} ({{ $es->name }})</td>
                                        <td class="red-text text-center">Not Completed</td>
                                        <td class="red-text text-center">
                                        </td>
                                    @endif

                                </tr>

                                @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>

                <div class="col-sm-3"></div>
            </div>
        </div>
    </section>
@endsection