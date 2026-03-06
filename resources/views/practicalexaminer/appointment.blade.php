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

            <p><strong>Subject:</strong> Appointment of Practical External Examiner for RCI recognized Diploma/Certificate courses, June 2025 term-end examination between 20th May and 10th June 2025 – reg.</p>

            <p>Madam/Sir,</p>

            <p>
                This is to inform you that the Practical External Examinations for all RCI recognized Diploma/Certificate courses are being conducted by the NBER, Chennai at the respective Training Centers across the country between 20th May and 10th June 2025. You are appointed as an External Examiner to conduct these Practical Examinations. Venue, schedule, and course details are as below:
            </p>

            <table style="border: 1px solid black; border-collapse: collapse; width: 100%; margin-top: 15px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; padding: 5px;">Exam Centre</th>
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

            <ol style="margin-top: 15px; padding-left: 15px;">
                <li>You are requested to conduct the examinations as per the schedule and submit the report/observation via email after the completion of examinations to NBER in the prescribed format (copy enclosed).</li>
                <li>Honorarium/TA/DA will be paid to the Practical Examiner by NBER as per RCI norms.</li>
                <li>Please send the Declaration form and your willingness to: <strong>{{ $data->nber_email }}</strong></li>
            </ol>

            <p><strong>Liaison Staff:</strong></p>
            <ul>
                <li><strong>Examiner Appointment:</strong> {{ $data->practical_exam_contact_1 }} / {{ $data->nber_email }}</li>
                <li><strong>Portal Marks Entry:</strong> {{ $data->practical_exam_contact_2 }}</li>
                <li><strong>More Info:</strong> {{ $data->practical_exam_contact_3 }}</li>
            </ul>

            <div style="margin-top: 20px;">
                Yours faithfully,<br><br>
                <strong>Director</strong><br>
                National Board of Examination in Rehabilitation<br>
                (NBER)
            </div>
        </div>
            <div style="page-break-after: always;"></div>

    @endforeach

    {{-- Optional page break if you want to force a new page for each examiner --}}
</div>
