@section('thead')
    <th>Institute Code</th>
    <th>Institute Name</th>
    <th>Course</th>
    <th>Faculty Name</th>
    <th>CRR Number</th>
    <th>Email</th>
    <th>Mobile</th>
    <th>Qualification</th>
    <th>Faculty Type</th>
    <th>Course Coordinator</th>
    <th>Language(s) Known</th>
    <th>Willingness for June 2025 exam</th>
    <th>Status</th>
    <th>Subjects Taught</th>
    
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
                    {{ $result->institute_name }}
                </td>
                <td>{{ $result->course }}</td>
                <td>{{ $result->name }} </td><td>
                {{ $result->crr_no }}</td><td>
                {{ $result->email }} </td><td>
                {{ $result->mobileno }}</td>
                <td>{{ $result->qualification }}</td>
                <td>
                    @if($result->core == 1)
                        Core Faculty
                    @else
                        Visisting Faculty
                    @endif 
                 
                </td>
                <td>
                    @if($result->coodinator == "YES")
                    Yes
                    @else
                    No
                @endif 
                </td>
                <td class="text-center">
                    {!! $result->language !!} 
                </td>
                <td>
                    {{ $result->responsiblity }}
                </td>
                <td>
                    @if($result->clo_verified == 1) <span style="color:green;">Approved</span> @endif
                    @if( !is_null($result->clo_verified) &&  $result->clo_verified == 0) <span style="color:red;"> Rejected </span> @endif
                </td>
          
                <td>
                        <table class="table  table-bordered">
                            <tr>
                                <th>Code</th>
                                <th>Subject</th>
                                <th>Year</th>
                                <th>Theory/Practical</th>
                            </tr>
                            <?php $subjects = \App\Facultysubject::where('faculty_id',$result->id)->where('institute_id',$result->institute_id)->where('course_id',$result->course_id)->get(); ?>
                            @foreach ($subjects as $s)
                                <tr>
                                    <td>
                                        {{ $s->subject->scode }}
                                    </td>
                                    <td>
                                        {{ $s->subject->sname }}
                                    </td>
                                    <td>
                                        {{ $s->subject->syear }}
                                    </td>
                                    <td>
                                        @if(!is_null($s->subject) && !is_null($s->subject->subjecttype) && $s->subject->subjecttype_id > 0)
                                            {{ $s->subject->subjecttype->type }} 
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                </td>
          
                
               
            </tr>
        @endforeach
    @endif
@endsection

