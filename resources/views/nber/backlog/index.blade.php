@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
            <h4>
                    Mark Entry - {{Session::get('examname')}} Exam
                    </h4>
                <ul>
                    @foreach($institutes as $i)
                        <li>
                            <a href="{{url('nber/markentry')}}/{{$i->id}}">
                            {{$i->name}} - ({{$i->rci_code}})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection