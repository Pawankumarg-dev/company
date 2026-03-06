@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <h4>
                    <a href="{{url('nber/publishresult')}}?attendance={{$attendance}}">
                   @if($attendance==1) Missing Classroom Attendance @else Publishing Missing Results @endif
                    </a>    | 
                    {{$p->course_name}} 
                </h4>
                <table class="table">
                    <tr>
                        <th>Slno</th>
                        <th>Institute</th>
                    </tr>
                    <?php $slno = 1; ?>
                @foreach($institutes as $i)
                    <tr>
                        <td>
                            {{$slno}}
                            <?php $slno++; ?>
                        </td>
                        <td>
                            <a href="{{url('nber/publishresult')}}/{{$p->id}}/{{$i->id}}/studentlist?attendance={{$attendance}}">
                            {{$i->rci_name}} ({{$i->rci_code}})
                            </a>
                        </td>
                    </tr>
                @endforeach
                </table>
                @if($institutes->count()==0)
                    <br /> Completed
                @endif
            </div>
        </div>
    </div>
@endsection

