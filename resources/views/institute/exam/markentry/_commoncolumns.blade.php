<td class="text-center">
    {{$slno}} 
</td>
<td id="enrolmentno_{{$internal['cid']}}">
    {{$internal['enrolmentno']}}
</td>
<td id="name_{{$internal['cid']}}">
    {{ $internal['name'] }}
</td>
    @if($supplementary == 'Yes' && $editshow == 'edit')
        <td>
            <a 
                href="javascript:getFailedSubjects({{$internal['cid']}},{{$subjecttype->id}},{{$syear}})"
                class="btn btn-xs btn-primary"
            >
                Fill Marks 
            </a>
        </td>
    @endif
