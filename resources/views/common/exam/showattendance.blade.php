@if($application->externalattendance_id == 1)
Present
@endif
@if($application->externalattendance_id == 2)
Absent
@endif
@if($application->externalattendance_id != 1 && $application->externalattendance_id != 2)
Not Marked
@endif
