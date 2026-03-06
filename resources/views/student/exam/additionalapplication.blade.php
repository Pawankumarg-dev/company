@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger  hidden">
                    Exam application form is closed.
                </div>
                <h4>    @if($exception == 1) Provisional @endif Exam  Application -  
                    {{ $exam->examtype->name }}, 
                    {{$exam->name}}</h4>
                @include('common.errorandmsg')
                <?php $slno = 1; ?>
                
                @if(!is_null($subjects) && $subjects->count()> 0)
                    @if(is_null($applicant))
                        {{--  <div class="alert alert-warning">
                           Please unselect the subjects you are not appearing  and choose the preferred language for Question Paper. 
                          Exam applications is closed
                            
                        </div>--}}
                    @endif
                    @If($reason != '')
                        <div class="alert alert-danger">
                            {{ $reason }}
                        </div>
                    @endif
                    @if(!is_null($applicant))
                    <div  class="alert alert-success">
                        <ul>
                              <li>
                                  Hall tickets will be generated for the eligible candidates to appear for exams subject to completion of following conditions: <br />
                                  a.	Enrollment fees paid.<br />
                                  b.	Examination fees paid.<br />
                                  c.	Passed in internal exam<br />
                                  d.	Attendance as per Scheme of Exam<br />
                              </li>
                              
                          </ul>  
                          <ul>
                            <li>
                                पात्र अभ्यर्थियों को परीक्षा में बैठने के लिए निम्नलिखित शर्तों को पूरा करने पर हॉल टिकट जारी किए जाएंगे: <br />

                                नामांकन शुल्क का भुगतान <br />
                                परीक्षा शुल्क का भुगतान <br />
                                आंतरिक परीक्षा में उत्तीर्ण <br />
                                परीक्षा योजना के अनुसार उपस्थिति <br />
                            </li>
                          </ul>
                    </div>
                    <br />


 <div  class="alert alert-success">
                        <ul>
                              
                                <li>
                                  Applied
                              </li>
                          </ul>
                    </div>

                    
                    @endif
                   
                    <form action="{{ url('student/exam/applications') }}" method="POST"  enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <?php $notapplied = 0; ?>
                        <ol class="list-group list-group-numbered">
                            <input type="hidden" id="noofsubjects" value="{{ $subjects->count() }}">
                            @foreach($subjects as $s)
                                @if($s->subjecttype_id == 1 || $approvedprogramme_id == 8838 )
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
                                                        <span style="color:red;">Select your alternative subject</span> <br/>
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
                                @endif
                            @endforeach
                        </ol>
                        <div class="form-group">
                            <label for="language_id">Preferred Language </label>
                            <select name="language_id" id="language_id"  class="form-control"    @if(!is_null($applicant))  @endif >
                                <option value="0"  selected> --Please choose --</option>
                                @foreach($languages as $l)
                                    @if($l->id != 13)
                                        <option  @if(!is_null($applicant) && $applicant->language_id==$l->id) selected @endif value="{{ $l->id }}">{{ $l->language }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div id="amount" class="alert alert-warning hidden">
                            
                        </div>
                        <input type="hidden" id="finalamount" name="finalamount">
                        <div id="message" class="alert alert-danger   ">
                            <ul>
                                <li id="selecttheSubjects"> Please select the subjects </li>
                                <li id="notallSubjects">  </li>
                                <li id="selectAlternative"> Please select the alternative Subjects </li>
                                <li id="selectLanguage"> Please select a language for question paper </li>
                            </ul>
                        </div>
                        <input type="hidden" name="exception" value="{{ $exception }}">
                        @if(is_null($applicant))
                            <button type="submit" class="btn btn-primary    " id="pay"    >Save</button>
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
              // $('#amount').removeClass('hidden');
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
            $('#message').addClass('hidden');
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