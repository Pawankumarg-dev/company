@extends('layouts.downloadabletable')

@section('filter')
    <option value="scanned" @if($type=='scanned') selected @endif>Scanned</option>
    <option value="verified" @if($type=='verified') selected @endif>Verified</option>
    <option value="uploaded" @if($type=='uploaded') selected @endif>Uploaded</option>
    <option value="evaluated" @if($type=='evaluated') selected @endif>Evaluated</option>
    <option value="language" @if($type=='language') selected @endif>Wrong Language</option>
@endsection

@include('nber.monitoring.tables.answerbooklets')

@section('sc')
<script>
      function showdeatils(eid){
        $('.ev_'+eid).removeClass('hidden');
      }
</script>
@endsection
