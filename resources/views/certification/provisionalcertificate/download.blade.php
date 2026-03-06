<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$provisionalCertificate->candidate->enrolmentno}}-Provisional_Certificate</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="{{asset('css/normalize.min.css')}}">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="{{asset('css/paper.css')}}">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        .lucida-text {
            font-family: "Lucida Calligraphy";
        }
        .adobe {
            font-family: "Adobe Caslon Pro";
        }
        .yu {
            font-family: "Yu Gothic Light";
        }
        .arial-text {
            font-family: "Arial";
        }
        .courier-text {
            font-family: "Courier New";
        }
        .monotype-text {
            font-family: "Monotype Corsiva";
        }

        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
        }
        @media print {
            #printPageButton {
                display: none;
            }
            #noprint {
                display: none;
            }
        }

        .equal-height-row {
            display: flex;
        }

        .minus15px-margin-top {
            margin-top: -15px !important;
        }

        .white-background {
            background-color: white;
            color: black;
        }

        .black-background {
            background-color: black;
            color: white;
        }

        .red-background {
            background-color: red !important;
            color: white !important;
        }

        .ghostwhite-background {
            background-color: ghostwhite;
            color: deepskyblue;
        }

        .darkblue-background {
            background-color: darkblue;
            color: white;
        }

        .green-background {
            background: green !important;
            color: white !important;
        }

        .grey-background {
            background: #EEEEEE;
        }

        .bold-text {
            font-weight: bold;
        }

        .center-text {
            text-align: center !important;
        }

        .left-text {
            text-align: left !important;
        }

        .right-text {
            text-align: right !important;
        }

        .green-text {
            color: darkgreen;
        }

        .red-text {
            color: red;
        }

        .blue-text {
            color: blue;
        }

        .brown-text {
            color: brown;
        }

        .yellow-text {
            color: yellow;
        }

        .icon-text {
            font-size: 30px;
        }

        .footer {
            background: #3fc3ee;
            color: white;
        }

        td, th {
            vertical-align: middle !important;
        }

        . {
            display: flex; /* equal height of the children */
        }
        .page-break {
            page-break-after: always;
        }

        .h5-text {
            font-size: 20px;
            font-weight: bold;
        }
        .h6-text {
            font-size: 15px;
        }
        .h7-text {
            font-size: 12px;
        }
        .h8-text {
            font-size: 10px;
        }

        .medium-text {
            font-size: 18px;
        }

        .justified-text {
            text-align: justify;
        }

        .red-button {
            background-color: red !important;
            color: white !important;
        }

        .red-button:focus,
        .red-button:hover {
            background-color: indianred !important;
            border-color: indianred !important;
            color: white !important;
        }
        .box {
            border-style: dashed;
            border-color: blue;
        }
        .image-box {
            border-style: solid;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 portrait">


<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
<section class="sheet padding-10mm">
    {{--
    <article>
        <img src="{{ asset('/images/provisional_certificate.jpg') }}" style="width: 100%; object-fit: cover;"
             class="img" />
        title
    </article>
    --}}

    <div class="box">
        <table border="0" width="100%">
            <tr>
                <td class="center-text" width="15%">
                    <img src="{{asset('/images/rci.png')}}"  style="width: 100px; height: 80px" class="img" />
                </td>
                <td class="center-text blue-text h8-text" width="70%">
                    <span class="h6-text bold-text">
                        NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULTIPLE DISABILITIES (DIVYANGJAN) [NIEPMD]
                    </span><br>
                    <span class="h7-text">
                        East Coast Road, Muttukadu, Kovalam Post, Chennai-603112, Tamil Nadu, India.
                    </span><br>
                    <span class="h7-text">
                        Examination conducted on behalf of the
                    </span><br>
                    <span class="bold-text h6-text">National Board of Examination in Rehabilitation
                    </span><br>
                    <span class="h7-text">
                        ( An Adjunct body of
                    <span class="bold-text h6-text">
                        Rehabilitation Council of India
                    </span>)</span><br>
                    <span class="h6-text">
                        Under Ministry of Social Justice and Empowerment,
                        Department of Empowerment of Persons with Disabilities (Divyangjan),
                        <b>
                            Govt. of India
                        </b>
                    </span><br>
                </td>
                <td class="center-text" width="15%">
                    <img src="{{asset('/images/niepmd_logo.png')}}"  style="width: 80px;" class="img" />
                </td>
            </tr>
        </table>
        <hr />

        <table border="0" width="100%">
            <tr>
                <td class="left-text">
                    @php
                        use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
                        $barcode = new BarcodeGenerator();
                        $barcode->setText($provisionalCertificate->folio_number);
                        $barcode->setType(BarcodeGenerator::Code128);
                        $barcode->setScale(2);
                        $barcode->setThickness(25);
                        $barcode->setFontSize(20);
                        $code = $barcode->generate();

                        echo '<img src="data:image/png;base64,'.$code.'" />';
                    @endphp
                </td>
                <td class="right-text">
                    <div class="right-text" style="font-size: 25px">
                        <span class="blue-text">
                            Folio Number:
                        </span>

                        <span class="bold-text red-text">
                            {{ $provisionalCertificate->folio_number }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        <table class="table" border="0">
            <tr>
                <td class="center-text" colspan="5">
                    <span class="bold-text blue-text"
                          style="font-style: italic; font-size: 50px;font-family: Edwardian Script ITC">
                        Provisional Certificate
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <div style="text-align: justify; padding: 2%;">
                    <span class="monotype-text blue-text" style="text-align: justify !important;font-style: italic; font-size: 23px; margin-left: 100px;">
                        This is to certify that the following candidate has been qualified for the award of Diploma / Certificate as detailed below:
                    </span>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table" border="0">
            <tr>
                <td width="5%"></td>
                <td width="17%" style="font-size: 18px">Enrolment No.</td>
                <td width="2%" style="font-size: 20px">:</td>
                <td class="bold-text blue-text" style="font-size: 18px">{{ $provisionalCertificate->candidate->enrolmentno }}</td>
                <td class="center-text image-box" rowspan="5" width="15%">
                    <img src="{{asset('/files/enrolment/photos')}}/{{$provisionalCertificate->candidate->photo}}"
                         style="width: 80px;" class="img" />
                </td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="17%" style="font-size: 18px">Name</td>
                <td width="2%" style="font-size: 20px">:</td>
                <td class="bold-text blue-text" style="font-size: 18px">{{ $provisionalCertificate->candidate->name }}</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="17%" style="font-size: 18px">Parent's / Guardian Name</td>
                <td width="2%" style="font-size: 20px">:</td>
                <td class="bold-text blue-text" style="font-size: 18px">{{ $provisionalCertificate->candidate->fathername }}</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="17%" style="font-size: 18px">Date of Birth</td>
                <td width="2%" style="font-size: 20px">:</td>
                <td class="bold-text blue-text" style="font-size: 18px">{{ $provisionalCertificate->candidate->dob->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="17%" style="font-size: 18px">Batch</td>
                <td width="2%" style="font-size: 20px">:</td>
                <td class="bold-text blue-text" style="font-size: 18px">
                    @if($provisionalCertificate->candidate->approvedprogramme->programme->numberofterms == 2)
                        {{ $provisionalCertificate->candidate->approvedprogramme->academicyear->year }}-{{ $provisionalCertificate->candidate->approvedprogramme->academicyear->year+2 }}
                    @else
                        {{ $provisionalCertificate->candidate->approvedprogramme->academicyear->year }}
                    @endif
                </td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="17%" style="font-size: 18px">Course</td>
                <td width="2%" style="font-size: 20px">:</td>
                <td class="bold-text blue-text" style="font-size: 18px">
                    {{ $provisionalCertificate->candidate->approvedprogramme->programme->abbreviation }}
                </td>
                <td class="center-text" rowspan="3" width="15%">
                    <div style="vertical-align: top !important;">
                        @php
                            $barcode = new BarcodeGenerator();
                            $barcode->setText($provisionalCertificate->candidate->enrolmentno);
                            $barcode->setType(BarcodeGenerator::Code128);
                            $barcode->setScale(1.5);
                            $barcode->setThickness(20);
                            $barcode->setFontSize(10);
                            $code = $barcode->generate();

                            echo '<img src="data:image/png;base64,'.$code.'" />';
                        @endphp
                    </div>
                </td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="17%" style="font-size: 18px">Month & Year</td>
                <td width="2%" style="font-size: 20px">:</td>
                <td class="bold-text blue-text" style="font-size: 18px">{{ $provisionalCertificate->exam->name }}</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="17%" style="font-size: 18px">Classification</td>
                <td width="2%" style="font-size: 20px">:</td>
                <td class="bold-text blue-text" style="font-size: 18px">{{ $provisionalCertificate->candidate->class }}</td>
            </tr>
        </table>

        <table border="0">
            <tr>
                <td width="40%" style="vertical-align: bottom !important;">
                    Date of Printing:
                    <span class="blue-text">
                    @php $date = \Carbon\Carbon::now(); @endphp
                        <b>{{ $date->format('d-m-Y h:i:s A') }}</b>
                    </span>
                </td>
                <td width="30%">
                    <div class="center-text">
                        <img src="{{asset('/images/nber_seal.png')}}" width="40%" class="img" />
                    </div>
                </td>
                <td width="25%">
                    <div class="center-text">
                        <img src="{{asset('/images/'.$provisionalCertificate->authorised_sign)}}" width="90%"  class="img" /><br>
                        <span class="green-text bold-text">DIRECTOR, NIEPMD</span>
                    </div>
                </td>
            </tr>
        </table>

        <table border="0" cellpadding="3" cellspacing="0" width="100%">
            <tr>
                <td width="15%">
                    <div class="center-text">
                        @php
                            use CodeItNow\BarcodeBundle\Utils\QrCode;
                            $qrCode = new QrCode();
                            $qrCode
                                ->setText('http://examcell.niepmdexaminationsnber.com/online-provisional-certificate')
                                ->setSize(100)
                                ->setPadding(20)
                                ->setErrorCorrection('high')
                                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                                //->setLabel('Scan Qr Code')
                                //->setLabelFontSize(16)
                                ->setImageType(QrCode::IMAGE_TYPE_PNG)
                            ;
                            echo '<img src="data:'.$qrCode->getContentType().';base64,'.$qrCode->generate().'" />';
                        @endphp
                    </div>
                </td>
                <td width="85%">
                    <div class="red-text">
                        <b><u>Disclaimer</u></b>
                        <ul>
                            <li>
                                This is a computer generated statement.
                                Original should be furnished while seeking for job.
                            </li>

                            <li>
                                All contents of this statement can be verified for authenticity by the process of
                                online verification through scanning the QR code printed here or
                                by visiting NIEPMD-NBER portal
                                <a href="http://examcell.niepmdexaminationsnber.com/online-provisional-certificate" target="_blank">
                                    (http://examcell.niepmdexaminationsnber.com/online-provisional-certificate)
                                </a>, and then entering the enrolment number and date of birth of the candidate.
                            </li>

                            <li>
                                For offline verification, please the statement send to:<br>
                                <b>
                                    The Director, <br>
                                    NIEPMD,<br>
                                    East Coast Road, Muttukadu, Kovalam Post,<br>
                                    Chennai, Tamil Nadu - 603 112.
                                </b>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div id="printPageButton" class="center-text">
        <p>
            <button type="button" onclick="window.print();return false;">
                Print
            </button>
        </p>
    </div>

</section>

<script>
    window.onload = function () {
        window.print();
    }
</script>

</body>

</html>