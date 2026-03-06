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
                    <div class="row">
                        <div class="col-sm-10">
                            <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="myInput" type="text" placeholder="Search..">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary btn-sm pull-right" onclick="window.print();return false;">
                                <span class="glyphicon glyphicon-print"></span> Print Foilsheet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <br>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th colspan="3" class="right-text">
                                    Bundle No.
                                </th>
                                <th colspan="3" class="center-text">
                                    {{ $common->bundle_number }}
                                </th>

                                <th colspan="2" class="center-text">
                                    @php
                                        $barcode = new BarcodeGenerator();
                                        $barcode->setText($common->bundle_number);
                                        $barcode->setType(BarcodeGenerator::Code128);
                                        $barcode->setScale(1);
                                        $barcode->setThickness(25);
                                        $barcode->setFontSize(7);
                                        $code = $barcode->generate();

                                        echo '<img src="data:image/png;base64,'.$code.'" />';
                                    @endphp
                                </th>
                            </tr>
                            <tr>
                                <th colspan="10" class="center-text">
                                    {{ $title }} - Foilsheet
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">Evaluation Center</th>
                                <th colspan="6">{{ $evaluationcenter->code }} - {{ $evaluationcenter->name }}</th>
                            </tr>
                            <tr>
                                <th colspan="2">Subject</th>
                                <th colspan="6">{{ $common->application->subject->scode }} - {{ $common->application->subject->sname }}</th>
                            </tr>
                            <tr>
                                <th colspan="2">Language</th>
                                <th>{{ $common->language->language }}</th>
                                <th class="right-text" colspan="4">Date of Evaluation</th>
                                <th colspan="2" class="center-text">
                                </th>
                            </tr>
                            <tr>
                                <th width="5%" class="center-text">S.No.</th>
                                <th width="5%" class="center-text">Answer Booklet No.</th>
                                <th width="10%" class="center-text">Ref. No.</th>
                                <th width="20%" class="center-text">Barcode</th>
                                <th width="5%" class="center-text">Min. Marks</th>
                                <th width="10%" class="center-text">Marks Obtained</th>
                                <th width="5%" class="center-text">Max. Marks</th>
                                <th width="20%" class="center-text">Remarks</th>
                            </tr>
                            </thead>

                            <tbody id="myTable">
                            @php $sno = 1; @endphp
                            @foreach($markexamattendances as $markexamattendance)
                                <tr>
                                    <td class="center-text">{{ $sno }}</td>
                                    <td class="center-text">{{ $markexamattendance->answersheet_serialnumber }}</td>
                                    <td class="center-text">{{ $markexamattendance->dummy_number }}</td>
                                    <td class="center-text">
                                        @php
                                            $barcode = new BarcodeGenerator();
                                            $barcode->setText($markexamattendance->dummy_number);
                                            $barcode->setType(BarcodeGenerator::Code128);
                                            $barcode->setScale(1);
                                            $barcode->setThickness(25);
                                            $barcode->setFontSize(7);
                                            $code = $barcode->generate();

                                            echo '<img src="data:image/png;base64,'.$code.'" />';
                                        @endphp
                                    </td>
                                    <td class="center-text">{{ $markexamattendance->application->subject->emin_marks }}</td>
                                    <td></td>
                                    <td class="center-text">{{ $markexamattendance->application->subject->emax_marks }}</td>
                                    <td></td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="2">Name of the Evaluator</th>
                                <th colspan="2"></th>
                                <th colspan="3">Signature of the Evaluator</th>
                                <th colspan="1"></th>
                            </tr>
                            <tr>
                                <th colspan="2">Marks entered by</th>
                                <th colspan="2"></th>
                                <th colspan="3">Marks verified by</th>
                                <th colspan="1"></th>
                            </tr>
                            <tr>
                                <th class="right-text" colspan="8">
                                    <br><br>
                                    Evaluation In-Charge
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection

