@if(($approvedprogramme->academicyear_id <= 16 ))
<a 

href="{{url('institute/exam/markentry')}}/{{$approvedprogramme->id}}?exam_id={{$exam->id}}&subjecttype_id={{$subjecttype_id}}&syear={{$term}}@if($approvedprogramme->academicyear_id != 16 && $approvedprogramme->academicyear_id != 14 && $approvedprogramme->academicyear_id != 12)&supplementary=Yes @endif"
class="btn   @if($approvedprogramme->academicyear_id == (15-$term) || $approvedprogramme->academicyear_id == 16 || $approvedprogramme->academicyear_id == 12) btn-primary @else btn-info @endif btn-xs "
style="margin-left:10px;margin-top:5px;"
>
<i class="fa fa-edit"></i> &nbsp;&nbsp;
@if($approvedprogramme->academicyear_id == (15-$term) || $approvedprogramme->academicyear_id == 16 || $approvedprogramme->academicyear_id == 12) Regular @else Backlog  @endif 
(Term {{$term}}) 
</a>
@endif