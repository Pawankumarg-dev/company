@extends('layouts.app')
@section('content')
<style>
#sidenav-container {
    display: none;
    border-inline-end: 1px solid var(--viewer-border-color);
    overflow: hidden;
    transition: transform 250ms cubic-bezier(.6,0,0,1), visibility 250ms;
    visibility: visible;
    width: var(--viewer-pdf-sidenav-width);
}
</style>


<div class="container">
  <div class="row">
    <div class="col-12">
      <h6>June 2025 Examinations - Mark Entry</h6>
      <h3>{{ $subject->scode }}</h3>
    </div>
  </div>

  <!-- Parallel Table Layout -->
  <div class="row">
    <!-- First Table inside Form -->
    <div class="col-md-6">
    

        <table class="table table-bordered table-striped table-hover">
          <tr>
            <th>SlNo.</th>
            <th>Dummy Enrolment Number</th>
            <th>Passing Marks</th>
            <th>Maxmum Marks</th>

            <th>Language</th>
            <th>Mark</th>
          </tr>



          @php $slno = 1; @endphp
          @foreach($applications as $a)
            @if($a->attendance == 1)
              <tr>
                <td>{{ $slno++ }}</td>
                <td>{{ $a->dummy_no }} @if($a->exam_id < 28 ) / {{$a->candidate->enrolmentno}} @endif</td>
                <td>{{ $subject->emin_marks }}</td>
                <td>{{ $subject->emax_marks }}</td>

                <td>{{ $a->language->language }}</td>
                <td>
                 {{ $a->external_mark }}
                </td>
              </tr>
            @endif
          @endforeach
        </table>


        
          {{-- <form action="{{ url('evaluationcenter/verify-marks') }}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="externalexamcenter_id" value="{{ $applications[0]->externalexamcenter_id }}">
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <button type="submit" class="btn btn-primary btn-sm mb-4">Verify</button>
          </form> --}}
    </div>
@php
    $pdfPath = 'files/markfiles/27_' . $applications[0]->externalexamcenter_id . '_' . $subject->id . '.pdf';
@endphp


    <div class="col-md-6" style="height: 700px">
        @if (file_exists($pdfPath))
<button onclick="window.open('{{ asset($pdfPath) }}', '_blank')">
    Open PDF Full View
</button>
            <iframe src="{{ asset($pdfPath) }}" style="width:164%;height:164%"></iframe>


@else
    <p>Please Upload and Fill The Marks</p>
@endif
    </div>
  </div>
</div>

@endsection
