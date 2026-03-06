@extends('layouts.app')
@section('content')
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                {{ $exam->name }} Examinations
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/nber/exams') }}">Exams</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/nber/practicalexams/'.$exam->id) }}">Practical Exams</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/nber/practicalexams/examiners/'.$exam->id) }}">Practical Examiners</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('nber/practicalexams/examiners/showdetails/'.$exam->id.'/'.$practicalexam->id) }}">{{ $practicalexam->common_code }}</a>
                                            </li>
                                            <li class="active">Update Examiners Details</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <form method="post" action="{{ url('/nber/practicalexams/examiners/updatepracticalexaminer') }}" onsubmit="return validateForm()">
                                {!! csrf_field() !!}
                                <input type="hidden" name="practicalexam_id" value="{{ $practicalexam->id }}">
                                <input type="hidden" name="practicalexaminer_id" value="{{ $practicalexaminer->id }}">
                                <input type="hidden" name="exam_id" value="{{ $exam->id }}">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body bg-default">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" role="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="center-text medium-text bg-primary" colspan="2">Add Practical Examiners</th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Examiner Type</th>
                                                            <th width="90%">
                                                                <label class="radio-inline">
                                                                    <input type="radio" id="practicalexaminertype_id1" name="practicalexaminertype_id" value="1" @if($practicalexaminer->practicalexaminertype_id == 1) checked @endif>Internal
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" id="practicalexaminertype_id2" name="practicalexaminertype_id" value="2" @if($practicalexaminer->practicalexaminertype_id == 2) checked @endif>External
                                                                </label>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Title</th>
                                                            <th width="90%">
                                                                <select id="title_id" name="title_id" required>
                                                                    @foreach($titles as $title)
                                                                        <option value="{{ $title->id }}" @if($practicalexaminer->title_id == $title->id) selected @endif>{{ $title->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Name</th>
                                                            <th width="90%">
                                                                <input id="name" name="name" type="text" size="100" placeholder="Enter Name" value="{{ $practicalexaminer->name }}" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Age</th>
                                                            <th width="90%">
                                                                <input id="age" name="age" type="text" size="3" placeholder="" value="{{ $practicalexaminer->age }}" required /> years
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Gender</th>
                                                            <th width="90%">
                                                                <select id="gender_id" name="gender_id" required>
                                                                    @foreach($genders as $gender)
                                                                        <option value="{{ $gender->id }}" @if($practicalexaminer->gender_id == $gender->id) selected @endif>{{ $gender->gender }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Academic Qualifications</th>
                                                            <th width="90%">
                                                                <input id="qualification" name="qualification" type="text" size="100" placeholder="Enter Qualifications" value="{{ $practicalexaminer->qualification }}" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">CRR No.</th>
                                                            <th width="90%">
                                                                <input id="crrnumber" name="crrnumber" type="text" size="15" placeholder="Enter CRR No." value="{{ $practicalexaminer->crrnumber }}" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Teaching Experiences</th>
                                                            <th width="90%">
                                                                <input id="experience" name="experience" type="text" size="3" placeholder="" value="{{ $practicalexaminer->experience }}" required /> years
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Residential Address</th>
                                                            <th width="90%">
                                                                <input id="address" name="address" type="text" size="100" placeholder="Enter Address" value="{{ $practicalexaminer->address }}" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">State</th>
                                                            <th width="90%">
                                                                <select name="state_id" id="state_id">
                                                                    <option value="0">-- Select State --</option>
                                                                    @foreach($states as $state)
                                                                        <option value="{{ $state->id }}" @if($practicalexaminer->city->state_id == $state->id) selected @endif>{{ $state->state_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">City</th>
                                                            <th width="90%">
                                                                <select name="city_id" id="city_id">
                                                                    <option value="0">-- Select District --</option>
                                                                    @foreach($cities as $city)
                                                                        <option value="{{ $city->id }}" @if($practicalexaminer->city_id == $city->id) selected @endif>{{ $city->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Pincode</th>
                                                            <th width="90%">
                                                                <input id="pincode" name="pincode" type="number" size="20" placeholder="Enter Pincode" value="{{ $practicalexaminer->pincode }}" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Mobile No.</th>
                                                            <th width="90%">
                                                                <input id="contactnumber" name="contactnumber" type="number" size="20" placeholder="Enter Mobile No." value="{{ $practicalexaminer->contactnumber }}" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Whatsapp No</th>
                                                            <th width="90%">
                                                                <input id="whatsappnumber" name="whatsappnumber" type="number" size="30" placeholder="Enter Whatsapp No." value="{{ $practicalexaminer->whatsappnumber }}" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Email Id</th>
                                                            <th width="90%">
                                                                <input id="email" name="email" type="text" size="50" placeholder="Enter Email Id." value="{{ $practicalexaminer->email }}" required />
                                                            </th>
                                                        </tr>
                                                        @if($practicalexaminer->practicalexaminertype_id == 1)
                                                            <input type="hidden" name="select_status" value="{{ $practicalexaminer->select_status }}">
                                                        @else
                                                            <tr>
                                                                <th width="10%">Select Remark</th>
                                                                <th width="90%">
                                                                    <label class="radio-inline">
                                                                        <input type="radio" name="select_status" value="0" @if($practicalexaminer->select_status == 0) checked @endif>Not Selected
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input type="radio" name="select_status" value="1" @if($practicalexaminer->select_status == 1) checked @endif>Selected
                                                                    </label>
                                                                </th>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td colspan="2">
                                                                <button id="submitbutton" type="submit" class="btn btn-primary">
                                                                    <span class="glyphicon glyphicon-pencil"></span>&nbsp; Update Details
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function () {
            $('#state_id').on('change',function(){
                var stateID = $(this).val();
                if(stateID){
                    $.ajax({
                        type:"GET",
                        url:"{{url('get-city-list')}}?state_id="+stateID,
                        success:function(res){
                            if(res){
                                $("#city_id").empty();
                                $("#city_id").append('<option value="0">-- Select District --</option>');

                                $.each(res, function () {
                                    $("#city_id").append('<option value="'+this.id+'">'+this.name+'</option>');
                                })

                            }else{
                                $("#city_id").empty();
                            }
                        }
                    });
                }
                else{
                    $("#city_id").empty();
                }
            });
        });

        function validateForm() {
            if ($('#state_id').val() == '0') {
                swal("Error Occurred!!!", "Please select the State from the option", "error");
                alert('Please select the State from the option');

                return false;
            }

            if ($('#city_id').val() == '0') {
                swal("Error Occurred!!!", "Please select the District from the option", "error");

                return false;
            }
        }
    </script>
@endsection

