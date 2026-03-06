<?php $term = 1;  ?>
@include('nber.internalmarkentry.markentry._markentrylink')
@if($approvedprogramme->academicyear_id < 11 && $approvedprogramme->programme->numberofterms==2)
    <?php $term = 2;  ?>
    @include('nber.internalmarkentry.markentry._markentrylink')
@endif