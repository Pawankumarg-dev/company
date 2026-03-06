<table class="table table-bordered table-condensed">
    <tr>
        <th>Slno</th>
        <th>Evaluation Center</th>
        <th>Number of Papers</th>
		<th>Present</th>
		<th>Absent</th>
		<th>Pending to Mark Attendance </th>
		<th>Evaluation Completed (Mark uploaded)</th>
		<th>Contact Person</th>
		<th>Contact Number</th>
		<th>Contact Number - Alternative</th>
		<th>Email</th>
		<th>Email - Alternative</th>
    </tr>
    <?php $slno = 1; ?>
    @foreach ($data as $ec)
        <tr>
            <td>{{ $slno }}
                <?php $slno++; ?>
            </td>
            <td>
                    {{ $ec->name }}
            </td>
			<td>
				{{$ec->no_of_papers}}
			</td>
			<td>
				{{$ec->present}}
			</td>
			<td>
				{{$ec->absent}}
			</td>
			<td>
				{{$ec->pending_attendance}}
			</td>
			<td>{{$ec->evaluation_completed}}</td>
			<td>
				{{$ec->contactperson}}
			</td>
			<td>
				{{$ec->contactnumber1}}
			</td>
			<td>
				{{$ec->contactnumber2}}
			</td>
			<td>
				{{$ec->email1}}
			</td>
			<td>
				{{$ec->email2}}
			</td>
        </tr>
    @endforeach
</table>
