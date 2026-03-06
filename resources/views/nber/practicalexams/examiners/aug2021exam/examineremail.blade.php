<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email</title>
    <style>
        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
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

        .justified-text {
            text-align: justify;
            text-justify: inter-word;
        }

        .medium-text {
            font-size: medium;
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
        .sup {
            font-size: 60%;
            vertical-align: super;
        }
    </style>
</head>
<body>
{{--
Respected Sir/Madam,<br>
You ({{ $practicalexaminer->name }}) have been appointed as external examiner for 1st Year Exam<br><br>
Regards,<br>
Sumitra Manoharan<br>
Sr. Consultant<br>
NIEPMD-NBER<br>
Chennai.<br>
--}}
Respected Sir/Madam,<br>
You ({{ $practicalexaminer->name }}) have been appointed as external examiner for 2<sup>nd</sup> Year Exam<br><br>
Regards,<br>
Mrs. Kavitha Anilkumar<br>
ADCE,<br>
NIEPMD-NBER,<br>
Chennai.<br>
</body>
</html>