@extends('layouts.app')
@section('content')
<style>
    .mb-2 {
        margin-bottom: 10px;
    }
    .edit-field{
        width:900px;
        border:1px solid #ccc;
    }
    .text-danger {
        font-size: 0.9em;
        color: red;
    }
</style>

<div class="container">
    <div class="row">

          <div class="alert alert-success">
                <ul>
                    <li>
                        Before mapping, please check the exam center details and ensure all information is correct.
                    </li>
                    <li>
                        NBER can only map its own state institute and candidates.
                    </li>
                    <li>
                        Please do not map more than the maximum capacity.
                    </li>
                </ul>
            </div>

        <div class="col-sm-12">
            <h4>Map Exam Center</h4>
            @include('common.errorandmsg')

            <form id="examForm" action="{{ url('nber/exam/examcenter/') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="institute">
                <input type="hidden" name="exam_id" value="{{ Session::get('exam_id') }}">
                <input type="hidden" name="nber_id" value="{{ $nber_id }}">

                <button class="btn mb-2 btn-primary btn-xs pull-right" 
                        style="position: absolute;right:15px;top:10px;">Save</button> 
                <a href="{{ url('nber/exam/examcenter/') }}" 
                   style="position: absolute;right:55px;top:10px;"
                   class="btn btn-success btn-xs mb-2 pull-right">Back</a>

                <table class="table table-bordered table-condensed">
                    <tr>
                        <th>Institute</th>
                        <td>
                            <select name="institute_id" id="institute_id" class="edit-field selectpicker form-control" 
                                    required data-live-search="true">
                                <option value="">--Please Select--</option>
                                @foreach($maxstudents as $max)
                                    <option value="{{ $max->institute_id }}">
                                        Maximum Candidate: {{ $max->max_candidate_count }}, {{ $max->rci_code }} - {{ $max->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="instituteError"></span>
                        </td>
                    </tr> 
                    <tr>
                        <th>Exam Center</th>
                        <td>
                            <select name="externalexamcenter_id" id="externalexamcenter_id" class="edit-field selectpicker form-control" 
                                    required data-live-search="true">
                                <option value="">--Please Select--</option>
                                @foreach($externalexamcenters as $ec)
                                    <option value="{{ $ec->id }}">
                                        {{ $ec->code }} - {{ $ec->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="centerError"></span>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>


<script>
    // Initialize Bootstrap selectpicker
    $('.selectpicker').selectpicker();

    document.getElementById('examForm').addEventListener('submit', function(e) {
        let valid = true;

        // Clear previous errors
        document.getElementById('instituteError').innerText = '';
        document.getElementById('centerError').innerText = '';
        document.getElementById('institute_id').style.borderColor = '#ccc';
        document.getElementById('externalexamcenter_id').style.borderColor = '#ccc';

        // Validate institute
        const institute = document.getElementById('institute_id').value;
        if (!institute) {
            document.getElementById('instituteError').innerText = 'Please select an institute.';
            document.getElementById('institute_id').style.borderColor = 'red';
            valid = false;
        }

        // Validate exam center
        const center = document.getElementById('externalexamcenter_id').value;
        if (!center) {
            document.getElementById('centerError').innerText = 'Please select an exam center.';
            document.getElementById('externalexamcenter_id').style.borderColor = 'red';
            valid = false;
        }

        if (!valid) {
            e.preventDefault(); // Stop form submission
        }
    });
</script>
@endsection