@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            @include('common.errorandmsg')
            <div class="alert alert-success">
                <ul>
                    <li>Click <a target="_blank" href="{{ url('files/evaluation/SOP_Evaluation.pdf') }}">here</a> to download the Evaluation SOP.</li>
                    <li>Click <a  target="_blank" href="{{ url('files/evaluation/Guidelines.pdf') }}">here</a> to download Guidelines for scanning answer booklets.</li>
                    <li>Click <a href="{{ url('files/evaluation/Evaluation_Center.zip') }}">here</a> to download the software.</li>
                    <li>Click <a href="{{ url('evaluationcenter') }}?download=1">here</a> to download the scanning and evaluation progress.</li>
                </ul>
            </div>
        </div>
        <div class="col-12">
            @if(!is_null($dashboard))
                <table class="table table-bordered  table-hover">
                    <tr>
                        <th>No of answer booklets</th>
                        <th>scanned</th>
                        <th>verified</th>
                        <th>uploaded</th>
                        <th>evaluated</th>
                    </tr>
                @foreach($dashboard as $d)
                    <tr>
                        <td  class="text-center">
                            {{ $d->answerbooklets }}
                        </td>
                        <td  class="text-center">
                            {{ $d->scanned }}
                        </td>
                        <td  class="text-center">
                            {{ $d->verified }}
                        </td>
                        <td  class="text-center">
                            {{ $d->uploaded }}
                        </td>
                        <td  class="text-center">
                            {{ $d->evaluated }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </div>
        <div class="col-12">
            @if(!is_null($courses))
                <table class="table table-bordered  table-hover">
                    <tr>
                        <th>NBER</th>
                        <th>Course</th>
                        <th>No of answer booklets</th>
                        <th>scanned</th>
                        <th>verified</th>
                        <th>uploaded</th>
                        <th>evaluated</th>
                    </tr>
                @foreach($courses as $d)
                    <tr>
                        <td>
                            {{ $d->nber }}
                        </td>
                        <td>
                            {{ $d->course }}
                        </td>
                        <td  class="text-center">
                            {{ $d->answerbooklets }}
                        </td>
                        <td  class="text-center">
                            {{ $d->scanned }}
                        </td>
                        <td  class="text-center">
                            {{ $d->verified }}
                        </td>
                        <td  class="text-center">
                            {{ $d->uploaded }}
                        </td>
                        <td  class="text-center">
                            {{ $d->evaluated }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
