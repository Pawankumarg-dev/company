@extends('layouts.print')

@section('content')
    <section class="sheet padding-10mm custom-sheet">
        <div class="box">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"></td>
                    <td class="bold-text right-text" colspan="2">
                        <div style="font-size: 25px">
                            TN/SP/617/CCR/{{ $yearSpecification }}
                        </div>
                    </td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td>
                        <div class="capital-text bold-text center-text">
                            भारत सरकार सेवार्थ <br>
                            On India Goverment Service
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="dotted-box center-text center-div" style="width: 15em; height: 5em; margin-left: 1.4em">
                            Tracking No.:
                        </div>
                    </td>
                    <td class="bold-text" colspan="2">
                        <span style="font-size: 20px">To</span>
                        <br>
                        <div style="font-size: 21px">
                            {{ $institute->name }} ({{ $institute->code }})
                            <br>

                            {{ $institute->street_address != '' ? strtoupper($institute->street_address) : '' }}
                            @if(!is_null($institute->postoffice))
                                <br>
                                {{ strtoupper($institute->postoffice) }} POST OFFICE,
                            @endif
                            @if($institute->city_id != 0)
                                <br>
                                {{ $institute->city->name }} DIST., {{ $institute->city->state->state_name }}
                            @endif
                            @if($institute->pincode != '') - {{$institute->pincode}}. @endif
                            @if($institute->landmark != '')
                                <br>
                                LANDMARK - {{ strtoupper($institute->landmark)}}
                            @endif

                            <br>
                            {{ $institute->contactnumber1 != '' ? 'Contact No.(s): '. ($institute->contactnumber2 != '' ? $institute->contactnumber1.', '.$institute->contactnumber2 : $institute->contactnumber1) : "" }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        If Undelivered, please return to:-<br>
                        <img src="{{ asset('/images/nber_logo.png') }}" style="height: 80px">
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                    <span class="bold-text" style="font-size: 20px">
                        National Institute for Empowerment of Persons with Multiple Disabilites  (Divyangjan) [NIEPMD]
                    </span>
                        <br>
                        <span class="italic-text" style="font-size: 15px">
                        (Dept. of Empowerment of Persons with Disabilities (Divyangjan),
                        Ministry of Social Justice & Empowerment, Govt. of India)
                    </span>
                        <br>
                        <span class="bold-text" style="font-size: 20px">
                        National Board of Examination in Rehabilitation [NBER]
                    </span>
                        <br>
                        <span class="italic-text" style="font-size: 15px">
                        (An Adjunct Body of Rehabilitation Council of India,
                        under Ministry of Social Justice & Empowerment)
                    </span>
                        <br>
                        <span class="italic-text bold-text" style="font-size: 15px">
                        <u>Co-ordinating Body</u>
                    </span>
                        <br>
                        <span class="italic-text" style="font-size: 15px">
                        East Coast Road, Muttukadu, Kovalam Post, Chennai - 603112, Tamil Nadu
                    </span>
                        <br>
                        <span style="font-size: 15px">
                        Email: niepmd.examinations@gmail.com || website: www.niepmdexaminationsnber.com
                    </span>
                        <p>
                            Centre Code: <b>{{ $institute->code }}</b>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </section>

    <script>
        window.onload = function () {
            <!-- Set "A5", "A4" or "A3" for class name -->
            <!-- Set also "landscape" if you need -->
            document.body.className = "A4 landscape";

            <!-- for printing -->
            window.print();
        }
    </script>
@endsection