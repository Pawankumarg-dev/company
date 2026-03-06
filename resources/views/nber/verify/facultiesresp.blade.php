@extends('layouts.downloadabletable')

@section('filter')

    <option value="CLO" @if($type=='CLO') selected @endif>CLO</option>
    <option value="PE" @if($type=='PE') selected @endif>Practical Examiner</option>
    <option value="Evaluator" @if($type=='Evaluator') selected @endif>Evaluator</option>
    <option value="Pending" @if($type=='Pending') selected @endif>Pending Approval/Reject</option>
@endsection


@include('nber.verify.tables.facultiesresp')


