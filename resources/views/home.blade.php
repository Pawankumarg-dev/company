
@extends('layouts.app')

@section('content')
<style>
    body{
        background:white!important;
    }
</style>
<div class="container">
    <div class="raw">
        <div class="col-md-12">
            @include('common.errorandmsg')
            <div class="alert alert-success" >
                <b> Supplementary Examination Applicaiton Form</b> 
                <p>
                    Students can fill the supplimentary examination application form online.
                    Please read the <a href="{{url('files')}}/ExamForm_guidelines.pdf">Guidelines</a> 
                </p>
            </div> 

            
<div class="alert alert-success ">
                <h4>
                    <a href="https://nber-rehabcouncil.gov.in/files/notice/SupplementarycircularTTIstudents_0001.pdf" target="_blank">Circular for Supplementary exam 2026</a>
                </h4>
             </div>
            

            <div class="alert alert-success hidden">
                <h4> <a href="{{url('/')}}/login#student" target="_blank"> June 2025 Re-evalution results </a></h4>
                <h4>
                   <strong>(Candidates can view their Re-evalution/ Re-totaling Marks on the candidate login dashboard.) &nbsp;&nbsp;&nbsp;</strong>
                        
                </h4>
            </div>

            <div class="alert alert-success hidden">
                <h4> <a href="{{url('/')}}/login#student" target="_blank"> June 2025 results </a></h4>
                <h4>
                   <strong>(The passed out candidates may download their Certificate, Marksheet with CRR Certificate from 13-10-2025) &nbsp;&nbsp;&nbsp;</strong>
                        
                </h4>
            </div>

            <div class="alert alert-success hidden">
                <h4> <a href="{{ url('files/notice/Circular NBER_ Academic Calendar 2025_26.pdf') }}" target="_blank"> - Circular of NBER - Academic Activity Calendar for Diploma & Certificate Level Courses for the Academic Session - 2025-26 </a></h4>
                <h4> <a href="{{ url('files/notice/Addendum 8_10_2025_0001.pdf') }}" target="_blank"> - Addendum:- Revised scheduled for admission 2025 till 31-10-2025 </a></h4>
                <h4> <a href="{{ url('files/notice/Addition_Deletion_2025.pdf') }}" target="_blank">- Provision for Addition and Deletion of Candidates in the Admission Portal for Direct Admissions -2025 </a></h4>
            </div>

            <div class="alert alert-success hidden">
                <h4>
                   <strong>Instructions for Open Round Admission 2025 &nbsp;&nbsp;&nbsp;</strong>
                <a href="{{ url('files/notice/Open_round_instructions.pdf') }}" target="_blank">    View Instructions</a><br>
             
                </h4>
            </div>


            <div class="alert alert-success hidden">
                <h4>
                   <strong>Addendum- Scheduled for Online Admission 2025-26 -updated 29-09-2025 &nbsp;&nbsp;&nbsp; </strong>
                <a href="{{ url('files/notice/Addendum_schedule180925.pdf') }}" target="_blank">    View Circular</a><br>
             
                </h4>
            </div>



        {{-- <div class="alert alert-success ">
                <h4> "The counselling for admission 2025 is open, Please wait for revised schedule'" </h4>
            </div> --}}
            
            
            <div class="alert alert-success hidden">
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
                        No further chances will be considered for the students in future if they do not meet conditions laid at section C.2.3 as per Scheme of Exam, 2024.
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
    यदि छात्र परीक्षा योजना, 2024 के अनुसार धारा C.2.3 में निर्धारित शर्तों को पूरा नहीं करते हैं, तो भविष्य में उनके लिए कोई और अवसर नहीं माना जाएगा।
</li>
<li>
    छात्रों को थ्योरी और प्रैक्टिकल दोनों पेपर चुनने होंगे केवल आंतरिक वाले पेपर भी चुने जाने हैं (भुगतान केवल बाहरी थ्योरी और प्रैक्टिकल के लिए होगा)

</li>
</ul>
            </div>
            <div class="alert alert-success hidden">
               Hall tickets for Supplementary examination is available to download from TTI's login.
            </div>
            <div class="alert alert-danger hidden">
                With respect to, applications received for the students appeared in the examination, who has attempted N+2 as per scheme of examination and have requested for one more chance as special case, as per scheme of examination. 
                <br />The following is the procedure to be followed. <br />
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
            </div>
            <div class="alert alert-info hidden">
                The Council is pleased to announce that the NBER-RCI portal i.e. https://rciber.org.in is initiating the process of migration of the server on NIC on 20-07-2024 (Saturday) at 09:00 A.M. The sever will not be operational on 20-07-2024 (Saturday) from 9.00 am till 11.00 pm. 
                The services after migration will resume on new portal https://nber-rehabcouncil.gov.in. 
                Inconvenience caused regretted.
            </div>
            <div class="alert alert-success hidden">
                <h4>Re-evaluation and Re-totalling</h4>
                <p>Re-evaluation & Re-totalling application form is open on this portal for June 2024 Examinations, under student login.</p>
            </div>
            <div class="alert alert-warning hidden">
                <h4>Internal Marks</h4>
                <p>Internal mark upload is available in institute login.                 </p>
            </div>
            <div class="alert alert-warning" style="display: none;">
                <h4>June 2024 - Practical Examination</h4>
                Practical examination application form is available in the student login. 
                This is for those who missed choosing practical papers while filling the exam applications. 
            </div>
            <div class="alert alert-success " style="display:none;">
                <b>Note Hall ticket:</b>
                <br /><br />
                Hall tickets are available for download on the Institute’s Login. 
                <br />
                Students are requested to collect Hall tickets from the respective Institute and get it sign with seal from the institute. 
                Hall tickets without sign and seal from the institute will not be allowed at the examination center.

            </div>
            <div class="alert alert-warning" style="display: none;" >
                
                <b> Practical Examination Application Form - June 2024  </b>    
                <br />            
                <br />            
                                Students
                             can <a href="{{url('login#student')}}"> login </a> to this portal and click on <b>Exam Application Form - June 2024</b> to apply for the June 2024 Practical Examinations.
                            <a  target="_blank" href="{{url('files/Exam_schedule_june_2024.pdf')}}"> Announcement of the date of Annual Theory and Practical Examination, June - 2024 </a>
                                        
            </div>
            <div class="alert alert-success" style="display: none;">
                
                <b> Results of the Supplementary Examinations - April 2024  </b>    
                <br />            
                <br />            
                    <ul>
                        <li>
                            <b>
                                Students
                            </b> can login to this portal and click on <i>Supplementary Exam Result</i> link to view the results.
                        </li>
                        <li>
                            <b>Institutes</b> can login to this portal and click on <i> Examination -> Supplementary Exam April 2024</i> to view the results.
                        </li>
                        <li>
                            Downloading of the marksheets and certificates for the Supplementary results will be available on this portal soon.
                        </li>
                    </ul>
            </div>
{{--            
            <div class="alert alert-success" >
                <b>Important Announcement: </b>                
                    Supplementary Examination has been scheduled on 5,6,7,8,10 and 12 April 2024 in morning and afternoon shift. <br>
            </div>

            <div class="alert alert-danger" >
                <b>Important Announcement: </b>                
                    Data verification on NBER portal is opened for the admission of 2023 academic year.<br>
                    All the TTIs who have not uploaded the data of the students may upload latest by 30th March 2024, failing which the admission stands cancelled.
            </div>

            <div class="alert alert-danger" style="display:none;" >
                <b>Important Announcement: </b> 
                <a target="_blank" href="{{url('files/nberexam220923.pdf')}}">
                    For online generation of marks cards and certificates, all the heads of the training institutes are advised to upload all candidate data including Aadhar card number, mobile number and email etc. on this portal.
                </a>
            </div>


                       

            <div class="alert alert-warning" >
                <b> Reevaluation Result</b> 
                <p>
                    Results of Re-evaluation for Sep-Oct 2023 exams is published. Result can be downlowed from Student login and TTI login.

                    Please read the <a href="{{url('files')}}/Guidelines_student.pdf">Guidelines</a> for Students
                </p>
            </div>

            <div class="alert alert-success" >
                <b> Sep/Oct 2023 Exam Results</b> 
                <p>
                Sep/Oct 2023 Exam Result are declared. Students and TTIs can download the marksheets and certificates by logging in to this portal.
                </p>
            </div>

            <div class="alert alert-warning" >
                <b>Add Faculties:  </b> 
                Information of the faculty and their CRR details in each NI / TTI  which are running various courses of RCI has to be updated. 
                <a target="_blank" href="{{url('files/Adding_Faculty_to_TTI_Login.pdf')}}">
                    Guidelines 
                </a> 
            </div> --}}

        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<div class="container">

    <h3 class="section-title">
        About NBER
    </h3>

    <!-- Address Card -->
    <div class="info-card" style="font-size: 16px;">
<p>
                <strong>National Board of Examination in Rehabilitation (NBER),</strong> RCI New Delhi has been created as a registered Society under Society Registration Act, 1860 and notified by the DEPwD as an Adjunct Body of RCI vide its Gazette Notification no. 5-62/93-RCIdated 8th June, 2014 “Rehabilitation Council of India (Conduct of Examinations, Qualifications of Examiners and the condition of Admission to Examinations) Regulations, 2014.The NBER is entrusted with the responsibility to conduct centralized examination and award diploma and certificates for all Certificate and Diploma level Programmes of RCI in the field of Special Education & Disability Rehabilitation vide Regulation No.5 of the aforesaid regulations.
            </p>
            <p>
            The NBER, New Delhi is responsible to conduct the Term End & Final Examination and award of Certificate and Diploma in respect of following training programme w.e.f. 2023-24.
            </p>
            <p>
            At present, the examinations are being conducted by the respective National Institute on behalf of NBER-RCI, New Delhi 
            </p>
            
                <ul>
                    <li>
                    National Institute for the Empowerment of Persons with Visual Disabilities (Divyangjan), (NIEPVD), Dehradun

                    </li>
                    <li>
                    National Institute for Empowerment of Persons with Multiple Disabilities (NIEPMD), Chennai

                    </li>
                    <li>
                    Ali Yavar Jung National Institute of Speech and Hearing Disabilities (Divyangjan) (AYJNISHD), Mumbai
                    </li>
                    <li>
                        National Institute for the Empowerment of Persons with Intellectual Disabilities, Secunderabad
                    </li>
                    <li>
                        Indian Sign Language Research & Training Centre(ISLRTC), Delhi
                    </li>
                </ul>
            

    </div>
</div>
<div class="container">

    <h3 class="section-title">
        Examination Body – NIEPVD, Dehradun
    </h3>

    <!-- Address Card -->
    <div class="info-card">
        <h4 class="card-heading">
            <i class="fa-solid fa-location-dot icon-red"></i> Address
        </h4>

        <p class="address-text">
            <strong>National Institute for Empowerment of Persons with Visual Disabilities (NIEPVD)</strong><br>
            116, Rajpur Road,<br>
            Dehradun – 248001,<br>
            Uttarakhand
        </p>

        <div class="contact-info">
            <p><i class="fa-solid fa-phone"></i>  0135-2744491, 2748147, 2744578</p>
            <p><i class="fa-solid fa-envelope"></i>nberniepvd@gmail.com</p>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="table-card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Sl.No.</th>
                    <th>Name of Courses</th>
                    <th>Short Name</th>
                    <th>Course Code</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>D.Ed. Special Education (Visual Impairment)</td>
                    <td>D.Ed.Spl.Ed.(VI)</td>
                    <td>550</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Diploma in Computer Education (Visual Impairment)</td>
                    <td>D.C.E.(VI)</td>
                    <td>566</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<!-- ============================
     Examination Body – NIEPMD
=============================== -->
<div class="container">
    <h3 class="section-title">
        Examination Body – NIEPMD, Chennai
    </h3>

    <div class="info-card">
        <h4 class="card-heading">
            <i class="fa-solid fa-location-dot icon-red"></i> Address
        </h4>

        <p class="address-text">
            <strong>National Institute for Empowerment of Persons with Multiple Disabilities (NIEPMD)</strong><br>
            East Coast Road (ECR), Muttukadu,<br>
            Chennai – 603112,<br>
            Tamil Nadu
        </p>

        <div class="contact-info">
            <p><i class="fa-solid fa-phone"></i>  9382934157</p>
            <p><i class="fa-solid fa-envelope"></i>niepmd.examinations@gmail.com<br></p>
        </div>
    </div>

    <div class="table-card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Sl.No.</th>
                    <th>Name of Courses</th>
                    <th>Short Name</th>
                    <th>Course Code</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>Diploma in Community Based Rehabilitation</td><td>D.C.B.R</td><td>1301</td></tr>
                <tr><td>2</td><td>Diploma in Prosthetics and Orthotics</td><td>D.P.O</td><td>1502</td></tr>
                <tr><td>3</td><td>Diploma in Vocational Rehabilitation (Intellectual Disability)</td><td>D.V.R.(ID)</td><td>551</td></tr>
                <tr><td>4</td><td>Diploma in Early Childhood Special Education (Intellectual Disability)</td><td>D.E.C.S.E.(ID)</td><td>519</td></tr>
                <tr><td>5</td><td>Certificate Course in Care Giving</td><td>C.C.C.G</td><td>1306</td></tr>
                <tr><td>6</td><td>Certificate Course in Rehabilitation Therapy</td><td>C.C.R.T</td><td>704</td></tr>
                <tr><td>7</td><td>Diploma in Special Education (Intellectual & Developmental Disability)</td><td>D.Ed.Spl.Ed.(IDD)</td><td>580</td></tr>
                <tr><td>8</td><td>Diploma in Rehabilitation Therapy</td><td>D.R.T</td><td>703</td></tr>
                <tr><td>9</td><td>D.Ed. Special Education (Multiple Disabilities)</td><td>D.Ed.Spl.Ed.(MD)</td><td>573</td></tr>
            </tbody>
        </table>
    </div>
</div>


<!-- ============================
     Examination Body – AYJNISHD
=============================== -->
<div class="container">
    <h3 class="section-title">
        Examination Body – AYJNISHD, Mumbai
    </h3>

    <div class="info-card">
        <h4 class="card-heading">
            <i class="fa-solid fa-location-dot icon-red"></i> Address
        </h4>

        <p class="address-text">
            <strong>Ali Yavar Jung National Institute of Speech and Hearing Disabilities (AYJNISHD)</strong><br>
            Bandra Reclamation, Bandra (West),<br>
            Mumbai – 400050,<br>
            Maharashtra
        </p>

        <div class="contact-info">
            <p><i class="fa-solid fa-phone"></i> 022-26400215, 26400228, 26427320</p>
            <p><i class="fa-solid fa-envelope"></i>ayjnishd-nber-mumbai@ayjnihh.nic.in</p>
        </div>
    </div>

    <div class="table-card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Sl.No.</th>
                    <th>Name of Courses</th>
                    <th>Short Name</th>
                    <th>Course Code</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>D.Ed. Special Education (Hearing Impairment)</td><td>D.Ed.Spl.Ed.(HI)</td><td>547</td></tr>
                <tr><td>2</td><td>Diploma in Hearing Language and Speech</td><td>D.H.L.S.</td><td>801</td></tr>
                <tr><td>3</td><td>Diploma in Indian Sign Language Interpretation</td><td>D.I.S.L.I</td><td>1701</td></tr>
                <tr><td>4</td><td>Diploma in Early Childhood Special Education (Hearing Impairment)</td><td>D.E.C.S.E.(HI)</td><td>552</td></tr>
                <tr><td>5</td><td>Diploma in Teaching Indian Sign Language</td><td>D.T.I.S.L</td><td>1703</td></tr>
                <tr><td>6</td><td>Diploma in Hearing Aid Repair & Ear Mould Technology</td><td>D.H.A.R.E.M.T</td><td>301</td></tr>
            </tbody>
        </table>
    </div>
</div>


<!-- ============================
     Examination Body – NIEPID
=============================== -->
<div class="container">
    <h3 class="section-title">
        Examination Body – NIEPID, Secunderabad
    </h3>

    <div class="info-card">
        <h4 class="card-heading">
            <i class="fa-solid fa-location-dot icon-red"></i> Address
        </h4>

        <p class="address-text">
            <strong>National Institute for the Empowerment of Persons with Intellectual Disabilities (NIEPID)</strong><br>
            Manovikas Nagar,<br>
            Secunderabad – 500009,<br>
            Telangana
        </p>

        <div class="contact-info">
            <p><i class="fa-solid fa-phone"></i> 040-27757719, 040-27751741/42/43/44/45</p>
            <p><i class="fa-solid fa-envelope"></i>niepidnber@gmail.com</p>
        </div>
    </div>

    <div class="table-card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Sl.No.</th>
                    <th>Name of Courses</th>
                    <th>Short Name</th>
                    <th>Course Code</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>Diploma in Special Education (Intellectual & Developmental Disability)</td><td>D.Ed.Spl.Ed.(IDD)</td><td>580</td></tr>
                <tr><td>2</td><td>Diploma in Community Based Rehabilitation</td><td>D.C.B.R</td><td>1301</td></tr>
                <tr><td>3</td><td>Diploma in Early Childhood Special Education (Intellectual Disability)</td><td>D.E.C.S.E.(ID)</td><td>519</td></tr>
                <tr><td>4</td><td>Diploma in Vocational Rehabilitation (Intellectual Disability)</td><td>D.V.R.(ID)</td><td>551</td></tr>
                <tr><td>5</td><td>Certificate Course in Care Giving</td><td>C.C.C.G</td><td>1306</td></tr>
                <tr><td>6</td><td>Community Based Inclusive Development Programme</td><td>C.B.I.D.</td><td>1307</td></tr>
            </tbody>
        </table>
    </div>
</div>
<!-- ============================
     Examination Body – ISLRTC
=============================== -->

<div class="container">
    <h3 class="section-title">
        Examination Body – ISLRTC, New Delhi
    </h3>

    <div class="info-card">
        <h4 class="card-heading">
            <i class="fa-solid fa-location-dot icon-red"></i> Address
        </h4>

        <p class="address-text">
            <strong>Indian Sign Language Research & Training Centre(ISLRTC)</strong><br>
            Okhla Industrial Estate,<br>
            New Delhi – 110020,<br>
            Delhi
        </p>

        <div class="contact-info">
            <p><i class="fa-solid fa-phone"></i> 011 – 20883013</p>
            <p><i class="fa-solid fa-envelope"></i>islrtcnewdelhi@gmail.com</p>
        </div>
    </div>

    <div class="table-card">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Sl.No.</th>
                    <th>Name of Courses</th>
                    <th>Short Name</th>
                    <th>Course Code</th>
                </tr>
            </thead>
            <tbody>
                
                <tr><td>1</td><td>Diploma in Indian Sign Language Interpretation</td><td>D.I.S.L.I</td><td>1701</td></tr>
                <tr><td>2</td><td>Diploma in Teaching Indian Sign Language</td><td>D.T.I.S.L</td><td>1703</td></tr>
            </tbody>
        </table>
    </div>
</div>







<style>


.section-title {
    font-size: 22px;
    font-weight: bold;
    color: #1d3557;
    margin-bottom: 20px;
}

.info-card, .table-card {
    background: #dedfe287;
    padding: 20px 24px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

.card-heading {
    font-size: 18px;
    margin-bottom: 10px;
    color: #444;
}

.icon-red {
    color: #e63946;
}

.address-text {
    font-size: 15px;
    line-height: 1.6;
}

.contact-info p {
    margin: 4px 0;
    font-size: 14px;
}

.contact-info i {
    color: #1d3557;
    margin-right: 6px;
}

/* Table Styling */
.styled-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
}

.styled-table thead {
    background-color: #00008b;
    color: #fff;
}

.styled-table th, .styled-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #ddd;
}

.styled-table tbody tr:hover {
    background: #f5f7fa;
}

.styled-table td:first-child {
    width: 60px;
    text-align: center;
}

</style>
@endsection
