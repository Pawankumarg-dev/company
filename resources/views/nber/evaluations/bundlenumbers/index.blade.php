@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/nber/evaluations')}}">Evaluations</a></li>
                    <li><span class="bold-text blue-text">Exam Bundles</span></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 well well-sm white-background">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Exams</th>
                            <th class="center-text">Link</th>
                        </tr>
                        </thead>

                        @php $sno = 1; @endphp
                        @foreach($exams as $exam)
                            <tbody>
                            <tr>
                                <td>{{ $sno }}</td>
                                <td>{{ $exam->name }}</td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/evaluations/bundles/'.$exam->id) }}"
                                        class="btn btn-primary"
                                    >
                                        <span class="glyphicon glyphicon-book"></span> Exam Bundles
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </section>
@endsection