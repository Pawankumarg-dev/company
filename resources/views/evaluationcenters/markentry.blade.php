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
<script>
  function validateFileInput() {
    const fileInput = document.getElementById('uploaded_file');
    const file = fileInput.files[0];

    if (!file) {
      alert("Please select a file.");
      return false;
    }

    if (file.size > 2 * 1024 * 1024) { // Corrected 2MB limit
      alert("File size must be 2MB or less.");
      return false;
    }

    const fileName = file.name.toLowerCase();
    const isPDF = file.type === "application/pdf" && fileName.endsWith(".pdf");

    if (!isPDF) {
      alert("Only PDF files are allowed.");
      return false;
    }

    return true;
  }
</script>

<div class="container">
  <div class="row">
    <div class="col-12">
      <h6>June 2025 Examinations - Mark Entry</h6>
      <h3>{{ $subject->scode }}</h3>

      @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
        <?php Session::forget('error'); ?>
      @endif

      @if (Session::has('messages'))
        <script>
          $(document).ready(function () {
            swal({
              type: 'success',
              title: '{{ Session::get('messages') }}',
              showConfirmButton: false,
              timer: 1500
            });
          });
          <?php Session::forget('messages'); ?>
        </script>
      @endif
    </div>
  </div>

  <!-- Parallel Table Layout -->
  <div class="row">
    <!-- First Table inside Form -->
    <div class="col-md-6">
      <form action="{{ url('evaluationcenter/savemark') }}" method="post" onsubmit="return validateFileInput()" enctype="multipart/form-data">
       {{csrf_field()}}
        <input type="hidden" name="externalexamcenter_id" value="{{ $applications[0]->externalexamcenter_id }}">
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">


          <div class="form-group">
        <label for="uploaded_file" style="font-weight: bold;">Upload Awardlist</label><br>
        <small style="color: #555;">The uploaded PDF should be below 2 MB</small><br><br>
        <input type="file" id="uploaded_file" name="uploaded_file" accept=".pdf" required>
        <div id="file_error" style="color: red; margin-top: 5px;"></div>
    </div>

        <table class="table table-bordered table-striped table-hover">
          <tr>
            <th>SlNo.</th>
            <th>Dummy Enrolment Number</th>
            <th>Language</th>
            <th>Mark</th>
          </tr>

          

          @php $slno = 1; @endphp
          @foreach($applications as $a)
            @if($a->attendance == 1)
              <tr>
                <td>{{ $slno++ }}</td>
                <td>{{ $a->dummy_no }}</td>
                <td>{{ $a->language->language }}</td>
                <td>
                  <input type="number" name="externalmark_{{ $a->id }}"
                         id="externalmark_{{ $a->id }}"
                         value="{{ $a->external_mark ?? '' }}"
                         min="0" max="{{ $subject->emax_marks }}" required>
                </td>
              </tr>
            @endif
          @endforeach
        </table>

        <button type="submit" class="btn btn-primary btn-sm mb-4">Save</button>
      </form>
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
