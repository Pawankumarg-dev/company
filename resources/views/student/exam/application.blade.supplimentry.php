@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>    @if($exception == 1) Provisional @endif Exam  Application -  
                    {{ $exam->examtype->name }}, 
                    {{$exam->name}}</h4>
                @include('common.errorandmsg')
                <?php $slno = 1; ?>
                
                @if(!is_null($subjects) && $subjects->count()> 0)
                    @if(is_null($applicant))
                        <div class="alert alert-warning">
                            Please unselect the subjects you are not appearing  and choose the preferred language for Question Paper.
                            
                        </div>
                    @endif
                    @If($reason != '')
                        <div class="alert alert-danger">
                            {{ $reason }}
                        </div>
                    @endif
                    @if($exception == 1)
                        <div class="alert alert-danger">
                            With respect to, applications received for the students appeared in the examination, who has attempted N+2 as per scheme of examination and have requested for one more chance as special case, as per scheme of examination. 
                            <br />The following is the procedure to be followed. <br />
                            <ol>
                                <li>
                                    Apply online for the supplementary examination for the respective subject. 
                                </li>
                                <li>
                                    Submit evidence document for not appearing the examination, for the consideration as per scheme of examination.
                                </li>
                                <li>
                                    Respective NBER to verify the application and the documents.
                                </li>
                                <li>
                                    After verification by NBERs, candidate to pay fee for examination.
                                </li>
                                <li>
                                    Only those candidates who is application has been verified by the NBER and payment received online will be considered for the Supplementary Examination, January 2025. 
                                </li>
                            </ol>
                        </div>
                        @endif
                    <form action="{{ url('student/exam/applications') }}" method="POST"  enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <?php $notapplied = 0; ?>
                        <ol class="list-group list-group-numbered">
                            <input type="hidden" id="noofsubjects" value="{{ $subjects->count() }}">
                            @foreach($subjects as $s)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <span class="badge bg-primary rounded-pill pull-left " style="margin-right:5px;">  {{ $slno }} <?php $slno++; ?></span>
                                    <small><span class="badge bg-transparent rounded-pill pull-left text-small" style="margin-right:5px;"> Term: {{ $s->term }} </span></small> 
                                    <small><span class="badge bg-transparent rounded-pill pull-left text-small" style="margin-right:5px;"> {{ $s->type }} </span></small> 
                                    @if($s->application_status == 1)
                                        <small><span class="badge bg-primary rounded-pill pull-left text-small" style="margin-right:5px;"> Applied </span></small> 
                                    @else
                                        <?php $notapplied+=1; ?>
                                    @endif

                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">
                                                <b>{{ $s->scode }}</b>
                                                <input type="checkbox"  class="pull-right checkbox" id="{{ $s->id }}" name="subject_{{ $s->id }}" checked @if($s->application_status == 1) disabled @endif>
                                                <input type="hidden" id="amount_{{ $s->id }}" value="<?php if($s->is_external==1) {echo '100'; } else {echo'0';}  ?>">
                                            </div>
                                            <div>
                                            <div style="margin-left:30px;">
                                                @if(is_null($s->elective_subjects))
                                                    {{ $s->sname }}
                                                    <input type="hidden" id="elective_{{ $s->id }}" value="0" >
                                                @else
                                                    <span style="color:red;">Select your optional subject</span> <br/>
                                                    <input type="hidden" id="elective_{{ $s->id }}" value="1" >
                                                    <table>
                                                        @foreach(json_decode('['.$s->elective_subjects.']') as $es) 
                                                            <tr>
                                                                <td>
                                                                    {{  $es->sname }} (<small>{{  $es->scode }} </small>)
                                                                </td>
                                                                <td style="vertical-align: top!important;">
                                                                    <input 
                                                                        type="radio" 
                                                                        style="margin-left:5px;" 
                                                                        value="{{ $es->id }}" 
                                                                        class="radio pull-right" 
                                                                        name="radio_{{ $s->id }}"
                                                                        @if($s->application_status == 1) disabled @endif @if($es->id == $s->alternativesubject_id) checked @endif
                                                                    >
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                        <div class="form-group">
                            <label for="language_id">Preferred Language </label>
                            <select name="language_id" id="language_id" class="form-control" @if(!is_null($applicant)) disabled @endif >
                                <option value="0" disabled selected> --Please choose --</option>
                                @foreach($languages as $l)
                                    <option  @if(!is_null($applicant) && $applicant->language_id==$l->id) selected @endif value="{{ $l->id }}">{{ $l->language }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="amount" class="alert alert-warning hidden">
                            
                        </div>
                        <input type="hidden" id="finalamount" name="finalamount">
                        <div id="message" class="alert alert-danger hidden">
                            <ul>
                                <li id="selecttheSubjects"> Please select the subjects </li>
                                <li id="notallSubjects">  </li>
                                <li id="selectAlternative"> Please select the alternative Subjects </li>
                                <li id="selectLanguage"> Please select a language for question paper </li>
                            </ul>
                        </div>
                        <input type="hidden" name="exception" value="{{ $exception }}">
                        @if(is_null($applicant))
                            @if($exception == 1)
                                <div class="form-group">
                                    <label for="language_id">Exams not attended before & Date</label>
                                    <small class="text-muted">Example: Sep-Oct 2023, April 2024, June 2024 etc. with date of absence</small>
                                    <input type="text" name="exam" id="exam" class="form-control" required >
                                </div>
                                <div class="form-group">
                                    <label for="language_id">Reason for non attending previous exams </label>
                                    <input type="text" name="reason" id="reason" class="form-control" required >
                                </div>
                                <div class="form-group">
                                    <label for="language_id">Document evidence </label>
                                    <small class="text-mute">Document should be in pdf format, Maximum size allowed is 100KB. Document should be valid medical document or other valid documents as per scheme of examination.</small>
                                    <input type="file" name="document" id="document" class="form-control"  accept="application/pdf" required>
                                </div>
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="pay" disabled>Submit</button>
                            </div>
                        @else

                            @if($applicant->payment_status==0 || $applicant->payment_status==3)
                                <div  class="alert alert-danger">
                                    <?php $npte = $applicant->nplustwoexceptions()->first(); ?> 
                                    @if(!is_null($npte))
                                        @if($npte->status == 0)
                                        Pending for Verification by NBER 
                                        @endif
                                        @if($npte->status == 1)
                                         Approved
                                        @endif

                                        @if($npte->status == 2)
                                         Rejected
                                        @endif
                                        <br /> 
                                        <div class="form-group">
                                            <label for="language_id">Exam & Date</label>
                                            <input type="text" name="reason" id="exam" class="form-control" disabled value="{{ $npte->exam }}" >
                                         
                                        </div>
                                        <div class="form-group">
                                            <label for="language_id">Reason for non attending previous exams </label>
                                            <input type="text" name="reason" id="reason" class="form-control" disabled value="{{ $npte->reason }}" >
                                            <a href="{{ url('files/supplyevidance') }}/{{ $npte->document }}" target="_blank">View Evidence</a>
                                        </div>
                                    @endif
                                    Payment Pending 
                                    <input type="hidden" name="paymentstatus" value="pending">
                                    <br /> <br />
                                    <div class="form-group">
                                        @if($exception == 0 || (!is_null($npte) && $npte->status == 1) || $applicant->id < 36)
                                        <input type="hidden" name="additional" value="{{$notapplied}}">
                                            <button type="submit" class="btn btn-primary  " id="pay" >
                                                
                                                <span class=""> Check the Payment Status / Try Again
                                             
                                                </span>
                                                @if($notapplied > 0)
                                                    Resubmit to add additional subjects
                                                @endif
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if($applicant->payment_status == 1 || $applicant->payment_status == 2)
                                <div  class="alert alert-success">
                                    Paid
                                @if($notapplied > 0)
                                    <input type="hidden" name="paymentstatus" value="additional">
                                    <input type="hidden" name="additional" value="{{$notapplied}}">
                                    <button type="submit" class="btn btn-primary  " id="pay" >
                                            Resubmit to add additional subjects
                                           <span class="hidden"> Resubmit for additional subjects for additional payment of {{ 100 * $notapplied}} </span>
                                    </button>
                                @endif
                                </div>

                            @endif
                        @endif
                    </form>
                @else
                    <div class="alert alert-warning">
                        Not applicable
                        <br />
                        {{ $reason }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(function() {
           validate();
           $('#language_id').on('change',function(){
                validate();
           });
           $('.checkbox').on('change',function(){
                validate();
           });
           $('.radio').on('change',function(){
                validate();
           });
        });

        function validate(){
            var amount = 0;
            var noofsubjects = $('#noofsubjects').val();
            var selectedsubjects = 0;
            var countofalternative = 0;
            var checkedradio = 0;
            $('.checkbox').each(function() {
                if($('#'+this.id).is(":checked")){
                    amount +=  parseInt($("#amount_"+this.id).val());
                    if($('#elective_'+this.id).val() == 1){
                        countofalternative += 1;
                        if($('input[name=radio_'+this.id+']').is(":checked")){
                            checkedradio += 1;
                        }   
                    }
                    selectedsubjects += 1;
                }else{
                    if($('#elective_'+this.id).val() == 1){
                        $('input[name=radio_'+this.id+']').prop('checked',false);
                    }
                }
            });
            if(amount > 0){
                $('#amount').html("<b>Amount: ₹ " + amount +"</b>");
                $('#finalamount').val(amount);
                $('#amount').removeClass('hidden');
            }else{
                $('#amount').addClass('hidden');
            }
            
            if(selectedsubjects == 0){
                $('#selecttheSubjects').removeClass('hidden');
            }else{
                $('#selecttheSubjects').addClass('hidden');
            }

            if(noofsubjects == selectedsubjects){
                $('#notallSubjects').addClass('hidden');
            }else{
                $('#notallSubjects').removeClass('hidden');
                $('#notallSubjects').text('You have choosen '+selectedsubjects + ' out of ' + noofsubjects + ' subjects.');
            }

            if(countofalternative == checkedradio){
                $('#selectAlternative').addClass('hidden');
            }else{
                $('#selectAlternative').removeClass('hidden');
            }

            if(
                $('#language_id').val() != 0 
                && $('#language_id').val() != null 
            ){
                $('#selectLanguage').addClass('hidden');
            }else{
                $('#selectLanguage').removeClass('hidden');
            }

            if(
                $('#language_id').val() != 0 
                && $('#language_id').val() != null 
                && selectedsubjects > 0
                && countofalternative == checkedradio
            ){
                $('#pay').prop('disabled',false);
                if(noofsubjects == selectedsubjects){
                    $('#message').addClass('hidden');
                }else{
                    $('#message').removeClass('hidden');
                    $('#message').removeClass('alert-danger');
                    $('#message').addClass('alert-info');
                }
            }else{
                $('#pay').prop('disabled',true);
                $('#message').removeClass('hidden');
                $('#message').removeClass('alert-info');
                $('#message').addClass('alert-danger');
            }
        }
    </script>
    <style>

        .bg-transparent{
            background: transparent!important;
            border:1px solid #777;
            color: #444;
        }
    </style>

<script>
    $(function() {
        $('#document').on('change',function(){
            var sizeInKB = this.files[0].size/1024;
            if(sizeInKB > 100){
                swal({
                    type: 'warning',
                    title: 'File size should be less than 100KB',
                    showConfirmButton: false,
                    timer: 3000
                });
                $('#document').val(null);
                return false;
            }
            var ext = this.value.match(/\.(.+)$/)[1];
            switch (ext) {
                case 'pdf':
                    break;
                default:
                    swal({
                        type: 'warning',
                        title: 'This is not an allowed file type.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#document').val(null);
                    return false;
            }
        });
    });
</script>
@endsection