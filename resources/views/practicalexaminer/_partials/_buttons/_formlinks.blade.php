
<?php $term = 1;  ?>
@include('practicalexaminer._partials._buttons._formlink')
@if($ap->academicyear_id < 12 && $ap->programme->numberofterms==2)
    <?php $term = 2;  ?>
    @include('practicalexaminer._partials._buttons._formlink')
@endif