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



    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="right-text" colspan="8">
                                    <a href="{{ url('/evaluationcenter/marks/showform/'.$evaluationcenter->id.'/'.$exam->id.'/'.$common->bundle_number) }}" class="btn btn-success">
                                        <span class="glyphicon glyphicon-pencil"></span>&nbsp; Update Marks
                                    </a>
                                </th>
                            </tr>
                            <tr>
                                <th class="red-text bold-text right-text" colspan="6">
                                    Bundle No.:
                                </th>
                                <th class="red-text bold-text center-text" colspan="2">
                                    {{ $common->bundle_number }}
                                </th>
                            </tr>
                            <tr class="green-background">
                                <th class="center-text" width="5%">S.No.</th>
                                <th class="center-text" width="13%">Ref. No.</th>
                                <th class="center-text" width="15%">Barcode</th>
                                <th class="center-text" width="10%">Subject Code</th>
                                <th class="center-text" width="15%">Language</th>
                                <th class="center-text" width="10%">Min. Marks</th>
                                <th class="center-text" width="10%">Marks Obtained</th>
                                <th class="center-text" width="10%">Max. Marks</th>
                            </tr>

                            @php $sno = 1; @endphp
                            @foreach($markexamattendances as $markexamattendance)
                                <tr>
                                    <td class="center-text blue-text">{{ $sno }}</td>
                                    <td class="center-text blue-text">{{ $markexamattendance->dummy_number }}</td>
                                    <td class="center-text blue-text">
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
                                    <td class="center-text blue-text">{{ $markexamattendance->application->subject->scode }}</td>
                                    <td class="center-text blue-text">{{ $markexamattendance->language->language }}</td>
                                    <td class="center-text blue-text">{{ $markexamattendance->application->subject->emin_marks }}</td>
                                    <td class="center-text blue-text">
                                        {{ $markexamattendance->mark }}
                                    </td>
                                    <td class="center-text blue-text">{{ $markexamattendance->application->subject->emax_marks }}</td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


