<?php $term = 1;  ?>
@include('institute.exam.home._markentrylink')
@if($approvedprogramme->academicyear_id < 13 && $approvedprogramme->programme->numberofterms==2)
    <?php $term = 2;  ?>
    @include('institute.exam.home._markentrylink')
@endif