@if (!is_null($applications))
    
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>
                    State
                </th>
                <th>
                    Institute Code
                </th>
                <th>
                    Institute Name
                </th>
                <th>
                    Course
                </th>
                <th>
                    Batch
                </th>
                <th>
                    Subject Code
                </th>

                <th>
                    Subject Name
                </th>
                <th>
                    No of Students applied
                </th>
                <th>
                    Total No. of  Students 
                </th>
                <th>Attendance Upload Status</th>
                <th>No of Students Applied</th>
                <th>
                    No of Students attendance Marked
                </th>
                <th>
                    No of Student Present
                </th>
                <th>
                    No of Students Absent
                </th>
                <th>
                    No of Papers Evaluated
                </th>
                <th>Exam Details</th>
                <th>
                    Exam Center Code
                </th>
                <th>
                    Exam Center Name
                </th>
                <th>
                    Exam Center Contact Person
                </th>
                <th>
                    Exam Center Contact Number
                </th>
                <th>
                    Exam Center Email
                </th>
                <th>
                    Evauation Center Code
                </th>
                <th>
                    Evaluation Center
                </th>
            </tr>
            @foreach($applications as $application)
                <tr>
                    <td>{{$application['state_name']}}</td>
                    <td>{{$application['institute_code']}}</td>
                    <td>{{$application['institute_name']}}</td>
                    <td>{{$application['course']}}</td>
                    <td>{{$application['batch']}}</td>
                    <td>{{$application['subject_code']}}</td>
                    <td>{{$application['subject_name']}}</td>
                    <td>{{$application['no_of_students']}}</td>
                    <td>{{$application['scan_copy']}}</td>
                    <td>{{$application['no_of_students']}}</td>
                    <td>{{$application['no_of_students_attendance_marked']}}</td>
                    <td>{{$application['present']}}</td>
                    <td>{{$application['absent']}}</td>
                    <td>{{$application['evaluation_completed']}}</td>
                    <td>{{$application['examdetails']}} - {{$application['examdate']}}  {{$application['starttime']}}</td>
                    <td>{{$application['exam_center_code']}}</td>
                    <td>{{$application['exam_center']}}</td>
                    <td>{{$application['contactperson']}}</td>
                    <td>{{$application['contact_number']}}</td>
                    <td>{{$application['email']}}</td>
                    <td>{{$application['evaluation_center_code']}}</td>
                    <td>{{$application['evaluation_center']}}</td>
                </tr>
            @endforeach
        </table>
@endif