<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    
    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="{{asset('css/normalize.min.css')}}">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="{{asset('css/paper.css')}}">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4 landscape;
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
<body class="A4 landscape">


<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
@for($i = 2; $i > 0; $i--)
    @php $subjectCount = $subjects->where('syear', $i)->count(); @endphp

    @if($subjectCount > 0)
        <section class="sheet padding-10mm page-break">
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <td>
                        <table border="0" cellpadding="5" cellspacing="0" width="100%">
                            <tr>
                                <td class="center-text" width="15%">
                                    <img src="{{asset('/images/rci_logo.png')}}"  style="width: 100px; height: 80px" class="img" />
                                </td>
                                <td class="h8-text center-text">
                                  {{--  <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                                    (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GoI)<br>
                                    <span style="font-style: italic">Examination conducted on behalf of</span><br>
                                    <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                                    (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br> --}}
                                </td>
                                <td class="center-text" width="15%">
                                    <img src="{{asset('/images/niepmd.png')}}"  style="width: 65px;" class="img" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="medium-text bold-text">
                        <div class="row">
                            <div class="col-sm-12 center-text">
                        <span class="h7-text">
                        External Theory Examnination Mark Entry Form
                        </span>
                                <div class="right-text">
                                    <button type="button" onclick="window.print();return false;" id="printPageButton"><span class="h7-text">Print</span></button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="2" width="100%" cellspacing="0" cellpadding="5">
                            <tr>
                                <th width="10%">Institute Name</th>
                                <th width="75%">{{ $approvedprogramme->institute->name }}</th>
                                <th width="10%">Institute Code</th>
                                <th width="5%">{{ $approvedprogramme->institute->code }}</th>
                            </tr>
                            <tr>
                                <th width="10%">Programme</th>
                                <th width="75%">
                                    {{ $approvedprogramme->programme->common_code }}
                                    - {{ $approvedprogramme->academicyear->year }} Batch
                                </th>
                                <th width="10%">Term / Year</th>
                                <th width="5%">
                                    @if($i == 2) II @else I @endif
                                </th>
                            </tr>
                        </table>

                        <table border="1" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <th colspan="2">
                                    INTERNAL THEORY
                                </th>
                                @foreach($subjects->where('syear', $i) as $subject)
                                    <th colspan="2" width="5px">{{ $subject->scode }}</th>
                                @endforeach

                                @php $count = $subjectCount;  @endphp
                                @while($count < 6)
                                    <th rowspan="3" width="5px">NA</th>
                                    @php $count++;@endphp
                                @endwhile

                                <th rowspan="3" width="10px">Total<br>Marks</th>
                            </tr>
                            <tr>
                                <th width="5px" rowspan="2">S.No.</th>
                                <th width="20px" rowspan="2">Enrolment No</th>

                                @foreach($subjects->where('syear', $i) as $subject)
                                    <th>Min:<br>{{ $subject->imin_marks }}</th>
                                    <th>Max:<br>{{ $subject->imax_marks }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($subjects->where('syear', $i) as $subject)
                                    <th colspan="2">Marks<br>Obtained</th>
                                @endforeach
                            </tr>
                            {{--
                            @php $sno = 1;
                                    $candidates = $applications->map(function ($query) use($i){
                                        if($query->where('term', $i))
                                            return $query->candidate;
                                    });

                                    $candidates = $candidates->unique('id')->sortBy('enrolmentno');
                            @endphp

                            @foreach($candidates as $candidate)
                                <tr class="custom-table-row">
                                    <td>{{ $sno }}</td>
                                    <td>{{ $candidate->enrolmentno }}</td>
                                </tr>

                                @php $sno++; @endphp
                            @endforeach
                            --}}
                            @for($i = 30; $i > 0; $i--)
                                <tr>
                                    <td>{{ $i }}</td>
                                </tr>
                            @endfor
                        </table>
                    </td>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td>Signature</td>
                </tr>
                </tfoot>
            </table>
        </section>
    @endif
@endfor

@for($i = 2; $i > 0; $i--)
    @php $subjectCount = $subjects->where('syear', $i)->count(); @endphp

    @if($subjectCount > 0)
        <section class="sheet padding-10mm page-break">
            <table border="2" width="100%" cellpadding="15">
                <tr>
                    <th width="10%">Institute Name</th>
                    <th width="75%">{{ $approvedprogramme->institute->name }}</th>
                    <th width="10%">Institute Code</th>
                    <th width="5%">{{ $approvedprogramme->institute->code }}</th>
                </tr>
                <tr>
                    <th width="10%">Programme</th>
                    <th width="75%">
                        {{ $approvedprogramme->programme->common_name }} [{{ $approvedprogramme->programme->common_code }}]
                        - {{ $approvedprogramme->academicyear->year }} Batch
                    </th>
                    <th width="10%">Term / Year</th>
                    <th width="5%">
                        @if($i == 2) II @else I @endif
                    </th>
                </tr>
            </table>

            <table border="1" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th colspan="2">
                        INTERNAL THEORY
                    </th>
                    @foreach($subjects->where('syear', $i) as $subject)
                        <th colspan="2" width="5px">{{ $subject->scode }}</th>
                    @endforeach

                    @php $count = $subjectCount;  @endphp
                    @while($count < 6)
                        <th rowspan="3" width="5px">NA</th>
                        @php $count++;@endphp
                    @endwhile

                    <th rowspan="3" width="10px">Total<br>Marks</th>
                </tr>

                <tr>
                    <th width="5px" rowspan="2">S.No.</th>
                    <th width="20px" rowspan="2">Enrolment No</th>

                    @foreach($subjects->where('syear', $i) as $subject)
                        <th>Min:<br>{{ $subject->imin_marks }}</th>
                        <th>Max:<br>{{ $subject->imax_marks }}</th>
                    @endforeach
                </tr>

                <tr>
                    @foreach($subjects->where('syear', $i) as $subject)
                        <th colspan="2">Marks<br>Obtained</th>
                    @endforeach
                </tr>

                {{--
                @php $sno = 1;
                                    $candidates = $applications->map(function ($query) use($i){
                                        if($query->where('term', $i))
                                            return $query->candidate;
                                    });

                                    $candidates = $candidates->unique('id')->sortBy('enrolmentno');
                @endphp

                @foreach($candidates as $candidate)
                    <tr class="custom-table-row">
                        <td>{{ $sno }}</td>
                        <td>{{ $candidate->enrolmentno }}</td>
                    </tr>

                    @php $sno++; @endphp
                @endforeach
                --}}
                @for($i = 30; $i > 0; $i--)
                    <tr>
                        <td>{{ $i }}</td>
                    </tr>
                @endfor
            </table>
        </section>
    @endif
@endfor
<script>
</script>

</body>

</html>