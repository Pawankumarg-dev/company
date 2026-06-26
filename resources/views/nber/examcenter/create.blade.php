@extends('layouts.app')

@section('content')
<style>
    .mb-2 { margin-bottom: 10px; }
    .edit-field { width: 500px; border: 1px solid #ccc; padding: 5px; }
</style>
  


<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h4>Add Exam Center</h4>
            @include('common.errorandmsg')

            <div class="alert alert-success">
                <ul>
                    <li>
                       Add Exam center as per scheme of examination 2026.
                    </li>
                </ul>
            </div>



            <form action="{{ url('nber/excenter/') }}" method="POST">
					{{ csrf_field() }}

                <button class="btn mb-2 btn-primary btn-xs pull-right" style="position:absolute;right:15px;top:10px;">
                    Save
                </button>
                <a href="{{ url('nber/excenter/') }}" style="position:absolute;right:55px;top:10px;"
                   class="btn btn-success btn-xs mb-2 pull-right">
                    Back
                </a>

                <table class="table table-bordered table-condensed">
				    <input type="hidden" name="exam_id" value='29'>                        
					<input type="hidden" name="institute_id" value='{{ Auth::user()->id }}'>                        

                    <tr>
                        <th>RCI Code/Unique Exam Center Code</th>
                        <td>
							<input type="text" name="code" id="inst_code" class="edit-field" required>                        
						</td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td><input type="text" name="name" class="edit-field" required></td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td><input type="text" name="address" class="edit-field" required></td>
                    </tr>

                    <tr>
                        <th>State</th>
                        <td>
                            <select name="lgstate_id" id="lgstate_id" class="edit-field" required>
                                <option value="">--Please Select--</option>
                                @foreach($lgstates as $state)
                                    <option data-id="{{ $state->state_name }}" data-id2="{{ $state->state_code }}" value="{{ $state->id }}">
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
    <th>District</th>
    <td>
        <select name="district" id="district" class="edit-field" required>
            <option value="">--Please Select--</option>
            @foreach($districts as $district)
                <option class="{{ $district->state_code }} districts" data-id="{{ $district->districtName }}" value="{{ $district->id }}">
                    {{ $district->districtName }}
                </option>
            @endforeach
        </select>
    </td>
</tr>

                    <tr>
                        <th>PIN Code</th>
                        <td><input type="text" name="pincode" class="edit-field" maxlength="6" required></td>
                    </tr>

                    <tr>
                        <th>Contact Number #1</th>
                        <td><input type="text" name="contactnumber1" class="edit-field" maxlength="10" required></td>
                    </tr>

                    <tr>
                        <th>Contact Number #2</th>
                        <td><input type="text" name="contactnumber2" class="edit-field" maxlength="10" required></td>
                    </tr>

                    <tr>
                        <th>Email #1</th>
                        <td><input type="email" name="email1" class="edit-field" required></td>
                    </tr>

                    <tr>
                        <th>Email #2</th>
                        <td><input type="email" name="email2" class="edit-field" required></td>
                    </tr>

                    <tr>
                        <th>Contact Person</th>
                        <td><input type="text" name="contactperson" class="edit-field" required></td>
                    </tr>

                    <tr>
                        <th>Maximum Seating Capacity</th>
                        <td><input type="number" name="setting_capacity" class="edit-field" required></td>
                    </tr>

                    <tr>
                        <th>Seat Per Room</th>
                        <td><input type="number" name="seats_per_room" class="edit-field" required></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    function showhidedistricts() {
        var className = $('#lgstate_id').find(':selected').data('id2');
        $('.districts').addClass('hidden');
        $('.' + className).removeClass('hidden');
    }

    showhidedistricts();
    $('#lgstate_id').on('change', showhidedistricts);


});


</script>
<script>
$(document).ready(function() {

    $('#inst_code').on('blur', function() {
        var code = $(this).val();

        if (code != '') {
            $.ajax({
                url: "{{ url('/fetch-rci') }}",
                type: "POST",
                data: { 
                    inst_code: code, 
                    _token: "{{ csrf_token() }}" 
                },
                success: function(response) {
                    console.log(response);

                    var data = JSON.parse(response);

                    // Make sure data exists
                    if (data.length > 0 && data[0].Inst_Excell!='NCOE') {

						                    if (data[0].Inst_Excell!='NCOE') {

                            $('input[name="name"]').val(data[0].inst_name);
                            $('input[name="address"]').val(data[0].inst_address);
                            $('input[name="pincode"]').val(data[0].inst_pincode);
                            $('input[name="contactnumber1"]').val(data[0].inst_mobile);
                            $('input[name="contactnumber2"]').val(data[0].inst_tel_no);
                            $('input[name="email1"]').val(data[0].emailid1);
                            $('input[name="email2"]').val(data[0].emailid2);
                            // Set state
                            var stateOption = $('#lgstate_id option').filter(function() {
                                return $(this).data('id') == data[0].inst_state;
                            }).val();

                            $('#lgstate_id').val(stateOption).trigger('change'); // triggers showhidedistricts

                            // Set district
                            var districtOption = $('#district option').filter(function() {
                                return $(this).data('id') == data[0].inst_dist;
                            }).val();

                            $('#district').val(districtOption).trigger('change');

                            // Call function to update districts if needed
                            if (typeof showhidedistricts === "function") {
                                showhidedistricts();
                            }

                        } else {
                        alert('Institute/ Org is not under COE');
                    }

                    } else {
                        alert('No data found for this institute code');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Failed to fetch institute details');
                }
            });
        }
    });

});
</script>

@endsection