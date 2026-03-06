
@if (!is_null($progress))    
        <table class="table table-bordered table-striped table-hover">
            <tr>
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
                    No of Students
                </th>
                <th>
                    No of Applications
                </th>
                <th>
                    No of Internal marks uploaded
                </th>
                <th>Internal Pending</th>
                <th>
                    No of External marks uploaded
                </th>
                <th>External Pending</th>
                <th>No of Students Applied</th>
                <th>
                    Examiner
                </th>
                <th>
                    Contact Number
                </th>
                <th>
                    Email ID
                </th>
            </tr>
            
            @foreach($progress as $application)
                <tr>
                    <td>{{$application['rci_code']}}</td>
                    <td>{{$application['Institute']}}</td>
                    <td>{{$application['course']}}</td>
                    <td>{{$application['batch']}}</td>
                    <td>{{$application['subject_code']}}</td>
                    <td>{{$application['subject_name']}}</td>
                    <td>{{$application['no_of_students']}}</td>
                    <td>{{$application['no_of_applications']}}</td>
                    <td>{{$application['no_of_internal_marks_uploaded']}}</td>
                    <td>{{$application['pending_internal_entries']}}</td>
                    <td>{{$application['no_of_external_marks_uploaded']}}</td>
                    <td>{{$application['pending_external_entries']}}</td>
                    <td>{{$application['examiner']}}</td>
                    <td>{{$application['contact_no']}}</td>
                    <td>{{$application['email']}}</td>
                </tr>
            @endforeach
        </table>
@endif