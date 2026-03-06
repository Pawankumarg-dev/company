@extends('layouts.app')

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
        }
    </style>

    <div id="noprint" class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/nber/evaluations')}}">Evaluations</a></li>
                    <li><a href="{{url('/nber/evaluations/bundles')}}">Exam Bundles</a></li>
                    <li><a href="{{url('/nber/evaluations/bundles/'.$exam->id)}}">{{ $exam->name }} Examinations</a></li>
                    <li><span class="bold-text blue-text">Bundle Number: {{ $bundle_number }}</span></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="printPageButton">
        <section class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-sm pull-right" onclick="window.print();return false;">
                            <span class="glyphicon glyphicon-print"></span> Print Foilsheet
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>

        <table border="1" cellspacing="5px" cellpadding="0" width="100%">
            <thead>
            <tr>
                <th class="center-text" colspan="6">
                    NIEPMD-NBER<br>
                    {{ $exam->name }} Examinations - Foilsheet
                </th>
            </tr>
            <tr>
                <th class="center-text" colspan="2">
                    Subject Details
                </th>
                <th class="left-text" colspan="4">
                    {{ $subject->scode }} - {{ $subject->sname }}
                </th>
            </tr>
            <tr>
                <th class="center-text" colspan="2">
                    Date of Evaluation :
                </th>
                <th class="center-text" colspan="1">

                </th>
                <th class="center-text" colspan="1">
                    Bundle Number :
                </th>
                <th class="center-text" colspan="1">
                    <span class="h5-text">
                    {{ $bundle_number }}
                    </span>
                </th>
                <th class="center-text" colspan="1" style="padding: 10px">
                    @php
                        $barcode = new BarcodeGenerator();
                        $barcode->setText($bundle_number);
                        $barcode->setType(BarcodeGenerator::Code128);
                        $barcode->setScale(2);
                        $barcode->setThickness(25);
                        $barcode->setFontSize(20);
                        $code = $barcode->generate();

                        echo '<img src="data:image/png;base64,'.$code.'" />';
                    @endphp
                </th>
            </tr>
            <tr>
                <th class="center-text" width="3%">S.No.</th>
                <th class="center-text" width="10%">Reference Number</th>
                <th class="center-text" width="10%">Barcode</th>
                <th class="center-text" width="5%">Marks Obtained</th>
                <th class="center-text" width="10%">Remarks-1</th>
                <th class="center-text" width="10%">Remarks-2</th>
            </tr>

            </thead>

            @php $sno = 1; @endphp
            @foreach($applications as $application)
                <tbody>
                <tr>
                    <td class="center-text">{{ $sno }}</td>
                    <td class="center-text">
                        {{ $application->dummy_number }}
                    </td>
                    <td class="center-text" style="padding: 10px">
                        @php
                            $barcode = new BarcodeGenerator();
                            $barcode->setText($application->dummy_number);
                            $barcode->setType(BarcodeGenerator::Code128);
                            $barcode->setScale(3);
                            $barcode->setThickness(20);
                            $barcode->setFontSize(10);
                            $code = $barcode->generate();

                            echo '<img src="data:image/png;base64,'.$code.'" />';
                        @endphp
                    </td>
                    <td class="center-text"></td>
                    <td class="center-text"></td>
                    <td class="center-text"></td>
                </tr>
                </tbody>
                @php $sno++; @endphp
            @endforeach

            <tfoot>
            <tr>
                <th colspan="2">Name of the Evaluator :</th>
                <th colspan="2"></th>
                <th colspan="1">Signature of the Evaluator</th>
                <th colspan="1"></th>
            </tr>
            <tr>
                <th colspan="2">Marks entered by</th>
                <th colspan="1"></th>
                <th colspan="1"></th>
                <th colspan="1">Marks verified by</th>
                <th colspan="1"></th>
            </tr>
            </tfoot>
        </table>
@endsection