@extends('layouts.app')

@section('content')
<style>
        body{
                background:#fff!important;
        }
</style>






<div class="container">
    <div class="alert alert-success ">
                <h4>
                    <a href="https://nber-rehabcouncil.gov.in/files/notice/SupplementarycircularTTIstudents_0001.pdf" target="_blank">Circular for Supplementary exam 2026</a>
                </h4>
             </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Admission 2025</h3>

                            <table class="table table-condensed table-hover table-bordered">
    <thead>
        <tr>
            <th>SL No.</th>
            <th>Course</th>
            <th>Maximim Intake</th>
            <th>Admitteed Candidate</th>
            <th>Admission Close on</th>

            <th class="">Action</th>
            
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        @foreach($apids as $item)
      <?php         $count = \App\Candidate::where('approvedprogramme_id',$item->id)->where('deleted_at',null)->count();

?>
            <tr>
                <td> {{ $i++ }}</td>
                <td> {{ $item->programme->abbreviation }}</td>
                <td> {{ $item->maxintake }}</td>
                <td> {{ $count }}</td>
                <td> {{ date($item->enable_admission_till) }}</td>

                <td class="" > 

    @if(\Carbon\Carbon::parse($item->enable_admission_till)->isPast())
    Admission Closed
      @else

                @if($item->maxintake > $count)
                    
               
                    
                     {{-- <form action="{{url('/')}}/eparivesh2" method="post"  style="padding:5px" calss="hidden">
                                    {{ csrf_field() }}
                        <input type="hidden" value="{{ $item->programme_id }}" name="programme_id">
                        <input type="hidden" value="{{$item->institute_id}}" name="institute_id">
                        <input type="hidden" value="" name="verification">

                        <button class="btn btn-primary" type="submit">Make Merit List (2nd Round)</button>
                    </form> --}}
                    



<a href="{{ url('/') }}/eparivesh/{{ base64_encode($item->id) }}/{{ base64_encode($item->programme_id) }}"><button class="btn btn-primary">Admission with ePravesh Registation</button></a>

<a href="{{ url('/') }}/eparivesh/addcandidate/48245/{{$item->id}}"><button class="btn btn-primary">Direct Admission</button></a>

                    @else

                    Sheets Full

                    @endif

                  
                    @endif




                </td>


            </tr> 
           

        @endforeach
    </tbody>
</table>


            </div>
        </div>
    </div>

    

{{-- <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Practical Examiner</h3>

                            <table class="table table-condensed table-hover table-bordered">
    <thead>
        <tr>
            <th>Course</th>
            <th>Subjects</th>
            <th>Faculty Name</th>
            <th>Mobile No</th>
            <th>Email</th>
            <th>From Date</th>
            <th>To Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($paractical as $item)
      
            @if ($item->course_id==23 ||$item->course_id==7)
            @if($i==1)
            <tr>
                <td>{{ $item->course_name }}</td>
                <td>{{ $item->subjects }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->mobileno }}</td>
                <td>{{ $item->email }}</td>
                <td>
                    
                    @if (!empty($item->start_date) && $item->start_date > '2025-00-00')
                        {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}
                    @endif
                </td>
                <td>
                    @if (!empty($item->end_date  && $item->end_date > '2025-00-00'))
                        {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}
                    @endif
                </td>
            </tr> 
            @endif
            @else
            <tr>
                <td>{{ $item->course_name }}</td>
                <td>{{ $item->subjects }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->mobileno }}</td>
                <td>{{ $item->email }}</td>
                <td>
                    
                    @if (!empty($item->start_date) && $item->start_date > '2025-00-00')
                        {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}
                    @endif
                </td>
                <td>
                    @if (!empty($item->end_date  && $item->end_date > '2025-00-00'))
                        {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}
                    @endif
                </td>
            </tr> 


            @endif

        @endforeach
    </tbody>
</table>


            </div>
        </div>
    </div> --}}



<div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('common.errorandmsg')
            <br />
            <div class="alert alert-success ">
                <h4>
                    <a href="{{url('/')}}/files/notice/SOP for TTI to fill online Admission Form 2025.pdf" target="_blank">Guidelince to Fill Online Admission Form 2025 </a>
                </h4>
             </div>
<div class="alert alert-success ">
                <h4>
                    <a href="{{url('/')}}/files/notice/SOP_Intitutions_2025.pdf" target="_blank">SOP for Admission 2025</a>
                </h4>
             </div>
             <div class="alert alert-success ">
                <h4>
                    <a href="https://nber-rehabcouncil.gov.in/files/notice/Circular_TTI_June_2025_exam.pdf" target="_blank">Circular for June exam 2025</a>
                </h4>
             </div>
            @if(Auth::user()->id==133861)
             <div class="alert alert-success hidden">
                <h4>
                    The online application for examination is open on 03/06/2025 from 8:30 AM to 6:00 PM. Enrollment fee is exempted. However, examination fee as per the scheme of examination i.e ₹100 per paper (theory and practical),
                </h4>
             </div>
            @endif
               <div class="alert alert-danger hidden">
                <h4>
                    Guidelines for students to apply online for the June 2025 examinations
                </h4>
                <ul>
                    <li>
                        All eligible students undergoing Diploma/Certificate level courses can apply w.e.f. 28th March – 07th April 2025 without late fees and 08th April – 12th April 2025 with late fees.
                    </li>
                    
                    <li>
                        Hall tickets will be printed and issued by TTIs from 21st May – 30th May 2025.
                    </li>
                    <li>
                        Hall tickets will be generated for the eligible candidates to appear for exams subject to completion of following conditions:
                            <ul>
                                <li>
                                    Enrollment fees paid.
                                </li>
                                <li>
                                    Examination fees paid.
                                </li>
                                <li>
                                    Passed in internal exam
                                </li>
                                <li>
                                    Attendance as per Scheme of Exam
                                </li>
                            </ul>
                    </li>
                    <li>
                        Students can make the payment for examination, after the attendance and internal marks are uploaded to the portal.
                    </li>
                    <li>
                        All students eligible as per section C.2.3 of Scheme of Exam, 2024 can apply (The condition of maximumnumber of chances is relaxed as a special case).
                    </li>
                    <li>
                        No further chances will be considered for the students in future if they do not meet conditions laid at section C.2.3 as per Scheme of Exam, 2025.
                    </li>
                    <li>
                        Students needs to select both Theory and practical papers 
                    </li>
                    <li>
                        Papers with only internal also to be selected (Payment will be only for external theory and practical)
                    </li>
                </ul>
                <br />
                <h4>जून 2025 की परीक्षाओं के लिए ऑनलाइन आवेदन करने के लिए छात्रों के लिए दिशा-निर्देश</h4>
<ul>
<li>डिप्लोमा/सर्टिफिकेट स्तर के पाठ्यक्रमों में अध्ययनरत सभी पात्र छात्र 28 मार्च से 07 अप्रैल 2025 तक बिना विलम्ब शुल्क के तथा 08 अप्रैल से 12 अप्रैल 2025 तक विलम्ब शुल्क के साथ आवेदन कर सकते हैं।</li>

<li>टीटीआई द्वारा 21 मई से 30 मई 2025 तक हॉल टिकट मुद्रित और जारी किए जाएंगे।</li>
<li>
    निम्नलिखित शर्तों को पूरा करने के अधीन पात्र उम्मीदवारों को परीक्षा में शामिल होने के लिए हॉल टिकट तैयार किए जाएंगे:
    <ul>
        <li>
            नामांकन शुल्क का भुगतान 

        </li>
        <li>
            परीक्षा शुल्क का भुगतान

        </li>
        <li>
            आंतरिक परीक्षा में उत्तीर्ण

        </li>
        <li>
            परीक्षा योजना के अनुसार उपस्थिति

        </li>
    </ul>
</li>
<li>
    उपस्थिति और आंतरिक अंक पोर्टल पर अपलोड होने के बाद छात्र परीक्षा के लिए भुगतान कर सकते हैं।
</li>
<li>परीक्षा योजना, 2024 की धारा C.2.3 के अनुसार पात्र सभी छात्र आवेदन कर सकते हैं (विशेष मामले के रूप में अधिकतम अवसरों की शर्त में छूट दी गई है)।</li>
<li>
    यदि छात्र परीक्षा योजना, 2025 के अनुसार धारा C.2.3 में निर्धारित शर्तों को पूरा नहीं करते हैं, तो भविष्य में उनके लिए कोई और अवसर नहीं माना जाएगा।
</li>
<li>
    छात्रों को थ्योरी और प्रैक्टिकल दोनों पेपर चुनने होंगे केवल आंतरिक वाले पेपर भी चुने जाने हैं (भुगतान केवल बाहरी थ्योरी और प्रैक्टिकल के लिए होगा)

</li>
</ul>
            </div>
            <div class="alert alert-success hidden">

            <li>
                Consent from 3 Govt. schools / CBSE direct affiliated school to conduct exams scheduled in June 2025:

                    <ul>
                        <li>
                            a.	Download the Declaration / Consent Form.
                        </li>
                        
                        <li>
                            b.	Get the details of the exam center filled by the Govt. school/ CBSE direct affiliated school.
                        </li>
                        <li>
                            c.	Scan the signed and stamped three pages Declaration / Consent Form.
                        </li>
                        <li>
                            d.	Login to you institute.
                        </li>
                        <li>
                            e.	Fill the details submitted by the School.
                        </li>
                        <li>
                            f.	Attach the scanned copy and submit.
                        </li>
                    </ul>

            </li>

<P><strong>Note: </strong> consent form is mandatory to be submitted even if earlier submitted. The portal for uploading the format will be open as per the schedule submitted. No further extension will be considered.</P>
            </div>
       
            <div class="alert alert-danger">
                <h4><b>Urgent: </b>Updating on the NBER-RCI Portal</h4>
                <p>
                   <b> Last Date:</b> 06/12/2024 
                </p>
                <p>
                    <ul>
                        <li>
                            1.	Update the location information on the NBER-RCI Portal
                                <ul>
                                    <li>
                                        a.	GPS Coordinates (Latitude and Longitude)
                                    </li>
                                    <li>
                                        b.	Geo Tagged photo of the TTI
                                    </li>
                                </ul>
                        </li>
                        <li>
                            2.	Faculty details
                                <ul>
                                    <li>
                                        a.	Adding faculties
                                    </li>
                                    <li>
                                        b.	Add subjects taught by the faculties
                                    </li>
                                    <li>
                                        c.	Add the course coordinator details
                                    </li>
                                </ul>
                        </li>
                    
                        <li>
                            3.	Update the National and/or State govt Scholarship Portal Registration Number
                        </li>
                    </ul>
                </p>
                <p>
                    <b>Instructions:</b> Click <a href="{{ url('files/Instructions_TTI.pdf') }}">here</a> to download the step by step instructions.
                </p>
            </div>
            <div class="alert alert-info hidden">
                <h4>2024 Batch Enrolmenent</h4>
                <p>
                    
                    Click <a target="_blank" href="{{url('files')}}/Enrolment 2024.pdf">here</a> to read step by step instructions for uploading 2024 Enrolment data to the portal.
                </p>
            </div>
            <div class="alert alert-danger hidden">
                <h4>Practical Examination</h4>
                <p>
                    Practical examiners are provided with user name and password to login to the portal to download marksheet format and to upload the practical exam marks.
                    <b>Practical marks to be uploaded to the portal on the same day of the exam.</b>
                    <b>Username and password is emailed to the examiner</b>
                </p>
            </div>
            <div class="alert alert-success hidden">
                <h4>Practical Hallticket</h4>
                <p>
                    Practical halltickets can be downloaded from the Examination -> June 2024 Exam -> Exam Applications & Halltickets page.
                </p>
            </div>
            <div class="alert alert-success hidden">
                <h4>Internal Marks</h4>
                <p>
                    Internal marks can be entered from Examination -> June 2024 Exam  page by clicking on links in Internal Marks column.
                </p>
            </div>
            <div class="alert alert-danger" style="display: none;">
                <b>Important Announcement: </b>                
                    Data verification on NBER portal is opened for the admission of 2023 academic year.<br>
                    All the TTIs who have not uploaded the data of the students may upload latest by 30th March 2024, failing which the admission stands cancelled.
            </div>

            @if($af_paid == 0)
                <div class="alert alert-danger" style="display: none;" >
                    <b>Affiliation Fee Payment: </b> 
                    Affiliation fee for the year 2023 is pending. Click 
                    <a href="{{url('/institute/affiliationfee')}}">
                        here 
                    </a> to make the payment online.
                </div>
            @endif
            @if($enf_paid == 0)
                <div class="alert alert-danger"  style="display: none;">
                    <b>Enrolment Fee Payment: </b> 
                    Enrolment fee for the year 2023 is pending. Click 
                    <a href="{{url('/institute/enrolmentfee')}}">
                        here 
                    </a> to make the payment online.
                </div>
            @endif

            @if($institute->is_data_verified !=1 || $institute->is_mobile_verified !=1 || $institute->is_email_verified  !=1 || $institute->is_institute_head_verified  !=1 || $institute->is_institute_head_email_verified  !=1 || $institute->is_institute_head_mobile_verified !=1 || $institute->is_facilities_verified !=1)
                <div class="alert alert-warning"  style="display: none;" >
                    Please go to <a href="{{url('institute/profile')}}">profile</a> page and update
                    <ul>
                        @if($institute->is_data_verified !=1 )
                            <li>Institute Adddress</li>
                        @endif
                     {{--   @if($institute->is_mobile_verified !=1 )
                            <li>Verifiy Institute Mobile Number</li>
                        @endif
                        @if($institute->is_email_verified !=1 )
                            <li>Verifiy Institute Email Address</li>
                        @endif --}}
                        @if($institute->is_institute_head_verified !=1 )
                            <li>Details of the head of institute</li>
                        @endif
                        {{--     @if($institute->is_institute_head_email_verified !=1 )
                            <li>Verify email of the head of institute</li>
                        @endif
                        @if($institute->is_institute_head_mobile_verified !=1 )
                            <li>Verify mobile number of the head of institute</li>
                        @endif--}}
                        @if($institute->is_facilities_verified !=1 )
                            <li>Facilities</li>
                        @endif
                    </ul>
                </div>
            @endif

            <div class="alert alert-danger" style="display: none;" >
                <b>Important Announcement: </b>  For online generation of marks cards and certificates, all the heads of the training institutes are advised to upload all candidate data including Aadhar card number, mobile number and email etc. on this portal.
                <a target="_blank" href="{{url('files/nberexam220923.pdf')}}">
                    Circular
                </a>
            </div>

            <div class="alert alert-warning"  style="display: none;">
                <b>Add Faculties:  </b> 
                Information of the faculty and their CRR details in each NI / TTI  which are running various courses of RCI has to be updated. 
                
                <a target="_blank" href="{{url('files/Adding_Faculty_to_TTI_Login.pdf')}}">
                    Guidelines 
                </a> 
            </div>
            @if($institute->is_data_verified !=1 )
            <div class="alert alert-info" >
                You have not updated the password recently. Click <a href="{{url('/institute/changepassword')}}">here</a> to change password.
            </div>
            @endif
     
            
              {{--  <h4><i class="fa fa-arrow-right"> </i> Instructions to download the Hall tickets </h4>
                <ul>
                        <li>

                       <b>
                       All the data corrections is to be completed before 4:00 PM on Monday, 28th August
                       </b>

                        </li>
                        <li>
                        Hall ticket download option will be enabled from Tuesday, 29th August
                        </li>
                        <li>
                        Kindly verify the details of the students appearing for the examination, by verifying the enrolment data of previous academic years. 
                        <ul>
                                <li>
                                Student’s enrolment data of NIEPMD NBER is available online for all the previous academic years.
                                </li>
                                <li>
                                        Student’s enrolment data of 2021-23 and 2022-24 of NIEPVD and AYJNISHD NBER is available online.

                                </li>
                        </ul>

                        </li>
                        <li>
                        In order to verify the student’s enrolment, click on the respective academic years from the top menu.
                        <br>
                        <img src="{{url('images/notice')}}/1.png" alt="">
                        </li>
                        <li>
                        Click on enrolment and click on the candidate enrolment to view the candidate list.
                        <br>
                        <img src="{{url('images/notice')}}/2.png" alt="">

                        </li>
                        <li>
                        To change photo and other data:
                        <ul>
                                <li>
                                To verify the data click on quick view button against each candidates.
                                </li>
                                <li>
                                To change/add photo, Click on the change file near the photo from the list of candidates
                                </li>
                                <li>
                                To change any other data like DOB ,Father name etc. Please click on Edit and update the correct data.
                                </li>
                                <li>
                                <b>Note:</b> Enrolment number and Name cannot be edited by TTI. If any correction required please contact the respective NBERs using the <b>
                                Data Correction Requests
                                </b>  from the TTI Login area.
                                </li>

                        </ul>
                        <img src="{{url('images/notice')}}/3.png" alt="">
                        <img src="{{url('images/notice')}}/4.png" alt="">

                        </li>
                        <li>
                                
Once all the student data is verified. Click on Examinations to verify the exam applications
<img src="{{url('images/notice')}}/5.png" alt="">


                        </li>
                        <li>
                        Verify the examination applications (Subject applied) by clicking on the View Applications button
                        </li>
                        <li>
                        If any corrections are required, please click on the applications again.
                        </li>
                        <li>
<img src="{{url('images/notice')}}/6.png" alt="">
<br>
<ul>
        <li>
        1st Button Is to apply for exam

        </li>
        <li>
        2nd button is to view the applications

        </li>
</ul>

                        </li>

                        <li>
                        <b>
                        IF NOT APPLIED ALREADY, 
                        </b>please select the subjects, choose the language to apply for the exam
                        <br>
<img src="{{url('images/notice')}}/7.png" alt="">

                        </li>
                        <li>
                        Incase of any data queries please use the Data Correction Requests  form to communicate with NBER to correct any data.
                <br>
<img src="{{url('images/notice')}}/8.png" alt="">
<br>
<img src="{{url('images/notice')}}/9.png" alt="">


                </li>
                </ul>
       --}}
        </div>
        
       
        <?php $institute_location = Session::get('institute_location');    ?>
@if($institute_location->state_nsp==''||$institute_location->state_nsp==NULL||$institute_location->national_nsp==''||$institute_location->national_nsp==NULL)        
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            Scholarship Portal Registation No.
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        

          <a href="{{ url('/images/notice/Circular-nsp.pdf') }}" class="btn btn-info btn-xs" download>Download Notification</a>    

          <!-- Start of the form -->
          <form action="{{url('/')}}/update-nsp" method="POST">
            {!! csrf_field() !!}

            <input type="hidden" name='id' value="<?=$institute_location->rci_code ?>">

            <div class="row" style="padding: 20px">
              <!-- State NSP Field -->
              <div class="group-form">
                <label for="state_nsp" class="form-label">State Govt. Scholarship Portal Registation No.</label>
                <input type="text" class="form-control" id="state_nsp" maxlength="50" name="state_nsp" value="<?=$institute_location->state_nsp ?>">
              </div>
  
              <!-- National NSP Field -->
              <div class="group-form">
                <label for="national_nsp" class="form-label">National Scholarship Portal Registation No.</label>
                <input type="text" class="form-control" id="national_nsp" maxlength="50" name="national_nsp" value="<?=$institute_location->national_nsp ?>">
              </div>
  
              <!-- Submit Button -->
              <div class="mb-3" style="padding-top: 10px">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- JavaScript to auto-show modal -->
  <script>
    // Ensure the document is fully loaded before triggering the modal
    $(document).ready(function() {
      $('#exampleModal').modal('show'); // This will trigger the modal to show automatically
    });
  </script>
  
@endif
@endsection
