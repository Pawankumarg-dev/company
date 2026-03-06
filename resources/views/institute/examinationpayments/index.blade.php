@extends('layouts.app')

@section('content')
    @php
        use App\Http\Controllers\Institute\ExaminationpaymentController;
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Payment for Examination Fee
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                           
                                        </section>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-condensed">
                                                <tr>
                                                    <th class="text-center">S.No</th>
                                                    <th class="text-center">Exam</th>
                                                    <th class="text-center">Students Count</th>
                                                    <th class="text-center">Papers Applied Count</th>
                                                    <th class="text-center">Payment Link</th>
                                                </tr>

                                                @php $sno = 1; @endphp
                                                @foreach($exams as $exam)
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ $sno }}@php $sno++;  @endphp</td>
                                                        <td>{{ $exam->name }}</td>
                                                        <td class="text-center"><span class="label label-success h6-text">{{ $exam->appliedcandidatecount($exam->id, $institute->id) }}</span></td>
                                                        <td class="text-center"><span class="label label-primary h6-text">{{ $exam->appliedsubjectcount($exam->id, $institute->id) }}</span></td>
                                                        <td class="text-center">
                                                            @php
                                                                $hrefvalue = "/institute/examinationpayments/showcourses/".$exam->id;
                                                            @endphp
                                                            <a href="javascript:void(0)" onclick="location.href='{{ $hrefvalue }}'" class="btn btn-warning">
                                                                <span class="glyphicon glyphicon-hand-right white-color bold-text"></span>&nbsp; Click Here
                                                            </a>
                                                        </td>
                                                    <!--
                                    <td class="text-center">
                                        @php
                                                        $hrefvalue = "/institute/examinationpayments/";
                                                    @endphp
                                                            <a href="{{ $hrefvalue }}" class="btn btn-warning">
                                            <span class="glyphicon glyphicon-hand-right white-color bold-text"></span>&nbsp; Check Here
                                        </a>

                                        <a href="javascript:void(0)" onclick="location.href='#'" class="btn btn-info">
                                            <span class="glyphicon glyphicon-hand-right white-color bold-text"></span>&nbsp; Enter Here
                                        </a>
                                    </td>
                                    -->
                                                    </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
