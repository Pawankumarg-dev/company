@extends('layouts.evaluationcenter')
@section('content')
    @php
        use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
    @endphp

    <style>
        @media print {
            #printPageButton {
                display: none;
            }
            #noprint {
                display: none;
            }
            .noprint {
                display: none;
            }
            a[href]:after {
                display: none;
                visibility: hidden;
            }
        }
    </style>

    <header class="noprint">
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

    <section class="noprint">
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

    <section class="noprint">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="center-text" colspan="2">Evaluation Center Information</th>
                            </tr>
                            <tr>
                                <th width="6%">Code</th>
                                <td>{{ $evaluationcenter->code }}</td>
                            </tr>
                            <tr>
                                <th width="6%">Name</th>
                                <td>{{ $evaluationcenter->name }}</td>
                            </tr>
                            <tr>
                                <th width="6%">Address</th>
                                <td>{{ $evaluationcenter->address }}, {{ $evaluationcenter->state }} - {{ $evaluationcenter->pincode }}.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="printPageButton">
        <section class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-sm pull-right" onclick="window.print();return false;">
                            <span class="glyphicon glyphicon-print"></span> Print Bundle Numbers
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <br>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed" style="border-width:5px; border-style:double;">
                            <thead>
                            <tr class="red-text" style="border-width:5px; border-style:double;">
                                <th colspan="10" class="center-text bold-text">
                                    Note: Please taken in Print in Landscape mode
                                </th>
                            </tr>
                            <tr style="border-width:5px; border-style:double;">
                                <th colspan="10" class="center-text">
                                    {{ $title }} - Print Bundle Numbers
                                </th>
                            </tr>
                            <tr style="border-width:5px; border-style:double;">
                                <th width="5%" class="center-text" style="border-width:5px; border-style:double;">S.No.</th>
                                <th width="10%" class="center-text" style="border-width:5px; border-style:double;">Bundle No.</th>
                                <th width="1%" class="center-text" style="border-width:5px; border-style:double;"></th>
                                <th width="20%" class="center-text" style="border-width:5px; border-style:double;">Part - A</th>
                                <th width="1%" class="center-text" style="border-width:5px; border-style:double;"></th>
                                <th width="20%" class="center-text" style="border-width:5px; border-style:double;">Part - B</th>
                                <th width="1%" class="center-text" style="border-width:5px; border-style:double;"></th>
                                <th width="20%" class="center-text" style="border-width:5px; border-style:double;">Green Cover</th>
                                <th width="1%" class="center-text" style="border-width:5px; border-style:double;"></th>
                                <th width="20%" class="center-text" style="border-width:5px; border-style:double;">Additional</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $sno = 1; @endphp
                            @foreach($markexamattendances as $markexamattendance)
                                <tr style="border-width:5px; border-style:double;">
                                    <td class="center-text"  style="border-width:5px; border-style:double;">{{ $sno }}</td>
                                    <td class="center-text" style="border-width:5px; border-style:double;">{{ $markexamattendance->bundle_number }}</td>

                                    <th width="1%" class="center-text" style="border-width:5px; border-style:double;"></th>
                                    <td class="center-text bold-text" style="border-width:5px; border-style:double;">
                                        {{ $markexamattendance->bundle_number }}
                                    </td>

                                    <th width="1%" class="center-text" style="border-width:5px; border-style:double;"></th>
                                    <td class="center-text bold-text" style="border-width:5px; border-style:double;">
                                        {{ $markexamattendance->bundle_number }}
                                    </td>

                                    <th width="1%" class="center-text" style="border-width:5px; border-style:double;"></th>
                                    <td class="center-text bold-text" style="border-width:5px; border-style:double;">
                                        {{ $markexamattendance->bundle_number }}
                                    </td>

                                    <th width="1%" class="center-text" style="border-width:5px; border-style:double;"></th>
                                    <td class="center-text bold-text" style="border-width:5px; border-style:double;">
                                        {{ $markexamattendance->bundle_number }}
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

