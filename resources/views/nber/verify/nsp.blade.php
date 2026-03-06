@extends('layouts.downloadabletable')

@section('filter')
    <option value="filled" @if($type=='filled') selected @endif>Institutes with Registration Number</option>
    <option value="notfilled" @if($type=='notfilled') selected @endif>Institutes not filled Registration Number</option>
@endsection

@include('nber.verify.tables.nsp')


