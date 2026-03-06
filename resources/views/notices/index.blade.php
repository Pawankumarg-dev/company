@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				{{-- <h4>Notices/ Circulars</h4> --}}
                <h4 tabindex="0"><strong>Notices/ Circulars </strong></h4>
				<ol>
					@foreach($notice as $data)
				<li>
					<a href="{{ url('files/notice/' . $data->file_name) }}" target="_blank">
						{{ $data->title }}
						@if($data->publish_date)
							– Date: {{ \Carbon\Carbon::parse($data->publish_date)->format('d M Y') }}
						@endif
					</a>
				</li>
{{-- <li><a href="{{url('files/Adm_notification_24.pdf')}}" target="_blank">Admission notification for vacant seats as well as DTISL & DISLI </a></li> --}}
					@endforeach
                    
                </ol>
			</div>
		</div>
	</div>
@endsection