<div class="page-break">
    <table style="border:0">
        <tr>
            <td>
                <img src="{{url('images/nber_logo.png')}}"  style="height:70px;"/>
            </td>
            <td style="v-align:center">
                <h3 style="margin-top:0;margin-bottom:4px;">
                National Board of Examination in Rehabilitation(NBER), New Delhi.
                </h3>
                <h6 style="margin-top:0;margin-bottom:0">
                An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment
                </h6>
            </td>
            <td>
                <img src="{{asset('/images/')}}/niepmd.png"  style="height: 70px;max-width:100px;" class="img" />
            </td>
        </tr>
    </table>
    <h5>JUNE 2024  EXAMINATION - ATTENDNACE SHEET</h5>
    @include('examcenter._parts.heading')
   
    <table class="table mt-2">
        <tr>
            <td>
                Institute Code
            </td>
            <td>
                UP144
            </td>
        </tr> 
        <tr>
            <td>
                Institute Name
            </td>
            <td>
                Purvanchal Shiksha Samiti
            </td>
        </tr>
        <tr>
            <td>
                Programme
            </td>
            <td>
                D.Ed.Spl.Ed.(IDD) - Diploma in Education - Special Education (Intellectual and Developmental Disabilities) - II Year
            </td>
        </tr>
        <tr>
            <td>
                Subject Code
            </td>
            <td>
                02IDDMG
            </td>
        </tr>
        <tr>
            <td>
                Subject 
            </td>
            <td>
                Management of Groups with High Support Needs
            </td>
        </tr>
    </table>
    <table class="table mt-2">
        <tr>
            <th class="center-text"> 
                Slno
            </th>
            <th>
                Student Name
            </th>
            <th>
                Enrolment Number
            </th>
            <th>
                Batch
            </th>
            <th>
                Language
            </th>
            <th>
                Answer Booklet Sl. No.
            </th>
            <th>
                Signature
            </th>
        </tr>
        <?php $slno= 1; ?>
        <tr style="height:18px;">
            <th class="center-text"> 
                {{$slno}}
                <?php $slno++ ; ?>
            </td>
            <td>
                SARITA YADAV
            </td>

            <td  class="center-text">
                352238403
            </td>
            <td  class="center-text">
                2022
            </td>
            <td>
                English
            </td>
            <td style="width:130px;height:30px;">
        
            </td>
            <td style="width:130px;height:30px;">
            </td>
        </tr>
    </table>
    @include('examcenter._parts.bottom')
