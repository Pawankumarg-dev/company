@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>Evaluation Center</th>
                <th>Subject</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
<?php $i=1; ?>
          @foreach ($subjects as $data)
    <tr>
        <td>{{$i++}}</td>
        <td>{{ $data->name }}</td>
                <td>{{ $data->scode }} {{ $data->sname }}</td>

        <td>
<form method="POST" action="{{url('/')}}/reevaluationcenter/verify-marks/show">
		{!! csrf_field() !!}

    <input type="hidden" name="evaluationcenter_id" value="{{ $data->evaluationcenter_id }}">
    <input type="hidden" name="id" value="{{ $data->id }}">

    <button type="submit" class="btn btn-primary">{{ $data->scode ?? 'N/A' }}</button>
</form>            
        </td>
    </tr>
@endforeach
        </tbody>
    </table>
</div>
@endsection
