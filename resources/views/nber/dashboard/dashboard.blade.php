@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        @include('common.errorandmsg')
              


        <div class="alert alert-success">
  <div class="alert alert-success ">
                <h4>
                    <a href="https://nber-rehabcouncil.gov.in/files/notice/SupplementarycircularNBER_0001.pdf" target="_blank">Circular for Supplementary exam 2026</a>
                </h4>
             </div>
            <li>
                W.r.t. pending enrolment numbers after admissions, all the NBERs and respective TTIs are informed to complete the following latest by 15th March as the port is opened for those pending cases:

                    <ul>
                        <li>
                            a.	Verification of details uploaded by TTIs.
                        </li>
                        
                        <li>
                            b.	Uploading of required documents and its verification.
                        </li>
                        <li>
                            c.	Uploading of declaration form and its verification.
                        </li>
                        <li>
                            d.	Spelling mistakes, if any. No name, father/mother name, DOB, etc. changes are allowed.
                        </li>
                        <li>
                            e.	The edit option is only enabled for only one time.
                        </li>
                    </ul>

            </li>
            <P style="color: red"><strong>Note: </strong> No further chances will be provided thereafter.</P>

                        </div>
        <div class="alert alert-danger">
        With reference to the attendance sheets uploaded by the exam centers, all NBERs to complete verification of the attendance sheets of respective papers uploaded by the exam centers, for each of session, course, subject, institute, academic year and batch. Once verified the colour will change. If some changes required, please mark accordingly and mention in the remarks.                <ul>
                    <li> Traking is available under  Exam -> Exam Attendance tracker</li>
                    <li>
                    Option to view the attendance sheet uploaded and attendance marked is available in the tracker.                     </li>
                    <li>
                    Option to verify or update the reasons for not able to verify is available under each attendance sheets.                     </li>
                </ul>
        </div>
        <div class="alert alert-danger hidden">
            <p>
                With reference to the supplementary hall tickets. TTI’s can download the hall tickets from their login.
            </p>
            <ol>
                <li>
                    Student’s whose hall tickets could not be downloaded, due to enrolment document verifications is not completed, NBER can verify the enrolment documents. TTIs can download the hall ticket once NBER completes the enrolment document verification.
                </li>
                <li>
                    Student’s whose mobile number is not verified will not be able to download the hall tickets. Mobile verification is enabled for students in their login. Once student completes the mobile number verification, Hall ticket can be downloaded.
                </li>
            </ol>



            <p>
                <b>
                    Note:</b>
                     Once the above step is completed, please wait for up to 1 - 2 hrs for the hall tickets to be generated.
            </p>
    </div>
        <div class="alert alert-danger hidden">
            <p>
                With respect to, applications received for the students appeared in the examination, who has attempted N+2 as per scheme of examination and have requested for one more chance as special case, as per scheme of examination. 
            </p>
            <p><b>The following is the procedure to be followed for the students to apply.</b> <br />
            <ol>
                <li>
                    Apply online for the supplementary examination for the respective subject. 
                </li>
                <li>
                    Submit evidence document for not appearing the examination, for the consideration as per scheme of examination.
                </li>
                <li>
                    Respective NBER to verify the application and the documents.
                </li>
                <li>
                    After verification by NBERs, candidate to pay fee for examination.
                </li>
                <li>
                    Only those candidates who is application has been verified by the NBER and payment received online will be considered for the Supplementary Examination, January 2025. 
                </li>
            </ol>
            </p>
            <p>
                <b>To verify the documents uploaded:</b>
                <ul>
                    <li>
                        Click on Exam->Applications
                    </li>
                    <li>
                        Select Exam January 2025 from top dropdown.
                    </li>
                    <li>
                        Select Special Cases from the dropdown and click on Show.
                    </li>
                    <li>
                        Click on the verify document button.
                    </li>
                    <li>
                        Click on approve if verified.
                    </li>
                </ul>
            </p>
        </div>
            <div class="panel panel-info">
                <div class="panel-heading">Course Admissions </div>
                <div class="panel-body">
                    <?php $count = 0; $totalcount = 0;  ?>
                    <?php $programmes = \App\Programme::where('nber_id',\App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id)->get(); ?>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>
                                    Programme
                                </th>
                                <th>Abbreviation</th>
                                <th>Maximum Intake</th>
                                <th>Applications received</th>
                                <th>Discontinued</th>

                            </tr>
                            @foreach ($programmes as $p)
                                <?php $count = 0; $totalcount = 0; $dis_count = 0; ?>
                                <?php $approvedprogrammes = \App\Approvedprogramme::where('programme_id',$p->id)->where('academicyear_id',Session::get('academicyear_id'))->get(); ?>
                                @foreach($approvedprogrammes as $approveprogramme)
                                    @if($approveprogramme->institute_id != 1004)
                                    <?php 
                                        $count +=  $approveprogramme->candidates()->count();
                                        $totalcount +=  $approveprogramme->maxintake;

                                        $dis_count +=  $approveprogramme->candidates()->where('status_id',9)->count();

                                    ?>
                                    @endif
                                @endforeach
                                @if($totalcount > 0)
                                <tr>
                                    <td>{{$p->name}}</td>
                                    <td>{{$p->course_name}}</td>
                                    <td>{{$totalcount}}</td>
                                    <td>{{$count}}</td>
                                    <td>{{$dis_count}}</td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Verification Status </div>
                <div class="panel-body">
                    <?php $count = 0; $totalcount = 0;  ?>
                    <?php $programmes = \App\Programme::where('nber_id',\App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id)->get(); ?>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>
                                    Institute Code
                                </th>
                                <th>Institute</th>
                                <th>Programme</th>
                                <th>Maximum Intake</th>
                                <th>Applications received</th>
                                <th>Verification Pending</th>
                                <th>Verified</th>
                                <th>Incomplete/Wrong Data</th>
                                <th>Discontinue</th>
                            </tr>
                            <?php $applications_received = 0;  $not_verified = 0 ; $verified= 0; $rejected = 0;  $discontinue=0;?>

                            @foreach ($verification as $v)
                            <tr>
                              <td>{{$v->username}}</td>
                              <td>{{$v->institute}}</td>
                              <td>{{$v->programme}}</td>
                              <td>{{$v->maxintake}}</td>
                              <td>{{$v->applications_received}}</td>
                              <td>{{$v->not_verified}}</td>
                              <td>{{$v->verified}}</td>
                              <td>{{$v->rejected}}</td>
                              <td>{{$v->discontinued}}</td>
                              
                            </tr>
                              <?php $applications_received += $v->applications_received; $not_verified += $v->not_verified; $verified += $v->verified; $rejected  += $v->rejected; $discontinue+=$v->discontinued?>
                            @endforeach
                           <tr>
                                <th colspan="4">Total</th>
                                <th>
                                    {{$applications_received}}
                                </th>
                                <th>
                                    {{$not_verified}}
                                </th>
                                <th>
                                    {{$verified}}
                                </th>
                                <th>
                                    {{$rejected}}
                                </th>
                                <th>
                                    {{$discontinue}}
                                </th>
                                
                           </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection