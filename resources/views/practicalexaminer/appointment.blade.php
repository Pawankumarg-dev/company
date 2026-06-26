<div style="font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4;">
    @foreach ($paractical as $data)
        <div style="margin-bottom: 40px;">
            <div style="display: flex; align-items: flex-start; gap: 15px;">
                <div style="">
                    <img src="/var/www/html/rcinber/public/images/{{ $data->logo }}" alt="NBER Logo" style="width: 80px;">
                </div>
                <div style="margin-left: 100px;">
                    <strong>{{ $data->short_name_code }}</strong><br>
                    {{ $data->nber_address }}<br>
                    <strong>Coordinating Body: National Board of Examination in Rehabilitation (NBER)</strong><br>
                    (An Adjunct Body of Rehabilitation Council of India)<br>
                    Email: {{ $data->nber_email }}
                </div>
            </div>

            <div style="margin-top: 20px;">
                <p>
                    To,<br>
                    {{ $data->faculty_name }}<br>
                    {{ $data->address }}
                </p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </div>

            <p><strong>Subject:</strong> Appointment of Practical External Examiner for RCI recognized Diploma/Certificate courses, {{$exam->name}} examination</p>

            <p>Madam/Sir,</p>

            <p>
This is to inform you that the Practical External Examination for all RCI Recognised Diploma and Certificate Courses are being conducted by NBERs at the respective exam centers/TTIs across the country from 11th june to june 24th for slot 1 and 10 July to 31 July slot 2, 2026.            
            </p>

            <table style="border: 1px solid black; border-collapse: collapse; width: 100%; margin-top: 15px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px;">TTI</th>
                        <th style="border: 1px solid black; padding: 5px;">Course</th>
                        <th style="border: 1px solid black; padding: 5px;">Duty on Dates</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid black; padding: 5px;">{{ $data->exam_center }}</td>
                        <td style="border: 1px solid black; padding: 5px;">{{ $data->name }}</td>
                        <td style="border: 1px solid black; padding: 5px;">
                            {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }} to {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <p>
                You are requested to conduct examinations as per the schedule and submit the report/observation via email after the completion of examination to NBER- {{ $data->short_name_code }} on the prescribed format copy enclosed. Honorarium and TA/DA will be paid to the practical examiner by {{ $data->short_name_code }} as per the Scheme of Examination 2026.
            </p>
            <p>
                Kindly enter the external marks and upload marks entry sheet in the portal without fail. Marks entry copy(Hard copy) should be sent through speed post mentioning Confidential properly Sealed envelop duly verified by Course Coordinator and Practical Examiner:
            </p>

            <p><strong>Liaison Staff:</strong></p>
            <ul>
                <li><strong>Examiner Appointment:</strong> {{ $data->practical_exam_contact_1 }} / {{ $data->nber_email }}</li>
                <li><strong>Portal Marks Entry:</strong> {{ $data->practical_exam_contact_2 }}</li>
                <li><strong>More Info:</strong> {{ $data->practical_exam_contact_3 }}</li>
            </ul>

            <div style="margin-top: 20px;">
                Yours faithfully,<br><br>
                <strong>Incharge</strong><br>
                National Board of Examination in Rehabilitation<br>
                {{ $data->short_name_code }}, (NBER)
            </div>
        </div>
            <div style="page-break-after: always;"></div>
    @endforeach
    {{-- Optional page break if you want to force a new page for each examiner --}}
</div>
