@if(!is_null($data) && !is_null($data['institute'])&& $data['institute']->count() > 0)
    <img  onerror="this.style.display='none'" src="{{ url('images/institutes') }}/{{ $data['institute'][0]->rci_code }}PH.png" class="img-responsive" />
    <br />
    @if(!is_null($data) && !is_null($data['courses'])&& $data['courses']->count() > 0)
        <ul class="nav nav-tabs">
            <?php $slno = 1; ?>
            @foreach($data['courses'] as $course)
                <li @if($slno==1)  class="active" @endif><a   data-toggle="tab" href="#d-{{$course->id}}"> {{$course->name}}</a></li>
                <?php $slno++; ?>
            @endforeach
        </ul>
        <?php $slno = 1; ?>
        <div class="tab-content">
            @foreach($data['courses'] as $course)
            
                <div id="d-{{$course->id}}" class="tab-pane fade in  @if($slno==1) active @endif">
                    <h3>{{$course->fullname}}</h3>
                    <?php $faculties =  $data['coursedetails'][$course->id]['faculties']; ?>
                    @if($faculties->count() > 0)
                        @include('public.listinstitutes.data.faculties')
                    @endif
                    <?php $candidates =  $data['coursedetails'][$course->id]['candidates']; ?>
                    @if($candidates->count() > 0)
                        @include('public.listinstitutes.data.candidates')
                    @endif
                </div>
                <?php $slno++; ?>
            @endforeach
        </div>
    @endif
@endif