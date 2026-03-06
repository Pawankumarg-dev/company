@extends('layouts.app')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
            html, body {
                page-break-after: avoid;
                page-break-inside:avoid;
            }
        }

        @page {
            size: A4 landscape;
        }

        .page-break-avoid{
            page-break-after: avoid;

        }

        .box {
            position: relative;
            display: inline-block;
        }

        .box .text{
            position: absolute;
            z-index: 999;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: 30%; /* Adjust this value to move the positioned div up and down */
            text-align: center;
            width: 100%; /* Set the width of the positioned div */
        }
    </style>
    <div  id="printPageButton">
        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-sm pull-right" onclick="window.print();return false;">
                            <span class="glyphicon glyphicon-print"></span> Print Provisional Certificate
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="container-fluid">
        <div class="col-sm-12 well well-sm white-background minus15px-margin-top box">
            <img src="{{ asset('/images/provisional_certificate.jpg') }}" style="width: 100%; object-fit: cover;"
                 class="img" />
            <div class="text">
                <h1>This is to certify that the following candidate</h1>
            </div>
        </div>
    </section>

    {{--
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background" style="border: 3px solid">
                <div class="table-responsive">

                    <table class="table table-condensed">
                        <tr>
                            <td class="center-text" width="15%">
                                <img src="{{asset('/images/rci.png')}}"  style="width: 100px; height: 80px" class="img" />
                            </td>
                            <td class="h8-text">
                                <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                                (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GOVT. OF INDIA)<br>
                                <span style="font-style: italic">Examination conducted on behalf of</span><br>
                                <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                                (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br>
                            </td>
                            <td class="center-text" width="15%">
                                <img src="{{asset('/images/niepmd.png')}}"  style="width: 60px;" class="img" />
                            </td>
                        </tr>
                        <tr>
                            <td class="right-text courier-text" colspan="3">
                                Folio Number: <span class="bold-text ">{{ $provisionalCertificate->folio_number }}</span>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-borderless">
                        <tr>
                            <td class="center-text" colspan="3">
                                <u><span class="bold-text courier-text" style="font-style: italic; font-size: large">Provisional Certificate</span></u>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                            <span class="courier-text" style="font-style: italic" colspan="3">
                                This is to certify that the following candidate has qualified for the award of Diploma as detailed below:
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%" class="courier-text">Enrolment Number</td>
                            <td width="3%" class="courier-text">:</td>
                            <td class="courier-text bold-text">{{ $provisionalCertificate->candidate->enrolmentno }}</td>
                        </tr>
                        <tr>
                            <td width="20%" class="courier-text">Name</td>
                            <td width="3%" class="courier-text">:</td>
                            <td class="courier-text bold-text">{{ $provisionalCertificate->candidate->name }}</td>
                        </tr>
                        <tr>
                            <td width="20%" class="courier-text">Father Name</td>
                            <td width="3%" class="courier-text">:</td>
                            <td class="courier-text bold-text">{{ $provisionalCertificate->candidate->fathername }}</td>
                        </tr>
                        <tr>
                            <td width="20%" class="courier-text">Batch</td>
                            <td width="3%" class="courier-text">:</td>
                            <td class="courier-text bold-text">2017-19</td>
                        </tr>
                        <tr>
                            <td width="20%" class="courier-text">Course</td>
                            <td width="3%" class="courier-text">:</td>
                            <td class="courier-text bold-text">{{ $provisionalCertificate->candidate->approvedprogramme->programme->course_name }}</td>
                        </tr>
                        <tr>
                            <td width="20%" class="courier-text">Classification</td>
                            <td width="3%" class="courier-text">:</td>
                            <td class="courier-text bold-text">{{ $provisionalCertificate->candidate->class }}</td>
                        </tr>
                    </table>
                    <table class="table table-borderless">
                        <tr>
                            <td class="courier-text bold-text center-text" colspan="3" style="font-size: larger">-- Validity: 60 days. [Provisional Cetificate is not valid for CRR Registration] --</td>

                        </tr>
                        <tr>
                            <td width="25%" class="courier-text"></td>
                            <td width="50%" rowspan="2">
                                <div class="center-text">
                                    <img src="{{asset('/images/nber_seal.png')}}" width="25%" class="img" />
                                </div>
                            </td>
                            <td width="25%" class="courier-text center-text" colspan="3">
                                <div>
                                    <img src="{{asset('/images/Director_sign.png')}}" width="80%"  class="img" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%" class="courier-text center-text">Date : <b>{{ $provisionalCertificate->print_date->format('d-m-Y') }}</b></td>


                            <td class="courier-text center-text" >
                                DIRECTOR, NIEPMD
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
    --}}
@endsection