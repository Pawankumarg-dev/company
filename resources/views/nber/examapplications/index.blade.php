@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Exam Applications
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr class="grey-background">
                                <th class="center-text">S. No.</th>
                                <th class="center-text">Exam</th>
                                <th class="center-text">Options</th>
                            </tr>
                            @php $sno = '1'; @endphp
                            @foreach($exams as $e)
                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="center-text blue-text">{{ $e->name }} Examination</td>
                                    <td class="center-text blue-text">
                                        <a href="{{ url('/nber/examapplications/'.$e->id.'/show-batches') }}" class="btn btn-sm btn-info">
                                            View Details
                                        </a>
                                    </td>
                                </tr>

                                @php $sno++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </section>
@endsection