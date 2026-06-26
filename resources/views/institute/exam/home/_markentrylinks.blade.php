<?php $term = 1;  ?>
@if($approvedprogramme->academicyear_id !=12)

@include('institute.exam.home._markentrylink')
@endif
@if($approvedprogramme->academicyear_id < 14 && $approvedprogramme->programme->numberofterms==2)
    <?php $term = 2;  ?>
    @include('institute.exam.home._markentrylink')
@endif