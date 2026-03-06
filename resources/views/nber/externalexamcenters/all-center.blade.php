

@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
			

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Institute Name</th>
                        <th>RCI Code</th>
                        <th>No of Center</th>
                        {{-- <th>Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($institutes as $institute)
                    
                        <tr>
                            <td>{{ $institute->name }}</td>
                            <td>{{ $institute->rci_code }}</td>
                            <td>{{$institute->external_exam_centers}}</td>
        
                            {{-- <td>
                                <!-- Example of action buttons -->
                                <a href="{{url('/')}}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{url('/')}}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
			</div>
		</div>
	</div>
	
@endsection