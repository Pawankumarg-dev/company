<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
            #noprint {
                display: none;
            }
        }
        .page-break {
            page-break-after: always;
        }
        .bold-text {
            font-weight: bold;
        }
        .blue-text {
            color: blue;
        }
        .red-text {
            color: red;
        }
        .green-text {
            color: green;
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
        .left-text{
            text-align: left !important;
        }
        .right-text{
            text-align: right !important;
        }
        .center-text{
            text-align: center !important;
        }
        .courier_new_font{
            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
        }
    </style>
</head>
<body>
<div class="right-text">
    <p>
        <button type="button" onclick="window.print();return false;" id="printPageButton">Print</button>
    </p>
</div>

<div class="page-break">
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <colgroup>
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
        </colgroup>
        <thead>
        <tr>
            <th colspan="100">
                <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                <span class="h8-text">(DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GOVT. OF INDIA)</span><br>
                <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span><br>
                <span class="h8-text">ECR, Muttukadu, Kovalam Post, Chennai-603112, Tamil Nadu.</span><br>
                <span class="h8-text">Email: niepmd.examinations@gmail.com</span>
            </th>
        </tr>
        <tr>
            <th colspan="100">
                {{ $exam }} Exam Attendance Sheet
            </th>
        </tr>

        <tr>
            <td class="h7-text bold-text" colspan="2">Study Center</td>
            <td class="h7-text bold-text" colspan="8">Code-Name</td>
            <td class="h7-text bold-text" colspan="2">Exam Center</td>
            <td class="h7-text bold-text" colspan="8">EXDEMO</td>
        </tr>
        <tr>
            <td class="h7-text bold-text" colspan="2">Course</td>
            <td class="h7-text bold-text" colspan="8">Course-{{ $id }}</td>
            <td class="h7-text bold-text" colspan="2">Batch</td>
            <td class="h7-text bold-text" colspan="8">20__</td>
        </tr>
        <tr>
            <td class="h7-text bold-text" colspan="2">Subject</td>
            <td class="h7-text bold-text" colspan="8">Code-{{ $id }} - Name-{{ $id }}</td>
            <td class="h7-text bold-text" colspan="2">Date & Time</td>
            <td class="h7-text bold-text" colspan="8">{{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <th class="h7-text bold-text center-text" colspan="1">S.No.</th>
            <th class="h7-text bold-text center-text" colspan="2">Photo</th>
            <th class="h7-text bold-text center-text" colspan="3">Name</th>
            <th class="h7-text bold-text center-text" colspan="3">Enrolment No.</th>
            <th class="h7-text bold-text center-text" colspan="3">DoB</th>
            <th class="h7-text bold-text center-text" colspan="3">Language writing</th>
            <th class="h7-text bold-text center-text" colspan="3">Answer Sheet<br>Sl.No.</th>
            <th class="h7-text bold-text center-text" colspan="3">Signature</th>
        </tr>
        </thead>

        <tbody>
        @php $sno = 1; @endphp
        @for($i=0; $i<10; $i++)
            <tr>
                <td class="h7-text bold-text center-text" colspan="1">{{ $sno }}</td>
                <td class="h7-text bold-text center-text" colspan="2">

                </td>
                <td class="h7-text bold-text left-text" colspan="3">Name-{{ $sno }}</td>
                <td class="h7-text bold-text center-text" colspan="3">{{ $sno }}{{ $sno }}{{ $sno }}{{ $sno }}{{ $sno }}{{ $sno }}</td>
                <td class="h7-text bold-text center-text" colspan="3">dd-mm-yyyy</td>
                <td class="h7-text bold-text center-text" colspan="3"></td>
                <td class="h7-text bold-text center-text" colspan="3"></td>
                <td class="h7-text bold-text center-text" colspan="3"></td>
            </tr>
            @php $sno++; @endphp
        @endfor

        </tbody>

        <tfoot>
        <tr>
            <td class="h7-text bold-text right-text" colspan="20"><br/><br/>Signature of the Invigilator</td>
        </tr>
        <tr>
            <td class="h7-text bold-text right-text" colspan="12">Name of the Invigilator</td>
            <td class="h7-text bold-text right-text" colspan="8"></td>
        </tr>
        <tr>
            <td class="h7-text bold-text right-text" colspan="12">Contact Number</td>
            <td class="h7-text bold-text right-text" colspan="8"></td>
        </tr>
        </tfoot>
    </table>
</div>
</body>