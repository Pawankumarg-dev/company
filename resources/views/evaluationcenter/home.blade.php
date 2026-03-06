@extends('layouts.evaluationcenter')
@section('content')
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background">
                    <div class="center-text">
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background minus15px-margin-top">
                    <div class="center-text bold-text">

                        {{$title}}

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="center-text" colspan="2">Evaluation Center Information</th>
                            </tr>
                            <tr>
                                <th width="10%">Code</th>
                                <td class="bold-text">{{ $evaluationcenter->code }}</td>
                            </tr>
                            <tr>
                                <th width="10%">Name</th>
                                <td>{{ $evaluationcenter->name }}</td>
                            </tr>
                            <tr>
                                <th width="10%">Address</th>
                                <td>{{ $evaluationcenter->address }}, {{ $evaluationcenter->state }} - {{ $evaluationcenter->pincode }}.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8 well well-sm white-background minus15px-margin-top">
                    <div class="pull-right">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                <tr>
                                    <th class="center-text" colspan="4">Exam Information</th>
                                </tr>
                                <tr>
                                    <th class="orange-text center-text" width="5%">S.No.</th>
                                    <th class="orange-text center-text" width="20%">Exam</th>
                                    <th class="orange-text center-text" width="65%">Remarks</th>
                                    <th class="orange-text center-text" width="10%">Evaluation<br>Link</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if($exams->count() == 0)
                                    <tr>
                                        <td class="red-text center-text" colspan="4">
                                            <h2>No record founds</h2>
                                        </td>
                                    </tr>
                                @else
                                    @php $sno = 1; @endphp
                                    @foreach($exams as $exam)
                                        @php
                                            $evaluationcenterdetail = \App\Evaluationcenterdetail::where('exam_id', $exam->id)->where('evaluationcenter_id', $evaluationcenter->id)->first();
                                        @endphp

                                        @if(!is_null($evaluationcenterdetail))
                                            <tr>
                                                <td class="blue-text center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                <td class="blue-text">{{ $exam->name }}</td>
                                                <td class="blue-text">
                                                    {{ $evaluationcenterdetail->remarks }}
                                                </td>
                                                <td class="center-text">
                                                    <a href="{{ url('/evaluationcenter/'.$evaluationcenter->id.'/'.$exam->id) }}" class="btn btn-success btm-xs" target="_blank">
                                                        <span class="glyphicon glyphicon-circle-arrow-right"></span>
                                                        Click
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif

                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </section>

@endsection
