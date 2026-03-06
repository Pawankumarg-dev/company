@if(($supplementary != 'Yes' || $editshow == 'show'))
    @foreach ($subjects as $subject)
        <th class="top">
            @if($codeorname=='imax_marks') Max: @endif 

            {{$subject->$codeorname}} 
            @if($subject->has_alternative ==  1)
                / Alternative
            @endif
        </th>
    @endforeach
@else
    <th></th>
@endif