@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
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
                                                <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/practicalexaminers/'.$exam->id) }}">Practical Examiners</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/practicalexaminers/examinerdetails/'.$exam->id.'/'.$practicalexam->id) }}">{{ $practicalexam->common_code }}</a>
                                            </li>
                                            <li class="active">Internal Examiner Details</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <form method="post" action="{{ url('/institute/examinations/practicalexaminers/updateinternalexaminer/') }}" onsubmit="return validateForm()">
                                {!! csrf_field() !!}
                                <input type="hidden" name="practicalexam_id" value="{{ $practicalexam->id }}">
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
                                                            <th width="10%">Title</th>
                                                            <th width="90%">
                                                                <select id="title_id" name="title_id" required>
                                                                    @foreach($titles as $title)
                                                                        <option value="{{ $title->id }}">{{ $title->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Name</th>
                                                            <th width="90%">
                                                                <input id="name" name="name" type="text" size="100" placeholder="Enter Name" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Age</th>
                                                            <th width="90%">
                                                                <input id="age" name="age" type="number" size="3" placeholder="" required /> years
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Gender</th>
                                                            <th width="90%">
                                                                <select id="gender_id" name="gender_id" required>
                                                                    @foreach($genders as $gender)
                                                                        <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Academic Qualifications</th>
                                                            <th width="90%">
                                                                <input id="qualification" name="qualification" type="text" size="100" placeholder="Enter Qualifications" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">CRR No.</th>
                                                            <th width="90%">
                                                                <input id="crrnumber" name="crrnumber" type="text" size="15" placeholder="Enter CRR No." required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Teaching Experiences</th>
                                                            <th width="90%">
                                                                <input id="experience" name="experience" type="text" size="3" placeholder="" required /> years
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Residential Address</th>
                                                            <th width="90%">
                                                                <input id="address" name="address" type="text" size="100" placeholder="Enter Address" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">State</th>
                                                            <th width="90%">
                                                                <select name="state_id" id="state_id">
                                                                    <option value="0">-- Select State --</option>
                                                                    @foreach($states as $state)
                                                                        <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">City</th>
                                                            <th width="90%">
                                                                <select name="city_id" id="city_id">
                                                                    <option value="0">-- Select District --</option>
                                                                </select>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Pincode</th>
                                                            <th width="90%">
                                                                <input id="pincode" name="pincode" type="number" size="20" placeholder="Enter Pincode" required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Mobile No.</th>
                                                            <th width="90%">
                                                                <input id="contactnumber" name="contactnumber" type="number" size="20" placeholder="Enter Mobile No." required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Whatsapp No</th>
                                                            <th width="90%">
                                                                <input id="whatsappnumber" name="whatsappnumber" type="number" size="30" placeholder="Enter Whatsapp No." required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th width="10%">Email Id.1#</th>
                                                            <th width="90%">
                                                                <input id="email" name="email" type="text" size="50" placeholder="Enter Email Id." required />
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <button id="submitbutton" type="submit" class="btn btn-primary">
                                                                     <span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp; Save Details
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
