<form id="form_{{$ap->id}}_{{$term}}" action="{{url('practicalexam/awardlisttemplate')}}" method="POST">
@include('practicalexaminer._partials._modal._top')
<div class="alert alert-warning subjects">
    {{ csrf_field() }}
    <input type="hidden" name="practicalexam_id" value="{{$exam->id}}">
    <input type="hidden" name="approvedprogramme_id" value="{{$ap->id}}">
    <input type="hidden" name="institute_id" value="{{$ap->institute_id}}">
    <input type="hidden" name="term" value="{{$term}}">
    <h4>
        <span class="text-muted">Please choose the subject(s) for today's practical exam </span>
    </h4>
    <h5>
        <table class="table table-bordered " >
            <tr>
                <td>Course</td>  <th>{{$ap->programme->abbreviation}}</th>
                <td>Batch</td><th>{{$batch}}</th>
                <td>Term</td> <th>{{$term}}</th>
            </tr>
        </table>
    </h5>
    <table class="table table-bordered " >
        <tr>
            <th>Slno</th>
            <th>Code</th>
            <th>Subject</th>
            <th></th>
        </tr>
        <?php $slno = 1; ?>
        @foreach($ap->programme->subjects as $subject)
            @if($subject->syear == $term && $subject->subjecttype_id == 2)
                <tr>
                    <td>{{$slno}} <?php $slno++ ; ?></td>
                    <td>{{$subject->scode}}</td>
                    <td>{{$subject->sname}}</td>
                    <td> 
                        <input 
                            type="checkbox"
                            class="chk_{{$ap->id}}_{{$term}}" 
                            name="chk_{{$subject->id}}"
                            
                        >
                    </td>
                </tr>
            @endif
        @endforeach
    </table>
</div>
@include('practicalexaminer._partials._modal._bottom')
</form>
