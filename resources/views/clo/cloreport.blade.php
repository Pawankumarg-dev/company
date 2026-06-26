
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-header" style="margin-top:0;">
                <span>CLO Report</span>
                <a class="btn btn-sm btn-success pull-right" href="{{ url('/clo/insert') }}">Add</a>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">

                    <thead>
                        <tr class="bg-primary">
                            <th >#</th>
                            <th>Days</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>File</th>
                            <th>Vidio</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(count($cloreports) > 0)

                            @foreach($cloreports as $index => $cloreport)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        {{ $cloreport->day}}
                                    </td>
                                    <td>
                                        {{ $cloreport->title }}
                                    </td>

                                    <td>
                                        {{ $cloreport->description }}
                                    </td>
                                    <td>
                                        @if(!empty($cloreport->file))
                                            <a href="{{ asset('files/examcenter/Clo-report/' . $cloreport->file) }}" target="_blank">Download PDF</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($cloreport->vidio))
                                            <div class="mt-1"><a href="{{ asset('files/examcenter/Clo-videos/' . $cloreport->vidio) }}" target="_blank">Open video</a></div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>

                            @endforeach

                        @else

                            <tr>
                                <td colspan="10" class="text-center text-danger">
                                    No Records Found
                                </td>
                            </tr>

                        @endif

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection