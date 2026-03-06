@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            @include('common.errorandmsg')
            <div class="alert alert-success">
                <ul>
                    <li>Click <a target="_blank" href="{{ url('files/evaluation/SOP_Evaluation.pdf') }}">here</a> to download the Evaluation SOP.</li>
                    <li>Click <a  target="_blank" href="{{ url('files/evaluation/Evaluator_Guidelines.pdf') }}">here</a> to download Guidelines for evaluating answer booklets.</li>
                    <li>Click <a href="{{ url('files/evaluation/Evaluator.zip') }}">here</a> to download the software.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
