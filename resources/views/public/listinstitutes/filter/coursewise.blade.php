@if(!is_null($dropdowndata['courses']) )
    @include('public.listinstitutes.filter.dropdowns.course')
@endif

@include('public.listinstitutes.filter.dropdowns.state')

@if(!is_null($dropdowndata['institutes']) && $selected['state_id'] != -1 )
    @include('public.listinstitutes.filter.dropdowns.institutes')
@endif

@include('public.listinstitutes.js.coursewise')

