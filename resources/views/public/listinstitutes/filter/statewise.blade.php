@include('public.listinstitutes.filter.dropdowns.state')

@if(!is_null($dropdowndata['courses']) && $selected['state_id'] != -1 )
    @include('public.listinstitutes.filter.dropdowns.course')
@endif
@if(!is_null($dropdowndata['institutes']) && $selected['state_id'] != -1 && $selected['course_id'] != -1)
    @include('public.listinstitutes.filter.dropdowns.institutes')
@endif
@include('public.listinstitutes.js.statewise')
