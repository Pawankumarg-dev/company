@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
            <h4>
            @if($attendance==1) Missing Classroom Attendance @else Publishing Missing Results @endif
                    </h4>
                <ul>
                    @foreach($courses as $p)
                        <li>
                            <a href="{{url('nber/publishresult')}}/{{$p->id}}?attendance={{$attendance}}">
                            {{$p->course_name}} 
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

