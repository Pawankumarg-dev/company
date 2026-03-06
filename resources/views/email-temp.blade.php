<div class="container">

    <div class="row">
        <div class="col-sm-1 text-right logo">
    <img src="{{ asset('images/' . $nber->logo) }}">
        </div>
        <div class="col-sm-11 text-center">
            <strong>{{$nber->name}} ({{$nber->short_name_code}})</strong><br>
            {{$nber->address}}<br>
            <strong>Coordinating Body: National Board of Examination in Rehabilitation (NBER)</strong><br>
            (An Adjunct Body of Rehabilitation Council of India)<br>
            Email: {{$nber->email}} 
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-sm-6">
            <p>To,<br>
                 {{ $paractical->first()->faculty_name }}<br>
                {{ $paractical->first()->address}}</p>
        </div>
        <div class="col-sm-6 text-right">
            <p><strong>Date:</strong> {{Carbon\Carbon::now()->format('d/m/Y')}}</p>
        </div>
    </div>

    <p class="subject">
        Sub: Appointment of Practical External Examiner for RCI recognized Diploma/Certificate courses,
        June 2025 term end examination between 20th May and 10th June 2025 – reg.
    </p>

    <div class="content">
        <p>Madam/Sir,</p>

        <p>
            This is to inform you that the Practical External Examinations for all RCI recognized Diploma/Certificate courses are being conducted by the NBER, Chennai at concerned Training Centers across the country between 20th May and 10th June 2025. You are appointed as External Examiner to conduct the Practical Examinations. Venue, schedule and course details are as below:
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Exam Centre</th>
                        <th>Course</th>
                        <th>Duty on Dates</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paractical as $exam)
                        <tr>
                            <td>{{ $exam->exam_center}}</td>
                            <td>{{ $exam->name}}</td>
                            <td> @if (!empty($exam->start_date) && $exam->start_date > '2025-00-00')
                                {{ \Carbon\Carbon::parse($exam->start_date)->format('d/m/Y') }} 
                                @endif   @if (!empty($exam->end_date  && $exam->end_date > '2025-00-00'))
                                To {{ \Carbon\Carbon::parse($exam->end_date)->format('d/m/Y') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <ol>
            <li>You are requested to conduct the examinations as per the schedule and submit the report/observation via email after the completion of examinations to NBER, Chennai on the prescribed format (copy enclosed).</li>
            <li>Honorarium/TA/DA will be paid to the Practical Examiner by NBER, Chennai as per the RCI norms.</li>
            <li>Please send the Declaration form and willingness to the following email id: <strong>{{$nber->email}}</strong></li>
        </ol>

        <p><strong>Liaison Staff:</strong></p>
        <ul>
            <li><strong>Examiner Appointment:</strong>{{ {$nber->practical_exam_contact_1} }} / {{  $nber->email}}</li>
            <li><strong>Portal Marks Entry:</strong> {{ {$nber->practical_exam_contact_2} }} </li>
            <li><strong>More Info:</strong> {{ {$nber->practical_exam_contact_3} }}</li>
        </ul>

        <!-- Signature -->
        <div class="signature text-right">
            Yours faithfully,<br><br><br>
            <strong>Director</strong><br>
            National Board of Examination in Rehabilitation <br> (NBER)
        </div>

        
    </div>

</div>

</body>
</html>
