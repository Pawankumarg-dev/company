@section('thead')
    <th>Institute Code</th>
    <th>Institute Name</th>
    <th class="text-center hidden">Number of Faculties</th>
    <th class="text-center hidden">Number of courses</th>
    <th>Status</th>
    <th>Action</th>
@endsection

@section('tbody')
    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>
                <td>
                    {{ $result->rci_code }}
                </td>
                <td>
                    {{ $result->name }}
                </td>
                <td class="text-center hidden">
                    {{ $result->no_of_faculties }}
                </td>
                <td class="text-center hidden">
                    {{ $result->no_of_courses }}
                </td>
                <td>
                    @if($result->no_of_courses > 0 && $result->no_of_courses <= $result->no_of_course_coordinators)
                        <span class="label label-success">Verified</span>
                    @else
                        <span class="label label-danger">Not Verified</span>
                    @endif
                </td>
                <td>
                    <a href="{{url('nber/verify/facultydetails')}}/{{$result->id}}" class="btn btn-xs btn-primary" >Show Faculties</a>
                </td>
            </tr>
        @endforeach
    @endif
@endsection