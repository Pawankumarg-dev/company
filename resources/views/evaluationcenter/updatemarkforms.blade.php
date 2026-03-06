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

    <form class="form-horizontal" role="form" method="POST"
          action="{{ url('/evaluationcenter/updatemarks/') }}" autocomplete="off" accept-charset="UTF-8"
          onsubmit="return validateForm()">

        {{ csrf_field() }}

        <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}" />
        <input type="hidden" id="evaluationcenter_id" name="evaluationcenter_id" value="{{ $evaluationcenter->id }}" />
        <input type="hidden" id="bundle_number" name="bundle_number" value="{{ $common->bundle_number }}" />

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed">
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

                                @php $sno = 1; $count = 0; @endphp
                                @foreach($markexamattendances as $markexamattendance)
                                    <input type="hidden" id="markexamattendance_id{{ $count }}" name="markexamattendance_id[{{ $count }}]" value="{{ $markexamattendance->id }}" />
                                    <input type="hidden" id="refno{{ $count }}" name="refno[{{ $count }}]" value="{{ $markexamattendance->dummy_number }}" />
                                    <input type="hidden" id="min_mark{{ $count }}" value="{{ $markexamattendance->application->subject->emin_marks }}" />
                                    <input type="hidden" id="max_mark{{ $count }}" value="{{ $markexamattendance->application->subject->emax_marks }}" />
                                    <input type="hidden" id="externalresult_id{{ $count }}" name="externalresult_id[{{ $count }}]" />

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
                                            <input type="text" size="1" id="mark{{ $count }}" name="mark[]"
                                                   class="center-text" onblur="checkMarkValue({{ $count }})"

                                                   @if(!is_null($markexamattendance->mark)) value="{{ $markexamattendance->mark }}" @endif
                                            />
                                        </td>
                                        <td class="center-text blue-text">{{ $markexamattendance->application->subject->emax_marks }}</td>
                                    </tr>
                                    @php $sno++; $count++; @endphp
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <section class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <button type="submit" class="btn btn-primary pull-right">Submit Marks</button>
                    </div>
                </div>
            </section>
        </section>
    </form>


    <script>
        function checkMarkValue(count) {
            var mark = document.getElementById('mark'+count);
            var min_mark = document.getElementById('min_mark'+count);
            var max_mark = document.getElementById('max_mark'+count);

            if(mark.value == 'Abs') {
                mark.style.backgroundColor = 'yellow';
                mark.style.color = 'red';
                mark.style.fontWeight = 'bold';
                mark.setAttribute('readOnly', true);
            }
            else if(isNaN(mark.value)) {
                mark.focus();
                mark.value = '';
                swal("Error Occurred!!!", "Please enter a Valid Mark.", "error");
            }
            else if(Number.isInteger(+mark.value) == false) {
                mark.focus();
                mark.value = '';
                swal("Error Occurred!!!", "Please enter a Valid Mark.", "error");
            }
            else {
                if (Number(mark.value) < Number(min_mark.value)) {
                    mark.style.backgroundColor = 'red';
                    mark.style.color = 'white';
                    mark.style.fontWeight = 'bold';
                    $("#externalresult_id"+count).val("2");
                }
                if (Number(mark.value) >= Number(min_mark.value)) {
                    mark.style.backgroundColor = 'green';
                    mark.style.color = 'white';
                    mark.style.fontWeight = 'bold';
                    $("#externalresult_id"+count).val("1");
                }
                if (Number(mark.value > Number(max_mark.value))) {
                    mark.focus();mark.value = '';
                    swal("Error Occurred!!!", "The mark that you have entered is more than the maximum mark alloted to the subject.", "error");
                }
            }
        }

        function validateForm() {
            /*
            for (var i = 0; i < "{{ $count }}"; i++) {
                var mark = document.getElementById('mark' + i);

                if (mark.value == "") {
                    mark.focus();
                    swal("Error Occurred!!!", "Please enter the Mark for the Ref.No.: "+$('#refno'+i).val(), "error");
                    mark.style.backgroundColor = 'yellow';
                    mark.style.color = 'red';
                    mark.style.fontWeight = 'bold';
                    return false;
                }
                else {

                }
            }
            */
        }
    </script>
@endsection


