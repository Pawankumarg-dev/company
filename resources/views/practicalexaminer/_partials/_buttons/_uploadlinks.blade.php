{{-- @php
// echo $exam->id;
// echo "<br>";

echo $key = $exam->id . '_' . $ap->id . '_' . $term;
$download_data = session('download_data')[$key] ?? null;
echo "<br>";
echo $exam->awardlisttemplates()->where('approvedprogramme_id',$ap->id)->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->count();
@endphp

@if($exam->awardlisttemplates()->where('approvedprogramme_id',$ap->id)->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->count()>0)

    @foreach($exam->awardlisttemplates()->where('approvedprogramme_id',$ap->id)->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->get() as $template)
       {{print_r($template->toArray()) }}
        @if($exam->faculty_id == $practicalexaminer_id)
           
             @include('practicalexaminer._partials._upload_marksheet')
        @endif

    @endforeach

@elseif($download_data)

    @include('practicalexaminer._partials._upload_marksheet')

@endif --}}



@foreach($exam->awardlisttemplates()->where('approvedprogramme_id',$ap->id)->where('exam_date',\Carbon\Carbon::parse($date)->toDateString())->get() as $template)
    @if($exam->faculty_id == $practicalexaminer_id)
    <?php $term = $template->term; ?>
    @include('practicalexaminer._partials._upload_marksheet')
    @endif
@endforeach

