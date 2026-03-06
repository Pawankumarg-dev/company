<h4> {{ $title }}
    <a  class="pull-right btn btn-xs btn-primary" style="margin-bottom: 10px;" target="_blank" href="{{ url('files/internalmarksheets/') }}/{{ $internal->first()->$filename }}">
        <span class="fa fa-download"></span> &nbsp; {{ $title }}
    </a> 
    </h4>
    <table class="table table-contensed table-stripped table-bordered">
        <tr>
            <th>Slno</th>
            <th>Enrolment No</th>
            <th>Candidate Name</th>
            @foreach($subjects as $s)
                <th>
                    {{ $s->scode }} <br />
                    <small class="text-muted">Min: {{ $s->imin_marks }}</small><br />
                    <small  class="text-muted">Max: {{ $s->imax_marks }}</small>
                </th>
            @endforeach
        </tr>
        <?php $slno = 1; ?>
        @foreach($internal as $im)
           
            <tr>
                <td>
                    {{ $slno }}
                    <?php $slno++ ; ?>
                </td>
                <td>
                    {{ $im->enrolmentno }} 
                </td>

                <td>
                    {{ $im->name }}
                    @if($im->status != 'Verified')
                    <small>{{ $im->status }}</small>
                    @endif
                </td>
                @foreach (json_decode('[' . $im->marks . ']', true) as $key => $value)
                    <td>
                         {{ $value['mark'] }} 
                    </td>
                @endforeach
            </tr>
        @endforeach 
    </table>

