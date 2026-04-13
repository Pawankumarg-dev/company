@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Practical Exam Subject Mapping</h2>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <?php
$finalArray = [];
            if (!empty($mapped) || count($mapped) != 0){
foreach ($mapped as $item) {
    $ids = explode(',', $item->subject_id); // ✅ access property
    $finalArray = array_merge($finalArray, $ids);
}

$finalArray = array_unique($finalArray);
$finalArray = array_values($finalArray);
            }
            ?>

    <form id="practical-map-form">
        {{ csrf_field() }}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>RCI Code</th>
                    <th>Institute Name</th>
                    <th>Programmes</th>
                    <th>1st Year Subjects</th>
                    <th>2nd Year Subjects</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($institutes as $institute)
                <tr>
                    <input type="hidden" value="{{ $institute->institute_id }}" name="institute_id[]">
                    <td>{{ $institute->rci_code }}</td>
                    <td>{{ $institute->name }}</td>
                    <td>
                        @foreach (explode(',', $institute->programmes) as $programme)
                        @php
                        $parts = explode(':', $programme);
                        $progName = $parts[1] ?? $parts[0];
                        @endphp
                        {{ $progName }}<br>
                        <small>Candidate: {{$institute->total_candidates}}</small>
                        @endforeach
                    </td>
                    <td>
                        <!-- 1st Year Check All -->
                        <label>
                            <input type="checkbox" class="check-all-year1" data-institute="{{ $institute->institute_id }}">
                            Check All
                        </label>
                        <br>
                        @foreach(explode(',', $institute->year_1_subjects) as $subject)
                            @php
                                $parts = explode(':', $subject);
                                $subId = $parts[0] ?? null;
                                $subName = $parts[1] ?? $parts[0];
                            @endphp
                            @if($subId)
                            <label>
                                
                                @if(in_array($subId, $finalArray))
                                    <span class="badge bg-success">Assigned</span>

                                    @else
<input type="checkbox" checked
                                       class="year1-{{ $institute->institute_id }}"
                                       name="subjects_year1[{{ $institute->institute_id }}][]"
                                       value="{{ $subId }}"
                                       onchange="confirmUncheck(this)">

                                @endif
                                                                {{ $subName }}

                            </label><br>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <!-- 2nd Year Check All -->
                        <label>
                            <input type="checkbox" class="check-all-year2" data-institute="{{ $institute->institute_id }}">
                            Check All
                        </label>
                        <br>
                        @foreach(explode(',', $institute->year_2_subjects) as $subject)
                            @php
                                $parts = explode(':', $subject);
                                $subId = $parts[0] ?? null;
                                $subName = $parts[1] ?? $parts[0];
                            @endphp
                            @if($subId)
                            <label>
                                
                                @if(in_array($subId, $finalArray))
                                    <span class="badge bg-success">Assigned</span>
                                    @else
<input type="checkbox" checked
                                       class="year2-{{ $institute->institute_id }}"
                                       name="subjects_year2[{{ $institute->institute_id }}][]"
                                       value="{{ $subId }}">
                                @endif
                                                                {{ $subName }}

                            </label><br>
                            @endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-group">
            <label for="faculty_id">Faculty / Examiner</label>
            <select class="form-control selectpicker" name="faculty_id" id="faculty_id" data-header="Select a faculty"
                data-live-search="true" required>
                <option value="">Please select Faculty</option>
                @foreach ($faculties as $f)
                <option value="{{ $f->id }}" data-content="
                        <b>{{ $f->name }}</b>
                        <div class='small'>CRR No: {{ $f->crr_no }}, Qualification: {{ $f->qualification }}</div>
                        <div class='small'>TTI Code: {{ $f->rci_code }}- {{ $f->inst_name }}</div>
                        <div class='small'>Address: {{ $f->address }}</div>
                        <div class='small'>Email: {{ $f->email }}, Mobile: {{ $f->mobileno }}</div>
                        <div class='small'>Languages: {{ $f->languagenonhtml }}</div>
                    ">
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">From Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required min="{{ $min_date }}"
                max="{{ $max_date }}">
            <label for="end_date">To Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required min="{{ $min_date }}"
                max="{{ $max_date }}">
        </div>

        <button type="submit" class="btn btn-primary">Save Mapping</button>
    </form>
    <div>
        <h4 class="center">Mapping Done</h4>

        @if (empty($mapped) || count($mapped) == 0)
        <p>No records found.</p>
        @else
        <!-- Subjects -->
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>Examiner</th>
                    <th>Exam Date</th>

                    <th>Subject Code</th>

                    <th>Subject Name</th>
                    <th>Send Mail</th>
                    <th>Remove</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($mapped as $faculty)
                <tr>
                    <td><b>Name:</b> {{ $faculty->name }} <br>

                        <b>Mobile:</b> {{ $faculty->mobileno }} <br>
                        <b>Email:</b> {{ $faculty->email }} <br>
                        <b>CRR No:</b> {{ $faculty->crr_no }}
                    </td>
                    <td>{{ $faculty->start_date }} to {{ $faculty->end_date }}</td>
                    <td>
                        <ul style="padding-left: 15px; margin: 0;">
                            @php
                            $codes = explode(',', $faculty->scode);
                            @endphp
                            @foreach ($codes as $code)
                            <li>{{ trim($code) }}</li>
                            @endforeach
                        </ul>
                    </td>

                    <td>
                        <ul style="padding-left: 15px; margin: 0;">
                            @php
                            $names = explode(',', $faculty->sname);
                            @endphp
                            @foreach ($names as $name)
                            <li>{{ trim($name) }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                    <button onclick="sendmail({{ $faculty->faculty_id }})">Send Password Mail</button>
                        
                    </td>
                    <td>
                    <button onclick="removeItem({{ $faculty->del_id }})">Delete</button>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>

<link rel="stylesheet" href="{{ url('css/bootstrap-select.min.css') }}">
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script>
   function removeItem(itemId) {
    // Ask user for a reason
    let reason = prompt("Please enter a reason for remove:");

    // If user cancels or leaves it blank
    if (reason === null || reason.trim() === "") {
        alert("You must provide a reason.");
        return;
    }

    // Send Ajax request
    $.ajax({
        url: "{{ url('/') }}/nber/savepracticalmap-remove", 
        type: 'POST',
        data: {
            id: itemId,
            reason: reason,
            _token: "{{ csrf_token() }}" 
        },
        success: function(response) {
            console.log("Server Response:", response);
           alert('removed');
                               location.reload();

        },
        error: function(xhr) {
            alert(xhr.responseJSON.message);
        }
    });
}

// Example usage:
// <button onclick="removeItem(5)">Delete</button>
</script>

<script>
   function sendmail(itemId) {
       $.ajax({
        url: "{{ url('/') }}/nber/practicalexammapping-mail", 
        type: 'POST',
        data: {
            id: itemId,
            _token: "{{ csrf_token() }}" 
        },
        success: function(response) {
            console.log();
           alert(response.message);
            location.reload();

        },
        error: function(xhr) {
            alert(xhr.responseJSON.message);
        }
    });
}

// Example usage:
// <button onclick="removeItem(5)">Delete</button>
</script>



<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
        // Check All functionality
        $('.check-all-year1').on('change', function() {
            var instituteId = $(this).data('institute');
            $('.year1-' + instituteId).prop('checked', $(this).prop('checked'));
        });
        $('.check-all-year2').on('change', function() {
            var instituteId = $(this).data('institute');
            $('.year2-' + instituteId).prop('checked', $(this).prop('checked'));
        });

        // AJAX form submission
        $('#practical-map-form').on('submit', function(e) {

            e.preventDefault();
            var formData = {
                _token: $('input[name="_token"]').val(),
                faculty_id: $('#faculty_id').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                subjects_year1: {},
                subjects_year2: {}
            };
            // Gather 1st-year subjects
            $('input[class^="year1-"]:checked').each(function() {
                var instituteId = $(this).attr('class').match(/year1-(\d+)/)[1];
                if (!formData.subjects_year1[instituteId]) formData.subjects_year1[
                    instituteId] = [];
                formData.subjects_year1[instituteId].push($(this).val());
            });
            // Gather 2nd-year subjects
            $('input[class^="year2-"]:checked').each(function() {
                var instituteId = $(this).attr('class').match(/year2-(\d+)/)[1];
                if (!formData.subjects_year2[instituteId]) formData.subjects_year2[
                    instituteId] = [];
                formData.subjects_year2[instituteId].push($(this).val());
            });
            // AJAX POST
            $.ajax({
                url: "{{ url('/') }}/nber/savepracticalmap",
                type: "POST",
                data: JSON.stringify(formData),
                contentType: "application/json",
                success: function(response) {
                    console.log(response);
                    alert(response.message || "Mapping saved successfully!");
                    location.reload();
                },
                error: function(xhr) {
                    alert("Error saving mapping: " + xhr.responseText);
                }
            });
        });
    });

    
</script>

<script>
function confirmUncheck(checkbox) {
    if (!checkbox.checked) {
        const confirmed = confirm("Are you sure you want to remove the subject?");
        if (!confirmed) {
            checkbox.checked = true; // re-check if user cancels
        }
    }
}
</script>

<style>
    .expand,
    .expand-term {
        cursor: pointer;
    }

    .small {
        color: blue;
    }

    .plus,
    .minus {
        display: inline-block;
        width: 16px;
        height: 16px;
        background-repeat: no-repeat;
        background-size: 16px 16px !important;
    }

    ul {
        list-style: none;
        padding: 0 0 0 20px;
    }

    ul.inner_ul li:before {
        content: "├";
        font-size: 18px;
        margin-left: -11px;
        margin-top: -5px;
        vertical-align: middle;
        float: left;
        width: 8px;
        color: #41424e;
    }

    ul.inner_ul li:last-child:before {
        content: "└";
    }

    .inner_ul {
        padding: 0 0 0 35px;
    }
</style>
@endsection