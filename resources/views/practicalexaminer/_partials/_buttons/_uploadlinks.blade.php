

@foreach($exam->awardlisttemplates()->where('approvedprogramme_id',$ap->id)->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->get() as $template)
    @if($exam->faculty_id == $practicalexaminer_id)
    <?php $term = $template->term; ?>
    @include('practicalexaminer._partials._upload_marksheet')
    @endif
@endforeach

