@extends('layouts.app')

@section('content')



<div class="container">
    <h2>Candidate List of  {{$programme->abbreviation}}</h2>

<div style="padding-bottom: 30px">
    <form method="post" action="{{ url('/') }}/eparivesh/{{ base64_encode($approve_program->id) }}/{{ base64_encode($approve_program->programme_id) }}" class="row g-3 mb-4">
            {!! csrf_field() !!}

        <input type="hidden" name="programme_id" value="{{ $approve_program->programme_id }}">
        <input type="hidden" name="institute_id" value="{{ $approve_program->institute_id }}">

        {{-- <div class="col-md-3">
            <label for="category" class="form-label">Category:</label>
            <select id="category" name="category" class="form-control">
                <option value="" {{ request('category') == '' ? 'selected' : '' }}>GENERAL</option>
                <option value="OBC" {{ request('category') == 'OBC' ? 'selected' : '' }}>OBC</option>
                <option value="SCHEDULED CASTE (SC)" {{ request('category') == 'SCHEDULED CASTE (SC)' ? 'selected' : '' }}>SCHEDULED CASTE (SC)</option>
                <option value="SCHEDULED TRIBE (ST)" {{ request('category') == 'SCHEDULED TRIBE (ST)' ? 'selected' : '' }}>SCHEDULED TRIBE (ST)</option>
                <option value="PWD" {{ request('category') == 'PWD' ? 'selected' : '' }}>PWD</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="gender" class="form-label">Gender:</label>
            <select id="gender" name="gender" class="form-control">
                <option value="" {{ request('gender') == '' ? 'selected' : '' }}>--Select--</option>
                <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>FEMALE</option>
                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>MALE</option>
                <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>TRANSGENDER</option>
            </select>
        </div> --}}

        <div class="col-md-3">
            <label for="registration_no" class="form-label">Registration No <small>(Search by Registration No)</small></label>

            <input type="text" id="registration_no" name="registration_no" maxlength="30" value="{{ old('registration_no') }}" class="form-control" placeholder="Enter Registration No">
        </div>

        <div class="col-md-3 d-flex align-items-end">
<label for="category" class="form-label" style=" padding-top: 40px"></label>
            <button type="submit" class="btn btn-primary me-2">Apply Filter</button>
            {{-- <button type="button" onclick="printMeritList()" class="btn btn-success">🖨️ Print Merit List</button> --}}
        </div>
    </form>

    {{-- <h4><strong>Note:</strong> .</h4> --}}
</div>




    <table class="table table-bordered table-condensed" id="printableArea">
        <thead>
            <tr>
                <th>ID</th>
                <th>Registration No</th>
                <th>Student Personal Details</th>

                {{-- <th>Student Name</th>
                <th>Father Name</th> --}}
                {{-- <th>Mother Name</th> --}}
                {{-- <th>Date of Birth</th> --}}
                {{-- <th>Gender</th>
                <th>Category</th> --}}
                <th>Acadmics</th>
                @if($display==1)

                <th class='print_hide'>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
            if ($programme->programmegroup_id == 2) {
            $filter_data = '10 STANDARD OR EQUIVALENT';
            } else {
            $filter_data = '10+2 OR EQUIVALENT';
            }



            
           $sortedStudents = $students->sortByDesc(function($student) use ($filter_data) {
    $tenthRecords = collect($student->epariveshacadmic)
        ->filter(function($record) use ($filter_data) {
            return $record['qulification_name'] == $filter_data;
        });
    return $tenthRecords->max('percentage') ?? 0;
});
            $i=1;
            @endphp

            @forelse($sortedStudents as $student)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $student->RegistrationNo }}</td>

                <td>
                    <ul class="list-unstyled mb-0">
                        <li><strong>Name:</strong> {{ $student->FirstName }} {{ $student->LastName }}</li>
                        <li><strong>Father's Name:</strong> {{ $student->FatherName }}</li>
                        <li><strong>Gender:</strong>

                            @if($student->gendername==1)
                            Male
                            @elseif($student->gendername==2)
                            Female
                            @elseif($student->gendername==3)
                            Transgender
                            @endif

                        </li>
                        @if(!empty($student->mobile))
                        <li><strong>Mobile No.:</strong> {{ $student->mobile }}</li>
                        @endif
                        @if(!empty($student->email))
                        <li><strong>Email.:</strong> {{ $student->email }}</li>
                        @endif

                        <li><strong>Category:</strong> {{ $student->categoryname }}</li>
                        <li><strong>State:</strong> {{ $student->PermanentAddressstate }}</li>
                        <li><strong>District:</strong> {{ $student->PermanentAddressdistrict }}</li>
                        <li><strong>Address:</strong> {{ $student->CorrespondanceAddress }}</li>

                        @if($student->IsPWD=='1')
                        <li><strong>UDID:</strong> {{ $student->PWDUDIDNo }}</li>
                        <li><strong>Disablity Type:</strong> {{ $student->PwDCategoryName }}</li>
                        <li><strong>Disablity Percentage:</strong> {{ $student->PWDPercentage }}</li>

                        @endif

                    </ul>

                </td>

                {{--
                    <td>{{ $student->FirstName }} {{ $student->LastName }}</td>
                <td>{{ $student->FatherName }}</td>
                <td>{{ $student->gendername }}</td> --}}
                {{-- <td>{{ $student->categoryname }}</td> --}}

                <td>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Qualification</th>
                                {{-- <th>Passing Year</th> --}}
                                {{-- <th>Subjects</th> --}}
                                {{-- <th>Max Marks</th>
            <th>Obtained Marks</th> --}}
                                <th>Board</th>

                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->epariveshacadmic as $record)
                            @if($programme->programmegroup_id==2 && $record['qulification_name']=='10 STANDARD OR EQUIVALENT')
                            <tr>
                                <td>{{ $record['qulification_name'] }}</td>
                                {{-- <td>{{ $record['passing_year'] }}
                </td> --}}
                {{-- <td>{{ $record['subjects'] }}</td> --}}
                {{-- <td>{{ $record['max_marks'] }}</td>
                <td>{{ $record['obtained_marks'] }}</td> --}}
                <td>{{ $record['board_name'] }}</td>

                <td>{{ $record['percentage'] }}%</td>
            </tr>
            @endif

            @if($programme->programmegroup_id!=2 && $record['qulification_name']=='10+2 OR EQUIVALENT')

            <tr>
                <td>{{ $record['qulification_name'] }}</td>
                {{-- <td>{{ $record['passing_year'] }}</td> --}}
                {{-- <td>{{ $record['subjects'] }}</td> --}}
                {{-- <td>{{ $record['max_marks'] }}</td>
                <td>{{ $record['obtained_marks'] }}</td> --}}
                <td>{{ $record['board_name'] }}</td>

                <td>{{ $record['percentage'] }}%</td>
            </tr>

            @endif

            @endforeach
        </tbody>
    </table>

    </td>
           
@if($display==1)
    <td class='print_hide'>

        @if($student->status == 'verified' and $student->status != 'canceled')
 <?php $admitted=\App\Candidate::where('epariveshreg',$student->RegistrationNo)->pluck('epariveshreg');?>

        

        @if(empty($admitted[0]))
        Complete admission form
        <a href="{{url('/')}}/eparivesh/addcandidate/{{ $student->id }}/{{$approve_program->id}}">Click Here</a>
                @else
Admission done

        @endif

        @else

        @if($student->status == 'canceled')
        <div class="mt-2 text-danger">
            <strong>Cancelled:</strong> {{ $student->cancellation_reason }}
        </div>
        @else



        <!-- comment it if u want addmission on fir 1st merit list -->
@if($display==1)

        <button class="btn btn-success btn-sm verify-btn" data-id="{{ $student->id }}">Proceed for Admission</button>

        <button class="btn btn-danger btn-sm cancel-btn mt-2" data-id="{{ $student->id }}">Cancel</button> 
@endif
         <!-- ENd comment it if u want addmission on fir 1st merit list -->

        
        @endif
        @endif

    </td>
@endif
    </tr>
    @empty
    <tr>
        <td colspan="13">No students found.</td>
    </tr>
    @endforelse
    </tbody>
    </table>
        {{ $students->links() }}

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // CSRF Token for Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        // Handle Verify
        $('.verify-btn').click(function() {
            var studentId = $(this).data('id');
            let text = "Please confirm.";
            if (confirm(text) == true) {
                $.ajax({
                    url: '/verify-student/' + studentId,
                    method: 'POST',
                    success: function(response) {
                        alert('Admission Confirmed!');
                        location.reload();
                        // Optional: reload or change button state
                    },
                    error: function(xhr) {
                        alert('Verification failed.');
                        location.reload();
                    }
                });
            }
        });
        // Handle Cancel
        $('.cancel-btn').click(function() {
                        alert('Councelling is closed');

            var studentId = $(this).data('id');
            var reason = prompt("Please enter the reason for cancellation:");
            if (reason === null || reason.trim() === "") {
                alert("Cancellation aborted. Reason is required.");
                return; // stop if no reason entered
            }
            $.ajax({
                url: '/cancel-student/' + studentId,
                method: 'POST',
                data: {
                    reason: reason
                },
                success: function(response) {
                    alert('Student canceled successfully!');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Cancellation failed.');
                    location.reload();
                }
            });
        });
    });
</script>
<script>
    function printMeritList() {
        // Hide elements you don't want in print
        document.querySelectorAll('.print_hide').forEach(el => {
            el.style.display = 'none';
        });

        window.print();

        // Restore them after print
        setTimeout(() => {
            document.querySelectorAll('.print_hide').forEach(el => {
                el.style.display = '';
            });
        }, 1000); // Adjust delay as needed
    }
</script>
<style>
    
@media print {
   
    .print_hide {
        display: none !important;
    }
    @page {
        size: A4 landscape;
        margin: 15mm;

  
    }

  
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        font-size: 11px;
        line-height: 1.4;
    }

    /* Hide all UI elements not needed in print */
    .btn, .verify-btn, .cancel-btn, form, nav, header, footer {
        display: none !important;
    }

    /* Ensure the merit list table takes full width */
    #printableArea {
        width: 100%;
    }

    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 6px !important;
        text-align: left;
        vertical-align: top;
    }

    /* Optional: Avoid page break inside student record */
    tr {
        page-break-inside: avoid !important;
    }

    /* Optional: Force page break after certain number of rows */
    /* tr:nth-child(20n) {
        page-break-after: always;
    } */
}
</style>





@endsection